<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tecnico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tecnicos';

    protected $fillable = [
        'nombre',
        'apellido',
        'rut',
        'email',
        'password',
        'role_id',
        'email_verified_at',
        'telefono',
        'fecha_nacimiento',
        'direccion',
        'ciudad',
        'region',
        'especialidades',
        'nivel_experiencia',
        'certificaciones',
        'zona_trabajo',
        'disponible',
        'carga_trabajo_actual',
        'telefono_trabajo',
        'horario_trabajo',
        'salario_base',
        'comision_por_orden',
        'estado',
        'fecha_ingreso',
        'notas_admin',
        'servicio_tecnico_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'especialidades' => 'array',
        'certificaciones' => 'array',
        'disponible' => 'boolean',
        'carga_trabajo_actual' => 'integer',
        'salario_base' => 'decimal:2',
        'comision_por_orden' => 'decimal:2',
        'fecha_ingreso' => 'date',
        'fecha_nacimiento' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function servicioTecnico()
    {
        return $this->belongsTo(ServicioTecnico::class);
    }

    public function ordenes()
    {
        return $this->hasMany(OrdenServicio::class);
    }

    public function trabajadores()
    {
        return $this->hasMany(Trabajador::class);
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }

    public function getEspecialidadesTextoAttribute()
    {
        return is_array($this->especialidades) ? implode(', ', $this->especialidades) : $this->especialidades;
    }

    public function getEstadoBadgeAttribute()
    {
        $estados = [
            'activo' => 'bg-green-100 text-green-800',
            'inactivo' => 'bg-gray-100 text-gray-800',
            'vacaciones' => 'bg-blue-100 text-blue-800',
            'licencia' => 'bg-yellow-100 text-yellow-800',
            'suspendido' => 'bg-red-100 text-red-800'
        ];

        return $estados[$this->estado] ?? 'bg-gray-100 text-gray-800';
    }

    public function getCargaTrabajoColorAttribute()
    {
        if ($this->carga_trabajo_actual >= 90) {
            return 'text-red-600';
        } elseif ($this->carga_trabajo_actual >= 70) {
            return 'text-yellow-600';
        } else {
            return 'text-green-600';
        }
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true)
                    ->where('estado', 'activo')
                    ->where('carga_trabajo_actual', '<', 95);
    }

    public function scopeConEspecialidad($query, $especialidad)
    {
        return $query->whereJsonContains('especialidades', $especialidad);
    }

    public function scopeEnZona($query, $zona)
    {
        return $query->where('zona_trabajo', 'LIKE', "%{$zona}%");
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->whereHas('user', function($q) use ($termino) {
            $q->where('name', 'LIKE', "%{$termino}%")
              ->orWhere('email', 'LIKE', "%{$termino}%");
        })->orWhere('zona_trabajo', 'LIKE', "%{$termino}%");
    }

    // Métodos
    public function totalOrdenesAsignadas()
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

    public function promedioTiempoResolucion()
    {
        $ordenes = $this->ordenes()
            ->where('estado', 'completada')
            ->whereNotNull('fecha_completada')
            ->get();

        if ($ordenes->isEmpty()) {
            return 0;
        }

        $tiempos = $ordenes->map(function($orden) {
            return $orden->created_at->diffInDays($orden->fecha_completada);
        });

        return round($tiempos->avg(), 1);
    }

    public function ingresosMesActual()
    {
        return $this->ordenes()
            ->where('estado', 'completada')
            ->whereMonth('fecha_completada', now()->month)
            ->whereYear('fecha_completada', now()->year)
            ->sum('precio_total');
    }

    public function puedeTomarOrden()
    {
        return $this->disponible && 
               $this->estado === 'activo' && 
               $this->carga_trabajo_actual < 95;
    }

    public function actualizarCargaTrabajo()
    {
        $ordenes_activas = $this->ordenes()
            ->whereIn('estado', ['pendiente', 'en_progreso'])
            ->count();
        
        // Calcular porcentaje basado en máximo de 10 órdenes activas
        $this->carga_trabajo_actual = min(($ordenes_activas / 10) * 100, 100);
        $this->save();
    }

    public function recomendar($especialidad_requerida, $zona_preferida = null)
    {
        $puntuacion = 0;
        
        // Puntuación por especialidad
        if (in_array($especialidad_requerida, $this->especialidades ?? [])) {
            $puntuacion += 50;
        }
        
        // Puntuación por zona
        if ($zona_preferida && strpos($this->zona_trabajo, $zona_preferida) !== false) {
            $puntuacion += 20;
        }
        
        // Puntuación por disponibilidad
        if ($this->puedeTomarOrden()) {
            $puntuacion += 20;
        }
        
        // Penalización por carga de trabajo
        $puntuacion -= ($this->carga_trabajo_actual * 0.1);
        
        // Bonus por experiencia
        $niveles = ['junior' => 0, 'semi-senior' => 5, 'senior' => 10, 'experto' => 15];
        $puntuacion += $niveles[$this->nivel_experiencia] ?? 0;

        return max($puntuacion, 0);
    }
}