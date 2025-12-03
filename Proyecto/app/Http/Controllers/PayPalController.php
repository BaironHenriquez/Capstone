<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    /**
     * Crear pago con PayPal
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'period_type' => 'required|string|in:monthly,quarterly,yearly',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:CLP,USD',
        ]);

        $user = Auth::user();
        $periodType = $request->period_type;
        $amount = $request->amount;
        $currency = $request->currency;
        
        $periods = config('paypal.periods');
        $period = $periods[$periodType];
        $subscription = config('paypal.subscription');

        try {
            // Simular creación de pago PayPal (en producción usarías el SDK real)
            $paymentId = 'PAY-' . uniqid();
            $approvalUrl = route('paypal.approve', ['paymentId' => $paymentId]);

            // Crear registro de pago pendiente
            Payment::create([
                'user_id' => $user->id,
                'payment_method' => 'paypal',
                'payment_provider_id' => $paymentId,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'pending',
                'type' => 'subscription',
                'description' => "{$subscription['name']} - {$period['name']}",
                'payment_provider_response' => [
                    'period_type' => $periodType,
                    'period_name' => $period['name'],
                    'created_at' => now()->toISOString()
                ]
            ]);

            return redirect($approvalUrl);

        } catch (\Exception $e) {
            Log::error('PayPal payment creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al procesar el pago. Intenta nuevamente.');
        }
    }

    /**
     * Página de aprobación de pago (simula la redirección de PayPal)
     */
    public function approvePayment(Request $request, $paymentId)
    {
        $payment = Payment::where('payment_method', 'paypal')
            ->where('payment_provider_id', $paymentId)
            ->firstOrFail();
        
        return view('paypal.approve', compact('payment'));
    }

    /**
     * Ejecutar pago aprobado
     */
    public function executePayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|string',
            'payer_id' => 'required|string',
        ]);

        $payment = Payment::where('payment_method', 'paypal')
            ->where('payment_provider_id', $request->payment_id)
            ->firstOrFail();
        $user = $payment->user;

        try {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
                'payment_provider_response' => array_merge($payment->payment_provider_response ?? [], [
                    'executed_at' => now()->toISOString(),
                    'payer_id' => $request->payer_id,
                ])
            ]);

            // Crear suscripción
            $periodType = $payment->payment_provider_response['period_type'];
            $periods = config('paypal.periods');
            $period = $periods[$periodType];
            $subscription = config('paypal.subscription');

            // Desactivar suscripciones anteriores del usuario
            Subscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            // Calcular fecha de fin según el período
            $endsAt = now();
            if ($period['interval'] === 'month') {
                $endsAt = now()->addMonths($period['interval_count']);
            } elseif ($period['interval'] === 'year') {
                $endsAt = now()->addYears($period['interval_count']);
            }

            $subscriptionRecord = Subscription::create([
                'user_id' => $user->id,
                'plan_type' => $periodType, // monthly, quarterly, yearly
                'status' => 'active',
                'paypal_subscription_id' => 'SUB-' . uniqid(),
                'amount' => $payment->amount,
                'currency' => $payment->currency,
                'starts_at' => now(),
                'ends_at' => $endsAt,
                'paypal_data' => [
                    'subscription_name' => $subscription['name'],
                    'period_name' => $period['name'],
                    'payment_method' => 'paypal',
                    'payment_id' => $payment->payment_provider_id,
                ]
            ]);

            // Actualizar usuario
            $user->update([
                'is_subscribed' => true,
            ]);

            // Asociar pago con suscripción
            $payment->update(['subscription_id' => $subscriptionRecord->id]);

            // Verificar si necesita configurar servicio técnico
            if (!$user->servicio_tecnico_id || !$this->hasCompleteProfile($user)) {
                return redirect()->route('setup.technical-service')
                    ->with('success', '¡Suscripción activada! Ahora completa la configuración de tu servicio técnico.');
            }

            return redirect()->route('dashboard')->with('success', '¡Suscripción activada exitosamente!');

        } catch (\Exception $e) {
            Log::error('PayPal payment execution error: ' . $e->getMessage());
            
            $payment->update(['status' => 'failed']);
            
            return redirect()->route('subscription.plans')->with('error', 'Error al completar el pago. Intenta nuevamente.');
        }
    }

    /**
     * Página de éxito de suscripción
     */
    public function success()
    {
        $user = Auth::user();
        $subscription = $user->activeSubscription;
        
        return view('subscription.success', compact('subscription'));
    }

    /**
     * Manejar cancelación de pago
     */
    public function cancel(Request $request)
    {
        $paymentId = $request->get('payment_id');
        
        if ($paymentId) {
            $payment = Payment::where('payment_method', 'paypal')
                ->where('payment_provider_id', $paymentId)
                ->first();
            if ($payment) {
                $payment->update(['status' => 'cancelled']);
            }
        }

        return redirect()->route('subscription.plans')->with('info', 'Pago cancelado. Puedes intentar nuevamente cuando desees.');
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
