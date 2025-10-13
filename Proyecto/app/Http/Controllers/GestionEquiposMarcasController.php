<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;
use App\Models\Equipo;
use App\Models\ClienteEquipo;
use App\Models\Cliente;
use App\Models\ServicioTecnico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class GestionEquiposMarcasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('subscription'); // Comentado para desarrollo
    }

    /**
     * Dashboard principal de equipos y marcas
     */
    public function index(Request $request)
    {
        // Estadísticas generales
        $totalMarcas = Marca::count();
        $marcasActivas = Marca::where('activa', true)->count();
        $totalEquipos = Equipo::count();
        $equiposActivos = Equipo::where('activo', true)->count();
        $totalClienteEquipos = ClienteEquipo::count();
        $equiposConGarantia = ClienteEquipo::conGarantia()->count();

        // Marcas más populares (con más equipos)
        $marcasPopulares = Marca::withCount(['equipos' => function($query) {
            $query->where('activo', true);
        }])
        ->where('activa', true)
        ->orderBy('equipos_count', 'desc')
        ->limit(5)
        ->get();

        // Equipos que necesitan mantenimiento
        $equiposMantenimiento = ClienteEquipo::with(['cliente', 'equipo.marca'])
            ->where('activo', true)
            ->whereHas('ordenesServicio', function($query) {
                $query->where('created_at', '<', now()->subMonths(6));
            }, '=', 0)
            ->orWhere(function($query) {
                $query->whereHas('ordenesServicio', function($q) {
                    $q->where('created_at', '<', now()->subMonths(6))
                      ->latest('created_at')
                      ->limit(1);
                });
            })
            ->limit(10)
            ->get();

        // Categorías de equipos más comunes
        $categorias = Equipo::select('categoria', DB::raw('COUNT(*) as total'))
            ->where('activo', true)
            ->whereNotNull('categoria')
            ->groupBy('categoria')
            ->orderBy('total', 'desc')
            ->limit(8)
            ->get();

        return view('equipos-marcas.index', compact(
            'totalMarcas',
            'marcasActivas',
            'totalEquipos',
            'equiposActivos',
            'totalClienteEquipos',
            'equiposConGarantia',
            'marcasPopulares',
            'equiposMantenimiento',
            'categorias'
        ));
    }

    // =======================================
    // GESTIÓN DE MARCAS
    // =======================================

    /**
     * Listado de marcas
     */
    public function marcasIndex(Request $request)
    {
        $query = Marca::withCount(['equipos' => function($q) {
            $q->where('activo', true);
        }]);

        // Filtros
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        if ($request->filled('categoria') && $request->categoria !== 'todas') {
            $query->porCategoria($request->categoria);
        }

        if ($request->filled('estado') && $request->estado !== 'todas') {
            $activa = $request->estado === 'activa';
            $query->where('activa', $activa);
        }

        // Ordenamiento
        $orderBy = $request->get('orden', 'created_at');
        $orderDirection = $request->get('direccion', 'desc');
        
        switch ($orderBy) {
            case 'nombre':
                $query->orderBy('nombre_marca', $orderDirection);
                break;
            case 'equipos':
                $query->orderBy('equipos_count', $orderDirection);
                break;
            default:
                $query->orderBy($orderBy, $orderDirection);
        }

        $marcas = $query->paginate(12)->withQueryString();

        // Para filtros
        $categorias = Marca::select('categoria')
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('equipos-marcas.marcas.index', compact('marcas', 'categorias'));
    }

    /**
     * Crear nueva marca
     */
    public function marcasCreate()
    {
        return view('equipos-marcas.marcas.create');
    }

    /**
     * Almacenar nueva marca
     */
    public function marcasStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_marca' => 'required|string|max:45|unique:marcas,nombre_marca',
            'descripcion' => 'nullable|string|max:1000',
            'sitio_web' => 'nullable|url|max:255',
            'pais_origen' => 'nullable|string|max:50',
            'categoria' => 'required|string|max:50',
            'activa' => 'required|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'nombre_marca.required' => 'El nombre de la marca es obligatorio.',
            'nombre_marca.unique' => 'Esta marca ya existe.',
            'sitio_web.url' => 'El sitio web debe ser una URL válida.',
            'categoria.required' => 'La categoría es obligatoria.',
            'logo.image' => 'El logo debe ser una imagen.',
            'logo.max' => 'El logo no puede ser mayor a 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->only([
                'nombre_marca', 'descripcion', 'sitio_web', 
                'pais_origen', 'categoria', 'activa'
            ]);

            // Procesar logo si se subió
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('marcas', 'public');
                $data['logo'] = basename($logoPath);
            }

            Marca::create($data);

            DB::commit();

            return redirect()->route('admin.equipos-marcas.marcas.index')
                ->with('success', 'Marca creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al crear la marca: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Editar marca
     */
    public function marcasEdit($id)
    {
        $marca = Marca::withCount('equipos')->findOrFail($id);
        return view('equipos-marcas.marcas.edit', compact('marca'));
    }

    /**
     * Actualizar marca
     */
    public function marcasUpdate(Request $request, $id)
    {
        $marca = Marca::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre_marca' => 'required|string|max:45|unique:marcas,nombre_marca,' . $id,
            'descripcion' => 'nullable|string|max:1000',
            'sitio_web' => 'nullable|url|max:255',
            'pais_origen' => 'nullable|string|max:50',
            'categoria' => 'required|string|max:50',
            'activa' => 'required|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'nombre_marca.required' => 'El nombre de la marca es obligatorio.',
            'nombre_marca.unique' => 'Esta marca ya existe.',
            'sitio_web.url' => 'El sitio web debe ser una URL válida.',
            'categoria.required' => 'La categoría es obligatoria.',
            'logo.image' => 'El logo debe ser una imagen.',
            'logo.max' => 'El logo no puede ser mayor a 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->only([
                'nombre_marca', 'descripcion', 'sitio_web', 
                'pais_origen', 'categoria', 'activa'
            ]);

            // Procesar nuevo logo si se subió
            if ($request->hasFile('logo')) {
                // Eliminar logo anterior si existe
                if ($marca->logo && Storage::disk('public')->exists('marcas/' . $marca->logo)) {
                    Storage::disk('public')->delete('marcas/' . $marca->logo);
                }

                $logoPath = $request->file('logo')->store('marcas', 'public');
                $data['logo'] = basename($logoPath);
            }

            $marca->update($data);

            DB::commit();

            return redirect()->route('admin.equipos-marcas.marcas.index')
                ->with('success', 'Marca actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al actualizar la marca: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Toggle estado de marca
     */
    public function marcasToggleStatus($id)
    {
        try {
            $marca = Marca::findOrFail($id);
            $marca->update(['activa' => !$marca->activa]);

            $mensaje = $marca->activa ? 'Marca activada exitosamente.' : 'Marca desactivada exitosamente.';
            return redirect()->back()->with('success', $mensaje);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cambiar el estado de la marca.');
        }
    }

    /**
     * Eliminar marca
     */
    public function marcasDestroy($id)
    {
        try {
            $marca = Marca::findOrFail($id);
            
            // Verificar si tiene equipos asociados
            if ($marca->equipos()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'No se puede eliminar la marca porque tiene equipos asociados.');
            }

            // Eliminar logo si existe
            if ($marca->logo && Storage::disk('public')->exists('marcas/' . $marca->logo)) {
                Storage::disk('public')->delete('marcas/' . $marca->logo);
            }

            $marca->delete();

            return redirect()->back()->with('success', 'Marca eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la marca.');
        }
    }

    // =======================================
    // GESTIÓN DE EQUIPOS
    // =======================================

    /**
     * Listado de equipos
     */
    public function equiposIndex(Request $request)
    {
        $query = Equipo::with(['marca'])
            ->withCount(['clienteEquipos' => function($q) {
                $q->where('activo', true);
            }]);

        // Filtros
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        if ($request->filled('marca') && $request->marca !== 'todas') {
            $query->porMarca($request->marca);
        }

        if ($request->filled('categoria') && $request->categoria !== 'todas') {
            $query->porCategoria($request->categoria);
        }

        if ($request->filled('estado') && $request->estado !== 'todos') {
            $activo = $request->estado === 'activo';
            $query->where('activo', $activo);
        }

        // Ordenamiento
        $orderBy = $request->get('orden', 'created_at');
        $orderDirection = $request->get('direccion', 'desc');
        
        switch ($orderBy) {
            case 'nombre':
                $query->orderBy('tipo_equipo', $orderDirection)
                      ->orderBy('modelo', $orderDirection);
                break;
            case 'marca':
                $query->join('marcas', 'equipos.marca_id', '=', 'marcas.id')
                      ->orderBy('marcas.nombre_marca', $orderDirection);
                break;
            case 'clientes':
                $query->orderBy('cliente_equipos_count', $orderDirection);
                break;
            default:
                $query->orderBy($orderBy, $orderDirection);
        }

        $equipos = $query->paginate(12)->withQueryString();

        // Para filtros
        $marcas = Marca::where('activa', true)->orderBy('nombre_marca')->get();
        $categorias = Equipo::select('categoria')
            ->whereNotNull('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('equipos-marcas.equipos.index', compact('equipos', 'marcas', 'categorias'));
    }

    /**
     * Crear nuevo equipo
     */
    public function equiposCreate()
    {
        $marcas = Marca::where('activa', true)->orderBy('nombre_marca')->get();
        return view('equipos-marcas.equipos.create', compact('marcas'));
    }

    /**
     * Almacenar nuevo equipo
     */
    public function equiposStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo_equipo' => 'required|string|max:45',
            'modelo' => 'required|string|max:45',
            'marca_id' => 'required|exists:marcas,id',
            'descripcion' => 'nullable|string|max:1000',
            'categoria' => 'required|string|max:50',
            'precio_referencial' => 'nullable|numeric|min:0|max:999999999.99',
            'garantia_meses' => 'nullable|integer|min:0|max:120',
            'manual_url' => 'nullable|url|max:255',
            'activo' => 'required|boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'tipo_equipo.required' => 'El tipo de equipo es obligatorio.',
            'modelo.required' => 'El modelo es obligatorio.',
            'marca_id.required' => 'Debe seleccionar una marca.',
            'marca_id.exists' => 'La marca seleccionada no existe.',
            'categoria.required' => 'La categoría es obligatoria.',
            'precio_referencial.numeric' => 'El precio debe ser un número.',
            'garantia_meses.integer' => 'La garantía debe ser un número entero.',
            'manual_url.url' => 'La URL del manual debe ser válida.',
            'imagen.image' => 'La imagen debe ser un archivo de imagen.',
            'imagen.max' => 'La imagen no puede ser mayor a 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->only([
                'tipo_equipo', 'modelo', 'marca_id', 'descripcion',
                'categoria', 'precio_referencial', 'garantia_meses',
                'manual_url', 'activo'
            ]);

            // Procesar imagen si se subió
            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('equipos', 'public');
                $data['imagen'] = basename($imagenPath);
            }

            Equipo::create($data);

            DB::commit();

            return redirect()->route('admin.equipos-marcas.equipos.index')
                ->with('success', 'Equipo creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al crear el equipo: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Editar equipo
     */
    public function equiposEdit($id)
    {
        $equipo = Equipo::with('marca')->findOrFail($id);
        $marcas = Marca::where('activa', true)->orderBy('nombre_marca')->get();
        return view('equipos-marcas.equipos.edit', compact('equipo', 'marcas'));
    }

    /**
     * Actualizar equipo
     */
    public function equiposUpdate(Request $request, $id)
    {
        $equipo = Equipo::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tipo_equipo' => 'required|string|max:45',
            'modelo' => 'required|string|max:45',
            'marca_id' => 'required|exists:marcas,id',
            'descripcion' => 'nullable|string|max:1000',
            'categoria' => 'required|string|max:50',
            'precio_referencial' => 'nullable|numeric|min:0|max:999999999.99',
            'garantia_meses' => 'nullable|integer|min:0|max:120',
            'manual_url' => 'nullable|url|max:255',
            'activo' => 'required|boolean',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'tipo_equipo.required' => 'El tipo de equipo es obligatorio.',
            'modelo.required' => 'El modelo es obligatorio.',
            'marca_id.required' => 'Debe seleccionar una marca.',
            'marca_id.exists' => 'La marca seleccionada no existe.',
            'categoria.required' => 'La categoría es obligatoria.',
            'precio_referencial.numeric' => 'El precio debe ser un número.',
            'garantia_meses.integer' => 'La garantía debe ser un número entero.',
            'manual_url.url' => 'La URL del manual debe ser válida.',
            'imagen.image' => 'La imagen debe ser un archivo de imagen.',
            'imagen.max' => 'La imagen no puede ser mayor a 2MB.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $data = $request->only([
                'tipo_equipo', 'modelo', 'marca_id', 'descripcion',
                'categoria', 'precio_referencial', 'garantia_meses',
                'manual_url', 'activo'
            ]);

            // Procesar nueva imagen si se subió
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($equipo->imagen && Storage::disk('public')->exists('equipos/' . $equipo->imagen)) {
                    Storage::disk('public')->delete('equipos/' . $equipo->imagen);
                }

                $imagenPath = $request->file('imagen')->store('equipos', 'public');
                $data['imagen'] = basename($imagenPath);
            }

            $equipo->update($data);

            DB::commit();

            return redirect()->route('admin.equipos-marcas.equipos.index')
                ->with('success', 'Equipo actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al actualizar el equipo: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Toggle estado de equipo
     */
    public function equiposToggleStatus($id)
    {
        try {
            $equipo = Equipo::findOrFail($id);
            $equipo->update(['activo' => !$equipo->activo]);

            $mensaje = $equipo->activo ? 'Equipo activado exitosamente.' : 'Equipo desactivado exitosamente.';
            return redirect()->back()->with('success', $mensaje);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cambiar el estado del equipo.');
        }
    }

    /**
     * Eliminar equipo
     */
    public function equiposDestroy($id)
    {
        try {
            $equipo = Equipo::findOrFail($id);
            
            // Verificar si tiene equipos de clientes asociados
            if ($equipo->clienteEquipos()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'No se puede eliminar el equipo porque tiene asociaciones con clientes.');
            }

            // Eliminar imagen si existe
            if ($equipo->imagen && Storage::disk('public')->exists('equipos/' . $equipo->imagen)) {
                Storage::disk('public')->delete('equipos/' . $equipo->imagen);
            }

            $equipo->delete();

            return redirect()->back()->with('success', 'Equipo eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el equipo.');
        }
    }

    // =======================================
    // ASOCIACIONES CLIENTE-EQUIPO
    // =======================================

    /**
     * Listado de asociaciones cliente-equipo
     */
    public function clienteEquiposIndex(Request $request)
    {
        $query = ClienteEquipo::with(['cliente', 'equipo.marca'])
            ->withCount(['ordenesServicio']);

        // Filtros
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        if ($request->filled('estado') && $request->estado !== 'todos') {
            $query->porEstado($request->estado);
        }

        if ($request->filled('garantia')) {
            if ($request->garantia === 'vigente') {
                $query->conGarantia();
            } elseif ($request->garantia === 'vencida') {
                $query->sinGarantia();
            }
        }

        // Ordenamiento
        $orderBy = $request->get('orden', 'created_at');
        $orderDirection = $request->get('direccion', 'desc');
        
        $query->orderBy($orderBy, $orderDirection);

        $clienteEquipos = $query->paginate(15)->withQueryString();

        return view('equipos-marcas.cliente-equipos.index', compact('clienteEquipos'));
    }

    /**
     * Crear nueva asociación cliente-equipo
     */
    public function clienteEquiposCreate()
    {
        $clientes = Cliente::where('estado', 'activo')->orderBy('nombre')->get();
        $equipos = Equipo::with('marca')->where('activo', true)->orderBy('tipo_equipo')->get();
        
        return view('equipos-marcas.cliente-equipos.create', compact('clientes', 'equipos'));
    }

    /**
     * Almacenar nueva asociación cliente-equipo
     */
    public function clienteEquiposStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'equipo_id' => 'required|exists:equipos,id',
            'numero_serie' => 'required|string|max:100|unique:cliente_equipos,numero_serie',
            'fecha_compra' => 'nullable|date|before_or_equal:today',
            'fecha_garantia' => 'nullable|date|after:fecha_compra',
            'estado' => 'required|in:operativo,mantenimiento,reparacion,fuera_servicio,retirado',
            'precio_compra' => 'nullable|numeric|min:0',
            'proveedor' => 'nullable|string|max:100',
            'ubicacion' => 'nullable|string|max:200',
            'observaciones' => 'nullable|string|max:1000',
            'activo' => 'required|boolean'
        ], [
            'cliente_id.required' => 'Debe seleccionar un cliente.',
            'equipo_id.required' => 'Debe seleccionar un equipo.',
            'numero_serie.required' => 'El número de serie es obligatorio.',
            'numero_serie.unique' => 'Este número de serie ya está registrado.',
            'fecha_compra.date' => 'La fecha de compra debe ser válida.',
            'fecha_garantia.after' => 'La fecha de garantía debe ser posterior a la fecha de compra.',
            'estado.required' => 'El estado es obligatorio.',
            'precio_compra.numeric' => 'El precio debe ser un número.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            ClienteEquipo::create($request->all());

            DB::commit();

            return redirect()->route('admin.equipos-marcas.cliente-equipos.index')
                ->with('success', 'Equipo asociado al cliente exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al asociar el equipo: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Ver detalle de asociación cliente-equipo
     */
    public function clienteEquiposShow($id)
    {
        $clienteEquipo = ClienteEquipo::with([
            'cliente',
            'equipo.marca',
            'ordenesServicio' => function($query) {
                $query->with('tecnico')->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        return view('equipos-marcas.cliente-equipos.show', compact('clienteEquipo'));
    }
}