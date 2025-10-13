<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nombre',
        'apellido',
        'rut',
        'telefono',
        'email',
        'password',
        'contrasena',
        'role_id',
        'servicio_tecnico_id',
        'google_id',
        'avatar',
        'email_verified',
        'email_verified_at',
        'provider',
        'trial_ends_at',
        'is_subscribed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'email_verified' => 'boolean',
            'trial_ends_at' => 'datetime',
            'is_subscribed' => 'boolean',
        ];
    }

    /**
     * Relación con la tabla roles
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relación con la tabla servicios_tecnicos
     */
    public function servicioTecnico()
    {
        return $this->belongsTo(ServicioTecnico::class);
    }

    /**
     * Relación con suscripciones
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Obtener suscripción activa
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }

    /**
     * Relación con pagos
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Verificar si el usuario tiene una suscripción activa
     */
    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription()->exists();
    }

    /**
     * Verificar si el usuario está en período de prueba
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Verificar si el usuario puede acceder al sistema
     */
    public function canAccessSystem(): bool
    {
        return $this->hasActiveSubscription() || $this->onTrial();
    }
}
