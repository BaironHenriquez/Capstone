<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return redirect()->route('subscription.plans');
        }

        // Verificar si el usuario tiene un servicio técnico asignado y completo
        if (!$user->servicio_tecnico_id || !$this->hasCompleteProfile($user)) {
            return redirect()->route('setup.technical-service');
        }

        return $next($request);
    }

    /**
     * Verificar si el usuario tiene el perfil completo
     */
    private function hasCompleteProfile($user): bool
    {
        // Verificar que tenga servicio técnico
        if (!$user->servicioTecnico) {
            return false;
        }

        $servicioTecnico = $user->servicioTecnico;

        // Verificar que los campos esenciales del servicio técnico estén completos
        return !empty($servicioTecnico->nombre_servicio) &&
               !empty($servicioTecnico->direccion) &&
               !empty($servicioTecnico->telefono) &&
               !empty($servicioTecnico->correo) &&
               !empty($servicioTecnico->rut);
    }
}
