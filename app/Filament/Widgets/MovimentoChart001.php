<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Movimento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MovimentoChart001 extends ChartWidget
{
    protected static ?string $heading = 'Nº de Lançamentos por Mês';

    protected static ?int $sort = 1;

    public ?string $filter = '2024';

    protected function getFilters(): ?array
    {
        $anos = $this->getAnos();

        $options = [];

        foreach ($anos as $ano) {
            $options[$ano->anos] = $ano->anos;
        }
        return $options;
    }

    protected function getData(): array
    {
        $this->filter = $this->filter ?? Carbon::now()->format('Y');

        $data = $this->getMovimentosPorMes();

        return [
            'datasets' => [
                [
                    'label' => 'Receitas',
                    'data' => $data['receitasPorMes'],
                    'borderColor' => 'rgb(54, 162, 235)'
                ],
                [
                    'label' => 'Despesas',
                    'data' => $data['despesasPorMes'],
                    'borderColor' => 'rgb(255, 99, 132)'
                ]
            ],
            'labels' => $data['meses']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getMovimentosPorMes(): array
    {
        $receitasPorMes = [];
        $despesasPorMes = [];
        $ano = $this->filter;

        $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];


        for ($mes = 1; $mes <= 12; $mes++) {
            // $ano = $agora->format('Y');
            $count = Movimento::whereMonth('dt_vencto', $mes)
                ->whereYear('dt_vencto', $ano)
                ->where('tipo_movimento', 'DESPESA')
                ->where('user_id', auth()->id())
                ->count();

            array_push($despesasPorMes, $count);

            $count = Movimento::whereMonth('dt_vencto', $mes)
                ->whereYear('dt_vencto', $ano)
                ->where('tipo_movimento', 'RECEITA')
                ->where('user_id', auth()->id())
                ->count();
            array_push($receitasPorMes, $count);
        }

        return [
            'receitasPorMes' => $receitasPorMes,
            'despesasPorMes' => $despesasPorMes,
            'meses' => $meses
        ];
    }

    private function getAnos()
    {
        $anos = DB::table('MOVIMENTOS')
            ->selectRaw('DISTINCT YEAR(dt_vencto) AS anos')
            ->orderBy('anos')
            ->get();

        return $anos;
    }
}
