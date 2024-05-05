<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CategoriaResource;

class EditCategoria extends EditRecord
{
    protected static string $resource = CategoriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['dominio'] = Auth::user()->isAdmin() ? 'Sistema' : 'Pessoal';
        $data['cor']     = $data['tipo'] === 'RECEITA' ? 'success' : 'danger';

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Categoria atualizada com sucesso!';
    }
}
