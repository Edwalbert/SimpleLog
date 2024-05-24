<?php

namespace App\Repositories\Util;

use App\Models\util\Rota;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RotaRepository
{
    protected $model;

    public function __construct(Rota $rota)
    {
        $this->model = $rota;
    }

    public function index(): Collection
    {
        $rotas = $this->model
            ->orderBy('cliente')
            ->orderByRaw("CASE WHEN POSITION('/' IN rota) > 0 THEN SUBSTRING(rota FROM POSITION('/' IN rota) + 1) ELSE rota END")
            ->get();


        foreach ($rotas as $rota) {
            $barPosition = strpos($rota->rota, '/', 0);
            $barPosition += 1;
            $rota->rota = substr($rota->rota, $barPosition, 10);
            $barPosition2 = strpos($rota->rota, '/', 0);
            $rota->rota = substr($rota->rota, 0, $barPosition2);
            trim(str_replace($rota->rota, '/', ''));
        }


        $uniqueRotas = $rotas->unique('rota');
        return $uniqueRotas;
    }


    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
