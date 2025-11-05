@extends('shared.layouts.tecnico')

@section('title', 'Órdenes de Servicio')

@section('breadcrumb', 'Órdenes de Servicio')

@section('content')
<h2 class="text-3xl font-bold text-blue-900 border-b-4 border-blue-500 pb-2 mb-8">📝 Órdenes de Servicio</h2>

<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between mb-4">
        <p class="text-gray-600">Listado de órdenes registradas.</p>
        <button class="bg-green-500 text-white px-4 py-2 rounded">➕ Crear Orden</button>
    </div>

    <table class="w-full border-collapse">
        <thead class="bg-blue-900 text-white">
            <tr>
                <th class="p-3 text-left">N° Orden</th>
                <th class="p-3 text-left">Cliente</th>
                <th class="p-3 text-left">Estado</th>
                <th class="p-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ordenes ?? [] as $orden)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $orden->numero_orden ?? 'TS-001' }}</td>
                <td class="p-3">{{ $orden->cliente->nombre ?? 'Juan Pérez' }}</td>
                <td class="p-3">
                    <select onchange="actualizarEstado(this.value, '{{ $orden->id ?? '1' }}')" 
                            class="border rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                            {{ $orden->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' :
                               ($orden->estado === 'en_progreso' ? 'bg-blue-100 text-blue-800' :
                               ($orden->estado === 'completada' ? 'bg-green-100 text-green-800' : 
                               'bg-red-100 text-red-800')) }}">
                        <option value="pendiente" {{ ($orden->estado ?? '') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_progreso" {{ ($orden->estado ?? '') === 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completada" {{ ($orden->estado ?? '') === 'completada' ? 'selected' : '' }}>Completada</option>
                        <option value="retrasada" {{ ($orden->estado ?? '') === 'retrasada' ? 'selected' : '' }}>Retrasada</option>
                    </select>
                </td>
                <td class="p-3 text-center space-x-2">
                    <button onclick="verOrden('{{ $orden->id ?? '1' }}')" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded transition">
                        <i class="fas fa-eye"></i>
                    </button>
                    <button onclick="editarOrden('{{ $orden->id ?? '1' }}')"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition">
                        <i class="fas fa-edit"></i>
                    </button>
                    <select onchange="actualizarPrioridad(this.value, '{{ $orden->id ?? '1' }}')"
                            class="border rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                            {{ $orden->prioridad === 'alta' ? 'bg-red-100 text-red-800' :
                               ($orden->prioridad === 'media' ? 'bg-yellow-100 text-yellow-800' :
                               'bg-green-100 text-green-800') }}">
                        <option value="baja" {{ ($orden->prioridad ?? '') === 'baja' ? 'selected' : '' }}>Baja</option>
                        <option value="media" {{ ($orden->prioridad ?? '') === 'media' ? 'selected' : '' }}>Media</option>
                        <option value="alta" {{ ($orden->prioridad ?? '') === 'alta' ? 'selected' : '' }}>Alta</option>
                    </select>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function actualizarEstado(estado, ordenId) {
        // Aquí irá la lógica para actualizar el estado via AJAX
        fetch(`/tecnico/ordenes/${ordenId}/estado`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ estado: estado })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar notificación de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Estado actualizado correctamente',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                // Mostrar error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar el estado',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    }

    function actualizarPrioridad(prioridad, ordenId) {
        // Aquí irá la lógica para actualizar la prioridad via AJAX
        fetch(`/tecnico/ordenes/${ordenId}/prioridad`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ prioridad: prioridad })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar notificación de éxito
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Prioridad actualizada correctamente',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                // Mostrar error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al actualizar la prioridad',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    }

    function editarOrden(ordenId) {
        // Redirigir a la página de edición usando URL absoluta
        window.location.href = `/tecnico/ordenes/${ordenId}/editar`;
    }

    function verOrden(ordenId) {
        // Redirigir a la página de detalles
        window.location.href = `/tecnico/ordenes/${ordenId}`;
    }
</script>
@endpush

