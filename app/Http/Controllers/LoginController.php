<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use app\Models\User;

class LoginController extends Controller
{
    public function auth(Request $request)
    {
        $credenciais = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required']
            ]
        );

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        } else {
            return redirect()->back()->with('erro', 'Usuário ou senha inválido.');
        }
    }
}
