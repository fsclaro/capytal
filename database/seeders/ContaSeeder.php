<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contas')->insert([
            'user_id' => 1,
            'descricao' => 'Conta não definida',
            'dominio' => 'Sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contas')->insert([
            'user_id' => 1,
            'descricao' => 'Carteira',
            'dominio' => 'Sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contas')->insert([
            'user_id' => 1,
            'descricao' => 'Banco Itaú',
            'dominio' => 'Sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contas')->insert([
            'user_id' => 1,
            'descricao' => 'Banco Santander',
            'dominio' => 'Sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contas')->insert([
            'user_id' => 1,
            'descricao' => 'Banco do Brasil',
            'dominio' => 'Sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contas')->insert([
            'user_id' => 1,
            'descricao' => 'Nubank',
            'dominio' => 'Sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('contas')->insert([
            'user_id' => 2,
            'descricao' => 'CEF',
            'dominio' => 'Pessoal',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
