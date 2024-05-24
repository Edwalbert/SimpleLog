<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nome' => 'string|max:45',
            'cpf' => 'string|max:11',
            'email' => 'email',
            'password' => 'string|max:20',
        ]);

        $user = new User;
        $user->name = $request->input('nome');
        $user->email = $request->input('email');
        $user->cpf = $request->input('cpf');
        $user->setor = $request->input('setor');
        $user->cargo = $request->input('cargo');
        $user->password = Hash::make($request->input('password')); // Hash da senha

        $user->save();

        return redirect('/login')->with('Usuario cadastrado com sucesso!');
    }
}
