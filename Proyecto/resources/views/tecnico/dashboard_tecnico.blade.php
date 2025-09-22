<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Técnico</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex">
      
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-900 text-white flex flex-col p-6">
            
            <h2 class="text-2xl font-bold mb-6">Panel Técnico</h2>
            <nav class="space-y-3">
                <a href="#resumen" class="block px-3 py-2 rounded hover:bg-blue-700">📊 Resumen</a>
                <a href="#clientes" class="block px-3 py-2 rounded hover:bg-blue-700">👥 Clientes</a>
                <a href="#equipos" class="block px-3 py-2 rounded hover:bg-blue-700">💻 Equipos</a>
                <a href="#marcas" class="block px-3 py-2 rounded hover:bg-blue-700">🏷️ Marcas</a>
                <a href="#ordenes" class="block px-3 py-2 rounded hover:bg-blue-700">📝 Órdenes</a>
                <a href="#modificaciones" class="block px-3 py-2 rounded hover:bg-blue-700">⚙️ Modificaciones</a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-10 space-y-20"> <!-- Espaciado entre secciones -->

            <!-- Dashboard técnico -->
            <section id="resumen" class="py-16">
                <h2 class="text-3xl font-bold mb-8 text-blue-900 border-b-4 border-blue-500 pb-2">📊 Dashboard del Técnico</h2>
                
                <!-- Tarjetas de resumen -->
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

                <!-- Gráfico -->
                <div class="bg-white p-6 rounded shadow flex justify-center">
                    <div class="w-72 h-72">
                        <canvas id="ordenesChart"></canvas>
                    </div>
                </div>
            </section>

            <!-- Gestión de clientes -->
            <section id="clientes" class="py-16">
                <h2 class="text-3xl font-bold mb-8 text-blue-900 border-b-4 border-blue-500 pb-2">👥 Gestión de Clientes</h2>
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200">
                    
                    <!-- Formulario -->
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Cliente</label>
                            <input type="text" placeholder="Ej: Juan Pérez" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                            <input type="email" placeholder="Ej: cliente@mail.com" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg shadow-md transition duration-300">
                            ➕ Guardar Cliente
                        </button>
                    </form>

                    <!-- Tabla -->
                    <div class="mt-8 overflow-x-auto">
                        <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">
                            <thead>
                                <tr class="bg-blue-900 text-white text-left">
                                    <th class="p-3">Nombre</th>
                                    <th class="p-3">Correo</th>
                                    <th class="p-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">Cliente 1</td>
                                    <td class="p-3">cliente1@mail.com</td>
                                    <td class="p-3 text-center">
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm mr-2">
                                            ✏️ Editar
                                        </button>
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                            🗑️ Eliminar
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3">Cliente 2</td>
                                    <td class="p-3">cliente2@mail.com</td>
                                    <td class="p-3 text-center">
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm mr-2">
                                            ✏️ Editar
                                        </button>
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-sm">
                                            🗑️ Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Gestión de equipos -->
            <section id="equipos" class="py-16">
                <h2 class="text-3xl font-bold mb-8 text-blue-900 border-b-4 border-blue-500 pb-2">💻 Gestión de Equipos</h2>
                <div class="bg-white p-6 rounded-lg shadow-lg border border-blue-200">
                    <p class="text-gray-600 mb-6">
                        Aquí puedes <span class="font-semibold text-blue-500">crear, editar y listar</span> los equipos asociados a clientes.
                    </p>

                    <!-- Tarjetas de ejemplo -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-semibold text-blue-600">Laptop Dell</h3>
                                <span class="bg-blue-400 text-white text-xs px-2 py-1 rounded">Activo</span>
                            </div>
                            <p class="text-sm text-gray-600">Equipo de oficina - Core i7, 16GB RAM</p>
                            <div class="mt-4 flex space-x-2">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm px-3 py-1 rounded">✏️ Editar</button>
                                <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-3 py-1 rounded">🗑️ Eliminar</button>
                            </div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-semibold text-blue-600">iPhone 13</h3>
                                <span class="bg-green-400 text-white text-xs px-2 py-1 rounded">En uso</span>
                            </div>
                            <p class="text-sm text-gray-600">Smartphone cliente VIP</p>
                            <div class="mt-4 flex space-x-2">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm px-3 py-1 rounded">✏️ Editar</button>
                                <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-3 py-1 rounded">🗑️ Eliminar</button>
                            </div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-lg font-semibold text-blue-600">Impresora HP</h3>
                                <span class="bg-orange-400 text-white text-xs px-2 py-1 rounded">Mantenimiento</span>
                            </div>
                            <p class="text-sm text-gray-600">Problemas con el tóner</p>
                            <div class="mt-4 flex space-x-2">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm px-3 py-1 rounded">✏️ Editar</button>
                                <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-3 py-1 rounded">🗑️ Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Gestión de marcas -->
            <section id="marcas" class="py-16">
                <h2 class="text-3xl font-bold mb-8 text-blue-900 border-b-4 border-blue-500 pb-2">🏷️ Gestión de Marcas</h2>
                <div class="bg-white p-6 rounded-lg shadow-lg border border-blue-200">
                    <p class="text-gray-600 mb-6">
                        Aquí puedes <span class="font-semibold text-blue-500">crear, editar y listar</span> las marcas de equipos disponibles.
                    </p>

                    <!-- Tarjetas de marcas -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition text-center">
                            <h3 class="text-lg font-semibold text-blue-600 mb-2">Dell</h3>
                            <p class="text-sm text-gray-600">Equipos de alto rendimiento y durabilidad.</p>
                            <div class="mt-4 flex justify-center space-x-2">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm px-3 py-1 rounded">✏️ Editar</button>
                                <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-3 py-1 rounded">🗑️ Eliminar</button>
                            </div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition text-center">
                            <h3 class="text-lg font-semibold text-blue-600 mb-2">Apple</h3>
                            <p class="text-sm text-gray-600">Innovación y diseño premium.</p>
                            <div class="mt-4 flex justify-center space-x-2">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm px-3 py-1 rounded">✏️ Editar</button>
                                <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-3 py-1 rounded">🗑️ Eliminar</button>
                            </div>
                        </div>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition text-center">
                            <h3 class="text-lg font-semibold text-blue-600 mb-2">HP</h3>
                            <p class="text-sm text-gray-600">Impresoras y laptops confiables.</p>
                            <div class="mt-4 flex justify-center space-x-2">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-sm px-3 py-1 rounded">✏️ Editar</button>
                                <button class="bg-red-400 hover:bg-red-500 text-white text-sm px-3 py-1 rounded">🗑️ Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Órdenes de servicio -->
            <section id="ordenes" class="py-16">
                <h2 class="text-3xl font-bold mb-8 text-blue-900 border-b-4 border-blue-500 pb-2">📝 Órdenes de Servicio</h2>
                <div class="bg-white p-6 rounded-lg shadow-lg border border-blue-200">
                    
                    <!-- Botón de creación -->
                    <div class="flex justify-between items-center mb-6">
                        <p class="text-gray-600">Gestiona y consulta las órdenes de servicio registradas en el sistema.</p>
                        <button class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105">
                            ➕ Crear Orden
                        </button>
                    </div>

                    <!-- Tabla -->
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-blue-100 text-left text-blue-700">
                                    <th class="p-3">N° Orden</th>
                                    <th class="p-3">Cliente</th>
                                    <th class="p-3">Estado</th>
                                    <th class="p-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-3 font-semibold">TS-001</td>
                                    <td class="p-3">Cliente 1</td>
                                    <td class="p-3">
                                        <span class="px-3 py-1 text-sm font-medium rounded bg-yellow-100 text-yellow-700">
                                            ⏳ En Progreso
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded shadow transition">
                                            🔍 Ver Detalle
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-3 font-semibold">TS-002</td>
                                    <td class="p-3">Cliente 2</td>
                                    <td class="p-3">
                                        <span class="px-3 py-1 text-sm font-medium rounded bg-green-100 text-green-700">
                                            ✅ Completada
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded shadow transition">
                                            🔍 Ver Detalle
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Gestión de modificaciones -->
            <section id="modificaciones" class="py-16">
                <h2 class="text-3xl font-bold mb-8 text-orange-700 border-b-4 border-orange-500 pb-2">⚙️ Gestión de Modificaciones</h2>
                <div class="bg-white p-6 rounded-lg shadow-lg border border-orange-200">
                    
                    <!-- Formulario -->
                    <form class="space-y-4">
                        <textarea class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none" placeholder="✍️ Escribe la descripción de la modificación..."></textarea>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg shadow-md transition transform hover:scale-105">
                            ➕ Agregar Modificación
                        </button>
                    </form>

                    <!-- Lista -->
                    <ul class="mt-6 space-y-3">
                        <li class="p-4 rounded-lg bg-gray-100 flex justify-between items-center shadow-sm">
                            <span class="text-gray-700">📅 [10/09/2025] Cambio de pantalla - <strong class="text-blue-600">Técnico A</strong></span>
                            <button class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow">✏️ Editar</button>
                        </li>
                        <li class="p-4 rounded-lg bg-gray-100 flex justify-between items-center shadow-sm">
                            <span class="text-gray-700">📅 [15/09/2025] Revisión de batería - <strong class="text-blue-600">Técnico B</strong></span>
                            <button class="text-sm bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow">✏️ Editar</button>
                        </li>
                    </ul>
                </div>
            </section>

        </main>
    </div>

    <!-- Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('ordenesChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Órdenes Asignadas', 'Órdenes Completadas', 'Carga Laboral'],
                datasets: [{
                    data: [12, 8, 65],
                    backgroundColor: ['#2563eb','#16a34a','#f59e0b'],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#1e293b', font: { size: 14 } }
                    }
                }
            }
        });
    </script>

</body>
</html>
