<?php

namespace App\Filament\Resources\MovimentoResource\Widgets;

use App\Models\Movimento;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class MovimentoOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total = Movimento::where('user_id', Auth::user()->id)->count();
        $aVencer = Movimento::where('user_id', Auth::user()->id)
            ->where('dt_vencto', '>=', now())
            ->whereNull('dt_pagto')
            ->count();
        $vencidos = Movimento::where('user_id', Auth::user()->id)
            ->where('dt_vencto', '<', now())
            ->whereNull('dt_pagto')
            ->count();

        return [
            Stat::make('Total', $total),
            Stat::make('A Vencer', $aVencer),
            Stat::make('Vencidas', $vencidos),
        ];
    }
}
