<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class OrdenServicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ordenes_servicio';

    protected $fillable = [
        'numero_orden',
        'cliente_id',
        'tecnico_id',
        'tipo_servicio',
        'descripcion_problema',
        'descripcion_solucion',
        'estado',
        'prioridad',
        'fecha_programada',
        'fecha_iniciada',
        'fecha_completada',
        'precio_presupuestado',
        'precio_total',
        'horas_estimadas',
        'horas_trabajadas',
        'ubicacion_servicio',
        'contacto_en_sitio',
        'telefono_contacto',
        'equipos_necesarios',
        'materiales_usados',
        'observaciones_tecnico',
        'observaciones_cliente',
        'calificacion_cliente',
        'firma_cliente',
        'fotos_antes',
        'fotos_despues',
        'archivos_adjuntos',
        'requiere_aprobacion',
        'aprobado_por',
        'fecha_aprobacion',
        'motivo_rechazo',
        'servicio_tecnico_id'
    ];

    protected $casts = [
        'fecha_programada' => 'datetime',
        'fecha_iniciada' => 'datetime',
        'fecha_completada' => 'datetime',
        'precio_presupuestado' => 'decimal:2',
        'precio_total' => 'decimal:2',
        'horas_estimadas' => 'decimal:2',
        'horas_trabajadas' => 'decimal:2',
        'calificacion_cliente' => 'integer',
        'equipos_necesarios' => 'array',
        'materiales_usados' => 'array',
        'fotos_antes' => 'array',
        'fotos_despues' => 'array',
        'archivos_adjuntos' => 'array',
        'requiere_aprobacion' => 'boolean',
        'fecha_aprobacion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function servicioTecnico()
    {
        return $this->belongsTo(ServicioTecnico::class);
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioOrden::class);
    }

    public function historial()
    {
        return $this->hasMany(HistorialOrden::class);
    }

    // Accessors
    public function getEstadoBadgeAttribute()
    {
        $estados = [
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'asignada' => 'bg-blue-100 text-blue-800',
            'en_progreso' => 'bg-indigo-100 text-indigo-800',
            'completada' => 'bg-green-100 text-green-800',
            'cancelada' => 'bg-red-100 text-red-800',
            'en_revision' => 'bg-orange-100 text-orange-800'
        ];

        return $estados[$this->estado] ?? 'bg-gray-100 text-gray-800';
    }

    public function getPrioridadBadgeAttribute()
    {
        $prioridades = [
            'baja' => 'bg-gray-100 text-gray-800',
            'media' => 'bg-yellow-100 text-yellow-800',
            'alta' => 'bg-orange-100 text-orange-800',
            'urgente' => 'bg-red-100 text-red-800'
        ];

        return $prioridades[$this->prioridad] ?? 'bg-gray-100 text-gray-800';
    }

    public function getDiasTranscurridosAttribute()
    {
        return $this->created_at->diffInDays(now());
    }

    public function getTiempoEstimadoRestanteAttribute()
    {
        if ($this->estado === 'completada') {
            return 0;
        }

        if ($this->fecha_programada) {
            return now()->diffInDays($this->fecha_programada, false);
        }

        return null;
    }

    public function getEficienciaAttribute()
    {
        if (!$this->horas_estimadas || !$this->horas_trabajadas) {
            return null;
        }

        return round(($this->horas_estimadas / $this->horas_trabajadas) * 100, 1);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnProgreso($query)
    {
        return $query->where('estado', 'en_progreso');
    }

    public function scopeCompletadas($query)
    {
        return $query->where('estado', 'completada');
    }

    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    public function scopeRetrasadas($query)
    {
        return $query->where('fecha_programada', '<', now())
                    ->whereNotIn('estado', ['completada', 'cancelada']);
    }

    public function scopeBuscar($query, $termino)
    {
        return $query->where(function($q) use ($termino) {
            $q->where('numero_orden', 'LIKE', "%{$termino}%")
              ->orWhere('descripcion_problema', 'LIKE', "%{$termino}%")
              ->orWhereHas('cliente', function($clienteQ) use ($termino) {
                  $clienteQ->where('nombre', 'LIKE', "%{$termino}%")
                          ->orWhere('apellido', 'LIKE', "%{$termino}%")
                          ->orWhere('empresa', 'LIKE', "%{$termino}%");
              });
        });
    }

    // Métodos
    public static function generarNumeroOrden($servicio_tecnico_id)
    {
        $año = date('Y');
        $mes = date('m');
        
        $ultimo_numero = self::where('servicio_tecnico_id', $servicio_tecnico_id)
            ->whereYear('created_at', $año)
            ->whereMonth('created_at', $mes)
            ->count() + 1;
        
        return "TS-{$año}{$mes}-" . str_pad($ultimo_numero, 3, '0', STR_PAD_LEFT);
    }

    public function iniciar()
    {
        $this->estado = 'en_progreso';
        $this->fecha_iniciada = now();
        $this->save();
        
        $this->registrarHistorial('Orden iniciada', 'Sistema');
    }

    public function completar($observaciones = null, $precio_total = null)
    {
        $this->estado = 'completada';
        $this->fecha_completada = now();
        
        if ($observaciones) {
            $this->observaciones_tecnico = $observaciones;
        }
        
        if ($precio_total) {
            $this->precio_total = $precio_total;
        }
        
        $this->save();
        
        // Actualizar carga de trabajo del técnico
        if ($this->tecnico) {
            $this->tecnico->actualizarCargaTrabajo();
        }
        
        $this->registrarHistorial('Orden completada', 'Técnico');
    }

    public function cancelar($motivo = null)
    {
        $this->estado = 'cancelada';
        $this->motivo_rechazo = $motivo;
        $this->save();
        
        $this->registrarHistorial('Orden cancelada', 'Sistema', $motivo);
    }

    public function asignarTecnico($tecnico_id)
    {
        $tecnico_anterior = $this->tecnico_id;
        $this->tecnico_id = $tecnico_id;
        $this->estado = 'asignada';
        $this->save();
        
        // Actualizar carga de trabajo de ambos técnicos
        if ($tecnico_anterior) {
            $tecnico_ant = Tecnico::find($tecnico_anterior);
            if ($tecnico_ant) {
                $tecnico_ant->actualizarCargaTrabajo();
            }
        }
        
        $this->tecnico->actualizarCargaTrabajo();
        
        $this->registrarHistorial('Técnico asignado', 'Sistema', "Asignado a: {$this->tecnico->nombre_completo}");
    }

    public function cambiarPrioridad($nueva_prioridad, $motivo = null)
    {
        $prioridad_anterior = $this->prioridad;
        $this->prioridad = $nueva_prioridad;
        $this->save();
        
        $this->registrarHistorial(
            'Prioridad cambiada', 
            'Sistema', 
            "De '{$prioridad_anterior}' a '{$nueva_prioridad}'" . ($motivo ? " - {$motivo}" : '')
        );
    }

    public function registrarHistorial($accion, $usuario, $detalle = null)
    {
        HistorialOrden::create([
            'orden_servicio_id' => $this->id,
            'accion' => $accion,
            'usuario' => $usuario,
            'detalle' => $detalle,
            'fecha' => now()
        ]);
    }

    public function estaRetrasada()
    {
        return $this->fecha_programada && 
               $this->fecha_programada->isPast() && 
               !in_array($this->estado, ['completada', 'cancelada']);
    }

    public function puedeSerEditada()
    {
        return in_array($this->estado, ['pendiente', 'asignada']);
    }

    public function requiereAprobacion()
    {
        return $this->requiere_aprobacion && !$this->aprobado_por;
    }

    public function calcularPuntuacionUrgencia()
    {
        $puntuacion = 0;
        
        // Puntos por prioridad
        $prioridades = ['baja' => 1, 'media' => 2, 'alta' => 3, 'urgente' => 4];
        $puntuacion += ($prioridades[$this->prioridad] ?? 1) * 25;
        
        // Puntos por días transcurridos
        $puntuacion += $this->dias_transcurridos * 2;
        
        // Puntos por retraso
        if ($this->estaRetrasada()) {
            $puntuacion += abs($this->tiempo_estimado_restante) * 5;
        }
        
        // Puntos por tipo de cliente
        if ($this->cliente && $this->cliente->tipo_cliente === 'vip') {
            $puntuacion += 20;
        }
        
        return $puntuacion;
    }
}