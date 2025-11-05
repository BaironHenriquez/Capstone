# Sistema de Asignación de Órdenes a Técnicos

## 📋 Descripción General

El sistema permite asignar órdenes de servicio a técnicos específicos, con gestión automática de estados y carga de trabajo.

## 🔗 Base de Datos

### Relación Técnico-Orden
- La tabla `ordenes_servicio` tiene el campo `tecnico_id` (FK a `tecnicos`)
- Una orden puede tener **UN** técnico asignado
- Un técnico puede tener **MÚLTIPLES** órdenes asignadas

### Estados de Órdenes
- **pendiente**: Orden sin asignar o devuelta al pool
- **asignada**: Orden asignada a un técnico (estado inicial tras asignación)
- **en_proceso**: Técnico trabajando activamente en la orden
- **diagnostico**: En evaluación técnica
- **completado**: Orden finalizada

## 🎯 Funcionalidades Implementadas

### 1. Vista de Asignación (`/admin/tecnicos/{id}/asignar`)

#### Panel Izquierdo - Información del Técnico
- Avatar con iniciales
- Estado de disponibilidad
- Carga de trabajo actual (%)
- Estadísticas:
  - Órdenes activas
  - Órdenes completadas
- Información profesional:
  - Nivel de experiencia
  - Zona de trabajo
  - Horario de trabajo
  - Especialidades

#### Panel Derecho - Gestión de Órdenes

**Órdenes Asignadas**
- Lista de órdenes actualmente asignadas al técnico
- Estados incluidos: `asignada`, `en_proceso`, `diagnostico`
- Información mostrada:
  - Número de orden
  - Estado actual (con badge de color)
  - Descripción del problema
  - Cliente asociado
  - Fecha de ingreso
- Acción: Botón para **desasignar**

**Órdenes Disponibles**
- Lista de órdenes sin asignar o pendientes
- Campo de búsqueda en tiempo real
- Información mostrada:
  - Número de orden
  - Prioridad (badge)
  - Tipo de equipo
  - Descripción del problema
  - Cliente
  - Fecha de ingreso
  - Fecha compromiso de entrega (si existe)
- Acción: Botón para **asignar**

### 2. Lógica de Asignación

#### Asignar Orden (`POST /admin/tecnicos/{id}/asignar`)
```php
// Cambios automáticos:
1. orden->tecnico_id = tecnico->id
2. orden->estado = 'asignada'
3. tecnico->carga_trabajo_actual += 20%
```

**Cálculo de Carga de Trabajo:**
- Cada orden activa = 20% de carga
- Máximo: 100%
- Estados considerados: `asignada`, `en_proceso`, `diagnostico`

#### Desasignar Orden (`DELETE /admin/tecnicos/{tecnicoId}/desasignar/{ordenId}`)
```php
// Cambios automáticos:
1. orden->tecnico_id = null
2. orden->estado = 'pendiente'
3. tecnico->carga_trabajo_actual -= 20%
```

### 3. Validaciones de Seguridad

✅ **Control de Permisos:**
- Solo el servicio técnico propietario puede asignar/desasignar
- Verificación de que el técnico pertenezca al mismo servicio
- Verificación de que la orden pertenezca al mismo servicio

✅ **Validaciones de Estado:**
- Solo se pueden asignar órdenes disponibles
- Solo se pueden desasignar órdenes del técnico correspondiente
- Estado de la orden se actualiza automáticamente

## 🎨 Interfaz de Usuario

### Códigos de Color por Estado
- **Pendiente**: Amarillo (yellow)
- **Asignada**: Celeste (sky)
- **En Proceso**: Azul (blue)
- **Diagnóstico**: Púrpura (purple)
- **Completado**: Verde (green)

### Características de UX
- **Búsqueda en Tiempo Real**: Filtro de órdenes disponibles
- **Diseño Responsivo**: Adaptable a móviles y tablets
- **Scroll Independiente**: Panel de órdenes con altura máxima
- **Confirmación de Acciones**: Alert antes de desasignar
- **Feedback Visual**: Badges de estado con colores distintivos
- **Navegación Intuitiva**: Botón de regreso a gestión de técnicos

## 📊 Gestión de Carga de Trabajo

### Cálculo Automático
```
Carga Total = min(Órdenes Activas × 20%, 100%)
```

### Indicadores Visuales
- Porcentaje numérico
- Barra de progreso con colores:
  - 0-50%: Verde (disponible)
  - 51-80%: Amarillo (ocupado)
  - 81-100%: Rojo (saturado)

### Actualización Automática
- Se recalcula después de cada asignación
- Se recalcula después de cada desasignación
- Se actualiza al completar órdenes

## 🔄 Flujo Completo de Trabajo

### 1. Crear Orden de Servicio
```
Estado inicial: "pendiente"
tecnico_id: null
```

### 2. Asignar a Técnico
```
Usuario admin accede a /admin/tecnicos/{id}/asignar
Selecciona orden disponible
Click en "Asignar"
→ orden->estado = "asignada"
→ orden->tecnico_id = {id}
→ tecnico->carga_trabajo_actual += 20%
```

### 3. Técnico Trabaja en Orden
```
Técnico puede cambiar estado a:
- "en_proceso": Iniciando trabajo
- "diagnostico": Evaluando problema
```

### 4. Completar Orden
```
Técnico finaliza trabajo
→ orden->estado = "completado"
→ Se descuenta de carga_trabajo_actual
```

### 5. Desasignar (si es necesario)
```
Usuario admin puede desasignar
→ orden->estado = "pendiente"
→ orden->tecnico_id = null
→ tecnico->carga_trabajo_actual -= 20%
```

## 🛠️ Archivos Modificados

### Controlador
- `app/Http/Controllers/GestionTecnicosController.php`
  - `asignar($id)`: Muestra vista de asignación
  - `asignarStore(Request, $id)`: Procesa asignación
  - `desasignar($tecnicoId, $ordenId)`: Procesa desasignación

### Vista
- `resources/views/admin/tecnicos/asignar.blade.php`
  - Layout de dos paneles
  - Búsqueda en tiempo real
  - Formularios de asignación/desasignación

### Rutas
- `routes/web.php`
  ```php
  Route::get('/{id}/asignar', 'asignar')->name('asignar');
  Route::post('/{id}/asignar', 'asignarStore')->name('asignar.store');
  Route::delete('/{tecnicoId}/desasignar/{ordenId}', 'desasignar')->name('desasignar');
  ```

### Modelo
- `app/Models/OrdenServicio.php`
  - Relación `belongsTo(Tecnico::class)`

## 📝 Notas Importantes

1. **Persistencia de Datos**: Todas las asignaciones se guardan en la base de datos
2. **Transacciones**: No se usan transacciones DB por ser operaciones simples
3. **Soft Deletes**: Las órdenes eliminadas mantienen el histórico de técnico asignado
4. **Permisos**: Solo usuarios autenticados con servicio técnico pueden asignar
5. **Escalabilidad**: El sistema soporta múltiples servicios técnicos simultáneos

## 🚀 Mejoras Futuras Sugeridas

- [ ] Notificaciones push al técnico cuando se le asigna una orden
- [ ] Historial de reasignaciones
- [ ] Filtros avanzados en órdenes disponibles (prioridad, fecha, etc.)
- [ ] Asignación automática por algoritmo (zona, carga, especialidades)
- [ ] Dashboard de rendimiento por técnico
- [ ] Exportación de reportes de asignaciones
- [ ] Comentarios/notas en la asignación
- [ ] Estimación de tiempo por orden
- [ ] Alertas de órdenes vencidas o próximas a vencer
