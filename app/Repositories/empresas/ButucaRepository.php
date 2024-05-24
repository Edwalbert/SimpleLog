<?php

namespace App\Repositories\empresas;

use App\Models\empresas\Butuca;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ButucaRepository
{
    protected $model;

    public function __construct(Butuca $butuca)
    {
        $this->model = $butuca;
    }

    public function index(): Collection
    {
        $butucas = $this->model->where('id', '!=', null)
            ->orderBy('nome')->pluck('nome', 'id');

        return $butucas;
    }


    public function butucas(): Collection
    {
        $butucas = $this->model->where('butuca', '!=', false)
            ->orderBy('nome')->pluck('nome', 'id');
        return $butucas;
    }

    public function depots(): Collection
    {
        $depots = $this->model->where('depot', '!=', false)
            ->orderBy('nome')->pluck('nome', 'id');
        return $depots;
    }


    public function terminais(): Collection
    {
        $terminais = $this->model->where('terminal', '!=', false)
            ->orderBy('nome')->pluck('nome', 'id');
        return $terminais;
    }


    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
