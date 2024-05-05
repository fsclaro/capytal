<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;

class Profile extends EditProfile
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        FileUpload::make('avatar_url')
                            ->label('Foto do Perfil')
                            ->avatar()
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull()
                            ->alignCenter()
                            ->directory('avatars'),

                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),

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
                            ])->columns(2),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(!static::isSimple()),
            ),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return $data;
    }

    protected function afterSave(): void
    {
        redirect(request()->header('Referer'));
    }
}
