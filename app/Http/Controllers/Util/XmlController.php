<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Services\TrataDadosService;
use Exception;
use Illuminate\Http\Request;
use SimpleXMLElement;

class XmlController extends Controller
{
    public function instanciarXml($arquivo)
    {
        $conteudoXml = file_get_contents($arquivo);

        if ($conteudoXml === false) {
            throw new Exception("Erro ao ler o arquivo XML");
        }

        $xml = new SimpleXMLElement($conteudoXml);
        return $xml;
    }

    public function processarXml($arquivo): array
    {
        try {
            $container = $this->encontrarContainer($arquivo);
            $booking = $this->encontrarBooking($arquivo);
            $nCte = $this->encontrarNumCte($arquivo);
            $valorCte = $this->encontrarValorCte($arquivo);
            $cnpjRem = $this->encontrarCnpj($arquivo);

            $dados[] = [
                'container' => $container,
                'booking' => $booking,
                'nCte' => $nCte,
                'valorCte' => $valorCte,
                'cnpj_remetente' => $cnpjRem,
            ];
        } catch (Exception $e) {
            return $e;
        }

        return $dados;
    }

    public function encontrarCnpj(&$arquivo)
    {
        try {
            $xml = $this->instanciarXml($arquivo);
            $cnpjRem = $xml->CTe->infCte->rem->CNPJ;
            return (string) $cnpjRem;
        } catch (Exception $e) {
            return 'erro';
        }
    }


    public function encontrarContainer($arquivo): string
    {
        try {
            $xml = $this->instanciarXml($arquivo);
            $xObs = $xml->CTe->infCte->compl->xObs;
            $xObsTratado = preg_replace('/\s+/', '', str_replace(['.', '-'], '', $xObs));


            $padraoContainer = '/[A-Z]{4}\d{7}/i';

            if (preg_match($padraoContainer, $xObsTratado, $containerEncontrado)) {
                $container = $containerEncontrado[0];
            } else {
                $container = '';
            }
            return $container;
        } catch (Exception $e) {
            return 'erro';
        }
    }

    public function encontrarBooking($arquivo): string
    {
        try {
            $xml = $this->instanciarXml($arquivo);
            $xObs = $xml->CTe->infCte->compl->xObs;
            $xObsExploded = \explode('/', $xObs);
            $bookingEncontrado = false;
            $indice = 0;

            while (!$bookingEncontrado && isset($xObsExploded[$indice])) {
                $campoBooking = $xObsExploded[$indice];
                if (strpos($campoBooking, 'Booking') !== false) {
                    $bookingEncontrado = true;
                } else {
                    $indice++;
                }
            }

            $campoBookingExploded = \explode(' ', $campoBooking);
            $booking = $campoBookingExploded[3];
            return $booking;
        } catch (Exception $e) {
            return 'erro';
        }
    }

    public function encontrarNumCte($arquivo): string
    {
        try {
            $xml = $this->instanciarXml($arquivo);
            $nCT = $xml->CTe->infCte->ide->nCT;
            return $nCT;
        } catch (Exception $e) {
            return 'erro';
        }
    }

    public function encontrarValorCte($arquivo): string
    {
        try {
            $xml = $this->instanciarXml($arquivo);
            $vComp = (float)$xml->CTe->infCte->vPrest->Comp->vComp;

            $trataDadosService = new TrataDadosService;
            $valorCte = $trataDadosService->tratarFloat($vComp);

            return $valorCte;
        } catch (Exception $e) {
            return 'erro';
        }
    }
}
