<?php

namespace App\Filament\Resources\TipoDocumentoResource\Widgets;

use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TipoDocumentosOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $total = TipoDocumento::whereIn('user_id', [1, Auth::user()->id])->count();
        $sistema = TipoDocumento::whereIn('user_id', [1, Auth::user()->id])->where('dominio', 'Sistema')->count();
        $pessoal = TipoDocumento::whereIn('user_id', [1, Auth::user()->id])->where('dominio', 'Pessoal')->count();

        return [
            Stat::make('Total', $total),
            Stat::make('Sistema', $sistema),
            Stat::make('Pessoais', $pessoal),
        ];
    }
}
