<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'marcas';

    protected $fillable = [
        'nombre_marca',
        'descripcion',
        'activa',
        'logo',
        'sitio_web',
        'pais_origen',
        'categoria'
    ];

    protected $casts = [
        'activa' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function clienteEquipos()
    {
        return $this->hasManyThrough(ClienteEquipo::class, Equipo::class);
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('nombre_marca', 'LIKE', "%{$termino}%")
              ->orWhere('descripcion', 'LIKE', "%{$termino}%")
              ->orWhere('categoria', 'LIKE', "%{$termino}%")
              ->orWhere('pais_origen', 'LIKE', "%{$termino}%");
        });
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    // Accessors
    public function getEstadoBadgeAttribute()
    {
        return $this->activa 
            ? 'bg-green-100 text-green-800' 
            : 'bg-red-100 text-red-800';
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/marcas/' . $this->logo);
        }
        return asset('images/marca-default.png');
    }

    // Métodos
    public function totalEquipos()
    {
        return $this->equipos()->count();
    }

    public function equiposActivos()
    {
        return $this->equipos()->where('activo', true)->count();
    }

    public function clientesAsociados()
    {
        return $this->clienteEquipos()
            ->distinct('cliente_id')
            ->count('cliente_id');
    }

    public function ordenesRelacionadas()
    {
        return $this->hasManyThrough(
            OrdenServicio::class,
            ClienteEquipo::class,
            'marca_id',
            'cliente_equipo_id',
            'id',
            'id'
        )->count();
    }

    public function esPopular()
    {
        return $this->totalEquipos() >= 10 || $this->clientesAsociados() >= 5;
    }
}