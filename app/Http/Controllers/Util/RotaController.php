<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\cr;
use Illuminate\Http\Request;
use App\Repositories\Util\RotaRepository;
use PhpOffice\PhpSpreadsheet\Reader\Xls\RC4;

class RotaController extends Controller
{

    private $rotaRepository;

    public function __construct(RotaRepository $rotaRepository)
    {
        $this->rotaRepository = $rotaRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rotas = $this->rotaRepository->index();
        
        return $rotas;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    public function update(Request $request)
    {
        //
    }
}
