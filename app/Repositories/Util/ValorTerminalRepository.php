<?php

namespace App\Repositories\Util;

use App\Models\util\ValorColeta;
use App\Models\util\ValorTerminal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ValorTerminalRepository
{
    protected $model;

    public function __construct(ValorTerminal $valorTerminal)
    {
        $this->model = $valorTerminal;
    }

    public function index($id_terminal, $tipo_container)
    {
        $valoresTerminal = $this->model::where('id_butuca', '=', $id_terminal)
            ->where('tipo_container', '=', $tipo_container)
            ->first();

        if ($valoresTerminal) {
            $atributos = $valoresTerminal->getAttributes();
            return response()->json(['data' => $atributos]);
        } else {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        }
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
