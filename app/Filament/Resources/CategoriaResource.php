<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Categoria;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoriaResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CategoriaResource extends Resource
{
    protected static ?string $model = Categoria::class;

    protected static ?string $navigationIcon       = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup      = 'Cadastros';
    protected static ?string $modelLabel           = 'Categoria';
    protected static ?string $pluralModelLabel     = 'Categorias';
    protected static bool $hasTitleCaseModelLabel  = false;
    protected static int $globalSearchResultsLimit = 20;
    protected static ?int $navigationSort          = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make()->schema([
                    Forms\Components\Select::make('tipo')
                        ->label('Tipo')
                        ->columnSpan([
                            'xl' => 1,
                            'lg' => 4,
                            'md' => 4,
                            'sm' => 4,
                        ])
                        ->options([
                            'RECEITA' => 'RECEITA',
                            'DESPESA' => 'DESPESA',
                        ])
                        ->native(false)
                        ->required(),

                    Forms\Components\TextInput::make('descricao')
                        ->label('Descrição')
                        ->columnSpan([
                            'xl' => 3,
                            'lg' => 4,
                            'md' => 4,
                            'sm' => 4,
                        ])
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (Categoria $record) => $record->cor)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('dominio')
                    ->label('Visibilidade')
                    ->badge()
                    ->color(fn (Categoria $record) => $record->dominio === 'Sistema' ? 'primary' : 'success')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                if (!Auth::user()->isAdmin()) {
                    $query->whereIn('user_id', [1, Auth::id()]);
                } else {
                    $query->where('user_id', Auth::id());
                }

                $query->orderBy('tipo', 'desc')->orderBy('id', 'asc');
            })
            ->filters([
                SelectFilter::make('tipo')
                    ->visible(fn () => !Auth::user()->isAdmin())
                    ->multiple()
                    ->label('Tipo')
                    ->options([
                        'RECEITA' => 'RECEITA',
                        'DESPESA' => 'DESPESA',
                    ]),

                SelectFilter::make('dominio')
                    ->visible(fn () => !Auth::user()->isAdmin())
                    ->multiple()
                    ->label('Visibilidade')
                    ->options([
                        'Sistema' => 'Sistema',
                        'Pessoal' => 'Pessoal',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make()
                        ->visible(
                            function (Categoria $record) {
                                if ($record->dominio === 'Sistema') {
                                    return Auth::user()->isAdmin();
                                }
                                return true;
                            }
                        ),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn (Categoria $record) => $record->dominio !== 'Sistema'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()->label('Exportar para Excel'),
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index'  => Pages\ListCategorias::route('/'),
            'create' => Pages\CreateCategoria::route('/create'),
            'edit'   => Pages\EditCategoria::route('/{record}/edit'),
        ];
    }
}
