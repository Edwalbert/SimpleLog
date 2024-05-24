<?php

namespace App\Repositories\empresas;

use App\Models\empresas\Posto;
use App\Models\veiculos\Cavalo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PostoRepository
{
    protected $model;

    public function __construct(Posto $posto)
    {
        $this->model = $posto;
    }

    public function index(): Collection
    {
        $postos = Posto::with('enderecoPosto', 'contatoPosto')
            ->where('nome_posto', 'LIKE', '%russi%')
            ->orWhere('nome_posto', 'LIKE', '%zandona%')
            ->orWhere('nome_posto', 'LIKE', '%Posto 44%')
            ->orWhere('nome_posto', 'LIKE', '%mahle%')
            ->orWhere('nome_posto', 'LIKE', '%mazoti%')
            ->orWhere('nome_posto', 'LIKE', '%deposito%')
            ->orWhere('nome_posto', 'LIKE', '%coqueiro%')
            // ->orWhere('nome_posto', 'LIKE', '%Buffon Serafina (02)%')
            // ->orWhere('nome_posto', 'LIKE', '%Tradição%')
            // ->orWhere('nome_posto', 'LIKE', '%Fuck%')
            ->orWhere('nome_posto', 'LIKE', '%Mime%')
            ->orderBy('nome_posto')
            ->get();
        return $postos;
    }

    public function consultaGeralPosto($filtro = null)
    {
        $postos = Posto::with('contatoPosto', 'enderecoPosto')->orderBy('nome_posto')
            ->where('nome_posto', 'LIKE', "%$filtro%")
            ->where('nome_posto', '<>', 'Depósito')
            ->get();

        return $postos;
    }

    public function consultaParaDashboard()
    {
        $postos = Posto::orderBy('nome_posto')->get();
        return $postos;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }
}
