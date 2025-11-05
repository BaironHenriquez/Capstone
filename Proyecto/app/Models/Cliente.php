<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToServicioTecnico;

class Cliente extends Model
{
    use HasFactory, SoftDeletes, BelongsToServicioTecnico;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'direccion',
        'rut',
        'empresa',
        'tipo_cliente',
        'estado',
        'notas',
        'servicio_tecnico_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function servicioTecnico()
    {
        return $this->belongsTo(ServicioTecnico::class);
    }

    public function ordenes()
    {
        return $this->hasMany(OrdenServicio::class);
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function getEstadoBadgeAttribute()
    {
        $estados = [
            'activo' => 'bg-green-100 text-green-800',
            'inactivo' => 'bg-gray-100 text-gray-800',
            'vip' => 'bg-purple-100 text-purple-800',
            'moroso' => 'bg-red-100 text-red-800'
        ];

        return $estados[$this->estado] ?? 'bg-gray-100 text-gray-800';
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeVip($query)
    {
        return $query->where('tipo_cliente', 'vip');
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombre', 'LIKE', "%{$termino}%")
              ->orWhere('apellido', 'LIKE', "%{$termino}%")
              ->orWhere('correo', 'LIKE', "%{$termino}%")
              ->orWhere('rut', 'LIKE', "%{$termino}%")
              ->orWhere('empresa', 'LIKE', "%{$termino}%");
        });
    }

    // Métodos
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
        return $this->ordenes()->whereIn('estado', ['pendiente', 'en_progreso'])->count();
    }

    public function valorTotalGastado()
    {
        return $this->ordenes()
            ->where('estado', 'completada')
            ->sum('precio_total');
    }

    public function ultimaOrden()
    {
        return $this->ordenes()->latest()->first();
    }
}