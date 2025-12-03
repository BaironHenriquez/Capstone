<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Tecnico\TecnicoAuthController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\TecnicoOrdenController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\TransbankController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\IAController;
use App\Http\Controllers\GestionTecnicosController;
use App\Http\Controllers\GestionClientesController;
use App\Http\Controllers\GestionEquiposMarcasController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\SuperAdminController;

// Página principal
Route::get('/', function () {
    return view('shared.welcome');
})->name('home');

// Página de selección de tipo de usuario
Route::get('/seleccionar-usuario', function () {
    return view('auth.select-user-type');
})->name('select.user.type');

// ============================================
// MÓDULO DE SUSCRIPCIÓN Y AUTENTICACIÓN
// ============================================

// Registro y autenticación personalizada
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::get('/login', [RegisterController::class, 'showLoginForm'])->name('login.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [RegisterController::class, 'login'])->name('login');
});

// ============================================
// AUTENTICACIÓN DE TÉCNICOS
// ============================================

Route::middleware('guest.tecnico:tecnico')->group(function () {
    Route::get('/tecnico/login', [TecnicoAuthController::class, 'showLoginForm'])->name('tecnico.login');
    Route::post('/tecnico/login', [TecnicoAuthController::class, 'login'])->name('tecnico.login.submit');
});

Route::middleware('auth:tecnico')->group(function () {
    Route::post('/tecnico/logout', [TecnicoAuthController::class, 'logout'])->name('tecnico.logout');
    Route::get('/tecnico/dashboard', [TecnicoOrdenController::class, 'dashboard'])->name('tecnico.dashboard');
    
    // Rutas de ganancias y perfil para técnico
    Route::get('/tecnico/ganancias', [TecnicoOrdenController::class, 'ganancias'])->name('tecnico.ganancias');
    Route::get('/tecnico/ordenes-trabajadas', [TecnicoOrdenController::class, 'ordenesTrabajadas'])->name('tecnico.ordenes-trabajadas');
    Route::get('/tecnico/perfil', [TecnicoOrdenController::class, 'perfil'])->name('tecnico.perfil');
    Route::put('/tecnico/perfil', [TecnicoOrdenController::class, 'actualizarPerfil'])->name('tecnico.perfil.actualizar');
    
    // Rutas de órdenes para técnico
    Route::prefix('tecnico/ordenes')->name('tecnico.ordenes.')->group(function () {
        Route::get('/', [TecnicoOrdenController::class, 'index'])->name('index');
        Route::get('/{orden}', [TecnicoOrdenController::class, 'show'])->name('show');
        Route::patch('/{orden}/actualizar-estado', [TecnicoOrdenController::class, 'actualizarEstado'])->name('actualizar-estado');
        Route::post('/{orden}/agregar-diagnostico', [TecnicoOrdenController::class, 'agregarDiagnostico'])->name('agregar-diagnostico');
        Route::post('/{orden}/agregar-observacion', [TecnicoOrdenController::class, 'agregarObservacion'])->name('agregar-observacion');
        Route::post('/{orden}/completar', [TecnicoOrdenController::class, 'completar'])->name('completar');
        Route::post('/{orden}/upload-foto', [TecnicoOrdenController::class, 'subirFoto'])->name('upload-foto');
    });
});

// ============================================
// MÓDULO DE SUSCRIPCIONES Y PAGOS
// ============================================


// Rutas de suscripción (requieren autenticación)
Route::middleware('auth')->prefix('subscription')->name('subscription.')->group(function () {
    Route::get('/plans', [SubscriptionController::class, 'showPlans'])->name('plans');
    Route::get('/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('checkout');
    Route::get('/show', [SubscriptionController::class, 'show'])->name('show');
    Route::get('/success', [SubscriptionController::class, 'success'])->name('success');
    Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
});

// Rutas de PayPal (requieren autenticación)
Route::middleware('auth')->prefix('paypal')->name('paypal.')->group(function () {
    Route::post('/create-payment', [PayPalController::class, 'createPayment'])->name('create.payment');
    Route::get('/approve/{paymentId}', [PayPalController::class, 'approvePayment'])->name('approve');
    Route::get('/approve', function (Request $request) {
        $paymentId = $request->query('payment_id');
        if ($paymentId) {
            return redirect()->route('paypal.approve', ['paymentId' => $paymentId]);
        }
        abort(404);
    });
    Route::post('/execute', [PayPalController::class, 'executePayment'])->name('execute');
    Route::get('/success', [PayPalController::class, 'success'])->name('success');
    Route::get('/cancel', [PayPalController::class, 'cancel'])->name('cancel');
});

// Rutas de Transbank (requieren autenticación)
Route::middleware('auth')->prefix('transbank')->name('transbank.')->group(function () {
    Route::post('/create', [TransbankController::class, 'createTransaction'])->name('create');
    Route::get('/return', [TransbankController::class, 'returnFromTransbank'])->name('return');
});

// Ruta para usuarios sin suscripción activa
Route::middleware('auth')->get('/no-subscription', function () {
    return view('admin.subscription.no-subscription');
})->name('no.subscription');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');
    
    // Rutas de configuración (requieren suscripción pero NO servicio técnico completo)
    Route::middleware('subscription')->prefix('setup')->name('setup.')->group(function () {
        Route::get('/technical-service', [\App\Http\Controllers\SetupController::class, 'showTechnicalServiceForm'])->name('technical-service');
        Route::post('/technical-service', [\App\Http\Controllers\SetupController::class, 'saveTechnicalService'])->name('technical-service.save');
        Route::post('/check-availability', [\App\Http\Controllers\SetupController::class, 'checkAvailability'])->name('check-availability');
    });
    
    // Dashboard requiere suscripción activa Y servicio técnico completo
    Route::middleware(['subscription', 'technical.service'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas de configuración (requieren suscripción y servicio técnico)
    Route::middleware(['subscription', 'technical.service'])->prefix('configuracion')->name('configuracion.')->group(function () {
        Route::get('/', [ConfiguracionController::class, 'index'])->name('index');
        Route::put('/servicio', [ConfiguracionController::class, 'updateServicio'])->name('update-servicio');
        Route::put('/personal', [ConfiguracionController::class, 'updatePersonal'])->name('update-personal');
    });
});

// Rutas demo (sin middleware auth para pruebas)
Route::group(['prefix' => 'demo'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('demo.dashboard');
});


// Dashboard administrativo
Route::get('/dashboard-admin', [DashboardController::class, 'adminDashboard'])
    ->middleware('auth')
    ->name('dashboard-admin');

// API endpoint para métricas en tiempo real
Route::get('/dashboard/metrics', [DashboardController::class, 'getMetrics'])
    ->middleware('auth')
    ->name('dashboard.metrics');

// Dashboard técnico (requiere autenticación y suscripción)
Route::middleware(['auth', 'subscription'])->get('/dashboard_tecnico', function () {
    return view('tecnico.dashboard_tecnico');
})->name('dashboard_tecnico');

// Rutas de servicios
Route::prefix('servicios')->name('servicios.')->group(function () {
    // Página de creación de servicio
    Route::get('/crear', function () {
        return view('admin.servicios.crear');
    })->name('crear');
    
    // Servicios específicos
    Route::get('/computadoras', function () {
        return view('admin.servicios.computadoras');
    })->name('computadoras');
    
    Route::get('/moviles', function () {
        return view('admin.servicios.moviles');
    })->name('moviles');
    
    Route::get('/soporte', function () {
        return view('admin.servicios.soporte');
    })->name('soporte');

    // Procesar solicitud de servicio
    Route::post('/crear', function () {
        // Aquí iría la lógica para procesar la solicitud
        return redirect()->route('home')->with('success', 'Solicitud de servicio enviada correctamente. Te contactaremos pronto.');
    })->name('store');
});

// 🔹 Rutas de calificación de técnicos (públicas - no requieren autenticación)
Route::post('/calificacion-tecnico', [App\Http\Controllers\CalificacionTecnicoController::class, 'store'])->name('calificacion.store');
Route::get('/tecnico/{id}/promedio', [App\Http\Controllers\CalificacionTecnicoController::class, 'promedio'])->name('tecnico.promedio');

// Rutas de órdenes de servicio (CRUD completo)
Route::middleware(['auth', 'subscription'])->group(function () {
    // Rutas para Clientes
    Route::resource('clientes', ClienteController::class);
    Route::get('clientes/{cliente}/estadisticas', [ClienteController::class, 'estadisticas'])->name('clientes.estadisticas');

    // Rutas para Técnicos
    Route::resource('tecnicos', TecnicoController::class);
// Esta sección se ha movido más arriba en el archivo
    Route::post('tecnicos/{tecnico}/activar', [TecnicoController::class, 'activar'])->name('tecnicos.activar');
    Route::post('tecnicos/{tecnico}/desactivar', [TecnicoController::class, 'desactivar'])->name('tecnicos.desactivar');

    // Rutas generales para Órdenes de Servicio (CRUD completo para admin)
    Route::prefix('admin')->group(function() {
        Route::resource('ordenes', OrdenServicioController::class);
        Route::post('ordenes/{orden}/asignar-tecnico', [OrdenServicioController::class, 'asignarTecnico'])->name('ordenes.asignar-tecnico');
        Route::post('ordenes/{orden}/cambiar-estado', [OrdenServicioController::class, 'cambiarEstado'])->name('ordenes.cambiar-estado');
        Route::get('ordenes/{orden}/historial', [OrdenServicioController::class, 'historial'])->name('ordenes.historial');
    });

    // Ruta de historial de órdenes (fuera del grupo para mantener compatibilidad)
    Route::get('admin/ordenes-historicas', [OrdenServicioController::class, 'historicas'])->name('admin.ordenes.historicas');

    // Rutas para actualización inline de órdenes
    Route::put('/ordenes/{id}/estado', [OrdenServicioController::class, 'updateEstado'])->name('ordenes.update-estado');
    Route::put('/ordenes/{id}/prioridad', [OrdenServicioController::class, 'updatePrioridad'])->name('ordenes.update-prioridad');
    Route::post('/ordenes/{id}/registrar-pago', [OrdenServicioController::class, 'registrarPago'])->name('ordenes.registrar-pago');

    // Rutas para manejo de imágenes en Bunny CDN
    Route::post('/ordenes/upload-fotos', [OrdenServicioController::class, 'uploadFotosIngreso'])->name('ordenes.upload-fotos');
    Route::delete('/ordenes/delete-foto', [OrdenServicioController::class, 'deleteFotoIngreso'])->name('ordenes.delete-foto');

    // Alias para crear equipos desde modales
    Route::post('equipos', [GestionEquiposMarcasController::class, 'equiposStore'])->name('equipos.store');

    // Rutas de funcionalidades IA
    Route::prefix('ia')->name('ia.')->group(function () {
        Route::post('recomendar-tecnico', [IAController::class, 'recomendarTecnico'])->name('recomendar-tecnico');
        Route::get('priorizar-ordenes', [IAController::class, 'priorizarOrdenes'])->name('priorizar-ordenes');
        Route::get('alertas-predictivas', [IAController::class, 'alertasPredictivas'])->name('alertas-predictivas');
        Route::post('optimizar-rutas', [IAController::class, 'optimizarRutas'])->name('optimizar-rutas');
    });
});

// Rutas públicas de órdenes (búsqueda y estado)
Route::prefix('ordenes')->name('ordenes.')->group(function () {
    Route::get('/estado', [OrdenServicioController::class, 'estado'])->name('estado');
    Route::get('/buscar', [OrdenServicioController::class, 'buscar'])->name('buscar');
});

// Ruta de prueba temporal
Route::get('/test-ordenes', function() {
    $ordenes = \App\Models\OrdenServicio::select('id', 'numero_orden', 'estado', 'cliente_id', 'equipo_id')
        ->orderBy('id', 'desc')
        ->limit(10)
        ->get();
    
    $busqueda = \App\Models\OrdenServicio::where('numero_orden', 'TS-2025-3956')->first();
    
    return response()->json([
        'total' => \App\Models\OrdenServicio::count(),
        'ordenes_recientes' => $ordenes,
        'busqueda_TS-2025-3956' => $busqueda ? [
            'encontrada' => true,
            'id' => $busqueda->id,
            'numero_orden' => $busqueda->numero_orden,
            'estado' => $busqueda->estado
        ] : ['encontrada' => false],
        'tiene_cliente' => $busqueda ? ($busqueda->cliente ? true : false) : false,
        'tiene_equipo' => $busqueda ? ($busqueda->equipo ? true : false) : false,
    ]);
});

// Ruta de prueba directa de búsqueda
Route::get('/test-buscar/{codigo}', function($codigo) {
    $orden = \App\Models\OrdenServicio::with(['cliente', 'tecnico', 'equipo.marca'])
        ->where('numero_orden', $codigo)
        ->first();
    
    if (!$orden) {
        return response()->json([
            'encontrada' => false,
            'codigo_buscado' => $codigo,
            'total_ordenes' => \App\Models\OrdenServicio::count()
        ]);
    }
    
    return response()->json([
        'encontrada' => true,
        'orden' => $orden,
        'tiene_cliente' => $orden->cliente ? true : false,
        'tiene_equipo' => $orden->equipo ? true : false,
        'tiene_tecnico' => $orden->tecnico ? true : false,
    ]);
});


// Rutas de contacto
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// API real para consulta de estado de órdenes
Route::prefix('api')->group(function () {
    Route::get('/orden-estado/{numero_orden}', [OrdenServicioController::class, 'apiEstado'])
        ->name('api.orden.estado');
});


// Ruta de logout para el dashboard
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ============================================
// MÓDULO SUPER ADMIN (SOLO JERARQUÍA 4)
// ============================================

Route::prefix('super-usuario')->name('super-admin.')->group(function () {
    Route::get('/', [SuperAdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SuperAdminController::class, 'login'])->name('login.submit');
    
    Route::middleware(['auth', 'super.admin'])->group(function () {
        Route::post('/logout', [SuperAdminController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/servicios-tecnicos', [SuperAdminController::class, 'serviciosTecnicos'])->name('servicios-tecnicos');
        Route::get('/reporte-financiero', [SuperAdminController::class, 'reporteFinanciero'])->name('reporte-financiero');
        Route::get('/alertas', [SuperAdminController::class, 'alertas'])->name('alertas');
    });
});

// ============================================
// MÓDULO DE GESTIÓN DE TÉCNICOS (ADMINISTRADOR)
// ============================================

// ============================================
// MÓDULO DE GESTIÓN ADMINISTRATIVA (ACCESO PÚBLICO PARA DESARROLLO)
// ============================================

Route::prefix('admin')->name('admin.')->group(function () {
    // Gestión de Técnicos
    Route::get('/gestion-tecnicos', [GestionTecnicosController::class, 'index'])->name('gestion-tecnicos');
    
    Route::prefix('tecnicos')->name('tecnicos.')->group(function () {
        Route::get('/create', [GestionTecnicosController::class, 'create'])->name('create');
        Route::post('/', [GestionTecnicosController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [GestionTecnicosController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GestionTecnicosController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle-ban', [GestionTecnicosController::class, 'toggleBan'])->name('toggle-ban');
        Route::patch('/{id}/cambiar-estado', [GestionTecnicosController::class, 'cambiarEstado'])->name('cambiar-estado');
        Route::delete('/{id}', [GestionTecnicosController::class, 'destroy'])->name('destroy');
        
        // Dashboard/Resumen del técnico (acepta ID opcional)
        Route::get('/resumen/{id?}', [DashboardController::class, 'tecnicoResumen'])->name('resumen');
        
        // Rutas de asignación de órdenes
        Route::get('/{id}/asignar', [GestionTecnicosController::class, 'asignar'])->name('asignar');
        Route::post('/{id}/asignar', [GestionTecnicosController::class, 'asignarStore'])->name('asignar.store');
        Route::delete('/{tecnicoId}/desasignar/{ordenId}', [GestionTecnicosController::class, 'desasignar'])->name('desasignar');
    });

    // Gestión de Clientes
    Route::get('/gestion-clientes', [GestionClientesController::class, 'index'])->name('gestion-clientes');
    Route::get('/clientes', [GestionClientesController::class, 'index'])->name('clientes.index'); // Alias
    
    Route::prefix('clientes')->name('clientes.')->group(function () {
        Route::get('/create', [GestionClientesController::class, 'create'])->name('create');
        Route::post('/', [GestionClientesController::class, 'store'])->name('store');
        Route::get('/{id}', [GestionClientesController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [GestionClientesController::class, 'edit'])->name('edit');
        Route::get('/{id}/ordenes', [GestionClientesController::class, 'getOrdenes'])->name('ordenes');
        Route::put('/{id}', [GestionClientesController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle-status', [GestionClientesController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{id}', [GestionClientesController::class, 'destroy'])->name('destroy');
        Route::get('/export/csv', [GestionClientesController::class, 'export'])->name('export');
    });

    // Gestión de Equipos y Marcas
    Route::get('/gestion-equipos-marcas', [GestionEquiposMarcasController::class, 'index'])->name('equipos-marcas.index');
    
    // Gestión de Marcas
    Route::prefix('marcas')->name('equipos-marcas.marcas.')->group(function () {
        Route::get('/', [GestionEquiposMarcasController::class, 'marcasIndex'])->name('index');
        Route::get('/create', [GestionEquiposMarcasController::class, 'marcasCreate'])->name('create');
        Route::post('/', [GestionEquiposMarcasController::class, 'marcasStore'])->name('store');
        Route::get('/{id}/edit', [GestionEquiposMarcasController::class, 'marcasEdit'])->name('edit');
        Route::put('/{id}', [GestionEquiposMarcasController::class, 'marcasUpdate'])->name('update');
        Route::patch('/{id}/toggle-status', [GestionEquiposMarcasController::class, 'marcasToggleStatus'])->name('toggle-status');
        Route::delete('/{id}', [GestionEquiposMarcasController::class, 'marcasDestroy'])->name('destroy');
    });

    // Gestión de Equipos
    Route::prefix('equipos')->name('equipos-marcas.equipos.')->group(function () {
        Route::get('/', [GestionEquiposMarcasController::class, 'equiposIndex'])->name('index');
        Route::get('/create', [GestionEquiposMarcasController::class, 'equiposCreate'])->name('create');
        Route::post('/', [GestionEquiposMarcasController::class, 'equiposStore'])->name('store');
        Route::get('/{id}/edit', [GestionEquiposMarcasController::class, 'equiposEdit'])->name('edit');
        Route::put('/{id}', [GestionEquiposMarcasController::class, 'equiposUpdate'])->name('update');
        Route::patch('/{id}/toggle-status', [GestionEquiposMarcasController::class, 'equiposToggleStatus'])->name('toggle-status');
        Route::delete('/{id}', [GestionEquiposMarcasController::class, 'equiposDestroy'])->name('destroy');
    });

    // Asociaciones Cliente-Equipo
    Route::prefix('cliente-equipos')->name('equipos-marcas.cliente-equipos.')->group(function () {
        Route::get('/', [GestionEquiposMarcasController::class, 'clienteEquiposIndex'])->name('index');
        Route::get('/create', [GestionEquiposMarcasController::class, 'clienteEquiposCreate'])->name('create');
        Route::post('/', [GestionEquiposMarcasController::class, 'clienteEquiposStore'])->name('store');
        Route::get('/{id}', [GestionEquiposMarcasController::class, 'clienteEquiposShow'])->name('show');
    });
});

