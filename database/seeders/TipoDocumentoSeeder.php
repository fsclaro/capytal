<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos_documentos[] = [ 'descricao' => 'Tipo não definido' ];
        $tipos_documentos[] = [ 'descricao' => 'Em Dinheiro' ];
        $tipos_documentos[] = [ 'descricao' => 'Boleto' ];
        $tipos_documentos[] = [ 'descricao' => 'Pix' ];
        $tipos_documentos[] = [ 'descricao' => 'Débito Automático' ];
        $tipos_documentos[] = [ 'descricao' => 'Transf. Bancária' ];
        $tipos_documentos[] = [ 'descricao' => 'Cheque' ];
        $tipos_documentos[] = [ 'descricao' => 'Cartão de Crédito' ];

        foreach ($tipos_documentos as $tipo_documento) {
            DB::table('tipo_documentos')->insert([
                'user_id' => 1,
                'descricao' => $tipo_documento['descricao'],
                'dominio' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
