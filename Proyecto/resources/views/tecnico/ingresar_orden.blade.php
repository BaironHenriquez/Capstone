@extends('tecnico.layout')

@section('titulo', 'Ingresar Orden')

@section('contenido')
<div class="max-w-6xl mx-auto bg-gradient-to-b from-white to-blue-50 rounded-3xl shadow-xl p-10 border border-blue-100">

    <!-- Título principal -->
    <div class="mb-12 text-center">
        <h2 class="text-4xl font-extrabold text-blue-900 tracking-tight flex justify-center items-center gap-3">
            <i class="fa-solid fa-file-pen text-blue-700"></i> Ingresar Nueva Orden de Servicio
        </h2>
        <p class="text-gray-500 text-lg mt-3">Registra los detalles de ingreso del equipo de manera completa y profesional.</p>
    </div>

    <form method="POST" action="#" enctype="multipart/form-data" class="space-y-16">
        @csrf

        <!-- 🟦 SECCIÓN 1: INFORMACIÓN GENERAL -->
        <section class="bg-white shadow-lg rounded-2xl p-8 border-t-4 border-blue-600 transition hover:shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <i class="fa-solid fa-calendar-check text-blue-600 text-2xl"></i>
                <h3 class="text-2xl font-bold text-blue-800">Información General</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Estado de la Orden</label>
                    <select name="estado_os"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option>Recibido</option>
                        <option>En Proceso</option>
                        <option>Reparado</option>
                        <option>Entregado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha Aproximada de Entrega</label>
                    <input type="date" name="fecha_aprox_entrega"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>
        </section>

        <!-- 🟨 SECCIÓN 2: ARCHIVOS -->
        <section class="bg-white shadow-lg rounded-2xl p-8 border-t-4 border-yellow-400 transition hover:shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <i class="fa-solid fa-folder-open text-yellow-500 text-2xl"></i>
                <h3 class="text-2xl font-bold text-yellow-700">Archivos de Evidencia</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subir Fotos de Ingreso</label>
                    <input type="file" name="fotos_ingreso[]" accept="image/*" multiple
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white transition focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    <p class="text-xs text-gray-500 mt-2">Puedes subir varias imágenes (JPG, PNG, WEBP)</p>

                    <div id="preview" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-3 hidden"></div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subir Videos (Opcional)</label>
                    <input type="file" name="videos_evidencia[]" accept="video/*" multiple
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 bg-gray-50 hover:bg-white transition focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    <p class="text-xs text-gray-500 mt-2">Formatos permitidos: MP4, MOV, WEBM</p>
                </div>
            </div>
        </section>

        <!-- 🟩 SECCIÓN 3: DESCRIPCIÓN -->
        <section class="bg-white shadow-lg rounded-2xl p-8 border-t-4 border-green-500 transition hover:shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <i class="fa-solid fa-screwdriver-wrench text-green-600 text-2xl"></i>
                <h3 class="text-2xl font-bold text-green-700">Descripción y Diagnóstico</h3>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción del Problema</label>
                    <textarea name="descripcion_problema" rows="3"
                        placeholder="Ej: No enciende, pantalla rota, error de sistema..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Dictamen Técnico</label>
                    <textarea name="dictamen_tecnico" rows="3"
                        placeholder="Ej: Reemplazo de fuente, cambio de batería, limpieza interna..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>
                </div>
            </div>
        </section>

        <!-- 🟧 SECCIÓN 4: PAGO -->
        <section class="bg-white shadow-lg rounded-2xl p-8 border-t-4 border-orange-400 transition hover:shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <i class="fa-solid fa-coins text-orange-500 text-2xl"></i>
                <h3 class="text-2xl font-bold text-orange-600">Información de Pago</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Medio de Pago</label>
                    <select name="medio_de_pago"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                        <option>Seleccione...</option>
                        <option>Transferencia</option>
                        <option>Efectivo</option>
                        <option>Tarjeta</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Trabajo</label>
                    <select name="tipo_de_trabajo"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                        <option>Seleccione...</option>
                        <option>Reparación</option>
                        <option>Mantenimiento</option>
                        <option>Instalación</option>
                        <option>Diagnóstico</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Costo Total ($)</label>
                    <input type="number" step="0.01" name="costo_total" placeholder="Ej: 45000"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Abono ($)</label>
                    <input type="number" step="0.01" name="abono" value="0.00"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Saldo ($)</label>
                    <input type="number" step="0.01" name="saldo"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-orange-400 focus:outline-none">
                </div>
            </div>
        </section>

        <!-- 🟪 SECCIÓN 5: RELACIONES -->
        <section class="bg-white shadow-lg rounded-2xl p-8 border-t-4 border-purple-500 transition hover:shadow-2xl">
            <div class="flex items-center gap-3 mb-6">
                <i class="fa-solid fa-link text-purple-600 text-2xl"></i>
                <h3 class="text-2xl font-bold text-purple-700">Relaciones</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Servicio Técnico ID</label>
                    <input type="number" name="servicio_tecnico_id" placeholder="Ej: 1"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cliente ID</label>
                    <input type="number" name="cliente_id" placeholder="Ej: 5"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Equipo ID</label>
                    <input type="number" name="equipo_id" placeholder="Ej: 12"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Usuario (Técnico) ID</label>
                    <input type="number" name="user_id" placeholder="Ej: 3"
                        class="w-full border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-purple-400 focus:outline-none">
                </div>
            </div>
        </section>

        <!-- 🟩 BOTÓN FINAL -->
        <div class="text-center">
            <button type="submit"
                class="bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white px-10 py-4 rounded-2xl text-lg font-semibold shadow-xl transform hover:scale-105 transition-all duration-200">
                💾 Guardar Orden de Servicio
            </button>
        </div>
    </form>
</div>

<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- JS vista previa -->
<script>
const fileInput = document.querySelector('input[name="fotos_ingreso[]"]');
const previewContainer = document.getElementById('preview');
fileInput.addEventListener('change', (event) => {
    const files = Array.from(event.target.files);
    previewContainer.innerHTML = '';
    if (files.length > 0) {
        files.forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.classList.add('relative', 'group');
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('rounded-xl', 'shadow', 'border', 'border-gray-300', 'object-cover', 'h-32', 'w-full');
                const btn = document.createElement('button');
                btn.innerHTML = '🗑️';
                btn.type = 'button';
                btn.classList.add('absolute', 'top-1', 'right-1', 'bg-red-500', 'text-white', 'rounded-full', 'px-2', 'py-1', 'text-xs', 'opacity-0', 'group-hover:opacity-100', 'transition');
                btn.onclick = () => wrapper.remove();
                wrapper.appendChild(img);
                wrapper.appendChild(btn);
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
        previewContainer.classList.remove('hidden');
    } else {
        previewContainer.classList.add('hidden');
    }
});
</script>
@endsection
