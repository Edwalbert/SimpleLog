<?php

namespace App\Repositories\Util;

use App\Models\Util\Senha;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SenhaRepository
{
    protected $model;

    public function __construct(Senha $senha)
    {
        $this->model = $senha;
    }

    public function index()
    {
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function consultaSenhas($request)
    {
        if ($request->input('pesquisar') !== null) {
            $filtro = $request->input('pesquisar');
        } else {
            $filtro = '';
        }
        $senhas = Senha::with('user')->where('sistema', 'like', "%$filtro%")->get();

        return ($senhas);
    }
}
