<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Página principal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de autenticación (Laravel Breeze/UI)
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});


// Dashboard administrativo (borrador - acceso público)
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
    
    Route::get('/dashboard_tecnico', function () {
    return view('tecnico.dashboard_tecnico');
    })->name('dashboard_tecnico');





    // Procesar solicitud de servicio
    Route::post('/crear', function () {
        // Aquí iría la lógica para procesar la solicitud
        return redirect()->route('home')->with('success', 'Solicitud de servicio enviada correctamente. Te contactaremos pronto.');
    })->name('store');
});

// Rutas de órdenes de servicio
Route::prefix('ordenes')->name('ordenes.')->group(function () {
    // Lista de órdenes (requiere autenticación)
    Route::get('/', function () {
        return view('ordenes.index');
    })->name('index')->middleware('auth');
    
    // Buscar orden por número (público)
    Route::get('/buscar', function () {
        $numeroOrden = request('numero_orden');
        if ($numeroOrden) {
            return view('ordenes.estado', compact('numeroOrden'));
        }
        return redirect()->route('home')->with('error', 'Número de orden requerido.');
    })->name('buscar');
    
    // Ver detalles de una orden específica
    Route::get('/{id}', function ($id) {
        return view('ordenes.detalle', compact('id'));
    })->name('show');
});

// Rutas de contacto
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// API Routes para AJAX
Route::prefix('api')->group(function () {
    Route::get('/orden-estado/{numero}', function ($numero) {
        // Simulación de estados de órdenes
        $estados = [
            'TS-2025-001' => [
                'estado' => 'En progreso',
                'descripcion' => 'Su equipo está siendo diagnosticado por nuestros técnicos',
                'fecha_ingreso' => '2025-09-10',
                'fecha_estimada' => '2025-09-17'
            ],
            'TS-2025-002' => [
                'estado' => 'Completado',
                'descripcion' => 'Reparación completada. Equipo listo para retirar',
                'fecha_ingreso' => '2025-09-08',
                'fecha_completado' => '2025-09-15'
            ]
        ];
        
        return response()->json($estados[$numero] ?? ['error' => 'Orden no encontrada']);
    });
});

// Ruta de logout para el dashboard
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
