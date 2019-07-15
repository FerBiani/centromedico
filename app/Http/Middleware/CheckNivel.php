<?php

namespace App\Http\Middleware;

use Closure;

class CheckNivel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {

        if ($request->user()->nivel_id > $role) {
            return back()->with('warning', 'Você não tem permissões suficientes para acessar este recurso');
        }

        return $next($request);
    }
}
