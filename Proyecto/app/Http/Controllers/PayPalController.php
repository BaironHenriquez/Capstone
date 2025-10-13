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
            'plan_type' => 'required|string|in:basic,premium',
        ]);

        $user = Auth::user();
        $planType = $request->plan_type;
        $plans = config('paypal.plans');
        $plan = $plans[$planType];

        try {
            // Simular creación de pago PayPal (en producción usarías el SDK real)
            $paymentId = 'PAY-' . uniqid();
            $approvalUrl = route('paypal.approve', ['paymentId' => $paymentId]);

            // Crear registro de pago pendiente
            Payment::create([
                'user_id' => $user->id,
                'paypal_payment_id' => $paymentId,
                'amount' => $plan['price'],
                'currency' => $plan['currency'],
                'status' => 'pending',
                'type' => 'subscription',
                'description' => "Suscripción {$plan['name']}",
                'paypal_response' => [
                    'plan_type' => $planType,
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
        $payment = Payment::where('paypal_payment_id', $paymentId)->firstOrFail();
        
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

        $payment = Payment::where('paypal_payment_id', $request->payment_id)->firstOrFail();
        $user = $payment->user;

        try {
            // Simular ejecución del pago (en producción usarías PayPal SDK)
            $payment->update([
                'status' => 'completed',
                'paypal_payer_id' => $request->payer_id,
                'paid_at' => now(),
                'paypal_response' => array_merge($payment->paypal_response ?? [], [
                    'executed_at' => now()->toISOString(),
                    'payer_id' => $request->payer_id,
                ])
            ]);

            // Crear suscripción
            $planType = $payment->paypal_response['plan_type'];
            $plans = config('paypal.plans');
            $plan = $plans[$planType];

            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_type' => $planType,
                'status' => 'active',
                'paypal_subscription_id' => 'SUB-' . uniqid(),
                'amount' => $plan['price'],
                'currency' => $plan['currency'],
                'starts_at' => now(),
                'ends_at' => now()->addMonth(),
                'paypal_data' => [
                    'plan_name' => $plan['name'],
                    'payment_id' => $payment->paypal_payment_id,
                ]
            ]);

            // Actualizar usuario
            $user->update([
                'is_subscribed' => true,
            ]);

            // Asociar pago con suscripción
            $payment->update(['subscription_id' => $subscription->id]);

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
            $payment = Payment::where('paypal_payment_id', $paymentId)->first();
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
