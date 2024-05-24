<?php

namespace App\Repositories\Pessoas;

use App\Models\pessoas\Motorista;
use App\Services\TrataDadosService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MotoristaRepository
{
    protected $model;

    public function __construct(Motorista $motorista)
    {
        $this->model = $motorista;
    }

    public function index(): Collection
    {
        $motoristas = $this->model
            ->orderBy('nome')->pluck('nome', 'cpf', 'id');

        return $motoristas;
    }


    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function consultaVencimentosMotoristas($request)
    {
        if ($request->input('pesquisar') !== null) {
            setcookie("filtroCookie",  $request->input('pesquisar'));
            $filtroCookie = $request->input('pesquisar');
        } else {
            setcookie("filtroCookie", '');
            $filtroCookie = '';
        }



        $consultaMotoristas = DB::table('motoristas')
            ->select('nome', DB::raw("REPLACE(nome, nome, 'ASO') as doc"), 'vencimento_aso', 'transportadoras.razao_social')
            ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
            ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
            ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
            ->where('motoristas.status', '=', 'Ativo')
            ->whereNotNull('vencimento_aso')
            ->where(function ($query) use ($filtroCookie) {
                $query->where('nome', 'LIKE', "%$filtroCookie%")
                    ->orWhere(DB::raw("REPLACE(nome, nome, 'ASO')"), 'LIKE', "%$filtroCookie%")
                    ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                    ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                    ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                    ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                    ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
            })
            ->unionAll(
                DB::table('motoristas')
                    ->select('nome', DB::raw("REPLACE(nome, nome, 'TDD') as doc"), 'vencimento_tdd', 'transportadoras.razao_social')
                    ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('motoristas.status', '=', 'Ativo')
                    ->whereNotNull('vencimento_tdd')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(nome, nome, 'TDD')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('motoristas')
                    ->select('nome', DB::raw("REPLACE(nome, nome, 'TOX') as doc"), 'vencimento_tox', 'transportadoras.razao_social')
                    ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('motoristas.status', '=', 'Ativo')
                    ->whereNotNull('vencimento_tox')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(nome, nome, 'TOX')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('motoristas')
                    ->select('nome', DB::raw("REPLACE(nome, nome, 'Opentech BRF') as doc"), 'vencimento_opentech_brf', 'transportadoras.razao_social')
                    ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('motoristas.status', '=', 'Ativo')
                    ->whereNotNull('vencimento_opentech_brf')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(nome, nome, 'Opentech BRF')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('motoristas')
                    ->select('nome', DB::raw("REPLACE(nome, nome, 'Seara') as doc"), 'motoristas.vencimento_opentech_seara', 'transportadoras.razao_social')
                    ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('motoristas.status', '=', 'Ativo')
                    ->whereNotNull('motoristas.vencimento_opentech_seara')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(nome, nome, 'Seara')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('motoristas')
                    ->select('nome', DB::raw("REPLACE(nome, nome, 'Minerva') as doc"), 'motoristas.vencimento_opentech_minerva', 'transportadoras.razao_social')
                    ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('motoristas.status', '=', 'Ativo')
                    ->whereNotNull('motoristas.vencimento_opentech_minerva')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(nome, nome, 'Minerva')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('motoristas')
                    ->select('nome', DB::raw("REPLACE(nome, nome, 'Aliança') as doc"), 'motoristas.vencimento_opentech_alianca', 'transportadoras.razao_social')
                    ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('motoristas.status', '=', 'Ativo')
                    ->whereNotNull('motoristas.vencimento_opentech_alianca')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(nome, nome, 'Aliança')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )

            ->unionAll(
                DB::table('motoristas')
                    ->select('nome', DB::raw("REPLACE(nome, nome, 'BRK') as doc"), 'motoristas.brasil_risk_klabin', 'transportadoras.razao_social')
                    ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('motoristas.status', '=', 'Ativo')
                    ->whereNotNull('motoristas.brasil_risk_klabin')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(nome, nome, 'BRK')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('motoristas')
                    ->select('nome', DB::raw("REPLACE(nome, nome, 'CNH') as doc"), 'vencimento_cnh', 'transportadoras.razao_social')
                    ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('motoristas.status', '=', 'Ativo')
                    ->whereNotNull('vencimento_cnh')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(nome, nome, 'CNH')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->orderBy('vencimento_aso')
            ->get();

        $result = $consultaMotoristas->map(function ($item) {
            $tratarDados = new TrataDadosService();
            $item->nome = htmlspecialchars($item->nome);
            $item->doc = htmlspecialchars($item->doc);
            $item->contagem_dias = $tratarDados->calcularVencimento($item->vencimento_aso);
            $vencimento = $item->contagem_dias['vencimento'];
            $status = $item->contagem_dias['status'];
            $item->vencimento_aso = htmlspecialchars($tratarDados->tratarDatas($item->vencimento_aso));
            return $item;
        })->toArray();

        return $result;
    }


    public function consultaMotoristaReserva($request)
    {
        if ($request->input('pesquisar') !== null) {
            setcookie("filtroCookie",  $request->input('pesquisar'));
            $filtroCookie = $request->input('pesquisar');
        } else {
            setcookie("filtroCookie", '');
            $filtroCookie = '';
        }

        $motoristas = Motorista::with('endereco', 'contatoPessoal1', 'contatoPessoal2', 'contatoPessoal3')
            ->leftJoin('cavalos', 'motoristas.id_cavalo', '=', 'cavalos.id')
            ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
            ->leftJoin('transportadoras', 'motoristas.id_transportadora', '=', 'transportadoras.id')
            ->where('motoristas.status', '=', 'Ativo')
            ->where(function ($query) {
                $query->where('motoristas.id_cavalo', '=', 0)
                    ->orWhere('motoristas.id_transportadora', '=', 0)
                    ->orWhere('cavalos.id_transportadora', '=', 0)
                    ->orWhere('carretas.id_cavalo', '=', 0)
                    ->orWhere('carretas.id_transportadora', '=', 0);
            })->where(function ($query) use ($filtroCookie) {
                $query->where('nome', 'LIKE', "%$filtroCookie%");
                $query->orWhere('cpf', 'LIKE', "%$filtroCookie%");
            })
            ->get();

        return $motoristas;
    }
}
