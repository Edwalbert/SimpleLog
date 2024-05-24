<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Util\PdfController;
use App\Models\empresas\Transportadora;
use App\Models\pessoas\Motorista;
use App\Models\veiculos\Carreta;
use App\Models\veiculos\Cavalo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Switch_;
use setasign\Fpdi\Tcpdf\Fpdi;
use Smalot\PdfParser\Parser;
use ZipArchive;
use App\Http\Controllers\Util\ZipController;
use App\Services\TrataDadosService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;


class CteController extends Controller
{
    private $pdfController;
    private $trataDadosService;

    public function __construct(
        PdfController $pdfController,
        TrataDadosService $trataDadosService,
    ) {
        $this->pdfController = $pdfController;
        $this->trataDadosService = $trataDadosService;
    }

    public function main(Request $request)
    {
        $arquivoZip = $request->file('arquivo_zip');
        $arquivosExtraidos = $this->descompactarZipPdf($arquivoZip);

        $pdfMerger = new Fpdi();
        foreach ($arquivosExtraidos as $arquivo) {
            $this->processarPdf($arquivo, $pdfMerger);
        }

        $pdfMerger->Output(storage_path('app/public/pdfs_mesclados.pdf'), 'D');

        $tempDir = storage_path('app/public/temp');

        $this->removerDiretorioTemporario($tempDir);
    }

    public function descompactarZipPdf($arquivoZip)
    {
        try {
            $zipController = new ZipController;
            $arquivosExtraidos = $zipController->descompactarZipPdf($arquivoZip);
            return $arquivosExtraidos;
        } catch (\Exception $e) {
            return $e;
        }
        return response()->json(['error' => 'Erro interno no servidor'], 500);
    }

    public function processarPdf($arquivo, $pdfMerger)
    {
        $placa = '';
        $id_cavalo = '';
        $id_transportadora = '';
        $codigo_motorista = '';
        $razao_social = '';
        $comissao = '';

        try {
            $cliente = $this->encontrarCliente($arquivo);
            $placa = $this->encontrarPlacaPadrao($arquivo);

            $cavalo = Cavalo::where('placa', '=', $placa)->get();

            $id_cavalo = $cavalo[0]->id;

            $id_transportadora = $cavalo[0]->id_transportadora;

            try {
                $motorista = Motorista::where('id_cavalo', '=', $id_cavalo)->get();
                $codigo_motorista = $motorista[0]->codigo_senior;
            } catch (Exception $e) {
                return $e;
            }

            try {
                $transportadora = Transportadora::where('id', '=', $id_transportadora)->get();
                $razao_social = $transportadora[0]->razao_social;
                $codigo_transportadora = $transportadora[0]->codigo_transportadora;
                $comissao = $transportadora[0]->comissao;
                $comissaoFloat = (float) str_replace('%', '', $comissao);
            } catch (Exception $e) {
                return $e;
            }
        } catch (Exception $e) {
            try {
                $carreta = Carreta::where('placa', '=', $placa)->get();
                $id_cavalo = $carreta[0]->id_cavalo;

                try {
                    $cavalo = Cavalo::where('id', '=', $id_cavalo)->get();
                    $placa_cavalo = $cavalo[0]->placa;
                    $placa = $placa_cavalo;
                    $id_transportadora = $cavalo[0]->id_transportadora;
                } catch (Exception $e) {
                    return $e;
                }

                try {
                    $motorista = Motorista::where('id_cavalo', '=', $id_cavalo)->get();
                    $codigo_motorista = $motorista[0]->codigo_senior;
                } catch (Exception $e) {
                    return $e;
                }

                try {
                    $transportadora = Transportadora::where('id', '=', $id_transportadora)->get();
                    $razao_social = $transportadora[0]->razao_social;
                    $codigo_transportadora = $transportadora[0]->codigo_transportadora;
                    $comissao = $transportadora[0]->comissao;
                    $comissaoFloat = (float) str_replace('%', '', $comissao);
                } catch (Exception $e) {
                    return $e;
                }
            } catch (Exception $e) {
            }
        }

        switch ($cliente) {
            case 'BRF':
                $this->escreverCteMulticte($placa, $codigo_motorista, $razao_social, $codigo_transportadora, $comissaoFloat, $arquivo, $pdfMerger);
                break;
            case 'MINERVA':

                $this->escreverCteMulticte($placa, $codigo_motorista, $razao_social, $codigo_transportadora, $comissaoFloat, $arquivo, $pdfMerger);
                break;
            case 'JBS':
                $this->escreverCteMyrp($placa, $codigo_motorista, $razao_social, $codigo_transportadora, $comissaoFloat, $arquivo, $pdfMerger);
                break;
            case 'ALIANCA':
                $this->escreverCteBsoft($placa, $codigo_motorista, $razao_social, $codigo_transportadora, $comissaoFloat, $arquivo, $pdfMerger);
                break;
            default:
                $this->escreverCteBsoft($placa, $codigo_motorista, $razao_social, $codigo_transportadora, $comissaoFloat, $arquivo, $pdfMerger);
                break;
        }
    }

    public function encontrarPlacaPadrao(&$arquivo)
    {
        $padraoPlaca = '/[A-Z]{3}\d[A-Z0-9]\d{2}/';


        $parser = new Parser();
        $pdf = $parser->parseFile($arquivo);
        $conteudoPdf = $pdf->getText();

        $caractereInicial = (stripos($conteudoPdf, 'PLACA') !== false) ? stripos($conteudoPdf, 'PLACA') : stripos($conteudoPdf, 'EXPORTAÇÃO');

        $stringPrimaria = \substr($conteudoPdf, $caractereInicial, 9000);
        $string = str_replace(' ', '', $stringPrimaria);

        if (preg_match($padraoPlaca, $string, $placaEncontrada)) {
            $placa = $placaEncontrada[0];
        } else {
            $placa = '';
        }

        return ($placa);
    }

    public function encontrarCliente(&$arquivo)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($arquivo);
        $conteudoPdf = $pdf->getText();

        $palavrasChave = ['JBS', 'MINERVA', 'ALIANCA', 'BRF'];
        $cliente = null;

        foreach ($palavrasChave as $palavra) {
            $posicaoCliente = strpos($conteudoPdf, $palavra);

            if ($posicaoCliente !== false) {
                $cliente = $palavra;
                break;
            }
        }
        return ($cliente);
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

    public function escreverCteMulticte(&$placa, &$codigo_motorista, &$razao_social, &$codigo_transportadora, &$comissaoFloat, &$arquivo, &$pdfMerger)
    {

        $comissaoPercentual = $this->trataDadosService->floatParaPercentual($comissaoFloat);

        $parser = new Parser();
        $pdf = $parser->parseFile($arquivo);
        $conteudoPdf = $pdf->getText();
        $string = $conteudoPdf;

        if (stripos($string, 'COMPLEMENTO') !== false) {
            $tipo = 'Complemento';
        } else {
            $tipo = 'Normal';
        }

        $pdfMerger->setSourceFile($arquivo);
        try {
            $pdfMerger->AddPage();

            $template = $pdfMerger->importPage(1);
            $pdfMerger->useTemplate($template);

            $font = 'helvetica';
            $fontSize = 10;
            $textColor = '255, 0, 0';

            if ($tipo == 'Complemento') {

                $pdfMerger->SetFillColor(100, 100, 100);
                $pdfMerger->Rect(8, 43, 30, 4, 'F');
                $textColorComp = '255, 255, 255';
                $xy = '08, 43';
                $value = 'COMPLEMENTO';
                $this->pdfController->escreverNoPdf($pdfMerger, $textColorComp, $xy, $value, $font, $fontSize);
                $comissao = $comissaoFloat - 0.25;
                $comissaoPercentual = $this->trataDadosService->floatParaPercentual($comissao);
            }

            $xy = '10, 220';
            $value = "$codigo_transportadora / $codigo_motorista";
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '50, 220';
            $value = $razao_social;
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '10, 230';
            $value = $placa;
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '50, 230';
            $value = $comissaoPercentual;
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function escreverCteMyrp(&$placa, &$codigo_motorista, &$razao_social, &$codigo_transportadora, &$comissaoFloat, &$arquivo, &$pdfMerger)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($arquivo);
        $conteudoPdf = $pdf->getText();
        $string = $conteudoPdf;
        if (stripos($string, 'COMPLEMENTO') !== false) {
            $tipo = 'Complemento';
        } else {
            $tipo = 'Normal';
        }

        $pdfMerger->setSourceFile($arquivo);
        try {
            $pdfMerger->AddPage();

            $template = $pdfMerger->importPage(1);
            $pdfMerger->useTemplate($template);

            $font = 'helvetica';
            $fontSize = 10;
            $textColor = '255, 0, 0';

            if ($tipo == 'Complemento') {
                $pdfMerger->SetFillColor(100, 100, 100);
                $pdfMerger->Rect(5, 51, 35, 4, 'F');
                $textColorComp = '255, 255, 255';
                $xy = '5, 51';
                $value = 'COMPLEMENTO';
                $this->pdfController->escreverNoPdf($pdfMerger, $textColorComp, $xy, $value, $font, $fontSize);

                $comissao = $comissaoFloat - 0.25;
                $comissaoPercentual = $this->trataDadosService->floatParaPercentual($comissao);

                $xy = '10, 180';
                $value = "$codigo_transportadora / $codigo_motorista";
                $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

                $xy = '50, 180';
                $value = $razao_social;
                $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

                $xy = '10, 190';
                $value = $placa;
                $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

                $xy = '50, 190';
                $value = $comissaoPercentual;
                $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);
            } else {
                $xy = '10, 200';
                $value = "$codigo_transportadora / $codigo_motorista";
                $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

                $xy = '50, 200';
                $value = $razao_social;
                $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

                $xy = '10, 210';
                $value = $placa;
                $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

                $xy = '50, 210';
                $comissaoPercentual = $this->trataDadosService->floatParaPercentual($comissaoFloat);
                $value = $comissaoPercentual;
                $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    public function escreverCteBsoft(&$placa, &$codigo_motorista, &$razao_social, &$codigo_transportadora, &$comissaoFloat, &$arquivo, &$pdfMerger)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($arquivo);
        $conteudoPdf = $pdf->getText();
        $string = $conteudoPdf;
        if (stripos($string, 'COMPLEMENTO') !== false) {
            $tipo = 'Complemento';
        } else {
            $tipo = 'Normal';
        }

        $pdfMerger->setSourceFile($arquivo);

        try {
            $pdfMerger->AddPage();

            $template = $pdfMerger->importPage(1);
            $pdfMerger->useTemplate($template);

            $font = 'helvetica';
            $fontSize = 10;
            $textColor = '255, 0, 0';

            if ($tipo == 'Complemento') {
                $pdfMerger->SetFillColor(100, 100, 100);
                $pdfMerger->Rect(8, 43, 30, 4, 'F');
                $textColorComp = '255, 255, 255';
                $xy = '8, 43';
                $value = 'COMPLEMENTO';
                $this->pdfController->escreverNoPdf($pdfMerger, $textColorComp, $xy, $value, $font, $fontSize);

                $comissao = $comissaoFloat - 0.25;
                $comissaoPercentual = $this->trataDadosService->floatParaPercentual($comissao);
            }

            $xy = '10, 255';
            $value = "$codigo_transportadora / $codigo_motorista";
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '50, 255';
            $value = $razao_social;
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '10, 245';
            $value = $placa;
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);

            $xy = '50, 245';
            $value = $comissaoPercentual;
            $this->pdfController->escreverNoPdf($pdfMerger, $textColor, $xy, $value, $font, $fontSize);
        } catch (Exception $e) {
            return $e;
        }
    }
}
