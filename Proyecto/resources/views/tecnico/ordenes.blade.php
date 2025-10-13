@extends('tecnico.layout')

@section('titulo', 'Órdenes')

@section('contenido')
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
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">TS-001</td>
                <td class="p-3">Juan Pérez</td>
                <td class="p-3"><span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded">En Progreso</span></td>
                <td class="p-3 text-center"><button class="bg-blue-600 text-white px-3 py-1 rounded">Ver</button></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
