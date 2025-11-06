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
     * Relación con el servicio técnico que posee este usuario
     * Un usuario puede tener un servicio técnico
     */
    public function servicioTecnico()
    {
        return $this->hasOne(ServicioTecnico::class);
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
     * Accessor para obtener la suscripción activa (singular)
     */
    public function getSubscriptionAttribute()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->first();
    }

    /**
     * Relación con pagos
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Relación con técnico
     */
    public function tecnico()
    {
        return $this->hasOne(Tecnico::class);
    }

    /**
     * Relación con trabajador
     */
    public function trabajador()
    {
        return $this->hasOne(Trabajador::class);
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

    /**
     * Verificar si el usuario tiene un perfil de servicio técnico completo
     */
    public function hasCompleteProfile(): bool
    {
        // Cargar la relación si no está cargada
        if (!$this->relationLoaded('servicioTecnico')) {
            $this->load('servicioTecnico');
        }

        // Verificar si tiene un servicio técnico asociado
        if (!$this->servicioTecnico) {
            return false;
        }

        // Verificar que todos los campos requeridos estén completos
        $requiredFields = ['nombre_servicio', 'direccion', 'telefono', 'correo', 'rut'];
        
        foreach ($requiredFields as $field) {
            if (empty($this->servicioTecnico->$field)) {
                return false;
            }
        }

        return true;
    }
}
