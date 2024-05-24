<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function uploadCavalo(Request $request, $campo_formulario, $documento, $formato)
    {
        if ($request->hasFile($campo_formulario)) {
            $file = $request->file($campo_formulario);
            $filename = strtoupper($request->input('placa') . '-' . $documento) . $formato;

            $path = $file->storeAs('/app/public/documents/veiculos/' . $documento, $filename);

            return $path;
        }
    }

    public function uploadMotorista(Request $request, $campo_formulario, $documento, $formato)
    {
        if ($request->hasFile($campo_formulario)) {
            $file = $request->file($campo_formulario);
            $filename = strtoupper(($request->input('cpf') . '-' . $documento)) . $formato;

            $path = $file->storeAs('/app/public/documents/motoristas/' . $documento, $filename);

            return '/' . $path;
        }
    }

    public function uploadCarreta(Request $request, $campo_formulario, $documento, $formato)
    {
        if ($request->hasFile($campo_formulario)) {
            $file = $request->file($campo_formulario);
            $filename = strtoupper(($request->input('placa') . '-' . $documento)) . $formato;

            $path = $file->storeAs('/app/public/documents/veiculos/' . $documento, $filename);

            return $path;
        }
    }

    public function uploadTransportadora(Request $request, $campo_formulario, $documento, $formato)
    {
        if ($request->hasFile($campo_formulario)) {
            $file = $request->file($campo_formulario);
            $filename = strtoupper(($request->input('cnpj') . '-' . $documento)) . $formato;

            $path = $file->storeAs('/app/public/documents/transportadoras/' . $documento, $filename);

            return $path;
        }
    }
}
