<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
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

class PdfController extends Controller
{

    public function escreverNoPdf(&$pdfMerger, &$textColor, &$xy, &$value, &$font, &$fontSize): void
    {
        $pdfMerger->SetFont($font, '', $fontSize);
        list($r, $g, $b) = explode(', ', $textColor);
        $pdfMerger->SetTextColor($r, $g, $b);

        list($x, $y) = explode(', ', $xy);
        $pdfMerger->SetXY($x, $y);
        $pdfMerger->Write(0, $value);
    }

    public function escreverTitulo(&$pdfMerger, &$textColor, &$xy, &$value, &$font, &$fontSize): void
    {
        $pdfMerger->SetFont($font, 'B', $fontSize);
        list($r, $g, $b) = explode(', ', $textColor);
        $pdfMerger->SetTextColor($r, $g, $b);

        list($x, $y) = explode(', ', $xy);
        $pdfMerger->SetXY($x, $y);
        $pdfMerger->Write(0, $value);
    }

    public function escreverDentroQuadrado(&$pdfMerger, &$textColor, &$xy, &$value, &$font, &$fontSize, &$quadrado): void
    {
        $pdfMerger->SetFont($font, '', $fontSize);
        list($r, $g, $b) = explode(', ', $textColor);
        $pdfMerger->SetTextColor($r, $g, $b);

        list($xQuadrado, $yQuadrado, $larguraQuadrado, $alturaQuadrado) = explode(', ', $quadrado);

        // Calcula as coordenadas X e Y para posicionar o texto no centro do quadrado
        $xTexto = $xQuadrado + ($larguraQuadrado / 2) - ($pdfMerger->GetStringWidth($value) / 2);
        $yTexto = $yQuadrado + ($alturaQuadrado / 2);

        $pdfMerger->SetXY($xTexto, $yTexto);
        $pdfMerger->Write(0, $value);
    }
}
