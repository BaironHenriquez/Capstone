<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteEquipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cliente_equipos';

    protected $fillable = [
        'cliente_id',
        'equipo_id',
        'numero_serie',
        'fecha_compra',
        'fecha_garantia',
        'estado',
        'observaciones',
        'precio_compra',
        'proveedor',
        'ubicacion',
        'activo'
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'fecha_garantia' => 'date',
        'precio_compra' => 'decimal:2',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function ordenesServicio()
    {
        return $this->hasMany(OrdenServicio::class, 'cliente_equipo_id');
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeConGarantia($query)
    {
        return $query->where('fecha_garantia', '>=', now());
    }

    public function scopeSinGarantia($query)
    {
        return $query->where('fecha_garantia', '<', now())
                    ->orWhereNull('fecha_garantia');
    }

    public function scopePorEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('numero_serie', 'LIKE', "%{$termino}%")
              ->orWhere('observaciones', 'LIKE', "%{$termino}%")
              ->orWhere('proveedor', 'LIKE', "%{$termino}%")
              ->orWhere('ubicacion', 'LIKE', "%{$termino}%")
              ->orWhereHas('cliente', function($q) use ($termino) {
                  $q->where('nombre', 'LIKE', "%{$termino}%")
                    ->orWhere('apellido', 'LIKE', "%{$termino}%")
                    ->orWhere('empresa', 'LIKE', "%{$termino}%");
              })
              ->orWhereHas('equipo', function($q) use ($termino) {
                  $q->where('tipo_equipo', 'LIKE', "%{$termino}%")
                    ->orWhere('modelo', 'LIKE', "%{$termino}%");
              });
        });
    }

    // Accessors
    public function getEstadoBadgeAttribute()
    {
        $estados = [
            'operativo' => 'bg-green-100 text-green-800',
            'mantenimiento' => 'bg-yellow-100 text-yellow-800',
            'reparacion' => 'bg-orange-100 text-orange-800',
            'fuera_servicio' => 'bg-red-100 text-red-800',
            'retirado' => 'bg-gray-100 text-gray-800'
        ];

        return $estados[$this->estado] ?? 'bg-gray-100 text-gray-800';
    }

    public function getGarantiaEstadoAttribute()
    {
        if (!$this->fecha_garantia) {
            return ['estado' => 'sin_garantia', 'texto' => 'Sin garantía', 'clase' => 'text-gray-500'];
        }

        $diasRestantes = now()->diffInDays($this->fecha_garantia, false);

        if ($diasRestantes < 0) {
            return ['estado' => 'vencida', 'texto' => 'Garantía vencida', 'clase' => 'text-red-500'];
        }

        if ($diasRestantes <= 30) {
            return ['estado' => 'por_vencer', 'texto' => "Vence en {$diasRestantes} días", 'clase' => 'text-orange-500'];
        }

        return ['estado' => 'vigente', 'texto' => "Vigente ({$diasRestantes} días)", 'clase' => 'text-green-500'];
    }

    public function getNombreCompletoEquipoAttribute()
    {
        return $this->equipo->marca->nombre_marca . ' ' . $this->equipo->modelo . ' - ' . $this->numero_serie;
    }

    public function getPrecioCompraFormateadoAttribute()
    {
        return $this->precio_compra 
            ? '$' . number_format($this->precio_compra, 0, ',', '.') 
            : 'No especificado';
    }

    // Métodos
    public function tieneGarantiaVigente()
    {
        return $this->fecha_garantia && $this->fecha_garantia >= now();
    }

    public function diasGarantiaRestantes()
    {
        if (!$this->tieneGarantiaVigente()) return 0;
        return now()->diffInDays($this->fecha_garantia);
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
        return $this->ordenesServicio()->latest('created_at')->first();
    }

    public function valorTotalGastadoServicio()
    {
        return $this->ordenesServicio()
            ->where('estado', 'completada')
            ->sum('precio_total');
    }

    public function necesitaMantenimiento()
    {
        $ultimaOrden = $this->ultimaOrdenServicio();
        if (!$ultimaOrden) return true;
        
        return $ultimaOrden->created_at->diffInMonths(now()) >= 6;
    }
}