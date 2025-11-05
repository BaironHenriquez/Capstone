{{-- Modal para Crear Cliente Rápido --}}
<div id="modalCrearCliente" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto animate-scale-in">
        <!-- Header del Modal -->
        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Crear Nuevo Cliente</h3>
                </div>
                <button type="button" onclick="cerrarModalCliente()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Formulario del Modal -->
        <form id="formCrearClienteRapido" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-green-500 mr-1"></i>
                        Nombre *
                    </label>
                    <input type="text" 
                           name="nombre" 
                           required 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition-all"
                           placeholder="Juan">
                </div>

                <!-- Apellido -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-green-500 mr-1"></i>
                        Apellido *
                    </label>
                    <input type="text" 
                           name="apellido" 
                           required 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition-all"
                           placeholder="Pérez">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-green-500 mr-1"></i>
                        Correo Electrónico *
                    </label>
                    <input type="email" 
                           name="correo" 
                           required 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition-all"
                           placeholder="juan@example.com">
                </div>

                <!-- Teléfono -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone text-green-500 mr-1"></i>
                        Teléfono *
                    </label>
                    <input type="tel" 
                           name="telefono" 
                           required 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition-all"
                           placeholder="+56 9 1234 5678">
                </div>

                <!-- RUT -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-id-card text-green-500 mr-1"></i>
                        RUT
                    </label>
                    <input type="text" 
                           name="rut" 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition-all"
                           placeholder="12.345.678-9">
                </div>

                <!-- Tipo de Cliente -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-briefcase text-green-500 mr-1"></i>
                        Tipo de Cliente
                    </label>
                    <select name="tipo_cliente" 
                            class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition-all">
                        <option value="regular" selected>� Regular</option>
                        <option value="vip">⭐ VIP</option>
                        <option value="corporativo">🏢 Corporativo</option>
                    </select>
                </div>

                <!-- Dirección -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt text-green-500 mr-1"></i>
                        Dirección
                    </label>
                    <input type="text" 
                           name="direccion" 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition-all"
                           placeholder="Av. Principal #123, Ciudad">
                </div>

                <!-- Empresa (opcional) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-building text-green-500 mr-1"></i>
                        Empresa (opcional)
                    </label>
                    <input type="text" 
                           name="empresa" 
                           class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-green-500 focus:outline-none transition-all"
                           placeholder="Nombre de la empresa">
                </div>
            </div>

            <!-- Mensaje de estado -->
            <div id="mensajeEstadoCliente" class="mt-4 hidden"></div>

            <!-- Botones -->
            <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" 
                        onclick="cerrarModalCliente()"
                        class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-all">
                    <i class="fas fa-times mr-2"></i>
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-semibold rounded-lg transition-all shadow-lg">
                    <i class="fas fa-save mr-2"></i>
                    Guardar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes scale-in {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .animate-scale-in {
        animation: scale-in 0.3s ease-out;
    }
</style>

<script>
    function abrirModalCliente() {
        document.getElementById('modalCrearCliente').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function cerrarModalCliente() {
        document.getElementById('modalCrearCliente').classList.add('hidden');
        document.body.style.overflow = 'auto';
        document.getElementById('formCrearClienteRapido').reset();
        document.getElementById('mensajeEstadoCliente').classList.add('hidden');
    }

    // Manejar envío del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formCrearClienteRapido');
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const mensajeDiv = document.getElementById('mensajeEstadoCliente');
                const submitBtn = form.querySelector('button[type="submit"]');
                
                // Deshabilitar botón
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
                
                try {
                    const response = await fetch('{{ route("clientes.store") }}', {
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
                                        <p class="font-semibold">¡Cliente creado exitosamente!</p>
                                        <p class="text-sm">El cliente ha sido agregado a la lista.</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        mensajeDiv.classList.remove('hidden');
                        
                        // Agregar el nuevo cliente al select
                        const selectCliente = document.querySelector('select[name="cliente_id"]');
                        if (selectCliente && data.cliente) {
                            const option = document.createElement('option');
                            option.value = data.cliente.id;
                            option.selected = true;
                            option.textContent = `👤 ${data.cliente.nombre} ${data.cliente.apellido || ''} - ${data.cliente.correo || data.cliente.telefono || 'Sin contacto'}`;
                            selectCliente.appendChild(option);
                        }
                        
                        // Cerrar modal después de 1.5 segundos
                        setTimeout(() => {
                            cerrarModalCliente();
                        }, 1500);
                        
                    } else {
                        // Mostrar error
                        mensajeDiv.innerHTML = `
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                                    <div>
                                        <p class="font-semibold">Error al crear el cliente</p>
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
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Guardar Cliente';
                }
            });
        }
    });

    // Cerrar modal al presionar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalCliente();
        }
    });

    // Cerrar modal al hacer clic fuera
    document.getElementById('modalCrearCliente')?.addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalCliente();
        }
    });
</script>
