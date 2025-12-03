<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Transbank\Webpay\WebpayPlus\Transaction;
use Transbank\Webpay\Options;
use Transbank\Utils\HttpClientRequestService;
use App\Utils\TransbankHttpClientNoSSL;

class TransbankController extends Controller
{
    public function createTransaction(Request $request)
    {
        $request->validate([
            'period_type' => 'required|string|in:monthly,quarterly,yearly',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:CLP',
        ]);

        $user = Auth::user();
        $periodType = $request->period_type;
        $amount = $request->amount;
        
        $periods = config('paypal.periods');
        $period = $periods[$periodType];
        $subscription = config('paypal.subscription');

        try {
            // Configurar opciones de Transbank para ambiente de integración
            // El constructor de Options espera: apiKey, commerceCode, integrationType
            $options = new Options(
                config('transbank.api_key'),
                config('transbank.commerce_code'),
                config('transbank.environment')
            );
            
            $buyOrder = 'ORDER-' . uniqid();
            $sessionId = 'SESSION-' . $user->id . '-' . time();
            $returnUrl = route('transbank.return');

            // Usar cliente HTTP personalizado sin verificación SSL para desarrollo
            $httpClient = new TransbankHttpClientNoSSL();
            $requestService = new HttpClientRequestService($httpClient);
            
            $transaction = new Transaction($options, $requestService);
            $response = $transaction->create($buyOrder, $sessionId, $amount, $returnUrl);

            $payment = Payment::create([
                'user_id' => $user->id,
                'payment_method' => 'transbank',
                'payment_provider_id' => $buyOrder,
                'transaction_token' => $response->getToken(),
                'amount' => $amount,
                'currency' => 'CLP',
                'status' => 'pending',
                'type' => 'subscription',
                'description' => "{$subscription['name']} - {$period['name']}",
                'payment_provider_response' => [
                    'period_type' => $periodType,
                    'period_name' => $period['name'],
                    'buy_order' => $buyOrder,
                    'session_id' => $sessionId,
                    'created_at' => now()->toISOString()
                ]
            ]);

            return view('transbank.redirect', [
                'token' => $response->getToken(),
                'url' => $response->getUrl()
            ]);

        } catch (\Exception $e) {
            Log::error('Transbank transaction creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al procesar el pago con Transbank. Intenta nuevamente.');
        }
    }

    public function returnFromTransbank(Request $request)
    {
        $token = $request->input('token_ws');

        if (!$token) {
            return redirect()->route('subscription.plans')->with('error', 'Token inválido. Intenta nuevamente.');
        }

        try {
            // Confirmar transacción con Transbank
            // El constructor de Options espera: apiKey, commerceCode, integrationType
            $options = new Options(
                config('transbank.api_key'),
                config('transbank.commerce_code'),
                config('transbank.environment')
            );
            
            // Usar cliente HTTP personalizado sin verificación SSL para desarrollo
            $httpClient = new TransbankHttpClientNoSSL();
            $requestService = new HttpClientRequestService($httpClient);
            
            $transaction = new Transaction($options, $requestService);
            $response = $transaction->commit($token);

            // Buscar el pago por token
            $payment = Payment::where('transaction_token', $token)->firstOrFail();

            if ($response->isApproved()) {
                // getCardDetail() puede retornar array o null, no un objeto
                $cardDetail = $response->getCardDetail();
                $cardData = is_array($cardDetail) ? $cardDetail : null;

                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'payment_provider_response' => array_merge($payment->payment_provider_response ?? [], [
                        'vci' => $response->getVci(),
                        'amount' => $response->getAmount(),
                        'status' => $response->getStatus(),
                        'buy_order' => $response->getBuyOrder(),
                        'session_id' => $response->getSessionId(),
                        'card_detail' => $cardData,
                        'accounting_date' => $response->getAccountingDate(),
                        'transaction_date' => $response->getTransactionDate(),
                        'authorization_code' => $response->getAuthorizationCode(),
                        'payment_type_code' => $response->getPaymentTypeCode(),
                        'response_code' => $response->getResponseCode(),
                        'installments_number' => $response->getInstallmentsNumber(),
                    ])
                ]);

                $this->createSubscription($payment);

                return redirect()->route('dashboard')->with('success', '¡Pago completado exitosamente con Transbank!');
            } else {
                $payment->update(['status' => 'failed']);
                return redirect()->route('subscription.plans')->with('error', 'El pago fue rechazado por Transbank.');
            }

        } catch (\Exception $e) {
            Log::error('Transbank commit error: ' . $e->getMessage());
            return redirect()->route('subscription.plans')->with('error', 'Error al confirmar el pago. Intenta nuevamente.');
        }
    }

    private function createSubscription(Payment $payment)
    {
        $user = $payment->user;
        $periodType = $payment->payment_provider_response['period_type'];
        $periods = config('paypal.periods');
        $period = $periods[$periodType];

        Subscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        $endsAt = now();
        if ($period['interval'] === 'month') {
            $endsAt = now()->addMonths($period['interval_count']);
        } elseif ($period['interval'] === 'year') {
            $endsAt = now()->addYears($period['interval_count']);
        }

        $subscriptionRecord = Subscription::create([
            'user_id' => $user->id,
            'plan_type' => $periodType,
            'status' => 'active',
            'paypal_subscription_id' => 'TB-' . uniqid(),
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'starts_at' => now(),
            'ends_at' => $endsAt,
            'paypal_data' => [
                'subscription_name' => config('paypal.subscription.name'),
                'period_name' => $period['name'],
                'payment_method' => 'transbank',
                'payment_id' => $payment->payment_provider_id,
            ]
        ]);

        $user->update(['is_subscribed' => true]);
        $payment->update(['subscription_id' => $subscriptionRecord->id]);
    }
}

