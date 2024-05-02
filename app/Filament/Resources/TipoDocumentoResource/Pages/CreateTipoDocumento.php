<?php

namespace App\Filament\Resources\TipoDocumentoResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TipoDocumentoResource;

class CreateTipoDocumento extends CreateRecord
{
    protected static string $resource = TipoDocumentoResource::class;

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
        return 'Tipo de documento criado com sucesso!';
    }
}
