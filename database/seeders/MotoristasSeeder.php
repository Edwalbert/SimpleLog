<?php

namespace Database\Seeders;

use App\Models\pessoas\Motorista;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotoristasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $motoristas = [
            [
                'nome' => 'João Silva',
                'id_cavalo' => 1,
                'id_transportador' => 1,
                'id_local_residencia' => 1,
                'codigo_senior' => '123456',
                'integracao_cotramol' => '2023-01-01',
                'telefone' => '999999999',
                'admissao' => '2022-01-01',
                'vencimento_aso' => '2023-12-31',
                'vencimento_tox' => '2024-06-30',
                'vencimento_tdd' => '2024-12-31',
                'vencimento_apisul' => '2024-06-30',
                'vencimento_opentech_alianca' => '2024-06-30',
                'vencimento_opentech_minerva' => '2024-06-30',
                'vencimento_opentech_seara' => '2024-06-30',
                'brasil_risk_klabin' => '2024-06-30',
                'id_contato_pessoal_1' => 1,
                'contato_pessoal_1_parentesco' => 'Irmão',
                'id_contato_pessoal_2' => 1,
                'contato_pessoal_2_parentesco' => 'Pai',
                'id_contato_pessoal_3' => 1,
                'contato_pessoal_3_parentesco' => 'Mãe',
                'registro_cnh' => '12345678901',
                'espelho_cnh' => '1234567890',
                'emissao_cnh' => '2020-01-01',
                'vencimento_cnh' => '2025-01-01',
                'primeira_cnh' => '2010-01-01',
                'renach' => '12345678901',
                'ear' => 'SIM',
                'categoria_cnh' => 'AE',
                'municipio_cnh' => 'São Paulo',
                'uf_cnh' => 'SP',
                'cpf' => '12345678901',
                'numero_rg' => '1234567890',
                'nome_pai' => 'José Silva',
                'nome_mae' => 'Maria Silva',
                'municipio_nascimento' => 'São Paulo',
                'uf_nascimento' => 'SP',
                'data_nascimento' => '1980-01-01',
                'status' => 'Ativo',
                'motivo_desligamento' => null,
                'obs_desligamento' => null,
                'path_cnh' => null,
                'path_foto_motorista' => null,
                'path_ficha_registro' => null,
                'path_aso' => null,
                'path_tox' => null,
                'path_tdd' => null,
                'path_integracao_brf' => null,
                'path_comprovante_residencia' => null,
                'path_treinamento_anti_tombamento' => null,
                'path_treinamento_3ps' => null,
            ],
        ];

        foreach ($motoristas as $motorista) {
            Motorista::create($motorista);
        }
    }
}
