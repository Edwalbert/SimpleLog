<?php

namespace App\Repositories\Util;

use App\Models\Util\Senha;
use App\Models\veiculos\Cavalo;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ConsultaRepository
{

    public function consultaPrincipal($request)
    {
        $filtroCookie = $request->input('pesquisar');

        setcookie("filtroCookie",  $filtroCookie);

        $cavalos = Cavalo::with('crlv.endereco', 'contaBancaria', 'contaBancaria.banco', 'carretas', 'carretas.crlv.endereco', 'motoristas', 'motoristas.contatoPessoal1', 'motoristas.endereco', 'motoristas.contatoPessoal2', 'motoristas.contatoPessoal3', 'transportadoras', 'transportadoras.contaBancaria', 'transportadoras.contaBancaria.banco', 'transportadoras.endereco', 'transportadoras.responsavel', 'transportadoras.contador')
            ->where(function ($query) use ($filtroCookie) {
                $query->whereHas('carretas', function ($subquery) use ($filtroCookie) {
                    $subquery->where('placa', 'like', "%$filtroCookie%");
                })->orWhereHas('motoristas', function ($subquery) use ($filtroCookie) {
                    $subquery->where('nome', 'like', "%$filtroCookie%")
                        ->orWhere('cpf', 'like', "%$filtroCookie%")
                        ->orWhere('telefone', 'like', "%$filtroCookie%")
                        ->orWhere('status_demarco', 'like', "%$filtroCookie%");
                })->orWhereHas('transportadoras', function ($subquery) use ($filtroCookie) {
                    $subquery->where('razao_social', 'like', "%$filtroCookie%")
                        ->orWhere('cnpj', 'like', "%$filtroCookie%");
                });
            })->orWhere('placa', 'like', "%$filtroCookie%")
            ->orWhere('grupo', 'like', "%$filtroCookie%")
            ->get();

        $cavalosFiltrados = $cavalos->filter(function ($cavalo) {
            if (($cavalo->carretas !== null && $cavalo->status == 'Ativo') && $cavalo->motoristas !== null && $cavalo->transportadoras !== null) {
                return $cavalo->carretas->count() > 0 &&
                    $cavalo->motoristas->count() > 0 &&
                    $cavalo->transportadoras->count() > 0;
            }
        });

        $result = [];

        foreach ($cavalosFiltrados as $cavalo) {
            foreach ($cavalo->carretas as $carreta) {
                $duplicatedCavalo = $cavalo->replicate();
                $duplicatedCavalo->setRelation('carretas', collect([$carreta]));

                if ($cavalo->contaBancaria->numero_conta_bancaria !== null && $cavalo->contaBancaria->agencia !== null) {
                    $conta = $cavalo->contaBancaria;
                } else {
                    $conta = $cavalo->transportadoras->contaBancaria;
                }

                $duplicatedCavalo->numero_conta_bancaria_validado = $conta->numero_conta_bancaria;
                $duplicatedCavalo->agencia_validado = $conta->agencia;
                $duplicatedCavalo->pix_validado = $conta->pix;
                $duplicatedCavalo->titularidade_validado = $conta->titularidade;
                $duplicatedCavalo->tipo_conta_validado = $conta->tipo_conta;

                try {
                    $nome_banco_manual = $conta->nome_banco;
                    $nome_banco_tabela_bancos = $conta->banco->nome_banco;
                    if ($nome_banco_manual !== null && $nome_banco_manual !== '') {
                        $nome_banco = $nome_banco_manual;
                    } else {
                        $nome_banco = $nome_banco_tabela_bancos;
                    }
                } catch (Exception $e) {
                }

                $duplicatedCavalo->nome_banco_validado = $nome_banco;

                $result[] = $duplicatedCavalo;
            }
        }

        return $result;
    }
}
