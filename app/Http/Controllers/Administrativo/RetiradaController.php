<?php

namespace App\Http\Controllers\Administrativo;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Empresas\ButucaController;
use App\Http\Controllers\Util\ValorColetaController;
use App\Models\administrativo\retiradas\Retirada;
use App\Models\empresas\Cliente;
use App\Models\User;
use App\Models\util\Contato;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetiradaController extends Controller
{

    private $butucaController;
    private $valorColetaController;

    public function __construct(
        ButucaController $butucaController,
        ValorColetaController $valorColetaController,
    ) {
        $this->butucaController = $butucaController;
        $this->valorColetaController = $valorColetaController;
    }

    public function storeOrUpdate(Request $request)
    {
        $status = $request->input('status');
        if ($status == 'Criado') {
            if ($request->input('id_retirada') !== null) {

                $resultado =    $this->update($request);
                $successMessage = 'Retirada atualizada com sucesso! ';
            } else {

                $resultado = $this->store($request);
                $successMessage = 'Retirada inserida com sucesso! ';
            }

            $redirectRoute = 'retiradas-solicitadas';
            $errorMessage = 'Erro! ';

            if ($resultado === 'success') {
                return redirect($redirectRoute)->with('success', $successMessage);
            } else {
                return redirect($redirectRoute)->with('error', $errorMessage . $resultado);
            }
        } else {
            return redirect()->back()->with('error', 'Impossível editar. Status: ' . $status);
        }
    }


    public function store(Request $request)
    {
        if (auth()->check()) {
            $id_user = auth()->user()->id;
        }
        try {
            DB::beginTransaction();

            $retirada = new Retirada;
            $retirada->setDataAttribute($request->input('data_retirada'));
            $retirada->setIdClienteAttribute($request->input('id_cliente'));
            $retirada->setIdButucaAttribute($request->input('id_butuca'));
            $retirada->setIdRotaAttribute($request->input('rota'));
            $retirada->setIdCavaloAttribute($request->input('id_cavalo'));
            $retirada->setContainerAttribute($request->input('container'));
            $retirada->setValorButucaAttribute($request->input('valor_butuca'));
            $retirada->setValorTerminalAttribute($request->input('valor_terminal'));
            $retirada->setValorDescontoAttribute($request->input('valor_desconto'));
            $retirada->setStatusAttribute('Pendente');
            $retirada->setIdSolicitadoAttribute($id_user);
            $retirada->setObservacaoAttribute($request->input('observacao'));
            $retirada->save();

            DB::commit();
            return ('success');
        } catch (QueryException $e) {

            $errorReason = $e->errorInfo[2];
            dd($errorReason);
            DB::rollback();
            return redirect('adiantamentos-solicitados')->with('error', 'Erro ao salvar os dados ' . $errorReason);
        }
    }

    public function update(Request $request)
    {

        try {
            DB::beginTransaction();

            if (auth()->check()) {
                $id_user = auth()->user()->id;
            }

            $retirada = Retirada::findOrFail($request->input('id_retirada'));
            $retirada->setIdClienteAttribute($request->input('id_cliente'));
            $retirada->setIdTerminalAttribute($request->input('id_terminal'));
            $retirada->setIdButucaAttribute($request->input('id_butuca'));
            $retirada->setIdCavaloAttribute($request->input('id_cavalo'));
            $retirada->setContainerAttribute($request->input('container'));
            $retirada->setValorServicoAttribute($request->input('valor_servico'));
            $retirada->setValorDescontoAttribute($request->input('valor_desconto'));
            $retirada->setIdSolicitadoAttribute($id_user);
            $retirada->setObservacaoAttribute($request->input('observacao'));
            $retirada->save();

            DB::commit();
        } catch (QueryException $e) {

            $errorReason = $e->errorInfo[2];

            DB::rollback();
            return redirect('adiantamentos-solicitados')->with('error', 'Erro ao salvar os dados ' . $errorReason);
        }
    }

    public function chamarIndex()
    {
        $butucas = $this->butucaController->butucas();
        $clientes = Cliente::orderBy('razao_social')->get();

        return view('administrativo.Formularios.formulario-solicitar-retirada', compact('butucas', 'clientes'));
    }

    public function consultaRetiradasSolicitadas()
    {

        return view('administrativo.Consultas.consulta-retiradas-solicitadas');
    }
}
