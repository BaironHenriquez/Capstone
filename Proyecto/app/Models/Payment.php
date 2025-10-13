<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'paypal_payment_id',
        'paypal_payer_id',
        'amount',
        'currency',
        'status',
        'type',
        'description',
        'paypal_response',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paypal_response' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con la suscripción
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Verificar si el pago está completado
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Verificar si el pago está pendiente
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Marcar como completado
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);
    }

    /**
     * Scopes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForSubscription($query)
    {
        return $query->where('type', 'subscription');
    }
}
