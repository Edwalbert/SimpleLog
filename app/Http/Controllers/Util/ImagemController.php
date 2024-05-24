<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagemController extends Controller
{
    public function exibirImagem($cpf)
    {
        $path = 'storage/documents/motoristas/foto-motorista/' . $cpf . '-foto-motorista.jpeg';

        return response()->file($path);
    }
}
