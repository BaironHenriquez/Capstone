@extends('shared.layouts.admin')

@section('title', 'Gestión de Clientes')
@section('breadcrumb', 'Pagina')

@push('styles')
<style>
    .dashboard-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Gestión de Clientes</h1>
            <p class="text-gray-600">Administra todos los clientes del sistema</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors duration-300 shadow-sm">
                <i class="fas fa-plus mr-2"></i>Nuevo Cliente
            </button>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-users text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Clientes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">Todos los registros</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Activos</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['activos'] }}</p>
                    <p class="text-xs text-green-600">Estado activo</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-clipboard-list text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Con Órdenes</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['con_ordenes'] }}</p>
                    <p class="text-xs text-gray-500">Tienen servicios</p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-user-plus text-orange-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Nuevos (Mes)</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['nuevos_mes'] }}</p>
                    <p class="text-xs text-gray-500">Este mes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="dashboard-card p-6 mb-6">
        <form method="GET" action="{{ route('admin.gestion-clientes') }}" id="filter-form">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Cliente</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nombre, email, RUT..."
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                    <select name="tipo_cliente" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="">Todos</option>
                        <option value="regular" {{ request('tipo_cliente') == 'regular' ? 'selected' : '' }}>Regular</option>
                        <option value="vip" {{ request('tipo_cliente') == 'vip' ? 'selected' : '' }}>VIP</option>
                        <option value="corporativo" {{ request('tipo_cliente') == 'corporativo' ? 'selected' : '' }}>Corporativo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    <select name="estado" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="">Todos</option>
                        <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3 mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors duration-300 shadow-sm">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
                <a href="{{ route('admin.gestion-clientes') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition-colors duration-300">
                    <i class="fas fa-redo mr-2"></i>Limpiar
                </a>
                <a href="{{ route('admin.clientes.export') }}" class="ml-auto bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors duration-300 shadow-sm">
                    <i class="fas fa-file-excel mr-2"></i>Exportar CSV
                </a>
            </div>
        </form>
    </div>

    <!-- Tabla -->
    <div class="dashboard-card overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Contacto</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Órdenes</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse($clientes as $cliente)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-blue-600 font-semibold text-sm">{{ substr($cliente->nombre, 0, 1) }}{{ substr($cliente->apellido, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">{{ $cliente->nombre }} {{ $cliente->apellido }}</div>
                                <div class="text-sm text-gray-500">RUT: {{ $cliente->rut }}</div>
                                @if($cliente->empresa)
                                    <div class="text-xs text-gray-400"><i class="fas fa-building mr-1"></i>{{ $cliente->empresa }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900"><i class="far fa-envelope mr-2 text-gray-400"></i>{{ $cliente->email }}</div>
                        <div class="text-sm text-gray-500"><i class="fas fa-phone mr-2 text-gray-400"></i>{{ $cliente->telefono }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $cliente->tipo_cliente == 'vip' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $cliente->tipo_cliente == 'corporativo' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $cliente->tipo_cliente == 'regular' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ ucfirst($cliente->tipo_cliente) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $cliente->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($cliente->estado) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm">
                            <div><span class="font-semibold text-gray-900">{{ $cliente->ordenes_count }}</span> total</div>
                            <div class="text-xs text-gray-500 space-x-2">
                                <span class="text-green-600">✓{{ $cliente->ordenes_completadas_count }}</span>
                                <span class="text-yellow-600">●{{ $cliente->ordenes_pendientes_count }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button onclick="verOrdenes({{ $cliente->id }})" 
                                    class="text-purple-600 hover:text-purple-800 hover:bg-purple-50 p-2 rounded transition-colors" 
                                    title="Ver Órdenes">
                                <i class="fas fa-list-alt"></i>
                            </button>
                            <button onclick="editCliente({{ $cliente->id }})" 
                                    class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded transition-colors" 
                                    title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteCliente({{ $cliente->id }})" 
                                    class="text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded transition-colors" 
                                    title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 font-medium">No se encontraron clientes</p>
                            <p class="text-gray-400 text-sm mt-2">Intenta ajustar los filtros o crea un nuevo cliente</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($clientes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $clientes->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div id="clienteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-xl">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-900">Nuevo Cliente</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="clienteForm" class="p-6">
            @csrf
            <input type="hidden" id="clienteId">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Apellido *</label>
                    <input type="text" name="apellido" id="apellido" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">RUT *</label>
                    <input type="text" name="rut" id="rut" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                    <input type="email" name="email" id="email" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                    <input type="text" name="telefono" id="telefono" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Empresa</label>
                    <input type="text" name="empresa" id="empresa" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dirección *</label>
                    <input type="text" name="direccion" id="direccion" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo *</label>
                    <select name="tipo_cliente" id="tipo_cliente" required 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="regular">Regular</option>
                        <option value="vip">VIP</option>
                        <option value="corporativo">Corporativo</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                    <select name="estado" id="estado" required 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                    <textarea name="notas" id="notas" rows="3" 
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                <button type="button" onclick="closeModal()" 
                        class="px-6 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors shadow-sm">
                    <i class="fas fa-save mr-2"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nuevo Cliente';
    document.getElementById('clienteForm').reset();
    document.getElementById('clienteId').value = '';
    const modal = document.getElementById('clienteModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
}

function closeModal() {
    const modal = document.getElementById('clienteModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
}

async function editCliente(id) {
    try {
        const response = await fetch(`/admin/clientes/${id}/edit`);
        const data = await response.json();

        if (data.success) {
            const c = data.cliente;
            document.getElementById('modalTitle').textContent = 'Editar Cliente';
            document.getElementById('clienteId').value = c.id;
            document.getElementById('nombre').value = c.nombre;
            document.getElementById('apellido').value = c.apellido;
            document.getElementById('rut').value = c.rut;
            document.getElementById('email').value = c.email;
            document.getElementById('telefono').value = c.telefono;
            document.getElementById('direccion').value = c.direccion;
            document.getElementById('empresa').value = c.empresa || '';
            document.getElementById('tipo_cliente').value = c.tipo_cliente;
            document.getElementById('estado').value = c.estado;
            document.getElementById('notas').value = c.notas || '';

            const modal = document.getElementById('clienteModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar el cliente');
    }
}

async function deleteCliente(id) {
    if (!confirm('¿Estás seguro de que deseas eliminar este cliente?\n\nEsta acción no se puede deshacer.')) return;

    try {
        const response = await fetch(`/admin/clientes/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();
        
        if (data.success) {
            // Mostrar mensaje de éxito
            alert('✅ ' + data.message);
            location.reload();
        } else {
            alert('❌ ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al eliminar el cliente');
    }
}

document.getElementById('clienteForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const clienteId = document.getElementById('clienteId').value;
    const url = clienteId 
        ? `/admin/clientes/${clienteId}` 
        : '{{ route('admin.clientes.store') }}';
    const method = clienteId ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        });

        const data = await response.json();

        if (data.success) {
            alert('✅ ' + data.message);
            location.reload();
        } else {
            if (data.errors) {
                const errors = Object.values(data.errors).flat().join('\n');
                alert('❌ Errores de validación:\n\n' + errors);
            } else {
                alert('❌ ' + data.message);
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error al guardar el cliente');
    }
});

// Cerrar modal al hacer clic fuera
document.getElementById('clienteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Cerrar modal con ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
        closeOrdenesModal();
    }
});

// Función para ver órdenes del cliente
async function verOrdenes(clienteId) {
    console.log('verOrdenes llamada con ID:', clienteId);
    try {
        const url = `/admin/clientes/${clienteId}/ordenes`;
        console.log('Fetching URL:', url);
        
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        console.log('Response status:', response.status);
        const data = await response.json();
        console.log('Data recibida:', data);
        
        if (data.success) {
            mostrarModalOrdenes(data.cliente, data.ordenes);
        } else {
            alert('❌ ' + data.message);
        }
    } catch (error) {
        console.error('Error completo:', error);
        alert('❌ Error al cargar las órdenes');
    }
}

function mostrarModalOrdenes(cliente, ordenes) {
    console.log('mostrarModalOrdenes llamada', { cliente, ordenes });
    const modal = document.getElementById('ordenesModal');
    console.log('Modal encontrado:', modal);
    document.getElementById('modalClienteNombre').textContent = cliente.nombre + ' ' + cliente.apellido;
    
    const tbody = document.getElementById('ordenesTableBody');
    tbody.innerHTML = '';
    
    if (ordenes.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                    <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500 font-medium">No hay órdenes de servicio</p>
                    <p class="text-gray-400 text-sm mt-2">Este cliente aún no tiene órdenes registradas</p>
                </td>
            </tr>
        `;
    } else {
        ordenes.forEach(orden => {
            const estadoClasses = {
                'pendiente': 'bg-yellow-100 text-yellow-800',
                'en_progreso': 'bg-blue-100 text-blue-800',
                'diagnostico': 'bg-purple-100 text-purple-800',
                'completada': 'bg-green-100 text-green-800',
                'cancelada': 'bg-red-100 text-red-800'
            };
            
            const row = `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <span class="font-semibold text-blue-600">${orden.numero_orden}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">${orden.equipo?.tipo_equipo || 'N/A'}</div>
                        <div class="text-xs text-gray-500">${orden.equipo?.marca?.nombre_marca || ''}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold ${estadoClasses[orden.estado] || 'bg-gray-100 text-gray-800'}">
                            ${orden.estado.replace('_', ' ')}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        ${orden.tecnico ? orden.tecnico.nombre + ' ' + orden.tecnico.apellido : 'Sin asignar'}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        ${orden.created_at}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="/ordenes/${orden.id}/publica" target="_blank" 
                           class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-2 rounded transition-colors inline-block"
                           title="Ver Orden">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    }
    
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
}

function closeOrdenesModal() {
    const modal = document.getElementById('ordenesModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
}

// Cerrar modal de órdenes al hacer clic fuera (cuando el DOM esté listo)
document.addEventListener('DOMContentLoaded', function() {
    const ordenesModal = document.getElementById('ordenesModal');
    if (ordenesModal) {
        ordenesModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeOrdenesModal();
            }
        });
    }
});
</script>

<!-- Modal de Órdenes -->
<div id="ordenesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-xl shadow-2xl max-w-5xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center rounded-t-xl">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Órdenes de Servicio</h3>
                <p class="text-sm text-gray-600 mt-1">Cliente: <span id="modalClienteNombre" class="font-semibold"></span></p>
            </div>
            <button onclick="closeOrdenesModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="p-6">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">N° Orden</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Equipo</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Técnico</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase">Acción</th>
                    </tr>
                </thead>
                <tbody id="ordenesTableBody" class="divide-y divide-gray-200">
                    <!-- Se llenará con JavaScript -->
                </tbody>
            </table>
        </div>

        <div class="sticky bottom-0 bg-gray-50 border-t border-gray-200 px-6 py-4 rounded-b-xl">
            <button onclick="closeOrdenesModal()" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors duration-300">
                Cerrar
            </button>
        </div>
    </div>
</div>

@endpush
