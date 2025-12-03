<!-- Modal para ver detalles de orden -->
<div id="modalOrden" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full my-8">
        <!-- Header del Modal -->
        <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-4 flex items-center justify-between rounded-t-lg">
            <div>
                <h2 class="text-2xl font-bold">Orden #<span id="numeroOrdenModal">--</span></h2>
                <p class="text-blue-100 text-sm mt-1"><i class="fas fa-calendar-alt mr-2"></i><span id="fechaOrdenModal">--</span></p>
            </div>
            <button onclick="cerrarModalOrden()" class="text-white hover:text-gray-200 transition-colors">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <!-- Contenido del Modal -->
        <div class="overflow-y-auto max-h-[calc(100vh-200px)] p-6">
            <!-- Grid de información principal -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Estado -->
                <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Estado</h3>
                    <div id="estadoOrdenModal" class="estado-badge">--</div>
                </div>

                <!-- Prioridad -->
                <div class="bg-purple-50 rounded-lg p-4 border-l-4 border-purple-500">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Prioridad</h3>
                    <div id="prioridadOrdenModal" class="prioridad-badge">--</div>
                </div>

                <!-- Técnico -->
                <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Técnico</h3>
                    <p id="tecnicoOrdenModal" class="text-lg font-semibold text-gray-900">--</p>
                </div>
            </div>

            <!-- Información General -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>Información General
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Cliente</label>
                        <p id="clienteOrdenModal" class="text-gray-900">--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Equipo</label>
                        <p id="equipoOrdenModal" class="text-gray-900">--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Tipo de Servicio</label>
                        <p id="tipoServicioOrdenModal" class="text-gray-900">--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Tipo de Trabajo</label>
                        <p id="tipoTrabajoOrdenModal" class="text-gray-900">--</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-gray-600">Descripción del Problema</label>
                        <p id="descripcionOrdenModal" class="text-gray-900 bg-white p-3 rounded border">--</p>
                    </div>
                </div>
            </div>

            <!-- Datos Económicos -->
            <div class="bg-green-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-dollar-sign text-green-500 mr-2"></i>Datos Económicos
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Precio Presupuestado</label>
                        <p id="precioOrdenModal" class="text-2xl font-bold text-gray-900">$--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Abono</label>
                        <p id="abonoOrdenModal" class="text-2xl font-bold text-blue-600">$--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Saldo Pendiente</label>
                        <p id="saldoOrdenModal" class="text-2xl font-bold text-orange-600">$--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Medio de Pago</label>
                        <p id="medioOrdenModal" class="text-gray-900">--</p>
                    </div>
                </div>
            </div>

            <!-- Detalles Adicionales -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-clipboard-list text-purple-500 mr-2"></i>Detalles Adicionales
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Contacto en Sitio</label>
                        <p id="contactoOrdenModal" class="text-gray-900">--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Teléfono</label>
                        <p id="telefonoOrdenModal" class="text-gray-900">--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Ubicación</label>
                        <p id="ubicacionOrdenModal" class="text-gray-900">--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Horas Estimadas</label>
                        <p id="horasOrdenModal" class="text-gray-900">-- horas</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Fecha Programada</label>
                        <p id="fechaProgramadaOrdenModal" class="text-gray-900">--</p>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Fecha Entrega</label>
                        <p id="fechaEntregaOrdenModal" class="text-gray-900">--</p>
                    </div>
                </div>
            </div>

            <!-- Galería de Fotos -->
            <div id="galeriaFotosContainer" class="mb-6" style="display: none;">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-images text-yellow-500 mr-2"></i>Fotos del Ingreso del Equipo
                </h3>
                <div id="galeriaFotosModal" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Se llena dinámicamente -->
                </div>
            </div>
        </div>

        <!-- Footer del Modal -->
        <div class="bg-gray-100 px-6 py-4 flex justify-end space-x-2 rounded-b-lg">
            <button onclick="cerrarModalOrden()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-times mr-2"></i>Cerrar
            </button>
            <a id="btnEditarOrdenModal" href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors inline-block">
                <i class="fas fa-edit mr-2"></i>Editar
            </a>
        </div>
    </div>
</div>

<!-- Modal para ver imagen en grande -->
<div id="modalImagenGrande" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl w-full">
        <button onclick="cerrarModalImagen()" class="absolute -top-10 right-0 text-white hover:text-gray-200">
            <i class="fas fa-times text-3xl"></i>
        </button>
        <img id="imagenGrande" src="" alt="Imagen ampliada" class="max-w-full max-h-[85vh] object-contain mx-auto">
    </div>
</div>

<style>
    .estado-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .estado-pendiente { background-color: #fef3c7; color: #92400e; }
    .estado-asignada { background-color: #dbeafe; color: #1e40af; }
    .estado-en_progreso { background-color: #bfdbfe; color: #1e3a8a; }
    .estado-completada { background-color: #bbf7d0; color: #166534; }
    .estado-cancelada { background-color: #fecaca; color: #991b1b; }
    
    .prioridad-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .prioridad-baja { background-color: #dcfce7; color: #166534; }
    .prioridad-media { background-color: #fef3c7; color: #92400e; }
    .prioridad-alta { background-color: #fed7aa; color: #9a3412; }
    .prioridad-urgente { background-color: #fecaca; color: #991b1b; }

    .imagen-galeria {
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .imagen-galeria:hover {
        transform: scale(1.05);
    }
</style>

<script>
function abrirModalOrden(ordenId) {
    // Hacer petición AJAX para obtener los datos de la orden
    fetch(`/admin/ordenes/${ordenId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const orden = data.orden;
        
        // Llenar datos en el modal
        document.getElementById('numeroOrdenModal').textContent = orden.numero_orden;
        document.getElementById('fechaOrdenModal').textContent = new Date(orden.created_at).toLocaleString('es-ES');
        
        // Estado y Prioridad
        const estadoDiv = document.getElementById('estadoOrdenModal');
        estadoDiv.className = `estado-badge estado-${orden.estado}`;
        estadoDiv.textContent = orden.estado.charAt(0).toUpperCase() + orden.estado.slice(1).replace(/_/g, ' ');
        
        const prioridadDiv = document.getElementById('prioridadOrdenModal');
        prioridadDiv.className = `prioridad-badge prioridad-${orden.prioridad}`;
        prioridadDiv.textContent = orden.prioridad.charAt(0).toUpperCase() + orden.prioridad.slice(1);
        
        document.getElementById('tecnicoOrdenModal').textContent = orden.tecnico?.nombre || 'Sin asignar';
        
        // Información General
        document.getElementById('clienteOrdenModal').textContent = orden.cliente?.nombre || 'N/A';
        document.getElementById('equipoOrdenModal').textContent = (orden.equipo?.modelo || 'N/A') + ' - ' + (orden.equipo?.marca?.nombre_marca || '');
        document.getElementById('tipoServicioOrdenModal').textContent = orden.tipo_servicio || 'N/A';
        document.getElementById('tipoTrabajoOrdenModal').textContent = orden.tipo_de_trabajo || 'N/A';
        document.getElementById('descripcionOrdenModal').textContent = orden.descripcion_problema || 'N/A';
        
        // Datos Económicos
        document.getElementById('precioOrdenModal').textContent = '$' + parseFloat(orden.precio_presupuestado || 0).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('abonoOrdenModal').textContent = '$' + parseFloat(orden.abono || 0).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('saldoOrdenModal').textContent = '$' + parseFloat(orden.saldo || 0).toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('medioOrdenModal').textContent = orden.medio_de_pago || 'N/A';
        
        // Detalles Adicionales
        document.getElementById('contactoOrdenModal').textContent = orden.contacto_en_sitio || 'N/A';
        document.getElementById('telefonoOrdenModal').textContent = orden.telefono_contacto || 'N/A';
        document.getElementById('ubicacionOrdenModal').textContent = orden.ubicacion_servicio || 'N/A';
        document.getElementById('horasOrdenModal').textContent = (orden.horas_estimadas || 0) + ' horas';
        document.getElementById('fechaProgramadaOrdenModal').textContent = orden.fecha_programada ? new Date(orden.fecha_programada).toLocaleDateString('es-ES') : 'N/A';
        document.getElementById('fechaEntregaOrdenModal').textContent = orden.fecha_aprox_entrega ? new Date(orden.fecha_aprox_entrega).toLocaleDateString('es-ES') : 'N/A';
        
        // Botón editar
        document.getElementById('btnEditarOrdenModal').href = `/admin/ordenes/${orden.id}/edit`;
        
        // Galería de fotos
        const galeriaContainer = document.getElementById('galeriaFotosContainer');
        const galeriaModal = document.getElementById('galeriaFotosModal');
        
        if (orden.fotos_ingreso && orden.fotos_ingreso.length > 0) {
            galeriaModal.innerHTML = '';
            orden.fotos_ingreso.forEach((foto, index) => {
                const div = document.createElement('div');
                div.className = 'bg-gray-100 rounded-lg overflow-hidden shadow hover:shadow-lg';
                div.innerHTML = `
                    <img src="${foto}" alt="Foto ${index + 1}" class="imagen-galeria w-full h-full" onclick="abrirModalImagen('${foto}', 'Foto ${index + 1}')">
                    <div class="p-2 bg-gray-50 text-center">
                        <p class="text-xs text-gray-600">Foto ${index + 1}</p>
                    </div>
                `;
                galeriaModal.appendChild(div);
            });
            galeriaContainer.style.display = 'block';
        } else {
            galeriaContainer.style.display = 'none';
        }
        
        // Mostrar modal
        document.getElementById('modalOrden').classList.remove('hidden');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar los datos de la orden');
    });
}

function cerrarModalOrden() {
    document.getElementById('modalOrden').classList.add('hidden');
}

function abrirModalImagen(src, alt) {
    document.getElementById('imagenGrande').src = src;
    document.getElementById('imagenGrande').alt = alt;
    document.getElementById('modalImagenGrande').classList.remove('hidden');
}

function cerrarModalImagen() {
    document.getElementById('modalImagenGrande').classList.add('hidden');
}

// Cerrar modal con ESC
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        cerrarModalOrden();
        cerrarModalImagen();
    }
});

// Cerrar modal al hacer click fuera
document.getElementById('modalOrden')?.addEventListener('click', function(event) {
    if (event.target === this) {
        cerrarModalOrden();
    }
});

document.getElementById('modalImagenGrande')?.addEventListener('click', function(event) {
    if (event.target === this) {
        cerrarModalImagen();
    }
});
</script>
