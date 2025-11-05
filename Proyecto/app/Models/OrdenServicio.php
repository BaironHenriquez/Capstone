<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    use HasFactory;

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

    /**
     * �🔢 Generar número único de orden
     */
    public static function generarNumeroOrden()
    {
        $año = date('Y');
        $mes = date('m');

        $ultimoNumero = self::whereYear('created_at', $año)
            ->whereMonth('created_at', $mes)
            ->count() + 1;

        return "TS-{$año}{$mes}-" . str_pad($ultimoNumero, 3, '0', STR_PAD_LEFT);
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
}
