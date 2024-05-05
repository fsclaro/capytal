<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Conta;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ContaResource\Pages;

class ContaResource extends Resource
{
    protected static ?string $model = Conta::class;

    protected static ?string $navigationIcon      = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup     = 'Cadastros';
    protected static ?string $modelLabel          = 'Conta';
    protected static ?string $pluralModelLabel    = 'Contas';
    protected static bool $hasTitleCaseModelLabel = false;

    // public static function getNavigationBadge(): ? string
    // {
    //     return static::getModel()::whereIn('user_id', [1, Auth::id()])->count();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make()->schema([
                    Forms\Components\TextInput::make('descricao')
                        ->label('Descrição')
                        ->required()
                        ->columnSpanFull()
                        ->unique(ignoreRecord: true),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('dominio')
                    ->label('Visibilidade')
                    ->badge()
                    ->color(fn (Conta $record) => $record->dominio === 'Sistema' ? 'primary' : 'success')
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

                $query->orderBy('user_id', 'asc')->orderBy('id', 'asc');
            })
            ->filters([
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
                            function (Conta $record) {
                                if ($record->dominio === 'Sistema') {
                                    return Auth::user()->isAdmin();
                                }
                                return true;
                            }
                        ),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn (Conta $record) => $record->dominio !== 'Sistema'),
                ]),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index'  => Pages\ListContas::route('/'),
            'create' => Pages\CreateConta::route('/create'),
            'edit'   => Pages\EditConta::route('/{record}/edit'),
        ];
    }
}
