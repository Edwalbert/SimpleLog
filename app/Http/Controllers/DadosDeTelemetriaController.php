<?php

namespace App\Http\Controllers;

ini_set("memory_limit", "1024M");

use App\Models\DadosDeTelemetria;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;


class DadosDeTelemetriaController extends Controller
{
    protected $guarded = [];

    public function processaDados()
    {
        try {
            DadosDeTelemetria::truncate();

            $pasta = "C:\Users\EdwalbertFernandes-C\OneDrive - NACIONAL\Dashboard Infratores\Desvios Telem/";
            $arquivos = scandir($pasta);

            $primeiraLinha = true;

            $placas = [
                "MLX7C62",
                "QJI4690",
                "MLI3199",
                "MKM6387",
                "QHX0440",
                "QIY8944",
                "RAE6477",
                "MJC8361",
                "QHY4980",
                "MLX6D67",
                "MCI3221",
                "MLV1027",
                "QJY7651",
                "QJF0806",
                "RLI4J55",
                "QIJ0480",
                "RLL0J78",
                "QHN6977",
                "QHA3D58",
                "MLB1761",
                "QJS6399",
                "FWW4I71",
                "MKU4450",
                "MIH8957",
                "MIQ7087",
                "MHO6B67",
                "RDZ4A24",
                "RDS3H73",
                "QIH8J93",
                "MLA6072",
                "RAB1B57",
                "OKH8E28",
                "QIK4A28",
                "QJU4450",
                "QTL6748",
                "RLE4A50",
                "QJC8018",
                "MKT6534",
                "MLN6B18",
                "MLA8I84",
                "MIX5355",
                "MLG4775",
                "QJO1289",
                "QIW9440",
                "RLI9A95",
                "MKV9G99",
                "MKJ1G13",
                "QJJ2E40",
                "MLM2C87",
                "MJT4450",
                "RLP1A96",
                "MJY8748",
                "RAH4450",
                "QJV6690",
                "QIA1050",
                "MLS0H80",
                "MMM1B24",
                "MKN3F75",
                "MJT8460",
                "MIZ2E40",
                "MIF6E70",
                "MKK4E60",
                "RAH6708",
                "QIU6H11",
                "RKY9A22",
                "QJI4610",
                "QJS9205",
                "AUU0J84",
                "RLA4A50",
                "QIU0J19",
                "MFE2875",
                "MLU3578",
                "RLE5D76",
                "RDZ5E09",
                "QJS7675",
                "AUP5B41",
                "QIZ0867",
                "QJH1175",
                "QIV9J74",
                "QIS9453",
                "MHG9G84",
                "QTM7617",
                "RXP4A50",
                "MJJ3B51",
                "RLK8B18",
                "RXM8C72",
                "RDX3B94",
                "QJG0G90",
                "QHH0500",
                "IUN5E65",
                "MLR3H29",
                "MJV4460",
                "RXL6B27",
                "QJL8460",
                "FAT2A29",
                "QHY9100",
                "RKY1H26",
                "MKR1440",
                "RLC4A50",
                "RDZ4H50",
                "MCU6830",
                "MKY3011",
                "QIL1J70",
                "MKY3C34",
                "MLA8294",
                "GHE9D53",
                "QJF9619",
                "MLT9128",
                "LYS7C66",
                "MLK1E40",
                "MKD4420",
                "MLI7243",
                "MJT6F60",
                "EAN4H68",
                "QJS7670",
                "QJS7655",
                "QIO5D15"
            ];

            $descricao = [
                'EXCESSO VELOCIDADE TRECHO RODOVIARIO SECO',
                'EXCESSO VELOCIDADE TRECHO RODOVIARIO COM CHUVA',
                'EXCESSO DE VELOCIDADE ROTOGRAMA FALADO SECO',
                'EXCESSO DE VELOCIDADE ROTOGRAMA FALADO COM CHUVA',
                'FREADA BRUSCA',
                'FORÇA G LATERAL MÉDIA',
                'FORÇA G LATERAL FORTE'
            ];
        } catch (Exception $e) {
            dd($e);
            return response()->json(['Erro no processamento dos arquivos: ']);
        }
        foreach ($arquivos as $arquivo) {

            // Ignorar arquivos ocultos (., ..) e ler apenas arquivos com extensão .xlsx ou .xls
            if (!in_array($arquivo, ['.', '..'])) {


                // Definir o caminho completo do arquivo
                $caminhoCompleto = $pasta . $arquivo;

                // Criar um leitor para o arquivo Excel
                $leitor = IOfactory::createReaderForFile($caminhoCompleto);

                // Carregar o arquivo Excel
                $planilha = $leitor->load($caminhoCompleto);

                // Obter a primeira planilha do arquivo (índice 0)
                $sheet = $planilha->getSheet(0);

                // Obter todas as células da planilha como um array associativo (array de arrays)
                $dados = $sheet->toArray();

                try {
                    DB::beginTransaction();

                    foreach ($dados as $linha) {
                        $placaAtual = substr($linha[3], 0, 7);
                        $descricaoAtual = $linha[8];

                        // Verifica se a placa existe na lista e se a descrição existe na lista especificada.
                        if (in_array($placaAtual, $placas) && in_array($descricaoAtual, $descricao)) {
                            // Tratar datetime
                            $ano = substr($linha[0], 6, 4);
                            $mes = substr($linha[0], 3, 2);
                            $dia = substr($linha[0], 0, 2);
                            $data = $ano . '-' . $mes . '-' . $dia;
                            $hora = substr($linha[1], 0, 5);
                            $data_hora = $data . ' ' . $hora;

                            // Instanciar objeto com os dados da telemetria e adicionar ao banco de dados.
                            $telemetria = new DadosDeTelemetria();
                            $telemetria->setDataHoraAttribute($data_hora);
                            $telemetria->setVeiculoAttribute($linha[3]);
                            $telemetria->setMotoristaAttribute($linha[5]);
                            $telemetria->setDescricaoEventoAttribute($linha[8]);
                            $telemetria->setNomeCercaAttribute($linha[9]);
                            $telemetria->setVelocidadeAttribute($linha[10]);
                            $telemetria->setHodometroAttribute($linha[11]);
                            $telemetria->setDuracaoAttribute($linha[12]);
                            $telemetria->save();
                        }
                    }
                    DB::commit();
                } catch (QueryException $e) {
                    DB::rollback();
                    return response()->json(['Erro ao salvar dados: ' . $linha[3]]);
                }
            }
        }
    }
}
