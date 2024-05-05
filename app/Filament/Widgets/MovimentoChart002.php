<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Movimento;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MovimentoChart002 extends ChartWidget
{
    protected static ?string $heading = 'Receita vs Despesa por Mês em R$';

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
                    'label'       => 'Receitas',
                    'data'        => $data['receitasPorMes'],
                    'borderColor' => auth()->user()->settings['colors']['primary'] ?? config('filament.theme.colors.primary'),
                ],
                [
                    'label'       => 'Despesas',
                    'data'        => $data['despesasPorMes'],
                    'borderColor' => auth()->user()->settings['colors']['danger'] ?? config('filament.theme.colors.danger'),
                ],
                [
                    'label'       => 'Saldo',
                    'data'        => $data['saldoPorMes'],
                    'borderColor' => auth()->user()->settings['colors']['success'] ?? config('filament.theme.colors.success'),
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
        $saldoPorMes    = [];
        $ano            = $this->filter;

        $meses = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'];

        for($mes = 1; $mes <= 12; $mes++) {
            $somaDespesa = Movimento::whereMonth('dt_vencto', $mes)
                ->whereYear('dt_vencto', $ano)
                ->where('tipo_movimento', 'DESPESA')
                ->where('user_id', auth()->id())
                ->sum('vl_vencto');
            array_push($despesasPorMes, $somaDespesa);

            $somaReceita = Movimento::whereMonth('dt_vencto', $mes)
                ->whereYear('dt_vencto', $ano)
                ->where('tipo_movimento', 'RECEITA')
                ->where('user_id', auth()->id())
                ->sum('vl_vencto');
            array_push($receitasPorMes, $somaReceita);

            $saldo = $somaReceita - $somaDespesa;
            array_push($saldoPorMes, $saldo);
        }

        return [
            'receitasPorMes' => $receitasPorMes,
            'despesasPorMes' => $despesasPorMes,
            'saldoPorMes'    => $saldoPorMes,
            'meses'          => $meses
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
