<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialOrden extends Model
{
    use HasFactory;

    protected $table = 'historial_orden';

    protected $fillable = [
        'orden_servicio_id',
        'accion',
        'usuario',
        'detalle',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'datetime'
    ];

    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class);
    }
}