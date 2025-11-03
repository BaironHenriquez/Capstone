<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrdenServicioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\IAController;
use App\Http\Controllers\GestionTecnicosController;
use App\Http\Controllers\GestionClientesController;
use App\Http\Controllers\GestionEquiposMarcasController;

// Página principal
Route::get('/', function () {
    return view('welcome-new');
})->name('home');

// ============================================
// MÓDULO DE SUSCRIPCIÓN Y AUTENTICACIÓN
// ============================================

// Registro y autenticación personalizada
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [RegisterController::class, 'login'])->name('login');
});

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
    // Ruta temporal para manejar el formato anterior con query parameters
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

// Ruta para usuarios sin suscripción activa
Route::middleware('auth')->get('/no-subscription', function () {
    return view('subscription.no-subscription');
})->name('no.subscription');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');
    
    // Rutas de configuración (requieren suscripción pero NO servicio técnico completo)
    Route::middleware('subscription')->prefix('setup')->name('setup.')->group(function () {
        Route::get('/technical-service', [\App\Http\Controllers\SetupController::class, 'showTechnicalServiceForm'])->name('technical-service');
        Route::post('/technical-service', [\App\Http\Controllers\SetupController::class, 'saveTechnicalService'])->name('technical-service.save');
    });
    
    // Dashboard requiere suscripción activa Y servicio técnico completo
    Route::middleware(['subscription', 'technical.service'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Rutas demo (sin middleware auth para pruebas)
Route::group(['prefix' => 'demo'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('demo.dashboard');
});


// Dashboard administrativo (acceso público para desarrollo)
Route::get('/dashboard-admin', function () {
    // Datos simulados para el dashboard
    $resumenOrdenes = [
        'total' => 156,
        'pendientes' => 23,
        'en_progreso' => 45,
        'completadas' => 88,
        'revision_necesaria' => 5,
        'canceladas' => 3
    ];
    
    $tecnicos = [
        [
            'id' => 1,
            'nombre' => 'Carlos Rodriguez',
            'ordenes_asignadas' => 8,
            'ordenes_completadas' => 12,
            'carga_trabajo' => 85, // porcentaje
            'especialidad' => 'Computadoras',
            'estado' => 'activo'
        ],
        [
            'id' => 2,
            'nombre' => 'Maria González',
            'ordenes_asignadas' => 6,
            'ordenes_completadas' => 15,
            'carga_trabajo' => 65,
            'especialidad' => 'Móviles',
            'estado' => 'activo'
        ],
        [
            'id' => 3,
            'nombre' => 'Diego Sánchez',
            'ordenes_asignadas' => 10,
            'ordenes_completadas' => 8,
            'carga_trabajo' => 95,
            'especialidad' => 'Soporte',
            'estado' => 'sobrecargado'
        ],
        [
            'id' => 4,
            'nombre' => 'Ana Torres',
            'ordenes_asignadas' => 4,
            'ordenes_completadas' => 18,
            'carga_trabajo' => 45,
            'especialidad' => 'Reparaciones',
            'estado' => 'disponible'
        ]
    ];
    
    $alertas = [
        [
            'id' => 1,
            'tipo' => 'retraso_critico',
            'orden' => 'TS-2025-089',
            'cliente' => 'Empresa XYZ',
            'dias_retraso' => 5,
            'tecnico' => 'Carlos Rodriguez',
            'prioridad' => 'alta'
        ],
        [
            'id' => 2,
            'tipo' => 'sobrecarga_tecnico',
            'tecnico' => 'Diego Sánchez',
            'carga' => 95,
            'ordenes_pendientes' => 10,
            'prioridad' => 'media'
        ],
        [
            'id' => 3,
            'tipo' => 'revision_pendiente',
            'orden' => 'TS-2025-091',
            'cliente' => 'TechCorp',
            'dias_pendiente' => 2,
            'prioridad' => 'baja'
        ]
    ];
    
    $metricas = [
        'tiempo_promedio_resolucion' => 3.2, // días
        'satisfaccion_cliente' => 94, // porcentaje
        'ordenes_mes_actual' => 89,
        'ordenes_mes_anterior' => 76,
        'crecimiento' => 17.1 // porcentaje
    ];
    
    return view('administrador.dashboard-admin', compact('resumenOrdenes', 'tecnicos', 'alertas', 'metricas'));
})->name('dashboard-admin');

// Dashboard técnico (requiere autenticación y suscripción)
Route::middleware(['auth', 'subscription'])->get('/dashboard_tecnico', function () {
    return view('tecnico.dashboard_tecnico');
})->name('dashboard_tecnico');

// Rutas de servicios
Route::prefix('servicios')->name('servicios.')->group(function () {
    // Página de creación de servicio
    Route::get('/crear', function () {
        return view('servicios.crear');
    })->name('crear');
    
    // Servicios específicos
    Route::get('/computadoras', function () {
        return view('servicios.computadoras');
    })->name('computadoras');
    
    Route::get('/moviles', function () {
        return view('servicios.moviles');
    })->name('moviles');
    
    Route::get('/soporte', function () {
        return view('servicios.soporte');
    })->name('soporte');

    // 🔹 Nueva ruta para calificar técnico
    Route::get('/calificar_tecnico', function () {
        return view('servicios.calificar_tecnico');
    })->name('calificar_tecnico');

    // Procesar solicitud de servicio
    Route::post('/crear', function () {
        // Aquí iría la lógica para procesar la solicitud
        return redirect()->route('home')->with('success', 'Solicitud de servicio enviada correctamente. Te contactaremos pronto.');
    })->name('store');
});

// Rutas de órdenes de servicio (CRUD completo)
Route::middleware(['auth', 'subscription'])->group(function () {
    // Rutas para Clientes
    Route::resource('clientes', ClienteController::class);
    Route::get('clientes/{cliente}/estadisticas', [ClienteController::class, 'estadisticas'])->name('clientes.estadisticas');

    // Rutas para Técnicos
    Route::resource('tecnicos', TecnicoController::class);
    Route::get('tecnicos/{tecnico}/ordenes', [TecnicoController::class, 'ordenes'])->name('tecnicos.ordenes');
    Route::post('tecnicos/{tecnico}/activar', [TecnicoController::class, 'activar'])->name('tecnicos.activar');
    Route::post('tecnicos/{tecnico}/desactivar', [TecnicoController::class, 'desactivar'])->name('tecnicos.desactivar');

    // Rutas para Órdenes de Servicio (CRUD completo)
    Route::resource('ordenes', OrdenServicioController::class);
    Route::post('ordenes/{orden}/asignar-tecnico', [OrdenServicioController::class, 'asignarTecnico'])->name('ordenes.asignar-tecnico');
    Route::post('ordenes/{orden}/cambiar-estado', [OrdenServicioController::class, 'cambiarEstado'])->name('ordenes.cambiar-estado');
    Route::get('ordenes/{orden}/historial', [OrdenServicioController::class, 'historial'])->name('ordenes.historial');

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
        Route::delete('/{id}', [GestionTecnicosController::class, 'destroy'])->name('destroy');
    });

    // Gestión de Clientes
    Route::get('/gestion-clientes', [GestionClientesController::class, 'index'])->name('clientes.index');
    
    Route::prefix('clientes')->name('clientes.')->group(function () {
        Route::get('/create', [GestionClientesController::class, 'create'])->name('create');
        Route::post('/', [GestionClientesController::class, 'store'])->name('store');
        Route::get('/{id}', [GestionClientesController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [GestionClientesController::class, 'edit'])->name('edit');
        Route::put('/{id}', [GestionClientesController::class, 'update'])->name('update');
        Route::patch('/{id}/toggle-status', [GestionClientesController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{id}', [GestionClientesController::class, 'destroy'])->name('destroy');
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

Route::prefix('tecnico')->group(function () {
    Route::view('/resumen', 'tecnico.resumen')->name('tecnico.resumen');
    Route::view('/clientes', 'tecnico.clientes')->name('tecnico.clientes');
    Route::view('/equipos', 'tecnico.equipos')->name('tecnico.equipos');
    Route::view('/marcas', 'tecnico.marcas')->name('tecnico.marcas');
    Route::view('/ordenes', 'tecnico.ordenes')->name('tecnico.ordenes');
    Route::view('/modificaciones', 'tecnico.modificaciones')->name('tecnico.modificaciones');
    Route::view('/ingresar_orden', 'tecnico.ingresar_orden')->name('tecnico.ingresar_orden');
});
