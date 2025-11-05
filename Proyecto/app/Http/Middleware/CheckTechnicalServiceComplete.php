<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckTechnicalServiceComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Verificar si el usuario está autenticado y tiene suscripción activa
        if (!$user || !$user->is_subscribed) {
            Log::info('CheckTechnicalService: Usuario no tiene suscripción activa', ['user_id' => $user?->id]);
            return redirect()->route('subscription.plans');
        }

        // Si estamos en la ruta de setup, permitir el acceso
        if ($request->is('setup/technical-service')) {
            Log::info('CheckTechnicalService: Acceso permitido a setup page', ['user_id' => $user->id]);
            return $next($request);
        }

        // Verificar si el usuario tiene un servicio técnico completo usando el método del modelo
        $hasComplete = $user->hasCompleteProfile();
        
        Log::info('CheckTechnicalService: Verificando perfil', [
            'user_id' => $user->id,
            'has_complete_profile' => $hasComplete,
            'servicio_tecnico_id' => $user->servicioTecnico?->id,
            'ruta_actual' => $request->path()
        ]);

        if (!$hasComplete) {
            Log::warning('CheckTechnicalService: Redirigiendo a setup', [
                'user_id' => $user->id,
                'desde' => $request->path()
            ]);
            return redirect()->route('setup.technical-service');
        }

        Log::info('CheckTechnicalService: Perfil completo, permitiendo acceso', [
            'user_id' => $user->id,
            'servicio_id' => $user->servicioTecnico->id
        ]);

        return $next($request);
    }
}
