<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioOrden extends Model
{
    use HasFactory;

    protected $table = 'comentarios_orden';

    protected $fillable = [
        'orden_servicio_id',
        'usuario',
        'tipo_usuario',
        'comentario',
        'es_interno',
        'archivos_adjuntos'
    ];

    protected $casts = [
        'es_interno' => 'boolean',
        'archivos_adjuntos' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class);
    }
}