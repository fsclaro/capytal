<?php

namespace App\Filament\Resources\MovimentoResource\Pages;

use App\Filament\Resources\MovimentoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMovimento extends CreateRecord
{
    protected static string $resource = MovimentoResource::class;

    public function formatData($data)
    {
        list($dia, $mes, $ano) = explode('/', $data);
        return $ano . '-' . $mes . '-' . $dia;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['dt_vencto'] = $this->formatData($data['dt_vencto']);
        $data['dt_pagto'] = $data['dt_pagto'] ? $this->formatData($data['dt_pagto']) : null;

        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Lançamento criado com sucesso!';
    }

}
