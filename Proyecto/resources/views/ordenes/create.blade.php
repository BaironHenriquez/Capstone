@extends('layouts.admin')

@section('title', 'Nueva Orden de Servicio')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nueva Orden de Servicio</h1>
            <p class="text-gray-600 mt-1">Crea una nueva orden de servicio técnico</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('ordenes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
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
        <div class="form-message mb-4 p-4 rounded-md hidden"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Panel principal del formulario -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Información básica -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Información Básica
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Número de Orden <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="numero_orden" 
                                       value="{{ 'TS-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT) }}"
                                       class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       data-validate="required|alphanumeric"
                                       readonly>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha de Ingreso <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="fecha_ingreso" 
                                       value="{{ date('Y-m-d') }}"
                                       class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       data-validate="required">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipo de Servicio <span class="text-red-500">*</span>
                                </label>
                                <select name="tipo_servicio" 
                                        class="validate-input trigger-dynamic w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        data-validate="required"
                                        data-dynamic-type="servicioTecnico"
                                        data-target="#campos-dinamicos-servicio">
                                    <option value="">Seleccione un tipo</option>
                                    <option value="reparacion">Reparación</option>
                                    <option value="mantenimiento">Mantenimiento</option>
                                    <option value="instalacion">Instalación</option>
                                    <option value="consultoria">Consultoría</option>
                                    <option value="soporte">Soporte Técnico</option>
                                </select>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Prioridad <span class="text-red-500">*</span>
                                </label>
                                <select name="prioridad" 
                                        class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        data-validate="required">
                                    <option value="">Seleccione prioridad</option>
                                    <option value="baja">Baja</option>
                                    <option value="media" selected>Media</option>
                                    <option value="alta">Alta</option>
                                    <option value="urgente">Urgente</option>
                                </select>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Estado
                                </label>
                                <select name="estado" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="pendiente" selected>Pendiente</option>
                                    <option value="asignado">Asignado</option>
                                    <option value="en_progreso">En Progreso</option>
                                    <option value="completado">Completado</option>
                                    <option value="cancelado">Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Descripción del Problema <span class="text-red-500">*</span>
                            </label>
                            <textarea name="descripcion_problema" 
                                      rows="4" 
                                      class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                      data-validate="required|minLength:10|maxLength:1000"
                                      placeholder="Describe detalladamente el problema o servicio requerido..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Cliente y contacto -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-user text-green-600 mr-2"></i>
                            Cliente y Contacto
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Cliente <span class="text-red-500">*</span>
                                </label>
                                <select name="cliente_id" 
                                        class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        data-validate="required">
                                    <option value="">Seleccione un cliente</option>
                                    <option value="1">Juan García Pérez</option>
                                    <option value="2">María López Silva</option>
                                    <option value="3">Carlos Martínez Torres</option>
                                    <option value="4">Ana Rodríguez López</option>
                                    <option value="5">Diego Sánchez Morales</option>
                                </select>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Contacto en Sitio
                                </label>
                                <input type="text" 
                                       name="contacto_en_sitio" 
                                       class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       data-validate="maxLength:100"
                                       placeholder="Nombre del contacto en sitio">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Teléfono de Contacto
                                </label>
                                <input type="tel" 
                                       name="telefono_contacto" 
                                       class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       data-validate="phone"
                                       placeholder="+56 9 1234 5678">
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Ubicación del Servicio
                                </label>
                                <input type="text" 
                                       name="ubicacion_servicio" 
                                       class="validate-input address-search w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       data-validate="maxLength:200"
                                       placeholder="Dirección donde se realizará el servicio">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Equipo -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-laptop text-purple-600 mr-2"></i>
                            Información del Equipo
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Equipo <span class="text-red-500">*</span>
                                </label>
                                <select name="equipo_id" 
                                        class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                        data-validate="required">
                                    <option value="">Seleccione un equipo</option>
                                    <option value="1">Laptop HP Pavilion</option>
                                    <option value="2">Desktop Dell OptiPlex</option>
                                    <option value="3">iPhone 14 Pro</option>
                                    <option value="4">Samsung Galaxy S23</option>
                                    <option value="5">Impresora Canon MG3600</option>
                                </select>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Medio de Pago
                                </label>
                                <select name="medio_de_pago" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Seleccione medio de pago</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta_credito">Tarjeta de Crédito</option>
                                    <option value="tarjeta_debito">Tarjeta de Débito</option>
                                    <option value="transferencia">Transferencia Bancaria</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tipo de Trabajo
                                </label>
                                <select name="tipo_de_trabajo" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Seleccione tipo</option>
                                    <option value="domicilio">A domicilio</option>
                                    <option value="taller">En taller</option>
                                    <option value="remoto">Remoto</option>
                                    <option value="empresarial">Empresarial</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campos dinámicos según tipo de servicio -->
                        <div id="campos-dinamicos-servicio" class="space-y-4"></div>
                    </div>
                </div>

                <!-- Planificación -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-calendar text-indigo-600 mr-2"></i>
                            Planificación
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha Programada
                                </label>
                                <input type="datetime-local" 
                                       name="fecha_programada" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha Aproximada de Entrega
                                </label>
                                <input type="date" 
                                       name="fecha_aprox_entrega" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Horas Estimadas
                                </label>
                                <input type="number" 
                                       name="horas_estimadas" 
                                       step="0.5" 
                                       min="0" 
                                       max="500"
                                       class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       data-validate="numeric"
                                       placeholder="Ej: 2.5">
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Precio Presupuestado
                                </label>
                                <input type="number" 
                                       name="precio_presupuestado" 
                                       step="0.01" 
                                       min="0"
                                       class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       data-validate="numeric"
                                       placeholder="0.00">
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Abono
                                </label>
                                <input type="number" 
                                       name="abono" 
                                       step="0.01" 
                                       min="0"
                                       class="validate-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                       data-validate="numeric"
                                       placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Archivos adjuntos -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-paperclip text-yellow-600 mr-2"></i>
                            Archivos Adjuntos
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Fotos de Ingreso
                                </label>
                                <input type="file" 
                                       name="fotos_ingreso[]" 
                                       multiple 
                                       accept="image/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Máximo 5 archivos, 10MB cada uno</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Videos de Evidencia
                                </label>
                                <input type="file" 
                                       name="videos_evidencia[]" 
                                       multiple 
                                       accept="video/*"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Máximo 3 archivos, 50MB cada uno</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Otros Archivos
                            </label>
                            <input type="file" 
                                   name="archivos_adjuntos[]" 
                                   multiple 
                                   accept=".pdf,.doc,.docx,.txt,.jpg,.png,.gif"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">PDF, DOC, imágenes. Máximo 10 archivos, 25MB cada uno</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel lateral -->
            <div class="space-y-6">
                <!-- Acciones -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Acciones</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Crear Orden
                        </button>
                        
                        <button type="button" 
                                class="btn-save-draft w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bookmark mr-2"></i>
                            Guardar Borrador
                        </button>
                        
                        <button type="button" 
                                class="btn-load-draft w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-folder-open mr-2"></i>
                            Cargar Borrador
                        </button>
                        
                        <button type="button" 
                                class="btn-auto-fill w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center"
                                data-form-id="nueva-orden"
                                data-fill-type="orden">
                            <i class="fas fa-magic mr-2"></i>
                            Auto-llenar
                        </button>
                    </div>
                </div>

                <!-- Asignación IA -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-robot text-purple-600 mr-2"></i>
                            Asistente IA
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <button type="button" 
                                class="btn-recomendar-tecnico w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center"
                                data-orden-id="nueva"
                                data-tipo-servicio=""
                                data-prioridad="">
                            <i class="fas fa-user-cog mr-2"></i>
                            Recomendar Técnico
                        </button>
                        
                        <button type="button" 
                                class="btn-calcular-tiempo w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock mr-2"></i>
                            Estimar Tiempo
                        </button>
                        
                        <button type="button" 
                                class="btn-calcular-precio w-full bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 px-4 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calculator mr-2"></i>
                            Calcular Precio
                        </button>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Información</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="text-sm">
                            <strong class="text-gray-700">Creado por:</strong>
                            <br>
                            <span class="text-gray-600">{{ Auth::user()->name ?? 'Usuario Actual' }}</span>
                        </div>
                        
                        <div class="text-sm">
                            <strong class="text-gray-700">Fecha de creación:</strong>
                            <br>
                            <span class="text-gray-600">{{ date('d/m/Y H:i') }}</span>
                        </div>
                        
                        <div class="text-sm">
                            <strong class="text-gray-700">Estado:</strong>
                            <br>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Nuevo
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Configuración adicional -->
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Configuración</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="requiere_aprobacion" value="1" class="mr-2">
                            <span class="text-sm text-gray-700">Requiere aprobación</span>
                        </label>
                        
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Observaciones Adicionales
                            </label>
                            <textarea name="observaciones_tecnico" 
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                      placeholder="Observaciones del técnico..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript para funcionalidades del formulario -->
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
        
        // Mostrar saldo calculado (podrías añadir un campo hidden o mostrar en UI)
        console.log('Saldo calculado:', saldo);
    }
    
    if (precioInput) precioInput.addEventListener('input', calcularSaldo);
    if (abonoInput) abonoInput.addEventListener('input', calcularSaldo);
});
</script>
@endsection