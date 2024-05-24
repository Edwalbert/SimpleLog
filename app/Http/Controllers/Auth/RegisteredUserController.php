<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'setor' => ['required', 'string', 'max:255'],
            'cpf' =>  ['required', 'string', 'max:11'],
        ]);

        $administrativo = 0;
        $solicitar_adiantamento = 0;
        $autorizar_adiantamento = 0;
        $operacao = 0;
        $monitoramento = 0;
        $enviar_adiantamento = 0;
        $cadastro = 0;
        $master = 0;

        switch ($request->setor) {
            case 'administrativo':
                $administrativo = 1;
                $solicitar_adiantamento = 1;
                $autorizar_adiantamento = 1;
                $enviar_adiantamento = 1;
                break;
            case 'operacao':
                $operacao = 1;
                $solicitar_adiantamento = 1;
                $autorizar_adiantamento = 1;
                break;
            case 'monitoramento':
                $monitoramento = 1;
                $cadastro = 1;
                $solicitar_adiantamento = 1;
                $autorizar_adiantamento = 1;
                break;
            case 'ssma':
                $cadastro = 1;
                $solicitar_adiantamento = 1;
                $autorizar_adiantamento = 1;
                break;
            case 'master':
                $master = 1;
                break;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'setor' => $request->setor,
            'cpf' => $request->cpf,
            'administrativo' => $administrativo,
            'solicitar_adiantamento' => $solicitar_adiantamento,
            'autorizar_adiantamento' => $autorizar_adiantamento,
            'enviar_adiantamento' => $enviar_adiantamento,
            'operacao' => $operacao,
            'monitoramento' => $monitoramento,
            'cadastro' => $cadastro,
            'master' => $master,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
