{{-- Modal para Crear Equipo Rápido --}}
<div id="modalCrearEquipo" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">
        <!-- Header del Modal -->
        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-laptop text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Crear Nuevo Equipo</h3>
                </div>
                <button type="button" onclick="cerrarModalEquipo()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Formulario del Modal -->
        <form id="formCrearEquipoRapido" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tipo de Equipo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-laptop text-purple-500 mr-1"></i>
                        Tipo de Equipo *
                    </label>
                    <input type="text" 
                           name="tipo_equipo" 
                           required 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:outline-none transition-all"
                           placeholder="Laptop, Desktop, Tablet, etc.">
                </div>

                <!-- Modelo -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag text-purple-500 mr-1"></i>
                        Modelo *
                    </label>
                    <input type="text" 
                           name="modelo" 
                           required 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:outline-none transition-all"
                           placeholder="Dell Inspiron 15">
                </div>

                <!-- Marca -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-copyright text-purple-500 mr-1"></i>
                        Marca *
                    </label>
                    <select name="marca_id" 
                            required 
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:outline-none transition-all">
                        <option value="">Seleccione una marca...</option>
                        @foreach(\App\Models\Marca::orderBy('nombre_marca')->get() as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nombre_marca }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Número de Serie -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-barcode text-purple-500 mr-1"></i>
                        Número de Serie
                    </label>
                    <input type="text" 
                           name="numero_serie" 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:outline-none transition-all"
                           placeholder="SN123456789">
                </div>

                <!-- Categoría -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-folder text-purple-500 mr-1"></i>
                        Categoría
                    </label>
                    <input type="text" 
                           name="categoria" 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:outline-none transition-all"
                           placeholder="Computación, Periféricos, etc.">
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-toggle-on text-purple-500 mr-1"></i>
                        Estado
                    </label>
                    <select name="activo" 
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:outline-none transition-all">
                        <option value="1" selected>✅ Activo</option>
                        <option value="0">❌ Inactivo</option>
                    </select>
                </div>

                <!-- Descripción -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left text-purple-500 mr-1"></i>
                        Descripción
                    </label>
                    <textarea name="descripcion" 
                              rows="3"
                              class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:outline-none transition-all resize-none"
                              placeholder="Descripción detallada del equipo..."></textarea>
                </div>
            </div>

            <!-- Mensaje de estado -->
            <div id="mensajeEstadoEquipo" class="mt-4 hidden"></div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" 
                        onclick="cerrarModalEquipo()"
                        class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white font-semibold rounded-lg transition-all shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Equipo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalEquipo() {
        document.getElementById('modalCrearEquipo').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalEquipo() {
        document.getElementById('modalCrearEquipo').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formCrearEquipoRapido').reset();
        document.getElementById('mensajeEstadoEquipo').classList.add('hidden');
    }

    // Manejar envío del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formCrearEquipoRapido');
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const mensajeDiv = document.getElementById('mensajeEstadoEquipo');
                const submitBtn = form.querySelector('button[type="submit"]');
                
                // Deshabilitar botón
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
                
                try {
                    const response = await fetch('{{ route("equipos.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: formData
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        // Mostrar mensaje de éxito
                        mensajeDiv.innerHTML = `
                            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-xl mr-3"></i>
                                    <div>
                                        <p class="font-semibold">¡Equipo creado exitosamente!</p>
                                        <p class="text-sm">El equipo ha sido agregado a la lista.</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        mensajeDiv.classList.remove('hidden');
                        
                        // Agregar el nuevo equipo al select
                        const selectEquipo = document.querySelector('select[name="equipo_id"]');
                        if (selectEquipo && data.equipo) {
                            const option = document.createElement('option');
                            option.value = data.equipo.id;
                            option.selected = true;
                            option.textContent = `💻 ${data.equipo.modelo || data.equipo.tipo_equipo} - ${data.equipo.marca?.nombre_marca || 'Sin marca'}${data.equipo.numero_serie ? ' - S/N: ' + data.equipo.numero_serie : ''}`;
                            selectEquipo.appendChild(option);
                        }
                        
                        // Cerrar modal después de 1.5 segundos
                        setTimeout(() => {
                            cerrarModalEquipo();
                        }, 1500);
                        
                    } else {
                        // Mostrar error
                        mensajeDiv.innerHTML = `
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                                    <div>
                                        <p class="font-semibold">Error al crear el equipo</p>
                                        <p class="text-sm">${data.message || 'Por favor verifique los datos.'}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        mensajeDiv.classList.remove('hidden');
                    }
                    
                } catch (error) {
                    mensajeDiv.innerHTML = `
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                                <div>
                                    <p class="font-semibold">Error de conexión</p>
                                    <p class="text-sm">No se pudo conectar con el servidor.</p>
                                </div>
                            </div>
                        </div>
                    `;
                    mensajeDiv.classList.remove('hidden');
                } finally {
                    // Rehabilitar botón
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Guardar Equipo';
                }
            });
        }
    });

    // Cerrar modal al presionar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalEquipo();
        }
    });

    // Cerrar modal al hacer clic fuera
    document.getElementById('modalCrearEquipo')?.addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalEquipo();
        }
    });
</script>
