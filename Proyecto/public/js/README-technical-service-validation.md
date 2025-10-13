# Validaciones JavaScript - Servicio Técnico

## Descripción
Este archivo contiene las validaciones del lado del cliente para el formulario de configuración del servicio técnico en TechService Pro.

## Características

### 🎯 Validaciones en Tiempo Real
- **Nombre del Servicio**: 3-45 caracteres, texto limpio
- **Dirección**: 5-45 caracteres, dirección válida
- **Teléfono**: 8-45 caracteres, formato chileno (+56XXXXXXXXX)
- **Correo**: 5-45 caracteres, formato email válido
- **RUT**: 9-12 caracteres, RUT chileno válido con dígito verificador

### 🎨 Características Visuales
- **Contadores de caracteres** en tiempo real
- **Estados de validación** (éxito, error, advertencia)
- **Formateo automático** de RUT y teléfono
- **Animaciones suaves** para transiciones
- **Feedback inmediato** al usuario

### 🛠️ Funcionalidades Técnicas
- **Validación de RUT chileno** con algoritmo de dígito verificador
- **Formateo automático** con puntos y guión
- **Validación de email** con regex
- **Sanitización** de inputs peligrosos
- **Prevención de XSS** básica

### 📱 Responsive Design
- **Adaptado para móviles** con textos más pequeños
- **Validaciones consistentes** en todos los dispositivos
- **UX optimizada** para pantallas táctiles

## Uso

### Inclusión en Vista
```html
<link href="{{ asset('css/technical-service-validation.css') }}" rel="stylesheet">
<script src="{{ asset('js/technical-service-validation.js') }}" defer></script>
```

### Estructura HTML Requerida
```html
<form action="{{ route('setup.technical-service.save') }}" method="POST">
    <input id="nombre_servicio" name="nombre_servicio" type="text" required>
    <input id="direccion" name="direccion" type="text" required>
    <input id="telefono" name="telefono" type="tel" required>
    <input id="correo" name="correo" type="email" required>
    <input id="rut" name="rut" type="text" required>
    <button type="submit">Completar Configuración</button>
</form>
```

## Validadores Disponibles

### `validateLength(value, min, max)`
Valida la longitud de una cadena entre valores mínimos y máximos.

### `validateEmail(email)`
Valida formato de email usando regex estándar.

### `validateRUT(rut)`
Valida RUT chileno usando algoritmo de módulo 11.

### `validatePhone(phone)`
Valida formato de teléfono chileno con código de país opcional.

## Formateadores

### `formatRUT(value)`
Formatea RUT automáticamente: `12345678K` → `12.345.678-K`

### `formatPhone(value)`
Limpia y formatea teléfono manteniendo solo números y +.

### `formatText(value)`
Sanitiza texto removiendo caracteres peligrosos como `<` y `>`.

## Estados de UI

### Clases CSS Aplicadas
- `.input-valid` - Campo válido (borde verde)
- `.input-invalid` - Campo inválido (borde rojo)
- `.error-message` - Mensaje de error (texto rojo)
- `.char-counter` - Contador de caracteres (texto gris)

### Animaciones
- **slideDown**: Para mensajes de error/éxito
- **shake**: Para campos con errores críticos
- **spin**: Para indicadores de carga

## Configuración

### Límites de Caracteres
```javascript
const config = {
    maxLength: 45, // Límite de la base de datos
    minLength: {
        nombre: 3,
        direccion: 5,
        telefono: 8,
        correo: 5,
        rut: 9
    }
};
```

### Personalización
Para modificar las validaciones, edita los objetos `fieldValidators` y `validators` en el archivo JavaScript.

## Compatibilidad
- ✅ Chrome 60+
- ✅ Firefox 55+
- ✅ Safari 12+
- ✅ Edge 79+
- ✅ Dispositivos móviles iOS/Android

## Dependencias
- **Tailwind CSS** para estilos base
- **JavaScript ES6+** para funcionalidades modernas
- **DOM API** estándar para manipulación

## Mantenimiento
- El archivo se auto-documenta con `console.log` al cargar
- Todas las funciones están modularizadas para fácil testing
- Código comentado para facilitar modificaciones futuras