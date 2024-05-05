<?php

namespace App\Filament\Resources\ContaResource\Pages;

use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\ContaResource;
use Filament\Resources\Pages\CreateRecord;

class CreateConta extends CreateRecord
{
    protected static string $resource = ContaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['dominio'] = Auth::user()->isAdmin() ? 'Sistema' : 'Pessoal';

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Conta criada com sucesso!';
    }
}
