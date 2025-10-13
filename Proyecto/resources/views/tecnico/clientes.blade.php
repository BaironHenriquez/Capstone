@extends('tecnico.layout')

@section('titulo', 'Clientes')

@section('contenido')
<h2 class="text-3xl font-bold text-blue-900 border-b-4 border-blue-500 pb-2 mb-8">👥 Gestión de Clientes</h2>

<div class="bg-white p-6 rounded shadow-lg border border-gray-200">
    <form class="space-y-4 mb-6">
        <input type="text" class="w-full border rounded p-2" placeholder="Nombre del cliente">
        <input type="email" class="w-full border rounded p-2" placeholder="Correo electrónico">
        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">Guardar Cliente</button>
    </form>

    <table class="w-full border-collapse">
        <thead class="bg-blue-900 text-white">
            <tr>
                <th class="p-3 text-left">Nombre</th>
                <th class="p-3 text-left">Correo</th>
                <th class="p-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">Juan Pérez</td>
                <td class="p-3">juan@mail.com</td>
                <td class="p-3 text-center">
                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Editar</button>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
