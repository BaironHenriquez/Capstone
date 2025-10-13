<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') - Panel Técnico</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <nav class="bg-blue-900 shadow-lg sticky top-0 z-50 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
            <span class="text-2xl font-bold">TechService Pro</span>
            <div class="space-x-4 text-sm">
                <a href="{{ route('home') }}" class="hover:text-blue-300 transition">🏠 Inicio</a>
                <span class="opacity-75">Panel Técnico</span>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-64 flex flex-col p-6 space-y-4 text-white shadow-lg"
                style="background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%);">

            <h2 class="text-2xl font-bold border-b border-blue-400 pb-2 mb-4">Panel Técnico</h2>

            <nav class="space-y-3">
                <a href="{{ route('tecnico.resumen') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-700 transition">
                    📊 <span>Resumen</span>
                </a>
                <a href="{{ route('tecnico.clientes') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-700 transition">
                    👥 <span>Clientes</span>
                </a>
                <a href="{{ route('tecnico.equipos') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-700 transition">
                    💻 <span>Equipos</span>
                </a>
                <a href="{{ route('tecnico.marcas') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-700 transition">
                    🏷️ <span>Marcas</span>
                </a>
                <a href="{{ route('tecnico.ordenes') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-700 transition">
                    📝 <span>Órdenes</span>
                </a>
                <a href="{{ route('tecnico.ingresar_orden') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-700 transition">
                    🧾 <span>Ingresar Orden</span>
                </a>
                <a href="{{ route('tecnico.modificaciones') }}" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-700 transition">
                    ⚙️ <span>Modificaciones</span>
                </a>
            </nav>
        </aside>

        <!-- Contenido dinámico -->
<main class="flex-1 p-10">
    @yield('contenido')
</main>

    </div>

</body>
</html>
