<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;


class ApiIbgeController extends Controller
{

    function consultarEstados()
    {


        try {
            $client = new Client();
            $response = $client->get('https://servicodados.ibge.gov.br/api/v1/localidades/estados', [
                'verify' => false, // Desabilitar a verificação do certificado SSL
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);

            return $data;
        } catch (RequestException $e) {
            dd($e);
        }
    }

    function consultarMunicipios($uf)
    {

        try {
            $client = new Client();
            $response = $client->get('https://servicodados.ibge.gov.br/api/v1/localidades/estados/' . $uf . '/municipios', [
                'verify' => false,
            ]);
            $body = $response->getBody();
            $data = json_decode($body, true);
            return $data;
        } catch (Exception $e) {
            DD($e);
        }
    }
}
