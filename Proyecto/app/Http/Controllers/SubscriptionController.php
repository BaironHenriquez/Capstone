<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Mostrar planes de suscripción
     */
    public function showPlans()
    {
        $user = Auth::user();
        $currentSubscription = $user->activeSubscription;
        
        $subscription = config('paypal.subscription');
        $periods = config('paypal.periods');
        
        return view('subscription.plans', compact('subscription', 'periods', 'currentSubscription', 'user'));
    }

    /**
     * Mostrar página de checkout para un período específico
     */
    public function checkout($period)
    {
        $user = Auth::user();
        
        // Verificar que el período existe
        $periods = config('paypal.periods');
        if (!array_key_exists($period, $periods)) {
            return redirect()->route('subscription.plans')->with('error', 'Período de pago no válido.');
        }
        
        $subscription = config('paypal.subscription');
        $selectedPeriod = $periods[$period];
        $selectedPeriod['type'] = $period;
        
        return view('subscription.checkout', compact('subscription', 'selectedPeriod', 'user'));
    }

    /**
     * Mostrar información de suscripción actual
     */
    public function show()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        $payments = $user->payments()->latest()->take(10)->get();
        
        if (!$subscription) {
            return redirect()->route('subscription.plans')->with('info', 'No tienes una suscripción activa.');
        }
        
        return view('subscription.show', compact('subscription', 'payments'));
    }

    /**
     * Cancelar suscripción
     */
    public function cancel()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        
        if (!$subscription) {
            return redirect()->route('subscription.plans')->with('error', 'No tienes una suscripción activa para cancelar.');
        }
        
        // Aquí se implementaría la lógica de cancelación en PayPal
        // Por ahora solo marcamos como cancelada
        $subscription->cancel();
        
        return redirect()->route('subscription.show')->with('success', 'Suscripción cancelada exitosamente.');
    }

    /**
     * Página de éxito de suscripción
     */
    public function success()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        
        if (!$subscription) {
            return redirect()->route('subscription.plans')->with('error', 'No se encontró suscripción activa.');
        }
        
        return view('subscription.success', compact('user', 'subscription'));
    }
}
