<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\veiculos\Carreta;
use App\Models\veiculos\Cavalo;
use Illuminate\Http\Request;


class ArquivosController extends Controller
{
    public function listarArquivos()
    {

        $cavalos = Cavalo::with('crlv')->get();

        $cavalos->each(function ($item) {
            if (isset($item->path_rntrc)) {
                $item->path_rntrc = str_replace('/', '...', $item->path_rntrc);
            }

            if (isset($item->path_teste_fumaca)) {
                $item->path_teste_fumaca = str_replace('/', '...', $item->path_teste_fumaca);
            }

            if (isset($item->path_foto_cavalo)) {
                $item->path_foto_cavalo = str_replace('/', '...', $item->path_foto_cavalo);
            }

            if (isset($item->crlv->path_crlv)) {
                $item->crlv->path_crlv = str_replace('/', '...', $item->crlv->path_crlv);
            }
        });

        $carretas = Carreta::with('crlv')->get();
        $carretas->each(function ($item) {
            if (isset($item->path_rntrc)) {
                $item->path_rntrc = '/' . str_replace('/', '...', $item->path_rntrc);
            }

            if (isset($item->crlv->path_crlv)) {
                $item->crlv->path_crlv = str_replace('/', '...', $item->crlv->path_crlv);
            }
        });

        $result = $cavalos->concat($carretas);

        $visual = '';

        return view('consultas.consulta-crlvs', compact('result', 'visual'));

        /*
        $cavalos = Cavalo::with('crlv')->get();

        $carretas = Carreta::with('crlv')->get();

        $result = $cavalos->concat($carretas);

        $visual = '';

        return view('consultas.consulta-crlvs', compact('result', 'visual'));*/
    }
}
