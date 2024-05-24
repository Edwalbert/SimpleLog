<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\documentos\Crlv;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use ZipArchive;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class DownloadController extends Controller
{
    public function download($caminho)
    {
        $caminho = \str_replace('...', '/', $caminho);
        $caminho = \str_replace('//', '/', $caminho);

        return response()->download(storage_path() . $caminho);
    }

    public function downloadZip($cavalo, $carreta, $cpf)
    {
        try {
            $zipFileName = 'Documentos - ' . $cavalo . '.zip';
            $tempDir = storage_path('app/temp');
            $zipPath = $tempDir . '/' . $zipFileName;

            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            $zip = new ZipArchive();

            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                $filesToZip = [
                    '/app/public/documents/veiculos/rntrc/' . $cavalo . '-RNTRC.pdf',
                    '/app/public/documents/veiculos/crlv/' . $cavalo . '-CRLV.pdf',
                    '/app/public/documents/motoristas/cnh/' . $cpf . '-CNH.pdf',
                    '/app/public/documents/veiculos/crlv/' . $carreta . '-CRLV.pdf',
                    '/app/public/documents/veiculos/rntrc/' . $carreta . '-RNTRC.pdf',
                ];

                foreach ($filesToZip as $file) {
                    try {
                        $zip->addFile(storage_path() . $file, basename($file));
                    } catch (Exception $e) {
                    }
                }

                $zip->close();

                return response()->download($zipPath)->deleteFileAfterSend(true);
            } else {
                return response()->json(['error' => 'Não foi possível criar o arquivo zip'], 500);
            }
        } catch (Exception $e) {
            return \redirect()->back();
        }
    }
}
