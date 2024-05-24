<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Empresas\ButucaController;
use App\Models\util\ValorTerminal;
use App\Repositories\Util\ValorTerminalRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValorTerminalController extends Controller
{
    private $butucaController;
    private $valorTerminalRepository;

    public function __construct(
        ButucaController $butucaController,
        ValorTerminalRepository $valorTerminalRepository,

    ) {
        $this->butucaController = $butucaController;
        $this->valorTerminalRepository = $valorTerminalRepository;
    }

    public function storeOrUpdate(Request $request)
    {

        if ($request->input('id_valor_terminal') !== null) {
            $resultado = $this->update($request);
            $successMessage = 'Valor atualizado com sucesso! ';
        } else {
            $resultado = $this->store($request);
            $successMessage = 'Valor cadastrado com sucesso! ';
        }

        $redirectRoute = 'cadastro-valor-terminal';
        $errorMessage = 'Erro! ';

        if ($resultado === 'success') {
            return redirect($redirectRoute)->with('success', $successMessage);
        } else {
            return redirect($redirectRoute)->with('error', $errorMessage . $resultado);
        }
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $valorTerminal = new ValorTerminal;
            $valorTerminal->setIdButucaAttribute($request->input('id_butuca'));
            $valorTerminal->setTipoContainerAttribute($request->input('tipo_container'));
            $valorTerminal->setValorAttribute($request->input('valor'));
            $valorTerminal->save();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();

            $id_valor_terminal = $request->input('id_valor_terminal');
            $valorTerminal = ValorTerminal::findOrFail($id_valor_terminal);

            $valorTerminal->setIdButucaAttribute($request->input('id_butuca'));
            $valorTerminal->setTipoContainerAttribute($request->input('tipo_container'));
            $valorTerminal->setValorAttribute($request->input('valor'));
            $valorTerminal->save();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function chamarIndex()
    {
        $terminais = $this->butucaController->terminais();
        return view('administrativo.Formularios.formulario-cadastro-valor-terminal', compact('terminais'));
    }

    public function index($terminalTipoContainer)
    {

        $dadosSeparados = \explode('...', $terminalTipoContainer);
        $id_terminal = $dadosSeparados[0];
        $tipo_container = $dadosSeparados[1];

        $valoresTerminal = $this->valorTerminalRepository->index($id_terminal, $tipo_container);
        return $valoresTerminal;
    }
}
