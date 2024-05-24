<?php

namespace App\Repositories\Veiculos;

use App\Models\veiculos\Cavalo;
use App\Services\TrataDadosService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CavaloRepository
{
    protected $model;

    public function __construct(Cavalo $cavalo)
    {
        $this->model = $cavalo;
    }

    public function index(): Collection
    {
        $cavalos = $this->model->where('id_transportadora', '!=', null)
            ->orderBy('placa')->pluck('placa', 'id');

        return $cavalos;
    }


    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function consultaCavaloReserva($request)
    {
        if ($request->input('pesquisar') !== null) {
            setcookie("filtroCookie",  $request->input('pesquisar'));
            $filtroCookie = $request->input('pesquisar');
        } else {
            setcookie("filtroCookie", '');
            $filtroCookie = '';
        }

        $cavalos = Cavalo::leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
            ->leftJoin('transportadoras', 'motoristas.id_transportadora', '=', 'transportadoras.id')
            ->where(function ($query) {
                $query->where('cavalos.id_transportadora', '=', 0)
                    ->orWhereNull('motoristas.id');
            })
            ->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
            ->get();


        return $cavalos;
    }


    public function consultaVencimentosVeiculos($request)
    {
        if ($request->input('pesquisar') !== null) {
            setcookie("filtroCookie",  $request->input('pesquisar'));
            $filtroCookie = $request->input('pesquisar');
        } else {
            setcookie("filtroCookie", '');
            $filtroCookie = '';
        }

        $consultaVeiculos = DB::table('cavalos')
            ->select('cavalos.placa', DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cavalo') AS tipo"), DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'CRLV') AS doc"), 'vencimento_crlv', 'transportadoras.razao_social')
            ->join('crlvs', 'cavalos.id_crlv', '=', 'crlvs.id')
            ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
            ->where('cavalos.status', '=', 'Ativo')
            ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
            ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
            ->whereNotNull('vencimento_crlv')
            ->where(function ($query) use ($filtroCookie) {
                $query->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
                    ->orWhere(DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'CRLV')"), 'LIKE', "%$filtroCookie%")
                    ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                    ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                    ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                    ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                    ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
            })
            ->unionAll(
                DB::table('cavalos')
                    ->select('cavalos.placa', DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cavalo')"), DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Teste Fumaça') AS doc"), 'vencimento_teste_fumaca', 'transportadoras.razao_social')
                    ->join('crlvs', 'cavalos.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('cavalos.status', '=', 'Ativo')
                    ->whereNotNull('vencimento_teste_fumaca')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Teste Fumaça')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('cavalos')
                    ->select('cavalos.placa', DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cavalo')"), DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cronotacógrafo') AS doc"), 'vencimento_cronotacografo', 'transportadoras.razao_social')
                    ->join('crlvs', 'cavalos.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('cavalos.status', '=', 'Ativo')
                    ->whereNotNull('vencimento_cronotacografo')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cronotacógrafo')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('cavalos')
                    ->select('cavalos.placa', DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cavalo')"), DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Minerva') AS doc"), 'cavalos.vencimento_opentech_minerva', 'transportadoras.razao_social')
                    ->join('crlvs', 'cavalos.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('cavalos.status', '=', 'Ativo')
                    ->whereNotNull('cavalos.vencimento_opentech_minerva')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Minerva')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('cavalos')
                    ->select('cavalos.placa', DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cavalo')"), DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Aliança') AS doc"), 'cavalos.vencimento_opentech_alianca', 'transportadoras.razao_social')
                    ->join('crlvs', 'cavalos.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('cavalos.status', '=', 'Ativo')
                    ->whereNotNull('cavalos.vencimento_opentech_alianca')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Aliança')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('cavalos')
                    ->select('cavalos.placa', DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cavalo')"), DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Seara') AS doc"), 'cavalos.vencimento_opentech_seara', 'transportadoras.razao_social')
                    ->join('crlvs', 'cavalos.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('cavalos.status', '=', 'Ativo')
                    ->whereNotNull('cavalos.vencimento_opentech_seara')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Seara')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('cavalos')
                    ->select('cavalos.placa', DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cavalo')"), DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Check Aliança') AS doc"), 'cavalos.checklist_alianca', 'transportadoras.razao_social')
                    ->join('crlvs', 'cavalos.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('cavalos.status', '=', 'Ativo')
                    ->whereNotNull('cavalos.checklist_alianca')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Check Aliança')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('cavalos')
                    ->select('cavalos.placa', DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Cavalo')"), DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Check Minerva') AS doc"), 'cavalos.checklist_minerva', 'transportadoras.razao_social')
                    ->join('crlvs', 'cavalos.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('carretas', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('cavalos.status', '=', 'Ativo')
                    ->whereNotNull('cavalos.checklist_minerva')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(cavalos.placa, cavalos.placa, 'Check Minerva')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )

            ->unionAll(
                DB::table('carretas')
                    ->select('carretas.placa', DB::raw("REPLACE(carretas.placa, carretas.placa, 'Carreta') AS tipo"), DB::raw("REPLACE(carretas.placa, carretas.placa, 'CRLV') AS doc"), 'vencimento_crlv', 'transportadoras.razao_social')
                    ->join('crlvs', 'carretas.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('cavalos', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'carretas.id_transportadora', '=', 'transportadoras.id')
                    ->where('carretas.status', '=', 'Ativo')
                    ->whereNotNull('vencimento_crlv')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(carretas.placa, carretas.placa, 'CRLV')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('carretas')
                    ->select('carretas.placa', DB::raw("REPLACE(carretas.placa, carretas.placa, 'Carreta')"), DB::raw("REPLACE(carretas.placa, carretas.placa, 'Seara') AS doc"), 'carretas.vencimento_opentech_seara', 'transportadoras.razao_social')
                    ->join('crlvs', 'carretas.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('cavalos', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('carretas.status', '=', 'Ativo')
                    ->whereNotNull('carretas.vencimento_opentech_seara')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(carretas.placa, carretas.placa, 'Seara')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('carretas')
                    ->select('carretas.placa', DB::raw("REPLACE(carretas.placa, carretas.placa, 'Carreta')"), DB::raw("REPLACE(carretas.placa, carretas.placa, 'Minerva') AS doc"), 'carretas.vencimento_opentech_minerva', 'transportadoras.razao_social')
                    ->join('crlvs', 'carretas.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('cavalos', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('carretas.status', '=', 'Ativo')
                    ->whereNotNull('carretas.vencimento_opentech_minerva')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(carretas.placa, carretas.placa, 'Minerva')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('carretas')
                    ->select('carretas.placa', DB::raw("REPLACE(carretas.placa, carretas.placa, 'Carreta')"), DB::raw("REPLACE(carretas.placa, carretas.placa, 'Aliança') AS doc"), 'carretas.vencimento_opentech_alianca', 'transportadoras.razao_social')
                    ->join('crlvs', 'carretas.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('cavalos', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('carretas.status', '=', 'Ativo')
                    ->whereNotNull('carretas.vencimento_opentech_alianca')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(carretas.placa, carretas.placa, 'Aliança')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('carretas')
                    ->select('carretas.placa', DB::raw("REPLACE(carretas.placa, carretas.placa, 'Carreta')"), DB::raw("REPLACE(carretas.placa, carretas.placa, 'Check Aliança') AS doc"), 'carretas.checklist_alianca', 'transportadoras.razao_social')
                    ->join('crlvs', 'carretas.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('cavalos', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('carretas.status', '=', 'Ativo')
                    ->whereNotNull('carretas.checklist_alianca')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(carretas.placa, carretas.placa, 'Check Aliança')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->unionAll(
                DB::table('carretas')
                    ->select('carretas.placa', DB::raw("REPLACE(carretas.placa, carretas.placa, 'Carreta')"), DB::raw("REPLACE(carretas.placa, carretas.placa, 'Check Minerva') AS doc"), 'carretas.checklist_minerva', 'transportadoras.razao_social')
                    ->join('crlvs', 'carretas.id_crlv', '=', 'crlvs.id')
                    ->leftJoin('cavalos', 'carretas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('motoristas', 'motoristas.id_cavalo', '=', 'cavalos.id')
                    ->leftJoin('transportadoras', 'cavalos.id_transportadora', '=', 'transportadoras.id')
                    ->where('carretas.status', '=', 'Ativo')
                    ->whereNotNull('carretas.checklist_minerva')
                    ->where(function ($query) use ($filtroCookie) {
                        $query->where('carretas.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere(DB::raw("REPLACE(carretas.placa, carretas.placa, 'Check Minerva')"), 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.razao_social', 'LIKE', "%$filtroCookie%")
                            ->orWhere('cavalos.placa', 'LIKE', "%$filtroCookie%")
                            ->orWhere('transportadoras.cnpj', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.nome', 'LIKE', "%$filtroCookie%")
                            ->orWhere('motoristas.cpf', 'LIKE', "%$filtroCookie%");
                    })
            )
            ->orderBy('vencimento_crlv')
            ->get();

        $result = $consultaVeiculos->map(function ($item) {
            $tratarDados = new TrataDadosService();
            $item->placa = htmlspecialchars($item->placa);
            $item->doc = htmlspecialchars($item->doc);
            $item->contagem_dias = $tratarDados->calcularVencimento($item->vencimento_crlv);
            $item->vencimento_crlv = htmlspecialchars($tratarDados->tratarDatas($item->vencimento_crlv));
            return $item;
        })->toArray();

        return $result;
    }
}
