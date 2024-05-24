<?php

namespace App\Repositories\Veiculos;

use App\Models\veiculos\Carreta;

class CarretaRepository
{
    public function index()
    {
        $carretas = Carreta::all();

        return view('Formularios.formulario-carreta', ['carretas' => $carretas]);
    }

    public function create(array $data)
    {
        return Carreta::create($data);
    }
}
