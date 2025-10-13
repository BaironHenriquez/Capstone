@extends('tecnico.layout')

@section('titulo', 'Modificaciones')

@section('contenido')
<h2 class="text-3xl font-bold text-orange-700 border-b-4 border-orange-500 pb-2 mb-8">⚙️ Gestión de Modificaciones</h2>

<div class="bg-white p-6 rounded-lg shadow">
    <form class="space-y-3">
        <textarea class="w-full border rounded p-2" placeholder="Escribe la modificación..."></textarea>
        <button class="bg-orange-500 text-white px-4 py-2 rounded">Agregar</button>
    </form>

    <ul class="mt-6 space-y-2">
        <li class="bg-gray-100 p-3 rounded flex justify-between items-center">
            <span>📅 [10/09/2025] Cambio de pantalla - <b class="text-blue-600">Técnico A</b></span>
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Editar</button>
        </li>
    </ul>
</div>
@endsection
