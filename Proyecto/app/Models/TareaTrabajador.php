<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareaTrabajador extends Model
{
    use HasFactory;

    protected $table = 'tareas_trabajador';

    protected $fillable = [
        'trabajador_id',
        'orden_servicio_id',
        'titulo',
        'descripcion',
        'estado',
        'prioridad',
        'fecha_asignada',
        'fecha_completada',
        'horas_trabajadas',
        'calificacion',
        'observaciones'
    ];

    protected $casts = [
        'fecha_asignada' => 'datetime',
        'fecha_completada' => 'datetime',
        'horas_trabajadas' => 'decimal:2',
        'calificacion' => 'integer'
    ];

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class);
    }
}