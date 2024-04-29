<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Receitas
        $categorias[] = ['tipo' => 'RECEITA', 'descricao' => 'Salário'];
        $categorias[] = ['tipo' => 'RECEITA', 'descricao' => 'Férias'];
        $categorias[] = ['tipo' => 'RECEITA', 'descricao' => '13º Salário'];
        $categorias[] = ['tipo' => 'RECEITA', 'descricao' => 'Rescisão'];
        $categorias[] = ['tipo' => 'RECEITA', 'descricao' => 'Aposentadoria'];
        $categorias[] = ['tipo' => 'RECEITA', 'descricao' => 'Aluguel Apartamento'];
        $categorias[] = ['tipo' => 'RECEITA', 'descricao' => 'Outras Receitas'];

        // Despesas - Pet Shop
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Pet/Alimentação'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Pet/Banho e Tosa'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Pet/Brinquedos'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Pet/Medicamentos'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Pet/Outras Despesas'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Pet/Roupinhas'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Pet/Veterinário'];

        // Despesas - Caridades e Doações
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Caridades/Doações'];

        // Despesas - Entretenimento
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Cafeteria e Bar'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Casas Noturnas'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Cinema e Teatro'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Lanches'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Lanchonete'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Museus e Exposições'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Padaria'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Parques e Zoológicos'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Restaurante'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Shows'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Entretenimento/Sorveteria'];

        // Despesas - Saúde e Bem-Estar
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Bem-Estar/Academia'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Bem-Estar/Cosméticos e Perfumaria'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Bem-Estar/Estética'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Bem-Estar/Produtos de Beleza'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Bem-Estar/Salão de Beleza e Barbearia'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Bem-Estar/SPA e Massagens'];

        // Despesas - Compras
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Artigos de Informática'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Artigos de Pesca'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Artigos Esportivos'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Brinquedos'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Calçados'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Jogos Eletrônicos'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Joias e Relógios'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Música e Filmes'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Presentes'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Revistas e Livros'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Compras/Vestuários e Acessórios'];

        // Despesas - Saúde
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Consultas Médicas'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Consultas Odontológicas'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Exames Laboratoriais'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Farmácia'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Fisioterapia'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Medicamentos'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Plano de Saúde'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Plano Odontológico'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Psicólogo'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Saúde/Terapias Alternativas'];

        // Despesas - Seguros
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Seguros/Seguro de Vida'];

        // Despesas - Viagens
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Alimentação'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Aluguel de Carro'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Compras'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Estacionamento'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Hospedagem'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Pacotes'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Passagens'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Passeios'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Pedágios'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Seguro Viagem'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Viagens/Transporte'];

        // Despesas - Moradia
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Açougue e Hortifruti'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Água e Esgoto'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Energia Elétrica'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Faxina'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Feira Livre'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Gás'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Internet'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/IPTU'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Jardinagem'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Lavanderia'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Manutenção e Reformas'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Padaria'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Quitanda'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Seguro Residencial'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Supermercado'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Taxa de Condomínio'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/Telefone Fixo'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Moradia/TV por Assinatura'];

        // Despesas - Veículos
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Combustível'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Consórcio'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Estacionamento'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Financiamento'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/IPVA'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Lavagem'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Licenciamento'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Manutenção'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Multas'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Veículo/Seguro do Carro'];

        // Despesas - Educação
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Educação/Cursos de Idiomas'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Educação/Cursos Livres'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Educação/Livros'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Educação/Material Escolar'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Educação/Mensalidade Escolar'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Educação/Papelaria'];

        // Despesas - Transporte
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Transporte/99'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Transporte/Aluguel de Carro'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Transporte/Táxi'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Transporte/Transporte Público'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Transporte/Trens e Metrôs'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Transporte/Uber'];

        // Despesas - Assinaturas
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Amazon Prime'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Apple Music'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Apple TV'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Deezer'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Disney+'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Globoplay'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/HBO Max'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Netflix'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Paramount+'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Spotify'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/Telecine'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Streaming/YouTube Premium'];

        // Despesas - Impostos
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Impostos/Imposto de Renda'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Impostos/Outros Impostos'];

        // Despesas - Investimentos
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/Ações'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/CDB'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/Consórcio'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/Fundos de Investimentos'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/Imóveis'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/LCI e LCA'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/Previdência Privada'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/Renda Fixa'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/Tesouro Direto'];
        $categorias[] = ['tipo' => 'DESPESA', 'descricao' => 'Investimentos/Outros Investimentos'];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert([
                'user_id' => 1,
                'tipo' => $categoria['tipo'],
                'descricao' => $categoria['descricao'],
                'cor' => ($categoria['tipo'] === 'RECEITA') ? '#28a745' : '#dc3545',
                'dominio' => 'system',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
