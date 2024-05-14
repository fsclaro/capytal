<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Movimento;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\MovimentoResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class MovimentoResource extends Resource
{
    protected static ?string $model = Movimento::class;

    protected static ?string $navigationIcon      = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup     = 'Movimentação Financeira';
    protected static ?string $modelLabel          = 'Lançamento';
    protected static ?string $pluralModelLabel    = 'Lançamentos';
    protected static bool $hasTitleCaseModelLabel = false;
    protected static ?int $navigationSort         = 1;

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::where('user_id', Auth::id())
    //         ->where('dt_vencto', '<', now())
    //         ->whereNull('dt_pagto')
    //         ->count();
    // }

    // public static function getNavigationBadgeColor(): ?string
    // {
    //     $atrasos = static::getModel()::where('user_id', Auth::id())
    //         ->where('dt_vencto', '<', now())
    //         ->whereNull('dt_pagto')
    //         ->count();

    //     return $atrasos > 0 ? 'danger' : 'success';
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Detalhes do Lançamento')->schema([
                    TextInput::make('descricao')
                        ->label('Descrição')
                        ->hint('Informe a descrição do lançamento')
                        ->hintColor('success')
                        ->required()
                        ->columnSpanFull()
                        ->maxLength(255),

                    Select::make('tipo_movimento')
                        ->label('Tipo')
                        ->native(false)
                        ->options([
                            'RECEITA' => 'RECEITA',
                            'DESPESA' => 'DESPESA',
                        ])
                        ->afterStateUpdated(fn (Set $set) => $set('categoria_id', null))
                        ->live()
                        ->columnSpan(2)
                        ->required(),

                    Select::make('categoria_id')
                        ->label('Categoria')
                        ->columnSpan(4)
                        ->hint('Escolha um item da lista ou cadastre um novo')
                        ->hintColor('success')
                        ->native(false)
                        ->preload()
                        ->required()
                        ->searchable()
                        ->optionsLimit(1000)
                        ->relationship('categoria', 'descricao', modifyQueryUsing: function (Builder $query, Get $get, Set $set) {
                            if (is_null($get('tipo_movimento'))) {
                                $set('categoria_id', null);
                            }

                            $query->where('tipo', $get('tipo_movimento'))
                                ->whereIn('user_id', [1, Auth::id()]);
                        })
                        ->createOptionForm([
                            Select::make('tipo')
                                ->label('Tipo')
                                ->options([
                                    'RECEITA' => 'RECEITA',
                                    'DESPESA' => 'DESPESA',
                                ])
                                ->live()
                                ->native(false)
                                ->afterStateUpdated(function (Set $set, Get $get) {
                                    if (is_null($get('tipo'))) {
                                        $set('cor', null);
                                    } else {
                                        $set('cor', $get('tipo') === 'RECEITA' ? 'success' : 'danger');
                                    }
                                })
                                ->required(),

                            TextInput::make('descricao')
                                ->label('Descricao')
                                ->required()
                                ->unique('categorias', 'descricao')
                                ->maxLength(255),

                            Forms\Components\Hidden::make('user_id')
                                ->default(Auth::user()->id),

                            Forms\Components\Hidden::make('dominio')
                                ->default(Auth::user()->isAdmin() ? 'Sistema' : 'Pessoal'),

                            Forms\Components\Hidden::make('cor')
                                ->default(function (Get $get) {
                                    return $get('tipo') === 'RECEITA' ? 'success' : 'danger';
                                }),
                        ])
                    ,

                    Select::make('tipo_documento_id')
                        ->label('Tipo de Documento')
                        ->relationship('tipo_documento', 'descricao', modifyQueryUsing: fn (Builder $query) => $query->whereIn('user_id', [1, Auth::id()]))
                        ->required()
                        ->native(false)
                        ->preload()
                        ->searchable()
                        ->optionsLimit(1000)
                        ->columnSpan(2)
                        ->createOptionForm([
                            TextInput::make('descricao')
                                ->label('Descrição')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                            Forms\Components\Hidden::make('user_id')
                                ->default(Auth::user()->id),

                            Forms\Components\Hidden::make('dominio')
                                ->default(Auth::user()->isAdmin() ? 'Sistema' : 'Pessoal'),

                        ]),

                    DatePicker::make('dt_vencto')
                        ->label('Data de Vencimento')
                        ->columnSpan(2)
                        ->default(now())
                        ->required(),

                    TextInput::make('vl_vencto')
                        ->label('Valor')
                        ->prefix('R$')
                        ->required()
                        ->columnSpan(2)
                        ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 2),
                ])->columns(6),

                Fieldset::make('Detalhes do pagamento')->schema([
                    Select::make('conta_id')
                        ->label('Conta de Pagamento')
                        ->relationship('conta', 'descricao', modifyQueryUsing: fn (Builder $query) => $query->whereIn('user_id', [1, Auth::id()]))
                        ->required()
                        ->optionsLimit(1000)
                        ->default('1')
                        ->native(false)
                        ->searchable()
                        ->preload()
                        ->columnSpan(2)
                        ->createOptionForm([
                            TextInput::make('descricao')
                                ->label('Descrição')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),
                            Forms\Components\Hidden::make('user_id')
                                ->default(Auth::user()->id)
                        ]),

                    TextInput::make('vl_pagto')
                        ->label('Valor Pago')
                        ->prefix('R$')
                        ->columnSpan(2)
                        ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 2),

                    DatePicker::make('dt_pagto')
                        ->label('Data de Pagamento')
                        ->columnSpan(2),
                ])->columns(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('dt_vencto')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo_movimento')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'RECEITA' => 'success',
                        'DESPESA' => 'danger',
                        default   => 'gray',
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->wrap()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('conta.descricao')
                    ->label('Conta')
                    ->wrap()
                    ->color(fn (string $state): string => match ($state) {
                        'Conta não definida' => 'danger',
                        default              => 'gray',
                    })
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('categoria.descricao')
                    ->label('Categoria')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('tipo_documento.descricao')
                    ->label('Tipo de Documento')
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('vl_vencto')
                    ->label('Valor')
                    ->currency('BRL')
                    ->alignEnd()
                    ->color(function (Model $record, string $state) {
                        if ($record->tipo_movimento === 'RECEITA') {
                            return 'success';
                        } elseif ($record->tipo_movimento === 'DESPESA') {
                            return 'danger';
                        } else {
                            return 'gray';
                        }
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('dt_pagto')
                    ->label('Pago em')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('vl_pagto')
                    ->label('Valor Pago')
                    ->currency('BRL')
                    ->alignEnd()
                    ->sortable()
                    ->color(function (Model $record, string $state) {
                        if ($record->tipo_movimento === 'RECEITA') {
                            return 'success';
                        } elseif ($record->tipo_movimento === 'DESPESA') {
                            return 'danger';
                        } else {
                            return 'gray';
                        }
                    })
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('user_id', Auth::id())
                    ->orderBy('dt_vencto', 'asc');
            })
            ->filters([
                SelectFilter::make('tipo_movimento')
                    ->label('Tipo')
                    ->multiple()
                    ->searchable()
                    ->options([
                        'RECEITA' => 'RECEITA',
                        'DESPESA' => 'DESPESA',
                    ]),

                DateRangeFilter::make('dt_vencto')
                    ->label('Data de Vencimento')
                    ->modifyQueryUsing(
                        fn (Builder $query, ?Carbon $startDate, ?Carbon $endDate, $dateString) =>
                        $query->when(
                            !empty($dateString),
                            fn (Builder $query, $date): Builder =>
                            $query->whereBetween('dt_vencto', [$startDate, $endDate])
                        )
                    )
                    ->withIndicator(),

                DateRangeFilter::make('dt_pagto')
                    ->label('Data de Pagamento')
                    ->modifyQueryUsing(
                        fn (Builder $query, ?Carbon $startDate, ?Carbon $endDate, $dateString) =>
                        $query->when(
                            !empty($dateString),
                            fn (Builder $query, $date): Builder =>
                            $query->whereBetween('dt_pagto', [$startDate, $endDate])
                        )
                    )
                    ->withIndicator(),

                SelectFilter::make('situacao')
                    ->label('Situação')
                    ->searchable()
                    ->options([
                        'contas_pagas'     => 'Contas pagas',
                        'contas_nao_pagas' => 'Contas não pagas',
                        'contas_vencidas'  => 'Contas vencidas',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!is_null($data['value'])) {
                            if ($data['value'] === 'contas_pagas') {
                                $query->whereNotNull('dt_pagto');
                            } elseif ($data['value'] === 'contas_nao_pagas') {
                                $query->whereNull('dt_pagto');
                            } elseif ($data['value'] === 'contas_vencidas') {
                                $query->whereNull('dt_pagto')
                                    ->where('dt_vencto', '<', now()->format('Y-m-d'));
                            }
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('efetua_baixa')
                        ->label('Baixa Automática')
                        ->icon('heroicon-s-check-circle')
                        ->visible(fn (Movimento $movimento) => is_null($movimento->dt_pagto))
                        ->action(
                            function (Movimento $movimento) {
                                $movimento->dt_pagto   = $movimento->dt_vencto;
                                $movimento->vl_pagto   = $movimento->vl_vencto;
                                $movimento->updated_at = now();
                                $movimento->save();
                            }
                        ),

                    Tables\Actions\Action::make('cancela_baixa')
                        ->label('Cancelar Pagamento')
                        ->icon('heroicon-s-x-circle')
                        ->visible(fn (Movimento $movimento) => !is_null($movimento->dt_pagto))
                        ->action(
                            function (Movimento $movimento) {
                                $movimento->dt_pagto   = null;
                                $movimento->vl_pagto   = null;
                                $movimento->updated_at = now();
                                $movimento->save();
                            }
                        ),

                    Tables\Actions\ViewAction::make(),

                    Tables\Actions\EditAction::make(),

                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('baixa_automatica')
                        ->icon('heroicon-s-check-circle')
                        ->label('Baixa Automática')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                if (is_null($record->dt_pagto)) {
                                    $record->update([
                                        'dt_pagto'   => $record->dt_vencto,
                                        'vl_pagto'   => $record->vl_vencto,
                                        'updated_at' => now(),
                                    ]);
                                }
                            });
                        })
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('cancela_pagamento')
                        ->icon('heroicon-s-x-circle')
                        ->label('Cancelar Pagamento')
                        ->requiresConfirmation()
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                if (!is_null($record->dt_pagto)) {
                                    $record->update([
                                        'dt_pagto'   => null,
                                        'vl_pagto'   => null,
                                        'updated_at' => now(),
                                    ]);
                                }
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                    ExportBulkAction::make()->label('Exportar para Excel'),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMovimentos::route('/'),
            'create' => Pages\CreateMovimento::route('/create'),
            'edit'   => Pages\EditMovimento::route('/{record}/edit'),
        ];
    }
}
