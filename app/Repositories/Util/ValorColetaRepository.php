<?php

namespace App\Repositories\Util;

use App\Models\util\ValorColeta;
use App\Models\empresas\Butuca;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ValorColetaRepository
{
    protected $model;

    public function __construct(ValorColeta $valorColeta)
    {
        $this->model = $valorColeta;
    }

    public function index()
    {
    }

    public function rotas($coluna, $id_butuca)
    {
        $resultados = [];

        $valoresColeta = $this->model::where('id_butuca', '=', $id_butuca)->get();

        foreach ($valoresColeta as $valor) {
            $id = $valor->id;
            $idDepot = $valor->id_terminal_coleta;
            $idTerminal = $valor->id_terminal_baixa;

            $depot = Butuca::findOrFail($idDepot);
            $nome_depot = $depot->nome;

            $terminal_baixa = Butuca::findOrFail($idTerminal);
            $nome_terminal_baixa = $terminal_baixa->nome;

            $resultados[] = [
                'id' => $id,
                'nome_depot' => $nome_depot,
                'nome_terminal_baixa' => $nome_terminal_baixa,
                'valor' => $valor->valor,
                'id_terminal' => $idTerminal
            ];
        }

        return response()->json(['data' => $resultados]);
    }



    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
