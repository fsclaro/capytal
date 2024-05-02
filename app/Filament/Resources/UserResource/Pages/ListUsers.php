<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

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
                ->badge(fn (User $query) => $query->count()),

            'Administradores' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_admin', true))
                ->badge(fn (User $query) => $query->where('is_admin', true)->count()),

            'Usuários' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_admin', false))
                ->badge(fn (User $query) => $query->where('is_admin', false)->count()),

            'Ativos' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', true))
                ->badge(fn (User $query) => $query->where('is_active', true)->count()),

            'Inativos' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_active', false))
                ->badge(fn (User $query) => $query->where('is_active', false)->count()),
        ];
    }

}
