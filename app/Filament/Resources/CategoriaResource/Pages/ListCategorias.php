<?php

namespace App\Filament\Resources\CategoriaResource\Pages;

use Filament\Actions;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CategoriaResource;
use App\Filament\Resources\CategoriaResource\Widgets\CategoriaOverview;

class ListCategorias extends ListRecords
{
    protected static string $resource = CategoriaResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            CategoriaOverview::class,
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
                ->badge(function (Categoria $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->count();
                })
                ->badgeColor('success'),

            'Receitas' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()])->where('tipo', 'RECEITA');
                    }
                )
                ->badge(function (Categoria $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->where('tipo', 'RECEITA')->count();
                })
                ->badgeColor('warning'),

            'Despesas' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()])->where('tipo', 'DESPESA');
                    }
                )
                ->badge(function (Categoria $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->where('tipo', 'DESPESA')->count();
                })
                ->badgeColor('warning'),

            'Sistema' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Sistema');
                    }
                )
                ->badge(function (Categoria $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Sistema')->count();
                })
                ->badgeColor('warning'),

            'Pessoal' => Tab::make()
                ->modifyQueryUsing(
                    function (Builder $query) {
                        return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Pessoal');
                    }
                )
                ->badge(function (Categoria $query) {
                    return $query->whereIn('user_id', [1, Auth::id()])->where('dominio', 'Pessoal')->count();
                })
                ->badgeColor('warning'),
        ];
    }
}
