<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAIECO – Panel Administrativo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* =======================
           PALETA Y TOKENS BAIECO
           ======================= */
        :root{
            --baieco-50:#ecfeff;
            --baieco-100:#cffafe;
            --baieco-200:#a5f3fc;
            --baieco-300:#7dd3fc;
            --baieco-400:#38bdf8;  /* celeste vivo */
            --baieco-500:#22c55e;  /* verde acento */
            --baieco-600:#0ea5e9;  /* azul-celeste */
            --baieco-700:#0284c7;  /* azul medio */
            --baieco-800:#0369a1;  /* azul oscuro */
            --baieco-900:#075985;  /* azul más oscuro */
            --grey-50:#f8fafc;
            --grey-100:#f1f5f9;
            --grey-200:#e2e8f0;
            --grey-300:#cbd5e1;
            --grey-700:#334155;
        }

        /* =======================
           GRADIENTES Y UTILIDADES
           ======================= */
        .bg-baieco-gradient{
            background: linear-gradient(90deg, var(--baieco-600) 0%, var(--baieco-700) 50%, var(--baieco-800) 100%);
        }
        .btn{
            display:inline-flex; align-items:center; gap:.5rem;
            padding:.5rem 1rem; border-radius:.75rem;
            font-weight:600; transition: all .25s ease;
            box-shadow: 0 2px 6px rgba(2,132,199,.18);
        }
        .btn:hover{ transform: translateY(-1px); box-shadow: 0 8px 16px rgba(2,132,199,.20);}
        .btn-primary{ color:#fff; background: linear-gradient(135deg, var(--baieco-600), var(--baieco-700)); }
        .btn-primary:hover{ filter: brightness(1.05); }
        .btn-outline{
            color: #fff; border:1px solid rgba(255,255,255,.35); background: rgba(255,255,255,.06);
            backdrop-filter: saturate(180%) blur(6px);
        }
        .chip{
            display:inline-flex; align-items:center; gap:.35rem;
            font-size:.75rem; padding:.25rem .5rem;
            border-radius:999px; background: var(--baieco-100); color: var(--baieco-800); font-weight:600;
        }

        /* =======================
           TARJETAS Y LAYOUT
           ======================= */
        .card{
            background:#fff; border:1px solid var(--grey-200);
            border-radius:1rem; box-shadow: 0 6px 18px rgba(2,132,199,.06);
            transition: box-shadow .25s ease, transform .25s ease;
        }
        .card:hover{ box-shadow:0 14px 28px rgba(2,132,199,.10); transform: translateY(-2px); }

        /* =======================
           ANIMACIONES
           ======================= */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.98); }
            to   { opacity: 1; transform: scale(1); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .dashboard-card { animation: fadeInScale .5s ease-out; }
        .dashboard-metric{ animation: slideInUp .45s ease-out; }
        .animate-slide-down{ animation: slideDown .5s ease-out; }

        /* =======================
           BLOQUES ESPECÍFICOS
           ======================= */
        .summary-pill{
            border-radius:.9rem; border-left:4px solid transparent;
            padding:1rem; display:flex; justify-content:space-between; align-items:center;
            background:#f8fafc; gap:1rem;
        }
        .summary-pill.green{ background:#ecfdf5; border-color:#34d399; }
        .summary-pill.blue{ background:#eef4ff; border-color:#60a5fa; }
        .summary-pill.yellow{ background:#fffbeb; border-color:#f59e0b; }
        .summary-pill.red{ background:#fef2f2; border-color:#ef4444; }

        .kpi-circle{
            width:3.5rem; height:3.5rem; display:flex; align-items:center; justify-content:center;
            border-radius:999px; font-weight:700; color:#0f172a;
            background: conic-gradient(var(--baieco-600) 0 240deg, #e2e8f0 240deg 360deg);
        }

        .chart-container { position: relative; height: 300px; width: 100%; }
        .shadow-soft { box-shadow: 0 10px 30px rgba(2,132,199,.08); }
        .muted { color: #64748b; }
    </style>
</head>

<body class="bg-[var(--grey-50)] font-sans">

    <!-- =======================
         NAVBAR BAIECO
         ======================= -->
    <nav class="bg-baieco-gradient shadow-lg sticky top-0 z-50 animate-slide-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-14 items-center">
                <div class="flex items-center gap-6">
                    <a class="flex items-center gap-2 text-white font-extrabold tracking-wide text-xl" href="{{ route('home') }}">
                        <i class="fa-solid fa-microchip"></i> Baieco
                    </a>

                    <div class="hidden md:flex md:space-x-1">
                        <a href="{{ route('home') }}"
                           class="btn btn-outline !py-1.5 !px-3 text-sm">Inicio</a>

                        <a href="{{ route('dashboard-admin') }}"
                           class="btn btn-primary !py-1.5 !px-3 text-sm shadow-soft">Panel</a>

                        <a href="{{ route('admin.gestion-tecnicos') }}"
                           class="btn btn-outline !py-1.5 !px-3 text-sm">
                            <i class="fas fa-users-cog"></i><span>Técnicos</span>
                        </a>

                        <a href="{{ route('admin.clientes.index') }}"
                           class="btn btn-outline !py-1.5 !px-3 text-sm">
                            <i class="fas fa-users"></i><span>Clientes</span>
                        </a>

                        <a href="{{ route('ordenes.index') }}"
                           class="btn btn-outline !py-1.5 !px-3 text-sm">Órdenes</a>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="chip"><i class="fa-solid fa-user-shield"></i> Técnico Administrador</span>
                    <a href="{{ route('home') }}" class="btn btn-outline !py-1.5 !px-3 text-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- =======================
         CONTENIDO
         ======================= -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

        <!-- Header / título -->
        <div class="mb-6">
            <h1 class="text-3xl font-extrabold text-slate-800 mb-1">Panel de Control Técnico</h1>
            <p class="muted">Resumen general del estado del servicio técnico</p>
            <div class="text-xs text-slate-500 mt-1">
                Última actualización: {{ date('d/m/Y H:i') }}
            </div>
        </div>

        <!-- =======================
             Distribución de Órdenes
             ======================= -->
        <div class="card p-6 mb-8 dashboard-card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-[var(--baieco-600)]"></i>
                    Distribución de Órdenes de Servicio
                </h2>
                <div class="text-sm text-slate-500">
                    Total: {{ $resumenOrdenes['total'] }} órdenes
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Gráfico -->
                <div class="flex justify-center">
                    <div class="chart-container" style="height: 350px; width: 100%;">
                        <canvas id="ordenesChart"></canvas>
                    </div>
                </div>

                <!-- KPIs -->
                <div class="space-y-4">
                    <div class="summary-pill green">
                        <div class="flex items-center gap-3">
                            <span class="kpi-circle" style="background: conic-gradient(#22c55e 0 210deg,#e2e8f0 210deg 360deg);">✓</span>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Completadas</p>
                                <p class="text-2xl font-extrabold text-slate-900">{{ $resumenOrdenes['completadas'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-emerald-600">
                                {{ round(($resumenOrdenes['completadas'] / $resumenOrdenes['total']) * 100, 1) }}%
                            </p>
                        </div>
                    </div>

                    <div class="summary-pill blue">
                        <div class="flex items-center gap-3">
                            <span class="kpi-circle" style="background: conic-gradient(var(--baieco-600) 0 180deg,#e2e8f0 180deg 360deg);"><i class="fa-solid fa-screwdriver-wrench"></i></span>
                            <div>
                                <p class="text-sm font-medium text-slate-600">En Progreso</p>
                                <p class="text-2xl font-extrabold text-slate-900">{{ $resumenOrdenes['en_progreso'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-[var(--baieco-700)]">
                                {{ round(($resumenOrdenes['en_progreso'] / $resumenOrdenes['total']) * 100, 1) }}%
                            </p>
                        </div>
                    </div>

                    <div class="summary-pill yellow">
                        <div class="flex items-center gap-3">
                            <span class="kpi-circle" style="background: conic-gradient(#f59e0b 0 120deg,#e2e8f0 120deg 360deg);"><i class="fa-regular fa-clock"></i></span>
                            <div>
                                <p class="text-sm font-medium text-slate-600">Pendientes</p>
                                <p class="text-2xl font-extrabold text-slate-900">{{ $resumenOrdenes['pendientes'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-amber-600">
                                {{ round(($resumenOrdenes['pendientes'] / $resumenOrdenes['total']) * 100, 1) }}%
                            </p>
                        </div>
                    </div>

                    <div class="summary-pill red">
                        <div class="flex items-center gap-3">
                            <span class="kpi-circle" style="background: conic-gradient(#ef4444 0 40deg,#e2e8f0 40deg 360deg);"><i class="fa-regular fa-file-lines"></i></span>
                            <div>
                                <p class="text-sm font-medium text-slate-600">En Revisión</p>
                                <p class="text-2xl font-extrabold text-slate-900">{{ $resumenOrdenes['revision_necesaria'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-rose-600">
                                {{ round(($resumenOrdenes['revision_necesaria'] / $resumenOrdenes['total']) * 100, 1) }}%
                            </p>
                        </div>
                    </div>

                    <!-- Resumen de Crecimiento -->
                    <div class="mt-6 p-4 bg-[var(--grey-100)] rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-600">Crecimiento mensual</p>
                                <p class="text-lg font-semibold text-emerald-600">+{{ $metricas['crecimiento'] }}%</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-slate-600">vs mes anterior</p>
                                <p class="text-sm text-slate-500">
                                    {{ $resumenOrdenes['total'] - round($resumenOrdenes['total'] / (1 + $metricas['crecimiento']/100)) }} órdenes más
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =======================
             Accesos Rápidos
             ======================= -->
        <div class="card p-6 mb-8 dashboard-card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-rocket text-[var(--baieco-600)]"></i>
                    Accesos Rápidos de Administración
                </h2>
                <div class="text-sm muted">Gestión del sistema</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Gestión de Técnicos -->
                <a href="{{ route('admin.gestion-tecnicos') }}"
                   class="group p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl"
                   style="background: linear-gradient(135deg, var(--baieco-600), var(--baieco-700));">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-users-cog text-3xl opacity-90"></i>
                        <span class="text-xs bg-white/25 px-2 py-1 rounded-full">NUEVO</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-1">Gestión de Técnicos</h3>
                    <p class="text-sm opacity-90">Crear, editar y administrar técnicos del sistema</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Ver todos</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Órdenes de Servicio -->
                <a href="{{ route('ordenes.index') }}"
                   class="group p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl"
                   style="background: linear-gradient(135deg, #60a5fa, #3b82f6);">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-clipboard-list text-3xl opacity-90"></i>
                        <span class="text-xs bg-white/25 px-2 py-1 rounded-full">{{ $resumenOrdenes['pendientes'] }}</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-1">Órdenes de Servicio</h3>
                    <p class="text-sm opacity-90">Gestionar y supervisar órdenes activas</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Administrar</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Gestión de Clientes -->
                <a href="{{ route('admin.clientes.index') }}"
                   class="group p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl"
                   style="background: linear-gradient(135deg, #34d399, #22c55e);">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-users text-3xl opacity-90"></i>
                        <span class="text-xs bg-white/25 px-2 py-1 rounded-full">NUEVO</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-1">Gestión de Clientes</h3>
                    <p class="text-sm opacity-90">Crear, editar y administrar clientes del sistema</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Ver todos</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>

                <!-- Reportes -->
                <a href="#"
                   class="group p-6 rounded-xl text-white transition-all duration-300 transform hover:scale-[1.02] hover:shadow-xl"
                   style="background: linear-gradient(135deg, #a855f7, #7c3aed);">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-chart-bar text-3xl opacity-90"></i>
                        <span class="text-xs bg-white/25 px-2 py-1 rounded-full">STATS</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-1">Reportes</h3>
                    <p class="text-sm opacity-90">Estadísticas y análisis detallados</p>
                    <div class="mt-4 flex items-center text-sm">
                        <span>Ver reportes</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- =======================
             Productividad semanal
             ======================= -->
        <div class="card p-6 mb-8 dashboard-card">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                <i class="fas fa-chart-line text-emerald-600"></i>
                Productividad Semanal
            </h2>
            <div class="chart-container" style="height: 300px;">
                <canvas id="productividadChart"></canvas>
            </div>
        </div>

        <!-- =======================
             Carga laboral técnicos
             ======================= -->
        <div class="card p-6 mb-8 dashboard-card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-users text-[var(--baieco-600)]"></i>
                    Carga Laboral de Técnicos
                </h2>
                <span class="text-sm text-slate-500">{{ count($tecnicos) }} técnicos activos</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Lista -->
                <div class="space-y-4">
                    @foreach($tecnicos as $tecnico)
                    <div class="dashboard-metric">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold
                                    @if($tecnico['estado'] == 'sobrecargado') bg-red-100 text-red-700
                                    @elseif($tecnico['estado'] == 'activo') bg-blue-100 text-blue-700
                                    @else bg-green-100 text-green-700
                                    @endif">
                                    {{ substr($tecnico['nombre'], 0, 2) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-slate-800">{{ $tecnico['nombre'] }}</p>
                                    <p class="text-xs text-slate-500">{{ $tecnico['especialidad'] == 'Computadoras' ? 'Computadores' : $tecnico['especialidad'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-slate-800">{{ $tecnico['carga_trabajo'] }}%</p>
                                <p class="text-xs text-slate-500">{{ $tecnico['ordenes_asignadas'] }} asignadas</p>
                            </div>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">
                            <div class="h-3 rounded-full transition-all duration-1000
                                @if($tecnico['carga_trabajo'] >= 90) bg-red-500
                                @elseif($tecnico['carga_trabajo'] >= 70) bg-yellow-500
                                @else bg-emerald-500
                                @endif"
                                style="width: {{ $tecnico['carga_trabajo'] }}%">
                            </div>
                        </div>
                        @if($tecnico['estado'] == 'sobrecargado')
                            <p class="text-xs text-red-600 mt-1">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Sobrecargado - Requiere redistribución
                            </p>
                        @elseif($tecnico['estado'] == 'disponible')
                            <p class="text-xs text-emerald-600 mt-1">
                                <i class="fas fa-check-circle mr-1"></i>
                                Disponible para nuevas asignaciones
                            </p>
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- Gráfico barras -->
                <div>
                    <h3 class="text-md font-medium text-slate-800 mb-4">Comparativa de Carga</h3>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="tecnicosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- =======================
             Alertas
             ======================= -->
        <div class="card p-6 mb-8 dashboard-card">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                    <i class="fas fa-bell text-amber-500"></i>
                    Alertas
                </h2>
                <span class="bg-rose-100 text-rose-700 text-xs font-medium px-2.5 py-0.5 rounded-full">
                    {{ count($alertas) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($alertas as $alerta)
                <div class="dashboard-metric border-l-4 pl-4 rounded-r-lg p-3
                    @if($alerta['prioridad'] == 'alta') border-red-500 bg-red-50
                    @elseif($alerta['prioridad'] == 'media') border-yellow-500 bg-yellow-50
                    @else border-blue-500 bg-blue-50
                    @endif">
                    @if($alerta['tipo'] == 'retraso_critico')
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-red-500 text-lg mr-2 mt-1"></i>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Retraso Crítico</p>
                                <p class="text-xs text-slate-600">Orden {{ $alerta['orden'] }}</p>
                                <p class="text-xs text-slate-600">{{ $alerta['dias_retraso'] }} días de retraso</p>
                                <p class="text-xs text-slate-500">Técnico: {{ $alerta['tecnico'] }}</p>
                            </div>
                        </div>
                    @elseif($alerta['tipo'] == 'sobrecarga_tecnico')
                        <div class="flex items-start">
                            <i class="fas fa-user-clock text-yellow-500 text-lg mr-2 mt-1"></i>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Sobrecarga</p>
                                <p class="text-xs text-slate-600">{{ $alerta['tecnico'] }}</p>
                                <p class="text-xs text-slate-600">{{ $alerta['carga'] }}% de carga</p>
                                <p class="text-xs text-slate-500">{{ $alerta['ordenes_pendientes'] }} órdenes pendientes</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-start">
                            <i class="fas fa-file-alt text-blue-500 text-lg mr-2 mt-1"></i>
                            <div>
                                <p class="text-sm font-semibold text-slate-800">Revisión Pendiente</p>
                                <p class="text-xs text-slate-600">Orden {{ $alerta['orden'] }}</p>
                                <p class="text-xs text-slate-600">{{ $alerta['dias_pendiente'] }} días sin revisar</p>
                                <p class="text-xs text-slate-500">Cliente: {{ $alerta['cliente'] }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>

            <div class="mt-4 pt-4 border-t border-slate-200">
                <button class="w-full btn btn-primary !py-2 !px-4">
                    <i class="fas fa-eye"></i> Ver todas las alertas
                </button>
            </div>
        </div>

        <!-- =======================
             Métricas
             ======================= -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="card p-6 hover:shadow-xl">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-stopwatch text-[var(--baieco-700)] text-2xl"></i>
                    </div>
                    <p class="text-sm muted mb-1">Tiempo Promedio</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ $metricas['tiempo_promedio_resolucion'] }}</p>
                    <p class="text-sm text-slate-500">días por orden</p>
                </div>
            </div>

            <div class="card p-6 hover:shadow-xl">
                <div class="text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-smile text-emerald-600 text-2xl"></i>
                    </div>
                    <p class="text-sm muted mb-1">Satisfacción</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ $metricas['satisfaccion_cliente'] }}%</p>
                    <p class="text-sm text-slate-500">promedio cliente</p>
                </div>
            </div>

            <div class="card p-6 hover:shadow-xl">
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                    </div>
                    <p class="text-sm muted mb-1">Crecimiento</p>
                    <p class="text-3xl font-extrabold text-slate-900">+{{ $metricas['crecimiento'] }}%</p>
                    <p class="text-sm text-slate-500">este mes</p>
                </div>
            </div>

            <div class="card p-6 hover:shadow-xl">
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-laptop text-orange-600 text-2xl"></i>
                    </div>
                    <p class="text-sm muted mb-1">Computadores</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ round($resumenOrdenes['total'] * 0.65) }}</p>
                    <p class="text-sm text-slate-500">reparaciones activas</p>
                </div>
            </div>
        </div>

        <!-- =======================
             Estadísticas por servicio
             ======================= -->
        <div class="card p-6 mb-8 dashboard-card">
            <h2 class="text-lg font-semibold text-slate-800 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-bar text-indigo-600"></i>
                Estadísticas por Tipo de Servicio
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Computadores -->
                <div class="text-center p-4 rounded-lg" style="background:linear-gradient(180deg,#eff6ff, #ffffff 60%); border:1px solid #e5e7eb;">
                    <i class="fas fa-desktop text-blue-600 text-3xl mb-3"></i>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Computadores</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="muted">En reparación:</span>
                            <span class="font-semibold text-slate-800">{{ round($resumenOrdenes['total'] * 0.45) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="muted">Completadas:</span>
                            <span class="font-semibold text-emerald-600">{{ round($resumenOrdenes['completadas'] * 0.50) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="muted">Tiempo prom:</span>
                            <span class="font-semibold text-slate-800">3.5 días</span>
                        </div>
                    </div>
                </div>

                <!-- Móviles -->
                <div class="text-center p-4 rounded-lg" style="background:linear-gradient(180deg,#ecfdf5, #ffffff 60%); border:1px solid #e5e7eb;">
                    <i class="fas fa-mobile-alt text-emerald-600 text-3xl mb-3"></i>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Móviles</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="muted">En reparación:</span>
                            <span class="font-semibold text-slate-800">{{ round($resumenOrdenes['total'] * 0.25) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="muted">Completadas:</span>
                            <span class="font-semibold text-emerald-600">{{ round($resumenOrdenes['completadas'] * 0.30) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="muted">Tiempo prom:</span>
                            <span class="font-semibold text-slate-800">2.1 días</span>
                        </div>
                    </div>
                </div>

                <!-- Soporte -->
                <div class="text-center p-4 rounded-lg" style="background:linear-gradient(180deg,#f5f3ff, #ffffff 60%); border:1px solid #e5e7eb;">
                    <i class="fas fa-headset text-purple-600 text-3xl mb-3"></i>
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Soporte Técnico</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="muted">En proceso:</span>
                            <span class="font-semibold text-slate-800">{{ round($resumenOrdenes['total'] * 0.15) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="muted">Resueltos:</span>
                            <span class="font-semibold text-emerald-600">{{ round($resumenOrdenes['completadas'] * 0.20) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="muted">Tiempo prom:</span>
                            <span class="font-semibold text-slate-800">1.8 días</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- =======================
         FOOTER
         ======================= -->
    <footer class="bg-white border-t border-slate-200 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-slate-500">
                <p>&copy; 2025 Baieco – Panel Técnico Administrador</p>
            </div>
        </div>
    </footer>

    <!-- =======================
         SCRIPTS / CHARTS
         ======================= -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Donut: Órdenes
            const ctxOrdenes = document.getElementById('ordenesChart').getContext('2d');
            new Chart(ctxOrdenes, {
                type: 'doughnut',
                data: {
                    labels: ['Completadas', 'En Progreso', 'Pendientes', 'En Revisión'],
                    datasets: [{
                        data: [{{ $resumenOrdenes['completadas'] }}, {{ $resumenOrdenes['en_progreso'] }}, {{ $resumenOrdenes['pendientes'] }}, {{ $resumenOrdenes['revision_necesaria'] }}],
                        backgroundColor: [
                            '#22c55e',      // completadas
                            '#3b82f6',      // en progreso
                            '#f59e0b',      // pendientes
                            '#ef4444'       // revisión
                        ],
                        borderWidth: 2,
                        borderColor: '#fff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { padding: 20, usePointStyle: true }
                        }
                    },
                    cutout: '55%'
                }
            });

            // Línea: Productividad semanal
            const ctxProductividad = document.getElementById('productividadChart').getContext('2d');
            new Chart(ctxProductividad, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                    datasets: [{
                        label: 'Órdenes Completadas',
                        data: [12, 15, 18, 14, 20, 8, 5],
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14,165,233,.12)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(2,132,199,.08)' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Barras: Técnicos
            const ctxTecnicos = document.getElementById('tecnicosChart').getContext('2d');
            new Chart(ctxTecnicos, {
                type: 'bar',
                data: {
                    labels: ['Carlos R.', 'Maria G.', 'Diego S.', 'Ana T.'],
                    datasets: [{
                        label: 'Carga de Trabajo (%)',
                        data: [85, 65, 95, 45],
                        backgroundColor: ['#f59e0b','#22c55e','#ef4444','#22c55e'],
                        borderColor: ['#d97706','#059669','#dc2626','#059669'],
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, max: 100, grid: { color: 'rgba(2,132,199,.08)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>

</body>
</html>
