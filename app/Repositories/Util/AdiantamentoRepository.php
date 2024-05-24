<?php

namespace App\Repositories\Util;

use App\Models\User;
use App\Models\util\Adiantamento;
use App\Models\Util\Senha;
use App\Models\veiculos\Cavalo;
use App\Services\TrataDadosService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdiantamentoRepository
{
    public function consultaHistoricoAdiantamentos(Request $request)
    {
        if ($request->input('pesquisar') !== null) {
            setcookie("filtroCookie",  $request->input('pesquisar'));
            $filtroCookie = $request->input('pesquisar');
        } else {
            setcookie("filtroCookie", '');
            $filtroCookie = '';
        }


        $adiantamentos = Adiantamento::with('cavalo', 'motorista', 'transportadora', 'posto')


            ->where(function ($query) use ($filtroCookie) {
                $query->where('status', '=', 'Concluido')
                    ->orWhere('status', '=', 'Cancelado')
                    ->orWhere('status', 'LIKE', "%$filtroCookie%")
                    ->orWhere('observacao', 'LIKE', "%$filtroCookie%");
            })
            ->where(function ($query) use ($filtroCookie) {
                $query->orWhereHas('cavalo', function ($query) use ($filtroCookie) {
                    $query->where('placa', 'LIKE', "%$filtroCookie%");
                })
                    ->orWhereHas('motorista', function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%");
                    })
                    ->orWhereHas('posto', function ($query) use ($filtroCookie) {
                        $query->where('nome_posto', 'LIKE', "%$filtroCookie%");
                    })
                    ->orWhereHas('transportadora', function ($query) use ($filtroCookie) {
                        $query->where('razao_social', 'LIKE', "%$filtroCookie%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->limit(500)
            ->get();


        $result = $adiantamentos->map(function ($adiantamento) {
            $em_maos = $adiantamento['em_maos'];

            $id_posto = $adiantamento->id_posto;
            $nome_posto = $adiantamento->posto->nome_posto;
            $observacao = $adiantamento->observacao;

            if ($em_maos == 'on') {
                $observacao = 'Em mãos ' . $observacao;
            }

            $id_user = $adiantamento->id_user;
            $user = User::findOrFail($id_user);

            if ($user->apelido == null) {
                $nome_completo_usuario = explode(" ", $user->name);
                $primeiro_nome = $nome_completo_usuario[0];
            } else {
                $primeiro_nome = $user->apelido;
            }

            $tratarDadosService = new TrataDadosService();
            $data_solicitacao = $tratarDadosService->tratarDatas($adiantamento->created_at);
            $data_carregamento = $tratarDadosService->tratarDatas($adiantamento->data_carregamento);
            $valor = $tratarDadosService->tratarFloat($adiantamento->valor);

            return [
                'id' => htmlspecialchars((string) $adiantamento->id),
                'placa' => htmlspecialchars((string) $adiantamento->cavalo->placa),
                'nome' => htmlspecialchars((string) $adiantamento->motorista->nome),
                'data' => htmlspecialchars((string) $data_solicitacao),
                'rota' => htmlspecialchars((string) $adiantamento->rota),
                'codigo_senior' => htmlspecialchars((string) $adiantamento->motorista->codigo_senior),
                'razao_social' => htmlspecialchars((string) $adiantamento->transportadora->razao_social),
                'codigo_senior_transportadora' => htmlspecialchars((string) $adiantamento->transportadora->codigo_transportadora),
                'nome_posto' => htmlspecialchars((string) $adiantamento->posto->nome_posto),
                'data_solicitacao' => htmlspecialchars((string) $adiantamento->created_at),
                'data_carregamento' => htmlspecialchars((string) $data_carregamento),
                'valor' => htmlspecialchars((string) $valor),
                'usuario' => htmlspecialchars((string) $primeiro_nome),
                'observacao' => htmlspecialchars((string) $observacao),
                'status' => htmlspecialchars((string) $adiantamento->status),
            ];
        })->toArray();

        return $result;
    }
}
