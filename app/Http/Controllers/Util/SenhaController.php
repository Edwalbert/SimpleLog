<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\util\Senha;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SenhaController extends Controller

{
    public function storeOrUpdate(Request $request)
    {
        if ($request->input('id_senha') !== null) {
            $this->update($request);
        } else {
            $this->store($request);
        }
        setcookie("visualCookie", 'senhas');
        return redirect('consulta');
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $userId = '';
            if ($user) {
                $userId = $user->id;
            } else {
                return redirect()->back();
            }

            $senha = new Senha();
            $senha->setAcessoAttribute($request->input('acesso'));
            $senha->setSistemaAttribute($request->input('sistema'));
            $senha->setLinkAttribute($request->input('link'));
            $senha->setLoginAttribute($request->input('login'));
            $senha->setPasswordAttribute($request->input('password'));
            $senha->setDescricaoAttribute($request->input('descricao'));
            $senha->setIdUserAttribute($userId);

            $senha->save();
            DB::commit();
        } catch (QueryException $e) {
            DB::rollback();
            $errorReason = $e->errorInfo[2];
            dd($e);
            return response()->json(['error' => 'Erro ao salvar os dados ' . $errorReason], 500);
        }

        $title = 'Cadastro de Senhas';
        return view('operacao.Formularios.formulario-senhas', compact('title'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = Auth::user();
            $userId = '';
            if ($user) {
                $userId = $user->id;
            } else {
                return redirect()->back();
            }

            $senha = Senha::findOrFail($request->input('id_senha'));
            $senha->setAcessoAttribute($request->input('acesso'));
            $senha->setSistemaAttribute($request->input('sistema'));
            $senha->setLinkAttribute($request->input('link'));
            $senha->setLoginAttribute($request->input('login'));
            $senha->setPasswordAttribute($request->input('password'));
            $senha->setDescricaoAttribute($request->input('descricao'));
            $senha->setIdUserAttribute($userId);
            $senha->save();
            DB::commit();
        } catch (QueryException $e) {
            DB::rollback();
            $errorReason = $e->errorInfo[2];
            dd($e);
            return response()->json(['error' => 'Erro ao salvar os dados ' . $errorReason], 500);
        }
    }
}
