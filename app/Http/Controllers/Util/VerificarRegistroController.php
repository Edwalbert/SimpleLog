<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\pessoas\Motorista;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VerificarRegistroController extends Controller
{
    public function verificarExistencia($path, $model, $coluna, $id)
    {
        try {
            $modelClass = "App\\Models\\$path\\$model";
            $id = str_replace('...', '/', $id);
            $registro = $modelClass::where($coluna, $id)->first();

            if ($registro) {
                $atributos = $registro->getAttributes();
                return response()->json(['data' => $atributos]);
            } else {
                return response()->json(['error' => 'Registro não encontrado'], 404);
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Erro ao buscar registro'], 500);
        }
    }
}
