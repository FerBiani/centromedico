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

        $roles = explode(' ', $role);

        if (!in_array($request->user()->nivel_id, $roles)) {
            return back()->with('warning', 'Você não tem permissões suficientes para acessar este recurso');
        }

        return $next($request);
    }
}
