<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión para acceder.');
        }

        if (!Auth::user()->role || Auth::user()->role->jerarquia < 4) {
            abort(403, 'Acceso denegado. Solo Super Administradores pueden acceder a esta sección.');
        }

        return $next($request);
    }
}
