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
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\ColorPicker;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon      = 'heroicon-o-user-group';
    protected static ?string $navigationGroup     = 'Administração';
    protected static ?int $navigationSort         = 1;
    protected static ?string $modelLabel          = 'Usuário';
    protected static ?string $pluralModelLabel    = 'Usuários';
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

                    FileUpload::make('avatar_url')
                        ->label('Foto do Perfil')
                        ->avatar()
                        ->image()
                        ->imageEditor()
                        ->columnSpanFull()
                        ->alignCenter()
                        ->directory('avatars')
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
                ])->columns(2),

                Fieldset::make('settings')
                    ->label('Configurações do Tema')
                    ->schema([
                        ColorPicker::make('settings.colors.success')
                            ->label('Sucesso')
                            ->required()
                            ->formatStateUsing(fn (?string $state): string => $state ?? config('filament.theme.colors.success')),

                        ColorPicker::make('settings.colors.danger')
                            ->label('Perigo')
                            ->required()
                            ->formatStateUsing(fn (?string $state): string => $state ?? config('filament.theme.colors.danger')),

                        ColorPicker::make('settings.colors.warning')
                            ->label('Aviso')
                            ->required()
                            ->formatStateUsing(fn (?string $state): string => $state ?? config('filament.theme.colors.warning')),

                        ColorPicker::make('settings.colors.primary')
                            ->label('Primária')
                            ->required()
                            ->formatStateUsing(fn (?string $state): string => $state ?? config('filament.theme.colors.primary')),

                        ColorPicker::make('settings.colors.gray')
                            ->label('Cinza')
                            ->required()
                            ->formatStateUsing(fn (?string $state): string => $state ?? config('filament.theme.colors.gray')),

                        ColorPicker::make('settings.colors.info')
                            ->label('Informação')
                            ->required()
                            ->formatStateUsing(fn (?string $state): string => $state ?? config('filament.theme.colors.info')),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Foto')
                    ->circular()
                    ->width('30px')
                    ->height('30px')
                ,
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
                        ->label('Desativar Usuário')
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
                        ->label('Ativar Usuário')
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
