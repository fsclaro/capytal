<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CategoriaResource;

class CreateCategoria extends CreateRecord
{
    protected static string $resource = CategoriaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['dominio'] = Auth::user()->isAdmin() ? 'Sistema' : 'Pessoal';
        $data['cor'] = $data['tipo'] === 'RECEITA' ? 'success' : 'danger';

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Categoria criada com sucesso!';
    }

}
