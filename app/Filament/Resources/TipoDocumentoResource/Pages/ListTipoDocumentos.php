<?php

namespace App\Filament\Resources\TipoDocumentoResource\Pages;

use Filament\Actions;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TipoDocumentoResource;
use App\Filament\Resources\TipoDocumentoResource\Widgets\TipoDocumentosOverview;

class ListTipoDocumentos extends ListRecords
{
    protected static string $resource = TipoDocumentoResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            TipoDocumentosOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Todos' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()]);
                    }
                )
                ->badge(function (TipoDocumento $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->count();
                })
                ->badgeColor('success'),

            'Sistema' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Sistema');
                    }
                )
                ->badge(function (TipoDocumento $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Sistema')->count();
                })
                ->badgeColor('warning'),

            'Pessoal' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Pessoal');
                    }
                )
                ->badge(function (TipoDocumento $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Pessoal')->count();
                })
                ->badgeColor('warning'),
        ];
    }
}
