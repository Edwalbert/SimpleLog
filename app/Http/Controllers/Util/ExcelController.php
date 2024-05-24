<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\pessoas\Motorista;
use App\Services\TrataDadosService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ExcelController extends Controller
{

    public function escolherMetodo(Request $request)
    {

        $_excel = $this->excelDemarco($request);

        $prontuario = $this->excelDemarcoProntuario($request);

        return redirect()->back();
    }

    public function excelDemarco($request)
    {

        $jsonData = $request->input('_excel-json');
        try {
            $_excel = json_decode($jsonData, true);
        } catch (Exception $e) {
            dd($e);
        }

        Motorista::whereNotNull('vencimento_opentech_brf')
            ->orWhereNotNull('vencimento_aso')
            ->orWhereNotNull('vencimento_tox')
            ->orWhereNotNull('vencimento_tdd')
            ->update([
                'vencimento_opentech_brf' => null,
                'vencimento_aso' => null,
                'vencimento_tox' => null,
                'vencimento_tdd' => null,
            ]);

        foreach ($_excel as $linha) {
            try {
                $cpf = $linha['CPF'];

                $tipo = $linha['Tipo'];
                $tratarDados = new TrataDadosService();
                $validade = $tratarDados->converterDatasAaMmDd($linha['Data de Validade']);

                $motorista = Motorista::where('cpf', $cpf)->firstOrFail();

                switch ($tipo) {
                    case 'GR':
                        $motorista->setVencimentoOpentechBrfAttribute($validade);
                        break;
                    case 'ET':
                        $motorista->setVencimentoToxAttribute($validade);
                        break;
                    case 'TDD':
                        $motorista->setVencimentoTddAttribute($validade);
                        break;
                    case 'ASO':
                        $motorista->setVencimentoAsoAttribute($validade);
                        break;
                }

                $motorista->save();
            } catch (Exception $e) {
            }
        }
    }

    public function excelDemarcoProntuario($request)
    {
        $jsonData = $request->input('prontuario-json');
        $indice = 0;
        try {
            Motorista::whereNotNull('status_demarco')
                ->orWhereNotNull('pontuacao_demarco')
                ->orWhereNotNull('motivo_bloqueio')
                ->update([
                    'status_demarco' => null,
                    'pontuacao_demarco' => null,
                    'motivo_bloqueio' => null,
                ]);
        } catch (Exception $e) {
            dd($e);
        }

        try {
            $prontuario = json_decode($jsonData, true);
            foreach ($prontuario as $linha) {
                $cpf = '';
                $status_demarco = '';
                $pontuacao_demarco = '';
                $motivo_bloqueio = '';

                if ($indice > 3) {

                    if (isset($linha['__EMPTY_4'])) {
                        $cpf = \str_replace('.', '', str_replace('-', '', $linha['__EMPTY_4']));
                    }
                    if (isset($linha['__EMPTY_8'])) {
                        $status_demarco = ucfirst(strtolower($linha['__EMPTY_8']));
                    }
                    if (isset($linha['__EMPTY_9'])) {
                        $motivo_bloqueio = ucfirst(strtolower($linha['__EMPTY_9']));
                    }
                    if (isset($linha['__EMPTY_18'])) {
                        $pontuacao_demarco = $linha['__EMPTY_18'];
                    }

                    try {
                        $motorista = Motorista::where('cpf', $cpf)->firstOrFail();
                        $motorista->setStatusDemarcoAttribute($status_demarco);
                        $motorista->setPontuacaoDemarcoAttribute($pontuacao_demarco);
                        $motorista->setMotivoBloqueioAttribute($motivo_bloqueio);
                        $motorista->save();
                    } catch (Exception $e) {
                    }

                    try {
                        Motorista::whereNull('status_demarco')
                            ->update([
                                'status_demarco' => 'Não cadastrado',
                            ]);
                    } catch (Exception $e) {
                        dd($e);
                    }
                }

                $indice += 1;
            }
        } catch (Exception $e) {
            dd($e);
        }
    }
}
