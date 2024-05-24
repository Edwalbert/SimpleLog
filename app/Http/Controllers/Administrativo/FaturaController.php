<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util\PdfController;
use App\Http\Controllers\Util\XmlController;
use App\Http\Controllers\Util\ZipController;
use App\Models\administrativo\retiradas\Retirada;
use App\Models\administrativo\recebiveis\Fatura;
use App\Models\empresas\Cliente;
use App\Services\TrataDadosService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use setasign\Fpdi\Tcpdf\Fpdi;
use SimpleXMLElement;
use Smalot\PdfParser\Parser;
use phputil\extenso\Extenso;

class FaturaController extends Controller
{
    private $xmlController;
    private $zipController;
    private $pdfController;
    private $trataDadosService;

    public function __construct(XmlController $xmlController, ZipController $zipController, PdfController $pdfController, TrataDadosService $trataDadosService)
    {
        $this->xmlController = $xmlController;
        $this->zipController = $zipController;
        $this->pdfController = $pdfController;
        $this->trataDadosService = $trataDadosService;
    }

    public function storeOrUpdate(Request $request)
    {

        if ($request->input('id_fatura') !== null) {
            $resultado = $this->update($request);

            if ($resultado == 'success') {
                return redirect('fatura-abbwood')->with('success', 'Fatura atualizada com sucesso!');
            } else {
                return redirect('fatura-abbwood')->with('error', 'Erro! ' . $resultado);
            }
        } else {
            // $resultado = $this->store($request);

            // if ($resultado == 'success') {
            //     return redirect('fatura-abbwood')->with('success', 'Fatura cadatrada com sucesso!');
            // } else {
            //     return redirect('fatura-abbwood')->with('error', 'Erro! ' . $resultado);
            // }
        }
        return redirect('fatura-abbwood');
    }

    public function store(&$dados, &$observacao)
    {
        try {
            DB::beginTransaction();
            $valorDuplicata = $this->trataDadosService->converterParaFloat($this->calcularValorDuplicata($dados));
            $emissao = Carbon::now();
            $vencimento = $this->obterDataVencimentoAbbWood($emissao);
            $primeiroCnpjRemetente = null;
            $conhecimentos_relacionados = null;
            foreach ($dados as $dado) {
                $cnpjRem = $dado[0]['cnpj_remetente'];
                $nCte = $dado[0]['nCte'];


                if ($conhecimentos_relacionados == null) {
                    $conhecimentos_relacionados = $nCte;
                } else {
                    $conhecimentos_relacionados = "$conhecimentos_relacionados, $nCte";
                }

                if ($primeiroCnpjRemetente === null) {
                    $primeiroCnpjRemetente = $cnpjRem;
                } else {
                    if ($cnpjRem !== $primeiroCnpjRemetente) {
                        return redirect('fatura-abbwood')->with('error', "Erro! o CTe N° $nCte está com CNPJ divergente dos demais!");
                    }
                }

                try {
                    $clientes = Cliente::where('cnpj', '=', $cnpjRem)->get();

                    $id_cliente = $clientes[0]->id;
                } catch (QueryException $e) {
                    return $e;
                }
            }

            $fatura = new Fatura();
            $fatura->setSituacaoAttribute('Pendente');
            $fatura->setEmissaoAttribute($emissao);
            $fatura->setVencimentoAttribute($vencimento);
            $fatura->setIdClienteAttribute($id_cliente);
            $fatura->setConhecimentosRelacionadosAttribute($conhecimentos_relacionados);
            $fatura->setObservacaoAttribute($observacao);
            $fatura->setValorTotalAttribute($valorDuplicata);
            $fatura->save();
            $id_fatura = $fatura->id;
            DB::commit();
            return $id_fatura;
        } catch (QueryException $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function main(Request $request)
    {
        $observacao = $request->input('observacao');
        $arquivoZipXml = $request->file('arquivo_zip_xml');

        $arquivos = $this->zipController->descompactarZipXml($arquivoZipXml);

        foreach ($arquivos as $arquivo) {
            $dados[] = $this->xmlController->processarXml($arquivo);
        }

        $id_fatura = null;
        $this->classificarPorCte($dados);
        $this->classificarPorBooking($dados);
        $this->gerarDuplicata($dados, $observacao, $id_fatura);
        session(['dadosParaValidacao' => $dados, 'observacao' => $observacao]);

        return view('administrativo.Consultas.validacao-fatura', ['dados' => $dados, 'observacao' => $observacao]);
    }


    public function confirmarESalvar(Request $request)
    {
        $dados = session('dadosParaValidacao');
        $observacao = session('observacao');

        $id_fatura = $this->store($dados, $observacao);
        $this->gerarDuplicata($dados, $observacao, $id_fatura);
        session()->forget(['dadosParaValidacao', 'observacao']);

        $tempDir = storage_path('app/public/temp');
        $this->removerDiretorioTemporario($tempDir);

        return redirect('fatura-abbwood');
    }


    public function classificarPorBooking(&$dados)
    {
        $compararPorBooking = function ($a, $b) {
            return strcmp($a[0]['booking'], $b[0]['booking']);
        };
        usort($dados, $compararPorBooking);
    }

    public function classificarPorCte(&$dados)
    {
        $compararPorCte = function ($a, $b) {
            return strcmp($a[0]['nCte'], $b[0]['nCte']);
        };
        usort($dados, $compararPorCte);
    }


    public function gerarDuplicata(&$dados, &$observacao, &$id_fatura)
    {
        $pdfMerger = new Fpdi();
        $pdfMerger->AddPage();

        $this->escreverCabecalho($pdfMerger);
        $this->desenharTabelaPrincipal($dados, $pdfMerger);
        $this->escreverTabelaPrincipal($dados, $pdfMerger, $observacao, $id_fatura);
        $posicaoUltimoRegistro = $this->criarTabela($dados, $pdfMerger);
        $espacoRodape = 280 - $posicaoUltimoRegistro;

        if ($espacoRodape > 20) {
            $this->escreverRodape($pdfMerger, $dados);
        } else {
            $pdfMerger->addPage();
            $this->escreverRodape($pdfMerger, $dados);
        }

        try {
            $pdfMerger->Output(storage_path('app/public/Duplicata.pdf'), 'D');
        } catch (Exception $e) {
        }
    }

    public function escreverCabecalho($pdfMerger)
    {
        $font = 'helvetica';

        $razaoSocial = 'COTRAMOL COOPERATIVA DOS TRANSP. DE CARGA DO MEIO OESTE CAT.';
        $endereco = 'AV. ITAIPAVA, nº 1262 - ITAIPAVA, CEP 88316-300. Itajaí-SC';
        $cnpjInscEstadual = 'CNPJ: 85.393.783/0004-16        Inscrição Estadual: 254825060';
        $foneEmail = 'Fone: (49)3522-3138                  E-mail: cte.itajai1@cotramol.com.br';
        $titulo = 'DUPLICATA';

        $fontSize = 12;
        $textColor = '0, 0, 255';
        $xy = '40, 5';
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $razaoSocial, $font, $fontSize);

        $fontSize = 9;
        $textColor = '0, 0, 0';
        $xy = '40, 11';
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $endereco, $font, $fontSize);

        $fontSize = 9;
        $textColor = '0, 0, 0';
        $xy = '40, 16';
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $cnpjInscEstadual, $font, $fontSize);

        $fontSize = 9;
        $textColor = '0, 0, 0';
        $xy = '40, 21';
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $foneEmail, $font, $fontSize);

        $fontSize = 15;
        $textColor = '0, 0, 0';
        $xy = '80, 35';
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $titulo, $font, $fontSize);

        $imagePath = public_path('storage/images/logomarca_preta.png');  // Use public_path para obter o caminho completo
        $x = 10;
        $y = 12;
        $width = 28;
        $height = 12;

        $pdfMerger->Image($imagePath, $x, $y, $width, $height);
    }

    public function desenharTabelaPrincipal(&$dados, &$pdfMerger)
    {
        $this->desenharLinhasHorizontais($pdfMerger);
        $this->desenharLinhasVerticais($pdfMerger);
    }

    public function desenharLinhasHorizontais(&$pdfMerger)
    {
        $linhas = [
            ['xInicio' => 81, 'yInicio' => 41, 'xFinal' => 111, 'yFinal' => 41],
            ['xInicio' => 10, 'yInicio' => 50, 'xFinal' => 200, 'yFinal' => 50],
            ['xInicio' => 10, 'yInicio' => 58, 'xFinal' => 160, 'yFinal' => 58],
            ['xInicio' => 10, 'yInicio' => 70, 'xFinal' => 160, 'yFinal' => 70],
            ['xInicio' => 10, 'yInicio' => 85, 'xFinal' => 200, 'yFinal' => 85],
            ['xInicio' => 10, 'yInicio' => 87, 'xFinal' => 200, 'yFinal' => 87],
            ['xInicio' => 10, 'yInicio' => 110, 'xFinal' => 200, 'yFinal' => 110],
            ['xInicio' => 10, 'yInicio' => 163, 'xFinal' => 200, 'yFinal' => 163],
        ];

        foreach ($linhas as $linha) {
            $this->desenharLinha($pdfMerger, $linha['xInicio'], $linha['yInicio'], $linha['xFinal'], $linha['yFinal']);
        }
    }

    public function desenharLinhasVerticais(&$pdfMerger)
    {
        $linhas = [
            ['xInicio' => 10, 'yInicio' => 50, 'xFinal' => 10, 'yFinal' => 85],
            ['xInicio' => 160, 'yInicio' => 50, 'xFinal' => 160, 'yFinal' => 85],
            ['xInicio' => 200, 'yInicio' => 50, 'xFinal' => 200, 'yFinal' => 85],
            ['xInicio' => 10, 'yInicio' => 87, 'xFinal' => 10, 'yFinal' => 110],
            ['xInicio' => 200, 'yInicio' => 87, 'xFinal' => 200, 'yFinal' => 110],
            ['xInicio' => 40, 'yInicio' => 50, 'xFinal' => 40, 'yFinal' => 70],
            ['xInicio' => 80, 'yInicio' => 50, 'xFinal' => 80, 'yFinal' => 70],
            ['xInicio' => 120, 'yInicio' => 50, 'xFinal' => 120, 'yFinal' => 70],
        ];

        foreach ($linhas as $linha) {
            $this->desenharLinha($pdfMerger, $linha['xInicio'], $linha['yInicio'], $linha['xFinal'], $linha['yFinal']);
        }
    }

    private function desenharLinha($pdf, $xInicio, $yInicio, $xFinal, $yFinal)
    {
        $pdf->Line($xInicio, $yInicio, $xFinal, $yFinal);
    }

    public function escreverTabelaPrincipal(&$dados, &$pdfMerger, &$observacao, &$id_fatura)
    {
        $font = 'helvetica';
        $dataEmissao = Carbon::now();
        $dataEmissaoFormatada = $dataEmissao->format('d/m/Y');
        $vencimentoFatura = $this->trataDadosService->tratarDatas($this->obterDataVencimentoAbbWood($dataEmissao));
        $numeroFatura = $id_fatura;
        $valorDuplicata = $this->calcularValorDuplicata($dados);
        $sacado = 'ABB WOOD BRAZIL LTDA.';
        $endereco = 'AV. ORLANDO SCARIOT';
        $numero = '840';
        $cidade = 'SANTA CECÍLIA';
        $uf = 'SC';
        $bairro = 'CONDOMINIO INDUSTRIAL';
        $inscEstadual = '260897582';
        $cnpj = '39.271.111/0001-78';
        $fontSize = 10;
        $textColor = '0, 0, 0';

        //Escrever cabeçalhos
        $xy = '15, 51';
        $value = "N° Fatura";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '44, 51';
        $value = "Valor Duplicata";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '87, 51';
        $value = "Data Emissão";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '128, 51';
        $value = "Vencimento";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '163, 51';
        $value = "Para uso Da Inst.";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '163, 55';
        $value = "Financeira";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        //Cabeçalho da tabela conhecimentos relacionados
        $xy = '43, 191';
        $value = "Booking";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '83, 191';
        $value = "Container";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '113, 191';
        $value = "N° CTe";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '145, 191';
        $value = "Valor";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        //Escrever Valores da Tabela
        $fontSize = 12;
        $xy = '12, 74';
        $value = "Obs: $observacao";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $fontSize = 12;
        $xy = '18, 62';
        $value = $numeroFatura;
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '45, 62';
        $value = $valorDuplicata;
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '88, 62';
        $value = $dataEmissaoFormatada;
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '128, 62';
        $value = $vencimentoFatura;
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $fontSize = 10;
        $xy = '11, 88';
        $value = "Nome do Sacado: $sacado";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '11, 93';
        $value = "Endereço: $endereco";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '120, 93';
        $value = "Bairro: $bairro";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '11, 98';
        $value = "Cidade: $cidade";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);


        $xy = '120, 98';
        $value = "UF: $uf";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '11, 103';
        $value = "CPF/CNPJ: $cnpj";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '120, 103';
        $value = "Inscrição estadual: $inscEstadual";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '10, 120';
        $value = "Reconheço(emos) a exatidão desta Duplicata de Prestação de Serviços / Venda Mercantil, na importância acima que pagarei(emos) a COTRAMOL COOPERATIVA DOS TRANSPORTADORES DE CARGA DO MEIO OESTE CATARINENSE ou à sua ordem.";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '15, 145';
        $value = "Em ___/___/_____";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '17, 150';
        $value = "(Data do aceite)";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '100, 145';
        $value = "Aceite: _______________________________________";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '10, 164';
        $value = "Banco: BANCO DO BRASIL    Agência: 4072-X    N° C/C: 7331-8    Titular: COTRAMOL   CNPJ: 85.393.783/0001-73";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '10, 170';
        $value = "PIX: 85.393.783/0001-73";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '10, 180';
        $value = "Conhecimentos relacionados:";
        $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);
    }


    public function criarTabela(&$dados, &$pdfMerger)
    {
        $posicoes = [
            'xSuperiorInicio' => 30,
            'xSuperiorFinal' => 170,
            'ySuperior' => 197,
            'xInferiorInicio' => 30,
            'xInferiorFinal' => 170,
            'yInferior' => 204,
            'xLateralEsquerdo' => 30,
            'yLateralEsquerdoInicio' => 197,
            'yLateralEsquerdoFinal' => 204,
            'xLateralEsquerdo2' => 75,
            'yLateralEsquerdoInicio2' => 197,
            'yLateralEsquerdoFinal2' => 204,
            'xMeio' => 110,
            'yMeioInicio' => 197,
            'yMeioFinal' => 204,
            'xLateralDireito2' => 130,
            'yLateralDireitoInicio2' => 197,
            'yLateralDireitoFinal2' => 204,
            'xLateralDireito' => 170,
            'yLateralDireitoInicio' => 197,
            'yLateralDireitoFinal' => 204,
            'yDados' => 198,

        ];



        $contadorDePaginas = 1;
        $contagem = 1;

        foreach ($dados as $dado) {

            $font = 'helvetica';
            $fontSize = 10;
            $textColor = '0, 0, 0';

            $xy = '33, ' . $posicoes['yDados'];
            $value = $dado[0]['booking'];
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '78, ' . $posicoes['yDados'];
            $value = $dado[0]['container'];
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '113, ' . $posicoes['yDados'];
            $value = $dado[0]['nCte'];
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '135, ' . $posicoes['yDados'];
            $value = $dado[0]['valorCte'];
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $linhas = [
                ['xInicio' => $posicoes['xSuperiorInicio'], 'yInicio' => $posicoes['ySuperior'], 'xFinal' => $posicoes['xSuperiorFinal'], 'yFinal' => $posicoes['ySuperior']],
                ['xInicio' => $posicoes['xInferiorInicio'], 'yInicio' => $posicoes['yInferior'], 'xFinal' => $posicoes['xInferiorFinal'], 'yFinal' => $posicoes['yInferior']],
                ['xInicio' => $posicoes['xLateralEsquerdo'], 'yInicio' => $posicoes['yLateralEsquerdoInicio'], 'xFinal' => $posicoes['xLateralEsquerdo'], 'yFinal' => $posicoes['yLateralEsquerdoFinal']],
                ['xInicio' => $posicoes['xLateralEsquerdo2'], 'yInicio' => $posicoes['yLateralEsquerdoInicio2'], 'xFinal' => $posicoes['xLateralEsquerdo2'], 'yFinal' => $posicoes['yLateralEsquerdoFinal2']],
                ['xInicio' => $posicoes['xMeio'], 'yInicio' => $posicoes['yMeioInicio'], 'xFinal' => $posicoes['xMeio'], 'yFinal' => $posicoes['yMeioFinal']],
                ['xInicio' => $posicoes['xLateralDireito2'], 'yInicio' => $posicoes['yLateralDireitoInicio2'], 'xFinal' => $posicoes['xLateralDireito2'], 'yFinal' => $posicoes['yLateralDireitoFinal2']],
                ['xInicio' => $posicoes['xLateralDireito'], 'yInicio' => $posicoes['yLateralDireitoInicio'], 'xFinal' => $posicoes['xLateralDireito'], 'yFinal' => $posicoes['yLateralDireitoFinal']],
            ];

            $yLimit = 296;
            $yLimitBooking = 270;
            $yFinal = $linhas[1]['yFinal'];

            foreach ($posicoes as $key => $value) {
                if (strpos($key, 'y') !== false) {
                    $posicoes[$key] += 7;
                }
            }

            foreach ($linhas as $linha) {
                $this->desenharLinha($pdfMerger, $linha['xInicio'], $linha['yInicio'], $linha['xFinal'], $linha['yFinal']);
            }

            if ($yFinal >= $yLimit || $posicoes['yDados'] >= $yLimitBooking) {;
                $pdfMerger->AddPage();
                $posicoes['ySuperior'] = 15;
                $posicoes['yInferior'] = 22;
                $posicoes['yLateralEsquerdoInicio'] = 15;
                $posicoes['yLateralEsquerdoFinal'] = 22;
                $posicoes['yLateralEsquerdoInicio2'] = 15;
                $posicoes['yLateralEsquerdoFinal2'] = 22;
                $posicoes['yMeioInicio'] = 15;
                $posicoes['yMeioFinal'] = 22;
                $posicoes['yLateralDireitoInicio2'] = 15;
                $posicoes['yLateralDireitoFinal2'] = 22;
                $posicoes['yLateralDireitoInicio'] = 15;
                $posicoes['yLateralDireitoFinal'] = 22;
                $posicoes['yDados'] = 16;
                $contadorDePaginas++;
                $pdfMerger->SetPage($contadorDePaginas);
            }
            $contagem++;
        }

        return ($posicoes['yDados']);
    }

    public function escreverRodape(&$pdfMerger, &$dados)
    {
        $font = 'helvetica';
        $fontSize = 10;
        $textColor = '0, 0, 0';

        $qtdeCte = 0;
        $valorDuplicata = $this->calcularValorDuplicata($dados);
        foreach ($dados as $dado) {
            $qtdeCte++;
        }

        $xy = '20, 270';
        $value = "Qtde. Conhecimentos: $qtdeCte";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $xy = '150, 270';
        $value = "Total: R$ $valorDuplicata";
        $this->pdfController->escreverTitulo($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

        $this->desenharLinha($pdfMerger, '10', '268', '200', '268');
        $this->desenharLinha($pdfMerger, '10', '277', '200', '277');
    }

    public function calcularValorDuplicata(&$dados)
    {
        try {
            $valorDuplicata = 0;
            foreach ($dados as $linha) {
                $valorCte = $linha[0]['valorCte'];
                $valorCteFloat = (float)$this->trataDadosService->converterParaFloat($valorCte);

                $valorDuplicata += $valorCteFloat;
            }
            $valorDuplicataTratado = $this->trataDadosService->tratarFloat($valorDuplicata);
            return $valorDuplicataTratado;
        } catch (Exception $e) {
            return $e;
        }
    }

    private function removerDiretorioTemporario(&$diretorio)
    {
        if (is_dir($diretorio)) {
            $objects = scandir($diretorio);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($diretorio . "/" . $object)) {
                        File::deleteDirectory($diretorio);
                    } else {
                        unlink($diretorio . "/" . $object);
                    }
                }
            }
            rmdir($diretorio);
        }
    }

    public function obterDataVencimentoAbbWood($dataEmissao)
    {
        Carbon::parse($dataEmissao);
        $dataProximaSemana  = $dataEmissao->addWeek();
        $proximaQuarta = $dataProximaSemana->next('Wednesday');
        $vencimentoFatura = $proximaQuarta->format('Y-m-d');
        return $vencimentoFatura;
    }
}
