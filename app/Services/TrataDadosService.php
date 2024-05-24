<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class TrataDadosService extends Model
{
    public function   tratarTelefone($telefone)
    {
        $telefoneTratado = "(" . substr($telefone, 0, 2) . ")" . " "  . substr($telefone, 2, 1) . " " . substr($telefone, 3, 4) . "-" . substr($telefone, 7, 4);
        return $telefoneTratado;
    }

    public function tratarFixoOuCelular($telefone)
    {
        if (strlen($telefone) == 11) {
            $tel_tratado = "(" . substr($telefone, 0, 2) . ")" . " "  . substr($telefone, 2, 1) . " " . substr($telefone, 3, 4) . "-" . substr($telefone, 7, 4);
        } else {
            if (strlen($telefone) == 10) {
                $tel_tratado =    "(" . substr($telefone, 0, 2) . ")" . " " . substr($telefone, 2, 4) . "-" . substr($telefone, 6, 4);
            } else {
                $tel_tratado = "";
            }
        }
        return $tel_tratado;
    }

    public function tratarFloat($valor)
    {
        $floatTratado = number_format($valor, 2, ',', '.');

        return $floatTratado;
    }

    public function converterParaFloat($valor)
    {

        $floatTratado = \str_replace(',', '.', str_replace('.', '', $valor));
        return $floatTratado;
    }

    public function tratarDatas($data)
    {
        if ($data !== null) {
            $dataCarbon = Carbon::parse($data);
            $dataFormatada = $dataCarbon->format('d/m/Y');
            return $dataFormatada;
        } else {
            return null;
        }
    }

    public function tratarDataHora($data_hora)
    {
        $dataCarbon = Carbon::parse($data_hora);
        $dataFormatada = $dataCarbon->format('d/m/Y H:m');

        return $dataFormatada;
    }


    public function converterDatasAaMmDd($data)
    {
        $excelBaseDate = Carbon::create(1900, 1, 1);
        $dataCalculada = $excelBaseDate->addDays($data - 2);
        $dataFormatada = $dataCalculada->format('Y-m-d');

        return $dataFormatada;
    }

    public function verificarVencimento($vencimento, $periodoAlerta)
    {
        $dataAtual = Carbon::now();
        $hoje = $dataAtual->format('Y-m-d');
        $intervalo = $dataAtual->diffInDays(Carbon::parse($vencimento));

        if ($vencimento > $hoje && $intervalo > $periodoAlerta) {
            return 2;
        } elseif ($vencimento > $hoje && $intervalo <= $periodoAlerta) {
            return 1;
        } else {
            return -10;
        }
    }

    public function calcularVencimento($data)
    {
        $dataAtual = Carbon::now();
        $hoje = $dataAtual->format('Y-m-d');
        $intervalo = $dataAtual->diffInDays(Carbon::parse($data));

        if ($data !== null) {

            $result = [];
            if ($data < $hoje) {
                $result['vencimento'] = "Vencido há $intervalo dias!";
                $result['status'] = 'Vencido';
            } else {
                $result['vencimento'] = 'Vence em ' . ++$intervalo . ' dias!';
                $result['status'] = 'A vencer';
            }
            return ($result);
        } else {
            return '';
        }
    }

    public function floatParaPercentual($value)
    {
        $floatTratado = $this->tratarFloat($value);
        $floatPercentual = (string)$floatTratado . '%';
        return $floatPercentual;
    }
}
