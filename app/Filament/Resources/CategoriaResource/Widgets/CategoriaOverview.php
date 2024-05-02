<?php

namespace App\Filament\Resources\CategoriaResource\Widgets;

use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CategoriaOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total = Categoria::whereIn('user_id', [1, Auth::user()->id])->count();
        $receita = Categoria::whereIn('user_id', [1, Auth::user()->id])->where('tipo', 'RECEITA')->count();
        $despesa = Categoria::whereIn('user_id', [1, Auth::user()->id])->where('tipo', 'DESPESA')->count();

        return [
            Stat::make('Total', $total),
            Stat::make('Receitas', $receita),
            Stat::make('Despesas', $despesa),
        ];
    }
}
