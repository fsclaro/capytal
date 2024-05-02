<?php

namespace App\Filament\Resources\ContaResource\Widgets;

use App\Models\Conta;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ContaOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total = Conta::whereIn('user_id', [1, Auth::user()->id])->count();
        $sistema = Conta::whereIn('user_id', [1, Auth::user()->id])->where('dominio', 'Sistema')->count();
        $pessoal = Conta::whereIn('user_id', [1, Auth::user()->id])->where('dominio', 'Pessoal')->count();

        return [
            Stat::make('Total', $total),
            Stat::make('Sistema', $sistema),
            Stat::make('Pessoais', $pessoal),
        ];
    }
}
