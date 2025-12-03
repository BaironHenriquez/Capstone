<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToServicioTecnico;

class OrdenServicio extends Model
{
    use HasFactory, BelongsToServicioTecnico;

    protected $table = 'ordenes_servicio'; // ✅ nombre real de la tabla

    protected $fillable = [
        'numero_orden',
        'estado',
        'prioridad',
        'fecha_programada',
        'fecha_iniciada',
        'fecha_completada',
        'fecha_ingreso',
        'fecha_aprox_entrega',
        'fotos_ingreso',
        'videos_evidencia',
        'descripcion_problema',
        'dictamen_tecnico',
        'medio_de_pago',
        'tipo_de_trabajo',
        'tipo_servicio',
        'precio_presupuestado',
        'precio_total',
        'abono',
        'saldo',
        'horas_estimadas',
        'horas_trabajadas',
        'ubicacion_servicio',
        'contacto_en_sitio',
        'telefono_contacto',
        'servicio_tecnico_id',
        'user_id',
        'tecnico_id',
        'cliente_id',
        'equipo_id',
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
    ];


    protected $casts = [
        'fecha_programada' => 'datetime',
        'fecha_iniciada' => 'datetime',
        'fecha_completada' => 'datetime',
        'fecha_ingreso' => 'date',
        'fecha_aprox_entrega' => 'date',
        'fecha_aprobacion' => 'datetime',

        'precio_presupuestado' => 'decimal:2',
        'precio_total' => 'decimal:2',
        'abono' => 'decimal:2',
        'saldo' => 'decimal:2',
        'horas_estimadas' => 'decimal:2',
        'horas_trabajadas' => 'decimal:2',

        'requiere_aprobacion' => 'boolean',

        'equipos_necesarios' => 'array',
        'materiales_usados' => 'array',
        'fotos_ingreso' => 'array',
        'videos_evidencia' => 'array',
        'fotos_antes' => 'array',
        'fotos_despues' => 'array',
        'archivos_adjuntos' => 'array',
    ];

    /**
     * 🔗 Relaciones
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function servicioTecnico()
    {
        return $this->belongsTo(ServicioTecnico::class);
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioOrden::class, 'orden_servicio_id');
    }

    public function historial()
    {
        return $this->hasMany(HistorialOrden::class, 'orden_servicio_id');
    }

    public function calificacion()
    {
        return $this->hasOne(CalificacionTecnico::class, 'orden_servicio_id');
    }

    /**
     * 🔢 Generar número único de orden por servicio técnico
     */
    public static function generarNumeroOrden($servicioTecnicoId = null)
    {
        // Si no se proporciona servicio técnico, obtenerlo del usuario autenticado
        if (!$servicioTecnicoId && \Illuminate\Support\Facades\Auth::check()) {
            $servicioTecnicoId = \Illuminate\Support\Facades\Auth::user()->servicioTecnico?->id;
        }

        if (!$servicioTecnicoId) {
            throw new \Exception('No se puede generar número de orden sin servicio técnico');
        }

        $año = date('Y');
        $mes = date('m');

        // Contar órdenes del servicio técnico en el año y mes actual
        $ultimoNumero = self::withoutGlobalScope('servicio_tecnico')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->whereYear('created_at', $año)
            ->whereMonth('created_at', $mes)
            ->count() + 1;

        // Formato: ST-<ID_SERVICIO>-<AÑO><MES>-<CORRELATIVO>
        // Ejemplo: ST-001-202411-001
        return sprintf(
            "ST-%03d-%s%s-%03d",
            $servicioTecnicoId,
            $año,
            $mes,
            $ultimoNumero
        );
    }

    /**
     * 🔍 Buscar por número o descripción
     */
    public function scopeBuscar($query, $termino)
    {
        return $query->where(function ($q) use ($termino) {
            $q->where('numero_orden', 'LIKE', "%{$termino}%")
              ->orWhere('descripcion_problema', 'LIKE', "%{$termino}%");
        });
    }

    /**
     * 🧭 Scopes de estado
     */
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

    public function scopeRetrasadas($query)
    {
        return $query->where('fecha_programada', '<', now())
                     ->whereNotIn('estado', ['completada', 'cancelada']);
    }

    /**
     * 🧾 Registrar historial (opcional)
     */
    public function registrarHistorial($accion, $usuario, $detalle = null)
    {
        // Ejemplo: puedes implementar registro de acciones aquí
    }

    /**
     * 🎨 Accessor para el badge de estado con colores
     */
    public function getEstadoBadgeAttribute()
    {
        $badges = [
            'pendiente' => 'bg-yellow-100 text-yellow-800',
            'asignada' => 'bg-blue-100 text-blue-800',
            'asignado' => 'bg-blue-100 text-blue-800', // Alias para compatibilidad
            'diagnostico' => 'bg-amber-100 text-amber-800',
            'espera_repuesto' => 'bg-purple-100 text-purple-800',
            'en_progreso' => 'bg-indigo-100 text-indigo-800',
            'listo_retiro' => 'bg-teal-100 text-teal-800',
            'completada' => 'bg-green-100 text-green-800',
            'entregada' => 'bg-emerald-100 text-emerald-800',
            'cancelada' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->estado] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * 🎨 Accessor para el badge de prioridad con colores
     */
    public function getPrioridadBadgeAttribute()
    {
        $badges = [
            'baja' => 'bg-gray-100 text-gray-800',
            'media' => 'bg-blue-100 text-blue-800',
            'alta' => 'bg-orange-100 text-orange-800',
            'urgente' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->prioridad] ?? 'bg-blue-100 text-blue-800';
    }

    /**
     * 💰 Accessor para calcular el saldo pendiente
     */
    public function getSaldoPendienteAttribute()
    {
        $total = $this->precio_presupuestado ?? 0;
        $abonado = $this->abono ?? 0;
        return max(0, $total - $abonado);
    }

    /**
     * 💵 Accessor para verificar si está pagado completamente
     */
    public function getEstaPagadoAttribute()
    {
        return $this->saldo_pendiente <= 0 && $this->precio_presupuestado > 0;
    }

    /**
     * 📊 Accessor para calcular el porcentaje pagado
     */
    public function getPorcentajePagadoAttribute()
    {
        if (!$this->precio_presupuestado || $this->precio_presupuestado <= 0) {
            return 0;
        }
        $abonado = $this->abono ?? 0;
        return round(($abonado / $this->precio_presupuestado) * 100, 2);
    }
}
