@extends('tecnico.layout')

@section('titulo', 'Marcas')

@section('contenido')
<h2 class="text-3xl font-bold text-blue-900 border-b-4 border-blue-500 pb-2 mb-8">🏷️ Gestión de Marcas</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-blue-600 font-semibold">Dell</h3>
        <p class="text-sm text-gray-500 mb-3">Equipos de alto rendimiento.</p>
        <button class="bg-yellow-400 text-white px-3 py-1 rounded">Editar</button>
        <button class="bg-red-400 text-white px-3 py-1 rounded">Eliminar</button>
    </div>
    <div class="bg-white p-4 rounded shadow text-center">
        <h3 class="text-blue-600 font-semibold">Apple</h3>
        <p class="text-sm text-gray-500 mb-3">Diseño premium e innovación.</p>
        <button class="bg-yellow-400 text-white px-3 py-1 rounded">Editar</button>
        <button class="bg-red-400 text-white px-3 py-1 rounded">Eliminar</button>
    </div>
</div>
@endsection
