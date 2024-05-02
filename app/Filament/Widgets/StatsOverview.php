<?php

namespace App\Filament\Widgets;

use App\Models\Conta;
use App\Models\Categoria;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        if (Auth::user()->isAdmin()) {
            $contas = Conta::where('user_id', 1)->count();
            $tpDocumentos = TipoDocumento::where('user_id', 1)->count();
            $categorias = Categoria::where('user_id', 1)->count();
        } else {
            $contas = Conta::whereIn('user_id', [1, Auth::user()->id])->count();
            $tpDocumentos = TipoDocumento::whereIn('user_id', [1, Auth::user()->id])->count();
            $categorias = Categoria::whereIn('user_id', [1, Auth::user()->id])->count();
        }

        return [
            Stat::make('Contas', $contas),
            Stat::make('Tipos de Documentos', $tpDocumentos),
            Stat::make('Categorias', $categorias),
        ];
    }
}
