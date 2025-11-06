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
    
    .animate-slide-in-right { animation: slideInRight 0.5s ease-out; }
    .animate-slide-in-left { animation: slideInLeft 0.5s ease-out; }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out; }
    .animate-scale-in { animation: scaleIn 0.4s ease-out; }
    
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .input-focus {
        transition: all 0.3s ease;
    }
    
    .input-focus:focus {
        transform: scale(1.01);
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
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 py-8">
    <div class="container mx-auto px-4 max-w-7xl">
        
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
                            Complete los datos para registrar una nueva orden
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

        <!-- Formulario principal -->
        <form action="{{ route('ordenes.store') }}" method="POST" 
              class="dynamic-form auto-save-form" 
              enctype="multipart/form-data" 
              data-clear-on-success="false"
              data-on-success="handleOrderSuccess">
            @csrf
            
            <!-- Mensaje de formulario -->
            <div class="form-message mb-6 p-4 rounded-xl hidden animate-scale-in"></div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Panel principal -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Información básica -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-left">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                Información Básica
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-hashtag text-blue-500 mr-2"></i>
                                        Número de Orden 
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               name="numero_orden" 
                                               value="{{ 'TS-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) }}"
                                               class="input-focus w-full px-4 py-3 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500 bg-gray-50 font-mono font-bold text-gray-700"
                                               readonly>
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-blue-400">
                                            <i class="fas fa-barcode"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-calendar-alt text-green-500 mr-2"></i>
                                        Fecha de Ingreso 
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="date" 
                                           name="fecha_ingreso" 
                                           value="{{ date('Y-m-d') }}"
                                           class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-500" 
                                           data-validate="required">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-wrench text-purple-500 mr-2"></i>
                                        Tipo de Servicio 
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select name="tipo_servicio" 
                                            class="input-focus validate-input trigger-dynamic w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-200 focus:border-purple-500 cursor-pointer" 
                                            data-validate="required"
                                            data-dynamic-type="servicioTecnico"
                                            data-target="#campos-dinamicos-servicio">
                                        <option value="">🔧 Seleccione un tipo</option>
                                        <option value="reparacion">🔨 Reparación</option>
                                        <option value="mantenimiento">⚙️ Mantenimiento</option>
                                        <option value="instalacion">🔌 Instalación</option>
                                        <option value="consultoria">💡 Consultoría</option>
                                        <option value="soporte">🛠️ Soporte Técnico</option>
                                    </select>
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-exclamation-triangle text-orange-500 mr-2"></i>
                                        Prioridad 
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select name="prioridad" 
                                            class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-orange-500 cursor-pointer" 
                                            data-validate="required">
                                        <option value="">Seleccione prioridad</option>
                                        <option value="baja">🟢 Baja</option>
                                        <option value="media" selected>🟡 Media</option>
                                        <option value="alta">🟠 Alta</option>
                                        <option value="urgente">🔴 Urgente</option>
                                    </select>
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-tasks text-indigo-500 mr-2"></i>
                                        Estado
                                    </label>
                                    <select name="estado" 
                                            class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 cursor-pointer">
                                        <option value="pendiente" selected>⏳ Pendiente</option>
                                        <option value="asignado">👤 Asignado</option>
                                        <option value="en_progreso">🔄 En Progreso</option>
                                        <option value="completado">✅ Completado</option>
                                        <option value="cancelado">❌ Cancelado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-comment-dots text-pink-500 mr-2"></i>
                                    Descripción del Problema 
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <textarea name="descripcion_problema" 
                                          rows="4" 
                                          class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-200 focus:border-pink-500 resize-none" 
                                          data-validate="required|minLength:10|maxLength:1000"
                                          placeholder="Describe detalladamente el problema o servicio requerido..."></textarea>
                                <div class="text-xs text-gray-500 mt-2 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Mínimo 10 caracteres, máximo 1000
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cliente -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-left delay-100">
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                Cliente y Contacto
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-user-circle text-green-500 mr-2"></i>
                                        Cliente 
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select name="cliente_id" 
                                            class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-500 cursor-pointer" 
                                            data-validate="required">
                                        <option value="">👤 Seleccione un cliente</option>
                                        @foreach($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->nombre_completo ?? $cliente->nombre . ' ' . $cliente->apellido }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-id-badge text-teal-500 mr-2"></i>
                                        Contacto en Sitio
                                    </label>
                                    <input type="text" 
                                           name="contacto_en_sitio" 
                                           class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-teal-200 focus:border-teal-500" 
                                           data-validate="maxLength:100"
                                           placeholder="Nombre del contacto en sitio">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-phone text-blue-500 mr-2"></i>
                                        Teléfono de Contacto
                                    </label>
                                    <input type="tel" 
                                           name="telefono_contacto" 
                                           class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500" 
                                           data-validate="phone"
                                           placeholder="+56 9 1234 5678">
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                        Ubicación del Servicio
                                    </label>
                                    <input type="text" 
                                           name="ubicacion_servicio" 
                                           class="input-focus validate-input address-search w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-200 focus:border-red-500" 
                                           data-validate="maxLength:200"
                                           placeholder="Dirección donde se realizará el servicio">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipo -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-left delay-200">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-laptop"></i>
                                </div>
                                Información del Equipo
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-desktop text-purple-500 mr-2"></i>
                                        Equipo 
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select name="equipo_id" 
                                            class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-200 focus:border-purple-500 cursor-pointer" 
                                            data-validate="required">
                                        <option value="">💻 Seleccione un equipo</option>
                                        @foreach($equipos as $equipo)
                                            <option value="{{ $equipo->id }}">
                                                {{ $equipo->marca->nombre ?? 'Sin marca' }} {{ $equipo->modelo }} ({{ $equipo->numero_serie }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-credit-card text-green-500 mr-2"></i>
                                        Medio de Pago
                                    </label>
                                    <select name="medio_de_pago" 
                                            class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-500 cursor-pointer">
                                        <option value="">💳 Seleccione medio de pago</option>
                                        <option value="efectivo">💵 Efectivo</option>
                                        <option value="tarjeta_credito">💳 Tarjeta de Crédito</option>
                                        <option value="tarjeta_debito">💳 Tarjeta de Débito</option>
                                        <option value="transferencia">🏦 Transferencia Bancaria</option>
                                        <option value="paypal">🅿️ PayPal</option>
                                    </select>
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-briefcase text-indigo-500 mr-2"></i>
                                        Tipo de Trabajo
                                    </label>
                                    <select name="tipo_de_trabajo" 
                                            class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-200 focus:border-indigo-500 cursor-pointer">
                                        <option value="">📋 Seleccione tipo</option>
                                        <option value="domicilio">🏠 A domicilio</option>
                                        <option value="taller">🔧 En taller</option>
                                        <option value="remoto">🌐 Remoto</option>
                                        <option value="empresarial">🏢 Empresarial</option>
                                    </select>
                                </div>
                            </div>

                            <div id="campos-dinamicos-servicio" class="space-y-4"></div>
                        </div>
                    </div>

                    <!-- Planificación -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-left delay-300">
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                Planificación y Costos
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-clock text-blue-500 mr-2"></i>
                                        Fecha Programada
                                    </label>
                                    <input type="datetime-local" 
                                           name="fecha_programada" 
                                           class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500">
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                                        Fecha Aproximada de Entrega
                                    </label>
                                    <input type="date" 
                                           name="fecha_aprox_entrega" 
                                           class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-hourglass-half text-orange-500 mr-2"></i>
                                        Horas Estimadas
                                    </label>
                                    <input type="number" 
                                           name="horas_estimadas" 
                                           step="0.5" 
                                           min="0" 
                                           max="500"
                                           class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-orange-500" 
                                           data-validate="numeric"
                                           placeholder="Ej: 2.5">
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-dollar-sign text-green-500 mr-2"></i>
                                        Precio Presupuestado
                                    </label>
                                    <input type="number" 
                                           name="precio_presupuestado" 
                                           step="0.01" 
                                           min="0"
                                           class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-200 focus:border-green-500" 
                                           data-validate="numeric"
                                           placeholder="0.00">
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-hand-holding-usd text-blue-500 mr-2"></i>
                                        Abono
                                    </label>
                                    <input type="number" 
                                           name="abono" 
                                           step="0.01" 
                                           min="0"
                                           class="input-focus validate-input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500" 
                                           data-validate="numeric"
                                           placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Archivos adjuntos -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-left">
                        <div class="bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-paperclip"></i>
                                </div>
                                Archivos Adjuntos
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-camera text-pink-500 mr-2"></i>
                                        Fotos de Ingreso
                                    </label>
                                    <input type="file" 
                                           name="fotos_ingreso[]" 
                                           multiple 
                                           accept="image/*"
                                           class="input-focus w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-pink-200 focus:border-pink-500 cursor-pointer">
                                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Máximo 5 archivos, 10MB cada uno
                                    </p>
                                </div>
                                
                                <div class="group">
                                    <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                        <i class="fas fa-video text-red-500 mr-2"></i>
                                        Videos de Evidencia
                                    </label>
                                    <input type="file" 
                                           name="videos_evidencia[]" 
                                           multiple 
                                           accept="video/*"
                                           class="input-focus w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-200 focus:border-red-500 cursor-pointer">
                                    <p class="text-xs text-gray-500 mt-2 flex items-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Máximo 3 archivos, 50MB cada uno
                                    </p>
                                </div>
                            </div>
                            
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-file text-blue-500 mr-2"></i>
                                    Otros Archivos
                                </label>
                                <input type="file" 
                                       name="archivos_adjuntos[]" 
                                       multiple 
                                       accept=".pdf,.doc,.docx,.txt,.jpg,.png,.gif"
                                       class="input-focus w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-200 focus:border-blue-500 cursor-pointer">
                                <p class="text-xs text-gray-500 mt-2 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    PDF, DOC, imágenes. Máximo 10 archivos, 25MB cada uno
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel lateral -->
                <div class="space-y-6">
                    <!-- Acciones -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-right sticky top-6">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-bolt mr-2"></i>
                                Acciones Rápidas
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <button type="submit" 
                                    class="btn-animate w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-save mr-2"></i>
                                Crear Orden
                            </button>
                            
                            <button type="button" 
                                    class="btn-save-draft btn-animate w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white font-bold py-3 px-6 rounded-xl flex items-center justify-center">
                                <i class="fas fa-bookmark mr-2"></i>
                                Guardar Borrador
                            </button>
                            
                            <button type="button" 
                                    class="btn-auto-fill btn-animate w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-3 px-6 rounded-xl flex items-center justify-center"
                                    data-form-id="nueva-orden"
                                    data-fill-type="orden">
                                <i class="fas fa-magic mr-2"></i>
                                Auto-llenar
                            </button>
                        </div>
                    </div>

                    <!-- Asistente IA -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-right delay-100">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-robot mr-2"></i>
                                Asistente IA
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <button type="button" 
                                    class="btn-recomendar-tecnico btn-animate w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl flex items-center justify-center"
                                    data-orden-id="nueva"
                                    data-tipo-servicio=""
                                    data-prioridad="">
                                <i class="fas fa-user-cog mr-2"></i>
                                Recomendar Técnico
                            </button>
                            
                            <button type="button" 
                                    class="btn-calcular-tiempo btn-animate w-full bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl flex items-center justify-center">
                                <i class="fas fa-clock mr-2"></i>
                                Estimar Tiempo
                            </button>
                            
                            <button type="button" 
                                    class="btn-calcular-precio btn-animate w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold py-3 px-6 rounded-xl flex items-center justify-center">
                                <i class="fas fa-calculator mr-2"></i>
                                Calcular Precio
                            </button>
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-right delay-200">
                        <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-info mr-2"></i>
                                Información
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Creado por</p>
                                    <p class="font-semibold text-gray-800">{{ Auth::user()->name ?? 'Usuario Actual' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar text-green-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Fecha de creación</p>
                                    <p class="font-semibold text-gray-800">{{ date('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-tag text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Estado</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                        ✨ Nuevo
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Configuración -->
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden card-hover animate-slide-in-right delay-300">
                        <div class="bg-gradient-to-r from-pink-500 to-rose-600 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-cog mr-2"></i>
                                Configuración
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="requiere_aprobacion" value="1" 
                                       class="w-5 h-5 text-pink-600 border-gray-300 rounded focus:ring-pink-500 focus:ring-2 cursor-pointer">
                                <span class="ml-3 text-sm font-semibold text-gray-700 group-hover:text-pink-600 transition">
                                    Requiere aprobación
                                </span>
                            </label>
                            
                            <div class="group">
                                <label class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-sticky-note text-orange-500 mr-2"></i>
                                    Observaciones Adicionales
                                </label>
                                <textarea name="observaciones_tecnico" 
                                          rows="3" 
                                          class="input-focus w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-200 focus:border-orange-500 resize-none" 
                                          placeholder="Observaciones del técnico..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script src="/js/modules/form-module.js"></script>
<script src="/js/modules/ia-module.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función personalizada para el éxito del formulario
    window.handleOrderSuccess = function(result) {
        if (result.orden_id) {
            setTimeout(() => {
                window.location.href = `/ordenes/${result.orden_id}`;
            }, 2000);
        }
    };
    
    // Actualizar datos IA cuando cambie tipo de servicio o prioridad
    document.querySelector('[name="tipo_servicio"]').addEventListener('change', function() {
        const btnIA = document.querySelector('.btn-recomendar-tecnico');
        btnIA.dataset.tipoServicio = this.value;
    });
    
    document.querySelector('[name="prioridad"]').addEventListener('change', function() {
        const btnIA = document.querySelector('.btn-recomendar-tecnico');
        btnIA.dataset.prioridad = this.value;
    });
    
    // Auto-calcular saldo cuando cambie precio o abono
    const precioInput = document.querySelector('[name="precio_presupuestado"]');
    const abonoInput = document.querySelector('[name="abono"]');
    
    function calcularSaldo() {
        const precio = parseFloat(precioInput.value) || 0;
        const abono = parseFloat(abonoInput.value) || 0;
        const saldo = precio - abono;
        console.log('Saldo calculado:', saldo);
    }
    
    if (precioInput) precioInput.addEventListener('input', calcularSaldo);
    if (abonoInput) abonoInput.addEventListener('input', calcularSaldo);
});
</script>
@endsection
