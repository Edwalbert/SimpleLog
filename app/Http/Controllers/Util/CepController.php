<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CepController extends Controller
{
    public function consultarCep(Request $request)
    {
        $cep = $request->input('cep');

        $client = new Client([
            'verify' => false
        ]);

        $response = $client->request('GET', 'https://viacep.com.br/ws/' . $cep . '/json/');

        $body = $response->getBody();
        $data = json_decode($body, true);

        if (isset($data['erro'])) {
            return response()->json(['error' => 'CEP não encontrado.'], 404);
        }

        return response()->json($data);
    }
}
