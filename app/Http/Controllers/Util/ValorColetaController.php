<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Empresas\ButucaController;
use App\Models\util\ValorColeta;
use App\Repositories\Util\ValorColetaRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\pessoas\Motorista;


class ValorColetaController extends Controller
{
    private $butucaController;
    private $valorColetaRepository;

    public function __construct(
        ButucaController $butucaController,
        ValorColetaRepository $valorColetaRepository
    ) {
        $this->butucaController = $butucaController;
        $this->valorColetaRepository = $valorColetaRepository;
    }


    public function storeOrUpdate(Request $request)
    {

        if ($request->input('id_valor_coleta') !== null) {
            $resultado = $this->update($request);
            $successMessage = 'Valor atualizado com sucesso! ';
        } else {
            $resultado = $this->store($request);
            $successMessage = 'Valor cadastrado com sucesso! ';
        }

        $redirectRoute = 'cadastro-valor-coleta';
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

            $valorColeta = new ValorColeta;
            $valorColeta->setIdButucaAttribute($request->input('id_butuca'));
            $valorColeta->setIdTerminalColetaAttribute($request->input('id_terminal_coleta'));
            $valorColeta->setIdTerminalBaixaAttribute($request->input('id_terminal_baixa'));
            $valorColeta->setValorAttribute($request->input('valor'));
            $valorColeta->save();
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

            $valorColeta = ValorColeta::findOrFail($request->input('id_valor_coleta'));
            $valorColeta->setIdButucaAttribute($request->input('id_butuca'));
            $valorColeta->setIdTerminalColetaAttribute($request->input('id_terminal_coleta'));
            $valorColeta->setIdTerminalBaixaAttribute($request->input('id_terminal_baixa'));
            $valorColeta->setValorAttribute($request->input('valor'));
            $valorColeta->save();

            DB::commit();
            return 'success';
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    public function chamarIndex($id = null)
    {
        $butucas = $this->butucaController->butucas();
        $depots = $this->butucaController->depots();
        $terminais = $this->butucaController->terminais();

        return view('administrativo.Formularios.formulario-cadastro-valor-coleta', compact('butucas', 'depots', 'terminais'));
    }

    public function index($dados)
    {
        try {
            $dadosSeparados = \explode('...', $dados);
            $idButuca = $dadosSeparados[0];
            $idTerminalColeta = $dadosSeparados[1];
            $idTerminalBaixa = $dadosSeparados[2];

            $valorButuca = ValorColeta::where('id_butuca', $idButuca)
                ->where('id_terminal_coleta', $idTerminalColeta)
                ->where('id_terminal_baixa', $idTerminalBaixa)
                ->first();

            if ($valorButuca) {
                $atributos = $valorButuca->getAttributes();
                return response()->json(['data' => $atributos]);
            } else {
                return response()->json(['error' => 'Registro não encontrado'], 404);
            }
        } catch (ModelNotFoundException $exception) {
            return response()->json(['error' => 'Erro ao buscar registro'], 500);
        }
    }

    public function rotas($coluna, $id)
    {

        try {

            $registros = $this->valorColetaRepository->rotas($coluna, $id);

            return response()->json(['data' => $registros]);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'Erro ao buscar registros'], 500);
        }
    }
}
