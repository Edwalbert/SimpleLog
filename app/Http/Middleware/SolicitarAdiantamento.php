<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class SolicitarAdiantamento
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if ((Auth::check() && Auth::user()->solicitar_adiantamento == 1) || Auth::user()->master == 1) {
            return $next($request);
        } else {
            return Redirect::route('home')->with('error', 'Você não tem permissão para solicitar adiantamentos!');
        }
    }
}
