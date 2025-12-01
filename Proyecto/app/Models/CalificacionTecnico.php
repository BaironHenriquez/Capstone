<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToServicioTecnico;

class CalificacionTecnico extends Model
{
    use HasFactory, SoftDeletes, BelongsToServicioTecnico;

    protected $table = 'calificacion_tecnicos';

    protected $fillable = [
        'tecnico_id',
        'orden_servicio_id',
        'cliente_id',
        'servicio_tecnico_id',
        'calificacion',
        'puntualidad',
        'calidad_trabajo',
        'atencion_cliente',
        'limpieza',
        'comentario',
        'recomendaria',
        'fecha_calificacion',
        'ip_calificacion',
        'verificada',
    ];

    protected $casts = [
        'calificacion' => 'integer',
        'puntualidad' => 'integer',
        'calidad_trabajo' => 'integer',
        'atencion_cliente' => 'integer',
        'limpieza' => 'integer',
        'recomendaria' => 'boolean',
        'verificada' => 'boolean',
        'fecha_calificacion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * 🔗 Relaciones
     */
    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function ordenServicio()
    {
        return $this->belongsTo(OrdenServicio::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function servicioTecnico()
    {
        return $this->belongsTo(ServicioTecnico::class);
    }

    /**
     * ⭐ Accessors
     */
    public function getPromedioAspectosAttribute()
    {
        $aspectos = array_filter([
            $this->puntualidad,
            $this->calidad_trabajo,
            $this->atencion_cliente,
            $this->limpieza,
        ]);

        return count($aspectos) > 0 ? round(array_sum($aspectos) / count($aspectos), 2) : 0;
    }

    public function getEstrellasBadgeAttribute()
    {
        $colores = [
            1 => 'bg-red-100 text-red-800',
            2 => 'bg-orange-100 text-orange-800',
            3 => 'bg-yellow-100 text-yellow-800',
            4 => 'bg-blue-100 text-blue-800',
            5 => 'bg-green-100 text-green-800',
        ];

        return $colores[$this->calificacion] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * 🔍 Scopes
     */
    public function scopeVerificadas($query)
    {
        return $query->where('verificada', true);
    }

    public function scopeRecientes($query, $dias = 30)
    {
        return $query->where('fecha_calificacion', '>=', now()->subDays($dias));
    }

    public function scopeConCalificacion($query, $estrellas)
    {
        return $query->where('calificacion', $estrellas);
    }

    public function scopeRecomendadas($query)
    {
        return $query->where('recomendaria', true);
    }

    /**
     * 📊 Métodos estáticos para estadísticas
     */
    public static function promedioGeneralTecnico($tecnicoId)
    {
        return self::where('tecnico_id', $tecnicoId)
            ->avg('calificacion') ?? 0;
    }

    public static function porcentajeRecomendacionTecnico($tecnicoId)
    {
        $total = self::where('tecnico_id', $tecnicoId)->count();
        if ($total === 0) return 0;

        $recomendadas = self::where('tecnico_id', $tecnicoId)
            ->where('recomendaria', true)
            ->count();

        return round(($recomendadas / $total) * 100, 1);
    }

    public static function distribucionTecnico($tecnicoId)
    {
        return [
            '5_estrellas' => self::where('tecnico_id', $tecnicoId)->where('calificacion', 5)->count(),
            '4_estrellas' => self::where('tecnico_id', $tecnicoId)->where('calificacion', 4)->count(),
            '3_estrellas' => self::where('tecnico_id', $tecnicoId)->where('calificacion', 3)->count(),
            '2_estrellas' => self::where('tecnico_id', $tecnicoId)->where('calificacion', 2)->count(),
            '1_estrella' => self::where('tecnico_id', $tecnicoId)->where('calificacion', 1)->count(),
        ];
    }
}
