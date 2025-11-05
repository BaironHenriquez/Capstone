<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToServicioTecnico
{
    /**
     * Boot the trait
     */
    protected static function bootBelongsToServicioTecnico()
    {
        // Al crear un registro, asignar automáticamente el servicio_tecnico_id
        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->servicioTecnico) {
                if (!isset($model->servicio_tecnico_id)) {
                    $model->servicio_tecnico_id = Auth::user()->servicioTecnico->id;
                }
            }
        });

        // Filtrar automáticamente por servicio técnico al hacer consultas
        static::addGlobalScope('servicio_tecnico', function (Builder $builder) {
            if (Auth::check() && Auth::user()->servicioTecnico) {
                $builder->where('servicio_tecnico_id', Auth::user()->servicioTecnico->id);
            }
        });
    }

    /**
     * Relación con el servicio técnico
     */
    public function servicioTecnico()
    {
        return $this->belongsTo(\App\Models\ServicioTecnico::class);
    }

    /**
     * Scope para filtrar por servicio técnico específico
     */
    public function scopeForServicioTecnico(Builder $query, $servicioTecnicoId)
    {
        return $query->where('servicio_tecnico_id', $servicioTecnicoId);
    }
}
