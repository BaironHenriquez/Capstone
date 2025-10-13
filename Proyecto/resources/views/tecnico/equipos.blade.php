@extends('tecnico.layout')

@section('titulo', 'Equipos')

@section('contenido')
<h2 class="text-3xl font-bold text-blue-900 border-b-4 border-blue-500 pb-2 mb-8">💻 Gestión de Equipos</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-blue-50 p-4 rounded shadow border border-blue-200">
        <h3 class="font-semibold text-blue-700">Laptop Dell</h3>
        <p class="text-sm text-gray-600 mb-2">Core i7 - 16GB RAM</p>
        <span class="text-xs bg-green-500 text-white px-2 py-1 rounded">Activo</span>
    </div>
    <div class="bg-blue-50 p-4 rounded shadow border border-blue-200">
        <h3 class="font-semibold text-blue-700">iPhone 13</h3>
        <p class="text-sm text-gray-600 mb-2">Cliente VIP</p>
        <span class="text-xs bg-yellow-500 text-white px-2 py-1 rounded">En Uso</span>
    </div>
</div>
@endsection
