<?php

namespace App\Filament\Resources\MovimentoResource\Pages;

use Filament\Actions;
use App\Models\Movimento;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MovimentoResource;
use App\Filament\Resources\MovimentoResource\Widgets\MovimentoOverview;

class ListMovimentos extends ListRecords
{
    protected static string $resource = MovimentoResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            MovimentoOverview::class,
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
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('user_id', Auth::id())
                )
                ->badge(fn (Movimento $query) => $query
                    ->where('user_id', Auth::id())->count()
                )
                ->badgeColor('success'),

            'Pagos' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('user_id', Auth::id())
                    ->whereNotNull('dt_pagto')
                )
                ->badge(fn (Movimento $query) => $query
                    ->where('user_id', Auth::id())
                    ->whereNotNull('dt_pagto')
                    ->count()
                )
                ->badgeColor('primary'),

            'A Vencer' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('user_id', Auth::id())
                    ->where('dt_vencto', '>=', now())
                    ->whereNull('dt_pagto')
                )
                ->badge(fn (Movimento $query) => $query
                    ->where('user_id', Auth::id())
                    ->where('dt_vencto', '>=', now())
                    ->whereNull('dt_pagto')
                    ->count()
                )
                ->badgeColor('warning'),

            'Vencidas' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query
                    ->where('user_id', Auth::id())
                    ->where('dt_vencto', '<', now())
                    ->whereNull('dt_pagto')
                )
                ->badge(fn (Movimento $query) => $query
                    ->where('user_id', Auth::id())
                    ->where('dt_vencto', '<', now())
                    ->whereNull('dt_pagto')
                    ->count()
                )
                ->badgeColor('danger'),
        ];
    }
}
