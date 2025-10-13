<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Verificar si el usuario tiene una suscripción activa
        $activeSubscription = $user->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', Carbon::now())
            ->first();

        if (!$activeSubscription) {
            // Verificar si está en período de prueba
            $trialEndsAt = $user->created_at->addDays(7);
            
            if (Carbon::now()->greaterThan($trialEndsAt)) {
                // El período de prueba ha expirado
                return redirect()->route('subscription.plans')
                    ->with('warning', 'Tu período de prueba ha expirado. Selecciona un plan para continuar usando el servicio.');
            }
        }

        return $next($request);
    }
}