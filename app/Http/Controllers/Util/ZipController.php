<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Tcpdf\Fpdi;
use ZipArchive;

class ZipController extends Controller
{

    public function descompactarZipPdf($arquivoZip)
    {
        try {

            $tempDir = storage_path('app/public/temp');

            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $zip = new ZipArchive;

            if ($zip->open($arquivoZip->path()) === true) {
                try {
                    $zip->extractTo($tempDir);
                    $zip->close();
                    $arquivosExtraidos = glob($tempDir . '/*.pdf');
                } catch (Exception $e) {
                    return $e;
                }

                return $arquivosExtraidos;
            } else {
                return response()->json(['error' => 'Falha ao abrir o arquivo ZIP'], 500);
            }
        } catch (\Exception $e) {
            return $e;
        }

        return response()->json(['error' => 'Erro interno no servidor'], 500);
    }

    public function descompactarZipXml($arquivoZip)
    {
        try {

            $tempDir = storage_path('app/public/temp');

            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }

            $zip = new ZipArchive;

            if ($zip->open($arquivoZip->path()) === true) {
                try {
                    $zip->extractTo($tempDir);
                    $zip->close();
                    $arquivosExtraidos = glob($tempDir . '/*.xml');
                   
                } catch (Exception $e) {
                    return $e;
                }

                return $arquivosExtraidos;
            } else {
                return response()->json(['error' => 'Falha ao abrir o arquivo ZIP'], 500);
            }
        } catch (\Exception $e) {
            return $e;
        }

        return response()->json(['error' => 'Erro interno no servidor'], 500);
    }
}
