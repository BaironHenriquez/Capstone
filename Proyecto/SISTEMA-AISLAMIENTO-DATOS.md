# 🔐 Sistema de Aislamiento de Datos por Servicio Técnico

## 📋 Resumen

Se ha implementado un sistema completo de aislamiento de datos que asegura que cada servicio técnico solo pueda ver y gestionar sus propios datos (clientes, órdenes, equipos). Además, se ha implementado numeración correlativa independiente para las órdenes de servicio de cada servicio técnico.

---

## 🎯 Objetivos Cumplidos

### ✅ 1. Aislamiento de Datos
- Cada usuario con servicio técnico solo ve sus propios clientes
- Las órdenes de servicio están filtradas por servicio técnico
- Los equipos mostrados pertenecen a clientes del servicio técnico
- No hay mezcla de información entre diferentes servicios técnicos

### ✅ 2. Numeración Correlativa
- Cada servicio técnico tiene su propia secuencia de números de orden
- Formato: `ST-<ID_SERVICIO>-<AÑO><MES>-<CORRELATIVO>`
- Ejemplo: `ST-001-202411-001`, `ST-001-202411-002`, etc.
- El correlativo se reinicia cada mes
- Es independiente entre servicios técnicos

---

## 🏗️ Componentes Implementados

### 1. **Trait: BelongsToServicioTecnico**
📁 `app/Traits/BelongsToServicioTecnico.php`

**Funcionalidad:**
- Global Scope automático que filtra consultas por `servicio_tecnico_id`
- Asignación automática del `servicio_tecnico_id` al crear registros
- Relación con ServicioTecnico
- Scope personalizado `forServicioTecnico()`

**Uso:**
```php
use App\Traits\BelongsToServicioTecnico;

class MiModelo extends Model
{
    use BelongsToServicioTecnico;
}
```

### 2. **Middleware: EnsureUserHasServicioTecnico**
📁 `app/Http/Middleware/EnsureUserHasServicioTecnico.php`

**Funcionalidad:**
- Verifica que el usuario autenticado tenga un servicio técnico asociado
- Agrega el `servicio_tecnico_id` al request
- Redirige al login si no hay usuario autenticado
- Muestra error si el usuario no tiene servicio técnico

**Alias:** `servicio.tecnico`

**Uso en rutas:**
```php
Route::middleware(['auth', 'servicio.tecnico'])->group(function () {
    // Rutas protegidas
});
```

### 3. **Modelos Actualizados**

#### Cliente.php
```php
use App\Traits\BelongsToServicioTecnico;

class Cliente extends Model
{
    use HasFactory, SoftDeletes, BelongsToServicioTecnico;
}
```

#### OrdenServicio.php
```php
use App\Traits\BelongsToServicioTecnico;

class OrdenServicio extends Model
{
    use HasFactory, BelongsToServicioTecnico;
    
    /**
     * Generar número correlativo por servicio técnico
     */
    public static function generarNumeroOrden($servicioTecnicoId = null)
    {
        // Implementación...
    }
}
```

### 4. **OrdenServicioController Actualizado**

**Método `create()`:**
- Filtra clientes automáticamente por servicio técnico (gracias al trait)
- Filtra equipos que pertenecen a clientes del servicio técnico
- Genera número de orden sugerido correlativo
- Pasa datos a la vista

**Método `store()`:**
- Valida que el usuario tenga servicio técnico
- Verifica que el cliente pertenezca al servicio técnico
- Genera número de orden correlativo automáticamente
- Asigna automáticamente `servicio_tecnico_id` y `user_id`

**Método `index()`:**
- Lista solo órdenes del servicio técnico actual
- Estadísticas filtradas por servicio técnico

---

## 🔄 Flujo de Funcionamiento

### Crear Nueva Orden de Servicio

```
1. Usuario autenticado accede a /ordenes/create
   ↓
2. Middleware verifica que tenga servicio técnico
   ↓
3. Controller obtiene:
   - Clientes del servicio técnico (filtrado automático por trait)
   - Equipos de esos clientes
   - Número de orden sugerido (correlativo)
   ↓
4. Vista muestra formulario con:
   - Número de orden auto-generado (readonly)
   - Solo clientes del servicio técnico
   - Solo equipos de esos clientes
   - Mensaje informativo de seguridad
   ↓
5. Al enviar formulario:
   - Valida datos
   - Verifica que cliente pertenezca al servicio técnico
   - Crea orden con servicio_tecnico_id automático
   - Incrementa correlativo del servicio técnico
```

### Listar Órdenes

```
1. Usuario accede a /ordenes
   ↓
2. Global Scope filtra automáticamente por servicio_tecnico_id
   ↓
3. Solo ve órdenes de su servicio técnico
   ↓
4. Estadísticas calculadas solo con sus datos
```

---

## 📊 Formato de Numeración

### Estructura
```
ST-<ID_SERVICIO>-<AÑO><MES>-<CORRELATIVO>
│   │             │         └─ 001, 002, 003... (3 dígitos)
│   │             └─ 202411 (Año y mes)
│   └─ 001, 002, 003... (ID del servicio técnico, 3 dígitos)
└─ Prefijo "ST" (Servicio Técnico)
```

### Ejemplos
- Servicio Técnico #1, Noviembre 2025:
  - `ST-001-202511-001`
  - `ST-001-202511-002`
  - `ST-001-202511-003`

- Servicio Técnico #2, Noviembre 2025:
  - `ST-002-202511-001` ← Correlativo independiente
  - `ST-002-202511-002`

- Servicio Técnico #1, Diciembre 2025:
  - `ST-001-202512-001` ← Se reinicia en nuevo mes

---

## 🔒 Seguridad Implementada

### 1. Filtrado Automático
- **Global Scope** en modelos previene acceso a datos de otros servicios
- **Verificación en Controller** antes de crear/actualizar
- **Validación de pertenencia** de clientes y equipos

### 2. Asignación Automática
- El trait asigna `servicio_tecnico_id` al crear registros
- No se puede manipular desde el formulario
- Se toma del usuario autenticado

### 3. Middleware de Protección
- Verifica autenticación
- Verifica existencia de servicio técnico
- Redirige si no cumple requisitos

### 4. Mensajes Informativos en UI
- "Solo se muestran clientes de su servicio técnico"
- "Solo se muestran equipos de clientes de su servicio técnico"
- "Número correlativo generado automáticamente"

---

## 🧪 Casos de Prueba

### ✅ Caso 1: Crear Orden con Cliente Propio
```php
// Usuario del Servicio Técnico #1
Cliente: Juan Pérez (servicio_tecnico_id = 1)
Resultado: ✅ Orden creada con número ST-001-202511-001
```

### ❌ Caso 2: Intentar Crear Orden con Cliente Ajeno
```php
// Usuario del Servicio Técnico #1 intenta usar cliente del Servicio #2
Cliente: María García (servicio_tecnico_id = 2)
Resultado: ❌ Error 403 - "El cliente seleccionado no pertenece a su servicio técnico"
```

### ✅ Caso 3: Numeración Correlativa
```php
Servicio Técnico #1:
- Orden 1: ST-001-202511-001
- Orden 2: ST-001-202511-002
- Orden 3: ST-001-202511-003

Servicio Técnico #2 (en paralelo):
- Orden 1: ST-002-202511-001 ← Independiente
- Orden 2: ST-002-202511-002
```

### ✅ Caso 4: Listado de Órdenes
```php
Usuario del Servicio Técnico #1:
- Ve solo órdenes con servicio_tecnico_id = 1
- Estadísticas calculadas solo con sus datos
- No puede ver órdenes de otros servicios
```

---

## 📝 Notas Importantes

### Para Desarrolladores

1. **Al agregar nuevos modelos** que deban pertenecer a un servicio técnico:
   ```php
   use App\Traits\BelongsToServicioTecnico;
   
   class NuevoModelo extends Model
   {
       use BelongsToServicioTecnico;
   }
   ```

2. **Si necesitas omitir el filtro** temporalmente:
   ```php
   Model::withoutGlobalScope('servicio_tecnico')->get();
   ```

3. **Para consultar datos de un servicio específico**:
   ```php
   Model::forServicioTecnico($servicioTecnicoId)->get();
   ```

### Para Administradores

1. Cada usuario debe tener un `servicio_tecnico_id` asignado
2. Los clientes se crean asociados a un servicio técnico
3. Las órdenes heredan el servicio técnico del usuario que las crea
4. La numeración es automática y no debe modificarse manualmente

---

## 🚀 Ventajas del Sistema

### ✅ Seguridad
- Aislamiento completo de datos
- Prevención de acceso cruzado
- Validación en múltiples capas

### ✅ Automatización
- Numeración automática
- Asignación automática de relaciones
- Filtrado transparente

### ✅ Escalabilidad
- Soporte para múltiples servicios técnicos
- Numeración independiente por servicio
- Fácil adición de nuevos modelos

### ✅ Mantenibilidad
- Código reutilizable (Trait)
- Lógica centralizada
- Fácil de entender y mantener

---

## 🔧 Mantenimiento Futuro

### Si necesitas modificar la numeración:
Edita el método en `app/Models/OrdenServicio.php`:
```php
public static function generarNumeroOrden($servicioTecnicoId = null)
{
    // Modifica el formato aquí
    return sprintf("TU-FORMATO-%03d", $numero);
}
```

### Si necesitas agregar más filtros:
Edita el trait en `app/Traits/BelongsToServicioTecnico.php`:
```php
static::addGlobalScope('tu_scope', function (Builder $builder) {
    // Tu lógica de filtrado
});
```

---

## 📞 Soporte

Si encuentras algún problema o necesitas agregar funcionalidad:
1. Verifica que el usuario tenga `servicio_tecnico_id` asignado
2. Limpia las cachés: `php artisan cache:clear`
3. Verifica las relaciones en los modelos
4. Revisa los logs en `storage/logs/laravel.log`

---

**Fecha de Implementación:** 5 de Noviembre de 2025
**Desarrollado por:** GitHub Copilot
**Estado:** ✅ Completado y Funcional
