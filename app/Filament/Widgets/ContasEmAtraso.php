<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Movimento;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\TableWidget as BaseWidget;

class ContasEmAtraso extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Movimento::query()
                    ->where('dt_vencto', '<', now())
                    ->where('dt_pagto', null)
                    ->where('user_id', auth()->id())
            )
            ->defaultPaginationPageOption(5)
            ->defaultSort('dt_vencto', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('dt_vencto')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tipo_movimento')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'RECEITA' => 'success',
                        'DESPESA' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('descricao')
                    ->label('Descrição')
                    ->wrap()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('categoria.descricao')
                    ->label('Categoria')
                    ->wrap()
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('vl_vencto')
                    ->label('Valor')
                    ->currency('BRL')
                    ->alignEnd()
                    ->color(function (Model $record, string $state) {
                        if ($record->tipo_movimento === 'RECEITA') {
                            return 'success';
                        } elseif ($record->tipo_movimento === 'DESPESA') {
                            return 'danger';
                        } else {
                            return 'gray';
                        }
                    })
                    ->sortable(),
            ]);
    }
}
