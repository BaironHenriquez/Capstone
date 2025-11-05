<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasServicioTecnico
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Si no hay usuario autenticado, redirigir al login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para continuar');
        }

        // Verificar si el usuario tiene un servicio técnico asociado
        if (!$user->servicioTecnico) {
            return redirect()->route('home')->with('error', 'No tiene un servicio técnico asociado. Contacte al administrador.');
        }

        // Agregar el servicio técnico al request para fácil acceso
        $request->merge([
            'servicio_tecnico_id' => $user->servicioTecnico->id
        ]);

        return $next($request);
    }
}
