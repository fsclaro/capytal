<?php

namespace App\Filament\Resources\MovimentoResource\Pages;

use App\Filament\Resources\MovimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMovimento extends EditRecord
{
    protected static string $resource = MovimentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function formatData($data)
    {
        list($dia, $mes, $ano) = explode('/', $data);
        return $ano . '-' . $mes . '-' . $dia;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();

        $data['dt_vencto'] = $this->formatData($data['dt_vencto']);
        $data['dt_pagto'] = $data['dt_pagto'] ? $this->formatData($data['dt_pagto']) : null;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Lançamento atualizado com sucesso!';
    }
}
