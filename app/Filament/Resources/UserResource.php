<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Administração';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Usuário';
    protected static ?string $pluralModelLabel = 'Usuários';
    protected static bool $hasTitleCaseModelLabel = false;

    // public static function getNavigationBadge(): ? string
    // {
    //     return static::getModel()::count();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Dados do Usuário')->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nome do Usuário')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),

                    Forms\Components\TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->required(fn (Page $livewire) => ($livewire instanceof CreateUser))
                        ->maxLength(255)
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->dehydrated(fn ($state) => filled($state)),
                ])->columns(3),

                Fieldset::make('Perfil de Acesso')->schema([
                    Forms\Components\Toggle::make('is_admin')
                        ->label('Este usuário será administrador?')
                        ->required()
                        ->default(false)
                        ->columnSpan(1),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Este usuário está ativo?')
                        ->required()
                        ->default(true)
                        ->columnSpan(1),

                    // Forms\Components\Select::make('roles')
                    //     ->label('Papel')
                    //     ->relationship('roles', 'name')
                    //     ->preload()
                    //     ->required(),

                    // Forms\Components\Select::make('permissions')
                    //     ->label('Permissões')
                    //     ->multiple()
                    //     ->relationship('permissions', 'name')
                    //     ->preload(),
                ])->columns(2),

                Fieldset::make('settings')
                    ->label('Configurações')
                    ->schema([
                        ColorPicker::make('settings.color')
                            ->label('Cor do tema')
                            ->columnSpanFull()
                            ->inlineLabel(),
                            // ->formatStateUsing(
                            //     fn (?string $state): string => $state ?? config('filament.theme.colors.primary')
                            // ),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome do Usuário')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_admin')
                    ->label('Administrador?')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Está Ativo?')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_admin')
                    ->label('Administrador?')
                    ->native(false)
                    ->options([
                        0 => 'Não',
                        1 => 'Sim',
                    ]),

                SelectFilter::make('is_active')
                    ->label('Usuário Ativo?')
                    ->native(false)
                    ->options([
                        0 => 'Não',
                        1 => 'Sim',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
					Tables\Actions\Action::make('inativa')
						->label('Inativa Usuário')
						->icon('heroicon-s-x-circle')
						->visible(function (User $user) {
                            if ($user->id === Auth::id()) {
                                return false;
                            }
                            return $user->is_active;
                        })
						->action(
							function (User $user) {
								$user->is_active = false;
								$user->save();
							}
						),

					Tables\Actions\Action::make('ativa')
						->label('Ativa Usuário')
						->icon('heroicon-s-check-circle')
						->visible(function (User $user) {
                            if ($user->id === Auth::id()) {
                                return false;
                            }
                            return !$user->is_active;
                        })
						->action(
							function (User $user) {
								$user->is_active = true;
								$user->save();
							}
						),



                    Tables\Actions\ViewAction::make(),

                    Tables\Actions\EditAction::make(),

                    Tables\Actions\DeleteAction::make()
                        ->visible(
                            function (User $record) {
                                if ($record->id === Auth::id()) {
                                    return false;
                                }
                                return true;
                            }
                        ),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('disable')
                        ->icon('heroicon-s-check-circle')
                        ->color('primary')
                        ->label('Desativar usuários')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => false]))
                        ->deselectRecordsAfterCompletion(),

                    BulkAction::make('enable')
                        ->icon('heroicon-s-x-circle')
                        ->color('primary')
                        ->label('Ativar usuários')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->update(['is_active' => true]))
                        ->deselectRecordsAfterCompletion(),

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}