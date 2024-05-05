<?php

namespace Database\Seeders;

use App\Models\Conta;
use App\Models\Categoria;
use App\Models\Movimento;
use Faker\Factory as Faker;
use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MovimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = Categoria::all()->pluck('id')->toArray();
        $contas = Conta::all()->pluck('id')->toArray();
        $tipoDocumentos = TipoDocumento::all()->pluck('id')->toArray();
        $users = [1, 2];
        $faker = Faker::create('pt_BR');

        for ($i = 0; $i < 5000; $i++) {
            $ano =  $faker->randomElement(range(2022,2026));
            $categoria = $categorias[array_rand($categorias)];
            $conta = $contas[array_rand($contas)];
            $tipoDocumento = $tipoDocumentos[array_rand($tipoDocumentos)];
            $user = $users[array_rand($users)];
            $dataIni = $ano . "-01-01";
            $dataFim = $ano . "-12-31";
            $dtVencto = $faker->dateTimeBetween($dataIni, $dataFim);
            $vlVencto = rand(10, 1000);
            $pago = rand(0,1);

            $data = [
                'user_id' => $user,
                'conta_id' => $conta,
                'categoria_id' => $categoria,
                'descricao' => $faker->sentence(),
                'tipo_movimento' => rand(0, 1) ? 'RECEITA' : 'DESPESA',
                'tipo_documento_id' => $tipoDocumento,
                'dt_vencto' => $dtVencto,
                'vl_vencto' => $vlVencto,
                'dt_pagto' => $pago ? $dtVencto : null,
                'vl_pagto' => $pago ? $vlVencto : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            Movimento::create($data);
        }
    }
}
