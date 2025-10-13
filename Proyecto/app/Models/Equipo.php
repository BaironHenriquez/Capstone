<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipos';

    protected $fillable = [
        'tipo_equipo',
        'modelo',
        'marca_id',
        'descripcion',
        'numero_serie',
        'especificaciones',
        'activo',
        'categoria',
        'precio_referencial',
        'garantia_meses',
        'manual_url',
        'imagen'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'especificaciones' => 'array',
        'precio_referencial' => 'decimal:2',
        'garantia_meses' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function clienteEquipos()
    {
        return $this->hasMany(ClienteEquipo::class);
    }

    public function ordenesServicio()
    {
        return $this->hasManyThrough(
            OrdenServicio::class,
            ClienteEquipo::class,
            'equipo_id',
            'cliente_equipo_id',
            'id',
            'id'
        );
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('tipo_equipo', 'LIKE', "%{$termino}%")
              ->orWhere('modelo', 'LIKE', "%{$termino}%")
              ->orWhere('descripcion', 'LIKE', "%{$termino}%")
              ->orWhere('categoria', 'LIKE', "%{$termino}%")
              ->orWhere('numero_serie', 'LIKE', "%{$termino}%")
              ->orWhereHas('marca', function($q) use ($termino) {
                  $q->where('nombre_marca', 'LIKE', "%{$termino}%");
              });
        });
    }

    public function scopePorMarca($query, $marcaId)
    {
        return $query->where('marca_id', $marcaId);
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->marca->nombre_marca . ' ' . $this->modelo;
    }

    public function getEstadoBadgeAttribute()
    {
        return $this->activo 
            ? 'bg-green-100 text-green-800' 
            : 'bg-red-100 text-red-800';
    }

    public function getImagenUrlAttribute()
    {
        if ($this->imagen) {
            return asset('storage/equipos/' . $this->imagen);
        }
        return asset('images/equipo-default.png');
    }

    public function getPrecioFormateadoAttribute()
    {
        return $this->precio_referencial 
            ? '$' . number_format($this->precio_referencial, 0, ',', '.') 
            : 'N/D';
    }

    public function getGarantiaTextoAttribute()
    {
        if (!$this->garantia_meses) return 'Sin garantía';
        
        if ($this->garantia_meses < 12) {
            return $this->garantia_meses . ' ' . ($this->garantia_meses === 1 ? 'mes' : 'meses');
        }
        
        $años = floor($this->garantia_meses / 12);
        $mesesExtra = $this->garantia_meses % 12;
        
        $texto = $años . ' ' . ($años === 1 ? 'año' : 'años');
        if ($mesesExtra > 0) {
            $texto .= ' y ' . $mesesExtra . ' ' . ($mesesExtra === 1 ? 'mes' : 'meses');
        }
        
        return $texto;
    }

    // Métodos
    public function totalClientesAsociados()
    {
        return $this->clienteEquipos()
            ->distinct('cliente_id')
            ->count('cliente_id');
    }

    public function totalOrdenesServicio()
    {
        return $this->ordenesServicio()->count();
    }

    public function ordenesActivasCount()
    {
        return $this->ordenesServicio()
            ->whereIn('estado', ['pendiente', 'en_progreso'])
            ->count();
    }

    public function ultimaOrdenServicio()
    {
        return $this->ordenesServicio()
            ->latest('created_at')
            ->first();
    }

    public function esPopular()
    {
        return $this->totalClientesAsociados() >= 5 || $this->totalOrdenesServicio() >= 10;
    }

    public function necesitaMantenimiento()
    {
        $ultimaOrden = $this->ultimaOrdenServicio();
        if (!$ultimaOrden) return false;
        
        return $ultimaOrden->created_at->diffInMonths(now()) >= 6;
    }
}