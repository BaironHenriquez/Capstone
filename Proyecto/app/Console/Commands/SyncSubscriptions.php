<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Payment;
use App\Models\Subscription;
use Carbon\Carbon;

class SyncSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:sync {--user_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronizar suscripciones basadas en pagos completados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user_id');
        
        if ($userId) {
            $users = User::where('id', $userId)->get();
            $this->info("Sincronizando suscripción para usuario ID: {$userId}");
        } else {
            $users = User::all();
            $this->info("Sincronizando suscripciones para todos los usuarios...");
        }

        $synced = 0;
        $skipped = 0;

        foreach ($users as $user) {
            // Obtener el pago más reciente completado
            $lastPayment = Payment::where('user_id', $user->id)
                ->where('status', 'completed')
                ->where('type', 'subscription')
                ->orderBy('paid_at', 'desc')
                ->first();

            if (!$lastPayment) {
                $this->warn("Usuario {$user->id} ({$user->email}) no tiene pagos completados. Omitiendo...");
                $skipped++;
                continue;
            }

            // Verificar si ya tiene una suscripción activa válida
            $activeSubscription = Subscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->where('ends_at', '>', now())
                ->first();

            if ($activeSubscription) {
                $this->info("Usuario {$user->id} ({$user->email}) ya tiene suscripción activa. Omitiendo...");
                $skipped++;
                continue;
            }

            // Desactivar suscripciones anteriores
            Subscription::where('user_id', $user->id)
                ->where('status', 'active')
                ->update(['status' => 'cancelled']);

            // Obtener información del período del pago
            $paypalResponse = $lastPayment->paypal_response;
            $periodType = $paypalResponse['period_type'] ?? 'monthly';
            
            // Configurar fechas según el tipo de período
            $startsAt = $lastPayment->paid_at;
            $endsAt = null;
            
            switch ($periodType) {
                case 'monthly':
                    $endsAt = Carbon::parse($startsAt)->addMonths(1);
                    break;
                case 'quarterly':
                    $endsAt = Carbon::parse($startsAt)->addMonths(3);
                    break;
                case 'yearly':
                    $endsAt = Carbon::parse($startsAt)->addYears(1);
                    break;
                default:
                    $endsAt = Carbon::parse($startsAt)->addMonths(1);
            }

            // Crear nueva suscripción
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_type' => $periodType,
                'status' => 'active',
                'paypal_subscription_id' => 'SUB-' . uniqid(),
                'amount' => $lastPayment->amount,
                'currency' => $lastPayment->currency,
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'paypal_data' => [
                    'payment_id' => $lastPayment->paypal_payment_id,
                    'synced_from_payment' => true,
                    'synced_at' => now()->toISOString(),
                ]
            ]);

            // Actualizar usuario
            $user->update(['is_subscribed' => true]);

            $this->info("✓ Usuario {$user->id} ({$user->email}) - Suscripción creada hasta {$endsAt->format('d/m/Y')}");
            $synced++;
        }

        $this->newLine();
        $this->info("Sincronización completada:");
        $this->info("- Sincronizadas: {$synced}");
        $this->info("- Omitidas: {$skipped}");
        
        return Command::SUCCESS;
    }
}
