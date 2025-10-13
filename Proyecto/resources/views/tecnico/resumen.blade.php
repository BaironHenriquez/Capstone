@extends('tecnico.layout')

@section('titulo', 'Resumen')

@section('contenido')
<h2 class="text-3xl font-bold text-blue-900 border-b-4 border-blue-500 pb-2 mb-8">📊 Dashboard del Técnico</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
    <div class="bg-white p-6 rounded shadow text-center">
        <h3 class="text-lg font-semibold">Órdenes Asignadas</h3>
        <p class="text-3xl font-bold text-blue-600">12</p>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <h3 class="text-lg font-semibold">Órdenes Completadas</h3>
        <p class="text-3xl font-bold text-green-600">8</p>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <h3 class="text-lg font-semibold">Carga Laboral</h3>
        <p class="text-3xl font-bold text-yellow-600">65%</p>
    </div>
</div>

<div class="bg-white p-6 rounded shadow flex justify-center">
    <div class="w-72 h-72">
        <canvas id="ordenesChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('ordenesChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Asignadas', 'Completadas', 'Pendientes'],
        datasets: [{
            data: [12, 8, 4],
            backgroundColor: ['#2563eb','#16a34a','#f59e0b'],
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endsection
