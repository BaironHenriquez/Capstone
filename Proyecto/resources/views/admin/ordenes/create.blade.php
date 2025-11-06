@extends('shared.layouts.admin')

@section('title', 'Nueva Orden de Servicio')

@section('content')
<style>
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes progressBar {
        from { width: 0%; }
    }
    
    .animate-slide-in-right { animation: slideInRight 0.5s ease-out; }
    .animate-slide-in-left { animation: slideInLeft 0.5s ease-out; }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out; }
    .animate-scale-in { animation: scaleIn 0.4s ease-out; }
    
    .step-content {
        display: none;
        animation: fadeInUp 0.5s ease-out;
    }
    
    .step-content.active {
        display: block;
    }
    
    .progress-step {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .progress-step.completed .step-circle {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        transform: scale(1.1);
    }
    
    .progress-step.active .step-circle {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        transform: scale(1.15);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.2);
    }
    
    .progress-bar-fill {
        animation: progressBar 0.6s ease-out;
    }
    
    .btn-animate {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .btn-animate:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .btn-animate:active {
        transform: translateY(0);
    }

    .input-focus {
        transition: all 0.3s ease;
    }
    
    .input-focus:focus {
        transform: scale(1.01);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 py-8">
    <div class="container mx-auto px-4 max-w-5xl">
        
        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-file-medical text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Nueva Orden de Servicio
                        </h1>
                        <p class="text-gray-500 mt-1 flex items-center text-sm">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Complete el formulario paso a paso
                        </p>
                    </div>
                </div>
                <a href="{{ route('ordenes.index') }}" 
                   class="btn-animate bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold py-3 px-6 rounded-xl flex items-center justify-center space-x-2 shadow-lg">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver</span>
                </a>
            </div>
        </div>

        <!-- Barra de Progreso -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 animate-scale-in">
            <div class="flex items-center justify-between relative">
                <!-- Línea de progreso de fondo -->
                <div class="absolute top-8 left-0 right-0 h-1 bg-gray-200 rounded-full" style="z-index: 0; margin: 0 50px;"></div>
                <!-- Línea de progreso activa -->
                <div id="progressBarFill" class="absolute top-8 left-0 h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full progress-bar-fill transition-all duration-500" style="z-index: 1; margin-left: 50px; width: 0%;"></div>
                
                <!-- Paso 1: Información Básica -->
                <div class="progress-step flex flex-col items-center relative" style="z-index: 2;" data-step="1">
                    <div class="step-circle w-16 h-16 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center text-white font-bold text-xl shadow-lg mb-3 transition-all duration-300">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 text-center">Información<br>Básica</span>
                </div>

                <!-- Paso 2: Cliente -->
                <div class="progress-step flex flex-col items-center relative" style="z-index: 2;" data-step="2">
                    <div class="step-circle w-16 h-16 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center text-white font-bold text-xl shadow-lg mb-3 transition-all duration-300">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 text-center">Datos del<br>Cliente</span>
                </div>

                <!-- Paso 3: Equipo -->
                <div class="progress-step flex flex-col items-center relative" style="z-index: 2;" data-step="3">
                    <div class="step-circle w-16 h-16 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center text-white font-bold text-xl shadow-lg mb-3 transition-all duration-300">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 text-center">Equipo y<br>Problema</span>
                </div>

                <!-- Paso 4: Planificación -->
                <div class="progress-step flex flex-col items-center relative" style="z-index: 2;" data-step="4">
                    <div class="step-circle w-16 h-16 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center text-white font-bold text-xl shadow-lg mb-3 transition-all duration-300">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 text-center">Planificación<br>y Costos</span>
                </div>

                <!-- Paso 5: Archivos -->
                <div class="progress-step flex flex-col items-center relative" style="z-index: 2;" data-step="5">
                    <div class="step-circle w-16 h-16 rounded-full bg-gradient-to-br from-gray-300 to-gray-400 flex items-center justify-center text-white font-bold text-xl shadow-lg mb-3 transition-all duration-300">
                        <i class="fas fa-paperclip"></i>
                    </div>
                    <span class="text-sm font-semibold text-gray-600 text-center">Archivos<br>Adjuntos</span>
                </div>
            </div>
        </div>

        <!-- Formulario Multi-Paso -->
        <form id="multiStepForm" action="{{ route('ordenes.store') }}" method="POST" 
              enctype="multipart/form-data">
            @csrf

            <!-- Paso 1: Información Básica -->
            <div class="step-content active" data-step="1">
                <div class="bg-white rounded-2xl shadow-lg p-8 animate-fade-in-up">
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b-2 border-blue-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clipboard-list text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Información Básica</h2>
                            <p class="text-sm text-gray-500">Datos generales de la orden de servicio</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Número de Orden -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-hashtag text-blue-500 mr-2"></i>
                                Número de Orden *
                            </label>
                            <input type="text" 
                                   name="numero_orden" 
                                   required 
                                   value="{{ $numeroOrdenSugerido }}"
                                   readonly
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 cursor-not-allowed"
                                   placeholder="Auto-generado">
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Número correlativo generado automáticamente
                            </p>
                        </div>

                        <!-- Fecha de Ingreso -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-calendar text-blue-500 mr-2"></i>
                                Fecha de Ingreso *
                            </label>
                            <input type="date" 
                                   name="fecha_ingreso" 
                                   required 
                                   value="{{ date('Y-m-d') }}"
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all">
                        </div>

                        <!-- Tipo de Servicio -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-tools text-blue-500 mr-2"></i>
                                Tipo de Servicio *
                            </label>
                            <select name="tipo_servicio" 
                                    required 
                                    class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all">
                                <option value="">Seleccione...</option>
                                <option value="reparacion">🔧 Reparación</option>
                                <option value="mantenimiento">⚙️ Mantenimiento</option>
                                <option value="instalacion">📦 Instalación</option>
                                <option value="consultoria">🔍 Consultoría</option>
                                <option value="soporte">💡 Soporte Técnico</option>
                            </select>
                        </div>

                        <!-- Prioridad -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-flag text-blue-500 mr-2"></i>
                                Prioridad *
                            </label>
                            <select name="prioridad" 
                                    required 
                                    class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all">
                                <option value="baja">🟢 Baja</option>
                                <option value="media" selected>🟡 Media</option>
                                <option value="alta">🔴 Alta</option>
                                <option value="urgente">⚠️ Urgente</option>
                            </select>
                        </div>

                        <!-- Estado -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                Estado Inicial
                            </label>
                            <select name="estado" 
                                    class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all bg-gray-50">
                                <option value="pendiente" selected>⏳ Pendiente</option>
                            </select>
                        </div>

                        <!-- Descripción del Problema -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-comment-dots text-blue-500 mr-2"></i>
                                Descripción del Problema *
                            </label>
                            <textarea name="descripcion_problema" 
                                      required 
                                      rows="4" 
                                      class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none transition-all resize-none"
                                      placeholder="Describa detalladamente el problema reportado por el cliente..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paso 2: Cliente -->
            <div class="step-content" data-step="2">
                <div class="bg-white rounded-2xl shadow-lg p-8 animate-fade-in-up">
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b-2 border-green-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Datos del Cliente</h2>
                            <p class="text-sm text-gray-500">Información de contacto y ubicación</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Cliente -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center justify-between">
                                <span>
                                    <i class="fas fa-user-circle text-green-500 mr-2"></i>
                                    Seleccionar Cliente *
                                </span>
                                <button type="button" 
                                        onclick="abrirModalCliente()"
                                        class="btn-animate bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white text-xs font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 shadow-md">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Nuevo Cliente</span>
                                </button>
                            </label>
                            <select name="cliente_id" 
                                    required 
                                    class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-all">
                                <option value="">-- Seleccione un cliente --</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">
                                        👤 {{ $cliente->nombre }} 
                                        @if($cliente->apellido){{ $cliente->apellido }}@endif 
                                        - {{ $cliente->correo ?? $cliente->telefono ?? 'Sin contacto' }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-shield-alt mr-1 text-green-500"></i>
                                Solo se muestran clientes de su servicio técnico
                            </p>
                        </div>

                        <!-- Contacto en Sitio -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-user-tie text-green-500 mr-2"></i>
                                Contacto en Sitio
                            </label>
                            <input type="text" 
                                   name="contacto_en_sitio" 
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-all"
                                   placeholder="Nombre del contacto">
                        </div>

                        <!-- Teléfono de Contacto -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-phone text-green-500 mr-2"></i>
                                Teléfono de Contacto
                            </label>
                            <input type="tel" 
                                   name="telefono_contacto" 
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-all"
                                   placeholder="+56 9 1234 5678">
                        </div>

                        <!-- Ubicación del Servicio -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                Ubicación del Servicio
                            </label>
                            <textarea name="ubicacion_servicio" 
                                      rows="3" 
                                      class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:outline-none transition-all resize-none"
                                      placeholder="Dirección completa donde se realizará el servicio..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paso 3: Equipo y Problema -->
            <div class="step-content" data-step="3">
                <div class="bg-white rounded-2xl shadow-lg p-8 animate-fade-in-up">
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b-2 border-purple-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-laptop text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Equipo y Problema</h2>
                            <p class="text-sm text-gray-500">Detalles del equipo a reparar</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Equipo -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center justify-between">
                                <span>
                                    <i class="fas fa-desktop text-purple-500 mr-2"></i>
                                    Seleccionar Equipo *
                                </span>
                                <button type="button" 
                                        onclick="abrirModalEquipo()"
                                        class="btn-animate bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white text-xs font-semibold py-2 px-4 rounded-lg flex items-center space-x-2 shadow-md">
                                    <i class="fas fa-plus-circle"></i>
                                    <span>Nuevo Equipo</span>
                                </button>
                            </label>
                            <select name="equipo_id" 
                                    required 
                                    class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition-all">
                                <option value="">-- Seleccione un equipo --</option>
                                @foreach($equipos as $equipo)
                                    <option value="{{ $equipo->id }}">
                                        💻 {{ $equipo->modelo ?? $equipo->tipo_equipo }} 
                                        - {{ $equipo->marca->nombre_marca ?? 'Sin marca' }} 
                                        @if($equipo->numero_serie)- S/N: {{ $equipo->numero_serie }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-shield-alt mr-1 text-purple-500"></i>
                                Solo se muestran equipos de clientes de su servicio técnico
                            </p>
                        </div>

                        <!-- Medio de Pago -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-credit-card text-purple-500 mr-2"></i>
                                Medio de Pago
                            </label>
                            <select name="medio_de_pago" 
                                    class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition-all">
                                <option value="">Seleccione...</option>
                                <option value="Efectivo">💵 Efectivo</option>
                                <option value="Tarjeta">💳 Tarjeta</option>
                                <option value="Transferencia">🏦 Transferencia</option>
                                <option value="Cheque">📝 Cheque</option>
                            </select>
                        </div>

                        <!-- Tipo de Trabajo -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-briefcase text-purple-500 mr-2"></i>
                                Tipo de Trabajo
                            </label>
                            <select name="tipo_de_trabajo" 
                                    class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none transition-all">
                                <option value="">Seleccione...</option>
                                <option value="En Taller">🏢 En Taller</option>
                                <option value="A Domicilio">🏠 A Domicilio</option>
                                <option value="Remoto">🌐 Remoto</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paso 4: Planificación y Costos -->
            <div class="step-content" data-step="4">
                <div class="bg-white rounded-2xl shadow-lg p-8 animate-fade-in-up">
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b-2 border-indigo-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-calendar-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Planificación y Costos</h2>
                            <p class="text-sm text-gray-500">Fechas, tiempo estimado y presupuesto</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fecha Programada -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-calendar-check text-indigo-500 mr-2"></i>
                                Fecha Programada
                            </label>
                            <input type="date" 
                                   name="fecha_programada" 
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all">
                        </div>

                        <!-- Fecha Aproximada de Entrega -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-calendar-day text-indigo-500 mr-2"></i>
                                Fecha Aprox. de Entrega
                            </label>
                            <input type="date" 
                                   name="fecha_aprox_entrega" 
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all">
                        </div>

                        <!-- Horas Estimadas -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-clock text-indigo-500 mr-2"></i>
                                Horas Estimadas
                            </label>
                            <input type="number" 
                                   name="horas_estimadas" 
                                   step="0.5" 
                                   min="0"
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all"
                                   placeholder="Ej: 2.5">
                        </div>

                        <!-- Precio Presupuestado -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-dollar-sign text-indigo-500 mr-2"></i>
                                Precio Presupuestado
                            </label>
                            <input type="number" 
                                   name="precio_presupuestado" 
                                   step="0.01" 
                                   min="0"
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all"
                                   placeholder="$0.00">
                        </div>

                        <!-- Abono -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-money-bill-wave text-indigo-500 mr-2"></i>
                                Abono Inicial
                            </label>
                            <input type="number" 
                                   name="abono" 
                                   step="0.01" 
                                   min="0"
                                   class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:outline-none transition-all"
                                   placeholder="$0.00">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paso 5: Archivos Adjuntos -->
            <div class="step-content" data-step="5">
                <div class="bg-white rounded-2xl shadow-lg p-8 animate-fade-in-up">
                    <div class="flex items-center space-x-3 mb-6 pb-4 border-b-2 border-yellow-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-paperclip text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Archivos Adjuntos</h2>
                            <p class="text-sm text-gray-500">Fotos, documentos y archivos relacionados</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Área de carga de archivos -->
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-yellow-500 transition-all duration-300 bg-gradient-to-br from-yellow-50 to-orange-50">
                            <div class="mb-4">
                                <i class="fas fa-cloud-upload-alt text-6xl text-yellow-500"></i>
                            </div>
                            <label class="cursor-pointer">
                                <input type="file" 
                                       name="archivos[]" 
                                       multiple 
                                       accept="image/*,.pdf,.doc,.docx"
                                       class="hidden" 
                                       id="fileInput">
                                <span class="btn-animate inline-block bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold py-3 px-8 rounded-xl shadow-lg">
                                    <i class="fas fa-folder-open mr-2"></i>
                                    Seleccionar Archivos
                                </span>
                            </label>
                            <p class="text-sm text-gray-500 mt-3">
                                Formatos: JPG, PNG, PDF, DOC, DOCX (Máx. 10MB por archivo)
                            </p>
                            <div id="fileList" class="mt-4 text-left"></div>
                        </div>

                        <!-- Información adicional -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Recomendaciones:</p>
                                    <ul class="list-disc list-inside space-y-1 text-blue-700">
                                        <li>Incluya fotos del equipo y el problema</li>
                                        <li>Adjunte documentos de garantía si aplica</li>
                                        <li>Agregue cotizaciones previas si existen</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Navegación -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mt-6 animate-fade-in-up">
                <div class="flex justify-between items-center">
                    <button type="button" 
                            id="prevBtn" 
                            class="btn-animate bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-3 px-8 rounded-xl flex items-center space-x-2 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <i class="fas fa-arrow-left"></i>
                        <span>Anterior</span>
                    </button>

                    <div class="text-center">
                        <p class="text-sm font-semibold text-gray-600">
                            Paso <span id="currentStepNum">1</span> de 5
                        </p>
                        <div class="flex space-x-2 mt-2">
                            <span class="step-dot w-2 h-2 rounded-full bg-blue-500" data-dot="1"></span>
                            <span class="step-dot w-2 h-2 rounded-full bg-gray-300" data-dot="2"></span>
                            <span class="step-dot w-2 h-2 rounded-full bg-gray-300" data-dot="3"></span>
                            <span class="step-dot w-2 h-2 rounded-full bg-gray-300" data-dot="4"></span>
                            <span class="step-dot w-2 h-2 rounded-full bg-gray-300" data-dot="5"></span>
                        </div>
                    </div>

                    <button type="button" 
                            id="nextBtn" 
                            class="btn-animate bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-3 px-8 rounded-xl flex items-center space-x-2 shadow-lg">
                        <span>Siguiente</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <button type="submit" 
                            id="submitBtn" 
                            class="btn-animate bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-3 px-8 rounded-xl flex items-center space-x-2 shadow-lg hidden">
                        <i class="fas fa-check-circle"></i>
                        <span>Crear Orden</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 5;
    
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const currentStepNum = document.getElementById('currentStepNum');
    const progressBarFill = document.getElementById('progressBarFill');
    
    function updateStep() {
        // Ocultar todos los pasos
        document.querySelectorAll('.step-content').forEach(step => {
            step.classList.remove('active');
        });
        
        // Mostrar paso actual
        document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.add('active');
        
        // Actualizar número de paso
        currentStepNum.textContent = currentStep;
        
        // Actualizar dots
        document.querySelectorAll('.step-dot').forEach(dot => {
            const dotStep = parseInt(dot.getAttribute('data-dot'));
            if (dotStep <= currentStep) {
                dot.classList.remove('bg-gray-300');
                dot.classList.add('bg-blue-500');
            } else {
                dot.classList.remove('bg-blue-500');
                dot.classList.add('bg-gray-300');
            }
        });
        
        // Actualizar círculos de progreso
        document.querySelectorAll('.progress-step').forEach(step => {
            const stepNum = parseInt(step.getAttribute('data-step'));
            step.classList.remove('active', 'completed');
            
            if (stepNum < currentStep) {
                step.classList.add('completed');
            } else if (stepNum === currentStep) {
                step.classList.add('active');
            }
        });
        
        // Actualizar barra de progreso
        const progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
        progressBarFill.style.width = progressPercentage + '%';
        
        // Actualizar botones
        prevBtn.disabled = currentStep === 1;
        
        if (currentStep === totalSteps) {
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
        } else {
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        }
        
        // Scroll al inicio
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    function validateStep(step) {
        const stepContent = document.querySelector(`.step-content[data-step="${step}"]`);
        const requiredInputs = stepContent.querySelectorAll('[required]');
        
        for (let input of requiredInputs) {
            if (!input.value.trim()) {
                input.focus();
                input.classList.add('border-red-500');
                
                // Mostrar mensaje de error
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor complete todos los campos requeridos antes de continuar.',
                    confirmButtonColor: '#3b82f6'
                });
                
                setTimeout(() => {
                    input.classList.remove('border-red-500');
                }, 3000);
                
                return false;
            }
        }
        return true;
    }
    
    nextBtn.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            currentStep++;
            updateStep();
        }
    });
    
    prevBtn.addEventListener('click', function() {
        currentStep--;
        updateStep();
    });
    
    // Manejar clic en los círculos de progreso
    document.querySelectorAll('.progress-step').forEach(step => {
        step.addEventListener('click', function() {
            const targetStep = parseInt(this.getAttribute('data-step'));
            if (targetStep < currentStep || validateStep(currentStep)) {
                currentStep = targetStep;
                updateStep();
            }
        });
    });
    
    // Manejo de archivos
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');
    
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            fileList.innerHTML = '';
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                const listContainer = document.createElement('div');
                listContainer.className = 'space-y-2';
                
                files.forEach((file, index) => {
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center justify-between bg-white p-3 rounded-lg shadow-sm border border-gray-200';
                    
                    const fileIcon = file.type.includes('image') ? 'fa-image' : 
                                   file.type.includes('pdf') ? 'fa-file-pdf' : 'fa-file-alt';
                    
                    fileItem.innerHTML = `
                        <div class="flex items-center space-x-3">
                            <i class="fas ${fileIcon} text-yellow-500 text-xl"></i>
                            <div>
                                <p class="text-sm font-semibold text-gray-800">${file.name}</p>
                                <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(2)} KB</p>
                            </div>
                        </div>
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    `;
                    
                    listContainer.appendChild(fileItem);
                });
                
                fileList.appendChild(listContainer);
            }
        });
    }
    
    // Inicializar
    updateStep();
});
</script>

<!-- SweetAlert2 para notificaciones -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Modales -->
@include('admin.ordenes._modal_crear_cliente')
@include('admin.ordenes._modal_crear_equipo')

@endsection
