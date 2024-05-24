<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use App\Models\util\ContaBancaria;
use Illuminate\Http\Request;

class ContaBancariaController extends Controller
{
    public function createContaBancaria(Request $request)
    {
        $conta_bancaria = new ContaBancaria;
        $conta_bancaria->setNumeroContaBancariaAttribute($request->input('numero_conta_bancaria'));
        $conta_bancaria->setAgenciaAttribute($request->input('agencia'));
        $conta_bancaria->setCodigoBancoAttribute($request->input('codigo_banco'));
        $conta_bancaria->setNomeBancoAttribute($request->input('nome_banco'));
        $conta_bancaria->setTitularidadeAttribute($request->input('titularidade'));
        $conta_bancaria->setTipoContaAttribute($request->input('tipo_conta'));
        $conta_bancaria->setPixAttribute($request->input('pix'));
        $conta_bancaria->setChavePixAttribute($request->input('chave_pix'));
        $conta_bancaria->save();
        $id_conta_bancaria = $conta_bancaria->id;
    }
}
