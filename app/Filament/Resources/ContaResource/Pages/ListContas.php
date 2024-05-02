<?php

namespace App\Filament\Resources\ContaResource\Pages;

use App\Models\Conta;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\ContaResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ContaResource\Widgets\ContaOverview;

class ListContas extends ListRecords
{
    protected static string $resource = ContaResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            ContaOverview::class,
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
                ->badge(function (Conta $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->count();
                })
                ->badgeColor('success'),

            'Sistema' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Sistema');
                    }
                )
                ->badge(function (Conta $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Sistema')->count();
                })
                ->badgeColor('warning'),

            'Pessoal' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Pessoal');
                    }
                )
                ->badge(function (Conta $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Pessoal')->count();
                })
                ->badgeColor('warning'),
        ];
    }
}
