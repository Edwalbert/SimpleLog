<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSetor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        if ($request->user()) {
            if (($request->user()->setor === 'desenvolvimento') || Auth::user()->master == 1) {
                return $next($request);
            }
        }
        return abort(403, 'Acesso não autorizado.');
    }
}
