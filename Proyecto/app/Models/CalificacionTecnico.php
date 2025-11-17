<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionTecnico extends Model
{
    use HasFactory;

    protected $table = 'calificaciones_tecnicos';

    protected $fillable = [
        'orden_servicio_id',
        'tecnico_id',
        'cliente_id',
        'calificacion',
        'comentario'
    ];

    // Relaciones
    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_servicio_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class, 'tecnico_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
