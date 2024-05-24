<?php

namespace App\Repositories\empresas;

use App\Models\empresas\Transportadora;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TransportadoraRepository
{
    protected $model;

    public function __construct(Transportadora $transportadora)
    {
        $this->model = $transportadora;
    }

    public function index(): Collection
    {
        $transportadoras = $this->model->where('status', 'Ativo')->orderBy('razao_social')->pluck('razao_social', 'id');

        return $transportadoras;
    }


    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
