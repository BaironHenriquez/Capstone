<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trabajador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'trabajadores';

    protected $fillable = [
        'user_id',
        'tecnico_id',
        'tipo_trabajo',
        'habilidades',
        'nivel_experiencia',
        'zona_trabajo',
        'disponible',
        'telefono_trabajo',
        'horario_trabajo',
        'salario_por_hora',
        'estado',
        'fecha_ingreso',
        'notas_admin',
        'servicio_tecnico_id'
    ];

    protected $casts = [
        'habilidades' => 'array',
        'disponible' => 'boolean',
        'salario_por_hora' => 'decimal:2',
        'fecha_ingreso' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function servicioTecnico()
    {
        return $this->belongsTo(ServicioTecnico::class);
    }

    public function tareas()
    {
        return $this->hasMany(TareaTrabajador::class);
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return $this->user ? $this->user->name : 'Sin usuario';
    }

    public function getHabilidadesTextoAttribute()
    {
        return is_array($this->habilidades) ? implode(', ', $this->habilidades) : $this->habilidades;
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

    public function getTipoTrabajoBadgeAttribute()
    {
        $tipos = [
            'instalacion' => 'bg-blue-100 text-blue-800',
            'mantenimiento' => 'bg-green-100 text-green-800',
            'reparacion' => 'bg-orange-100 text-orange-800',
            'soporte' => 'bg-purple-100 text-purple-800',
            'general' => 'bg-gray-100 text-gray-800'
        ];

        return $tipos[$this->tipo_trabajo] ?? 'bg-gray-100 text-gray-800';
    }

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true)
                    ->where('estado', 'activo');
    }

    public function scopeConHabilidad($query, $habilidad)
    {
        return $query->whereJsonContains('habilidades', $habilidad);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_trabajo', $tipo);
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
        })->orWhere('zona_trabajo', 'LIKE', "%{$termino}%")
          ->orWhere('tipo_trabajo', 'LIKE', "%{$termino}%");
    }

    // Métodos
    public function totalTareas()
    {
        return $this->tareas()->count();
    }

    public function tareasCompletadas()
    {
        return $this->tareas()->where('estado', 'completada')->count();
    }

    public function tareasPendientes()
    {
        return $this->tareas()->whereIn('estado', ['asignada', 'en_progreso'])->count();
    }

    public function horasTrabajadasMes($mes = null, $año = null)
    {
        $mes = $mes ?? now()->month;
        $año = $año ?? now()->year;

        return $this->tareas()
            ->where('estado', 'completada')
            ->whereMonth('fecha_completada', $mes)
            ->whereYear('fecha_completada', $año)
            ->sum('horas_trabajadas');
    }

    public function ingresosMes($mes = null, $año = null)
    {
        $horas = $this->horasTrabajadasMes($mes, $año);
        return $horas * $this->salario_por_hora;
    }

    public function promedioCalificacion()
    {
        return $this->tareas()
            ->where('estado', 'completada')
            ->whereNotNull('calificacion')
            ->avg('calificacion');
    }

    public function puedeTomarTarea()
    {
        return $this->disponible && 
               $this->estado === 'activo' && 
               $this->tareasPendientes() < 5; // máximo 5 tareas pendientes
    }

    public function asignarATecnico($tecnico_id)
    {
        $this->tecnico_id = $tecnico_id;
        $this->save();
    }

    public function liberarDeTecnico()
    {
        $this->tecnico_id = null;
        $this->save();
    }
}