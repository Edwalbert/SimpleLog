<?php

namespace App\Http\Controllers\Empresas;

use App\Http\Controllers\Controller;
use App\Models\empresas\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        if ($request->input('id_cliente') !== null) {
            $resultado = $this->update($request);
        } else {
            $resultado = $this->store($request);
        }

        $redirectRoute = 'cadastro-clientes';
        $successMessage = 'Cliente ';
        $errorMessage = 'Erro! ';

        if ($resultado === 'success') {
            return redirect($redirectRoute)->with('success', $successMessage . 'atualizado com sucesso!');
        } else {
            return redirect($redirectRoute)->with('error', $errorMessage . $resultado);
        }
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $cliente = new Cliente;
            $cliente->setRazaoSocialAttribute($request->input('razao_social'));
            $cliente->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('cadastro-clientes-resumido')->with('error', $e);
        }
        return redirect('cadastro-clientes-resumido')->with('success', 'Cadastrado com sucesso!');
    }

    public function consultaFormularioCliente($id = null)
    {
        if ($id !== null) {
            $clientes = Cliente::find($id);
        } else {
            $clientes = null;
        }

        return view('administrativo.Formularios.formulario-cadastro-clientes-resumido', compact('clientes'));
    }
}
