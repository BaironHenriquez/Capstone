<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicioTecnico extends Model
{
    use HasFactory;

    // Especificar el nombre correcto de la tabla
    protected $table = 'servicios_tecnicos';

    protected $fillable = [
        'user_id',
        'nombre_servicio',
        'direccion',
        'telefono',
        'correo',
        'rut',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Relación con el usuario propietario del servicio técnico
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con clientes
     */
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    /**
     * Relación con técnicos
     */
    public function tecnicos()
    {
        return $this->hasMany(Tecnico::class);
    }

    /**
     * Relación con trabajadores
     */
    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class);
    }

    /**
     * Relación con órdenes de servicio
     */
    public function ordenes()
    {
        return $this->hasMany(OrdenServicio::class);
    }

    // Métodos
    public function totalClientes()
    {
        return $this->clientes()->count();
    }

    public function totalTecnicos()
    {
        return $this->tecnicos()->count();
    }

    public function totalTrabajadores()
    {
        return $this->trabajadores()->count();
    }

    public function totalOrdenes()
    {
        return $this->ordenes()->count();
    }

    public function ordenesCompletadas()
    {
        return $this->ordenes()->where('estado', 'completada')->count();
    }

    public function ordenesPendientes()
    {
        return $this->ordenes()->whereIn('estado', ['pendiente', 'asignada', 'en_progreso'])->count();
    }

    public function ingresosMensuales($mes = null, $año = null)
    {
        $mes = $mes ?? now()->month;
        $año = $año ?? now()->year;

        return $this->ordenes()
            ->where('estado', 'completada')
            ->whereMonth('fecha_completada', $mes)
            ->whereYear('fecha_completada', $año)
            ->sum('precio_total');
    }
}
