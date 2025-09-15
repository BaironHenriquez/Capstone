<?php

use Illuminate\Support\Facades\Route;

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

// Dashboard para usuarios autenticados
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

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
