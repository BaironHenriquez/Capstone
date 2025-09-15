# Proyecto Capstone Laravel con Docker# Proyecto Laravel con Docker# Proyecto Laravel con Docker# 🚀 Proyecto Laravel con Docker<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



Proyecto Laravel completo con Docker, MySQL, Redis, Nginx, Node.js y Tailwind CSS configurado para el desarrollo del Capstone.



## RequisitosEste proyecto está configurado para ejecutar una aplicación Laravel completa usando Docker, incluyendo MySQL, Redis, Nginx, y Node.js para el desarrollo frontend.



- [Docker](https://www.docker.com/get-started)

- [Docker Compose](https://docs.docker.com/compose/install/)

## RequisitosEste proyecto está configurado para ejecutar una aplicación Laravel completa usando Docker, incluyendo MySQL, Redis, Nginx, y Node.js para el desarrollo frontend.

## Servicios Incluidos



- **Laravel** (PHP 8.2 + Composer)

- **MySQL 8.0** (Base de datos con usuario específico del proyecto)- [Docker](https://www.docker.com/get-started)

- **Redis** (Cache y sesiones)  

- **Nginx** (Servidor web)- [Docker Compose](https://docs.docker.com/compose/install/)

- **Node.js 18** (Frontend/NPM)

- **phpMyAdmin** (Administración de BD)## RequisitosEste proyecto está configurado para ejecutar una aplicación Laravel completa usando Docker, incluyendo MySQL, Redis, Nginx, y Node.js para el desarrollo frontend.<p align="center">

- **Tailwind CSS** (Framework CSS preconfigurado)

## Servicios Incluidos

## Inicio Rápido para Colaboradores



### Si CLONASTE este repositorio desde GitHub:

- **Laravel** (PHP 8.2 + Composer)

```powershell

# Solo necesitas ejecutar este comando:- **MySQL 8.0** (Base de datos)- [Docker](https://www.docker.com/get-started)<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>

.\init-existing.bat

```- **Redis** (Cache y sesiones)  



**Esto configurará automáticamente:**- **Nginx** (Servidor web)- [Docker Compose](https://docs.docker.com/compose/install/)

- Docker y todos los contenedores

- MySQL con base de datos y usuario específicos del proyecto- **Node.js 18** (Frontend/NPM)

- Laravel con todas las dependencias

- Tailwind CSS completamente configurado- **phpMyAdmin** (Administración de BD)## 📋 Requisitos<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>

- Migraciones de base de datos

- Optimización de cache



### Configuración Automática Incluida## Inicio Rápido## Servicios Incluidos



El script `init-existing.bat` configurará automáticamente:



**Base de Datos:**### IMPORTANTE: Elige el script correcto según tu situación<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>

- Base de datos: `capstone_laravel`

- Usuario: `capstone_user`

- Contraseña: `capstone_password_2025`

- Base de datos de testing: `capstone_laravel_testing`#### Si CLONASTE este repositorio desde GitHub:- **Laravel** (PHP 8.2 + Composer)



**Tecnologías Frontend:**```powershell

- Tailwind CSS v4.0

- PostCSS y Autoprefixer.\init-existing.bat- **MySQL 8.0** (Base de datos)- [Docker](https://www.docker.com/get-started)<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>

- Vite para desarrollo

- Configuración personalizada con colores del proyecto```



## URLs Disponibles**Por qué:** Laravel ya está instalado en el repositorio, solo necesitas configurar el entorno Docker.- **Redis** (Cache y sesiones)



- **Aplicación Laravel:** http://localhost:8080

- **phpMyAdmin:** http://localhost:8081

  - Usuario: `capstone_user`#### Si estás creando un proyecto NUEVO desde cero:- **Nginx** (Servidor web)- [Docker Compose](https://docs.docker.com/compose/install/)</p>

  - Contraseña: `capstone_password_2025`

  - Host de BD: `db` (puerto interno 3306, externo 3307)```powershell

- **Vite Dev Server:** http://localhost:5173

.\init-smart.bat- **Node.js 18** (Frontend/NPM)

## Desarrollo Frontend con Tailwind CSS

```

Para trabajar con Tailwind CSS en modo desarrollo:

**Por qué:** Detecta automáticamente si Laravel existe y lo instala si es necesario.- **phpMyAdmin** (Administración de BD)

```powershell

# Iniciar servidor de desarrollo con hot reload

docker-compose -f docker-compose.existing.yml exec node npm run dev

```#### Si NO ESTÁS SEGURO de qué script usar:



### Características de Tailwind CSS Incluidas```powershell



- **Tailwind CSS v4.0** con configuración optimizada.\init-smart.bat## Instalación y Configuración## 🏗️ Servicios Incluidos## About Laravel

- **@tailwindcss/forms** para mejor estilizado de formularios

- **Colores personalizados** del proyecto (capstone-50 a capstone-900)```

- **Fuente personalizada** (Inter) configurada

- **Autoprefixer** para compatibilidad con navegadores**Por qué:** Es inteligente y se adapta a cualquier situación automáticamente.



### Ejemplo de uso en templates Blade:



```html## URLs Disponibles Después de la Instalación### Tipos de Proyecto

<div class="bg-capstone-500 text-white p-6 rounded-lg shadow-lg">

    <h1 class="text-3xl font-bold mb-4">Proyecto Capstone</h1>

    <p class="text-capstone-50">Desarrollado con Laravel y Tailwind CSS</p>

</div>- **Aplicación Laravel:** http://localhost:8080

```

- **phpMyAdmin:** http://localhost:8081

## Comandos Útiles para Desarrollo

  - Usuario: `laravel_user`#### Opción A: Proyecto Nuevo (Sin Laravel)- **Laravel** (PHP 8.2 + Composer)Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

### Comandos Básicos

```powershell  - Contraseña: `laravel_password`

# Iniciar servicios

docker-compose -f docker-compose.existing.yml up -d  - Host de BD: `db` (puerto interno 3306, externo 3307)Si estás creando un proyecto desde cero:



# Detener servicios- **Vite Dev Server:** http://localhost:5173 (cuando esté ejecutándose)

docker-compose -f docker-compose.existing.yml down

- **MySQL 8.0** (Base de datos)

# Ver logs

docker-compose -f docker-compose.existing.yml logs -f## Desarrollo Frontend



# Reiniciar servicios```powershell

docker-compose -f docker-compose.existing.yml restart

```Para trabajar con assets frontend (CSS, JS):



### Comandos de Laravel# Script inteligente (detecta automáticamente)- **Redis** (Cache y sesiones)- [Simple, fast routing engine](https://laravel.com/docs/routing).

```powershell

# Ejecutar comandos Artisan```powershell

docker-compose -f docker-compose.existing.yml exec app php artisan [comando]

# Si usaste init.bat o init-smart.bat.\init-smart.bat

# Ejemplos comunes:

docker-compose -f docker-compose.existing.yml exec app php artisan migrate.\dev-frontend.bat

docker-compose -f docker-compose.existing.yml exec app php artisan make:controller HomeController

docker-compose -f docker-compose.existing.yml exec app php artisan cache:clear- **Nginx** (Servidor web)- [Powerful dependency injection container](https://laravel.com/docs/container).



# Acceder al contenedor# Si usaste init-existing.bat

docker-compose -f docker-compose.existing.yml exec app bash

```docker-compose -f docker-compose.existing.yml exec node npm install# O script tradicional



### Comandos de Frontenddocker-compose -f docker-compose.existing.yml exec node npm run dev

```powershell

# Instalar nuevas dependencias de NPM```.\init.bat- **Node.js 18** (Frontend/NPM)- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.

docker-compose -f docker-compose.existing.yml exec node npm install [paquete]



# Compilar assets para producción

docker-compose -f docker-compose.existing.yml exec node npm run build## Guía de Resolución de Problemas```



# Modo desarrollo con hot reload

docker-compose -f docker-compose.existing.yml exec node npm run dev

```### Error: "Could not open input file: artisan"- **phpMyAdmin** (Administración de BD)- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).



### Comandos de Base de Datos**Causa:** Laravel no está instalado correctamente.

```powershell

# Ejecutar migraciones**Solución:**#### Opción B: Repositorio Existente (Ya tiene Laravel)

docker-compose -f docker-compose.existing.yml exec app php artisan migrate

```powershell

# Rollback de migraciones

docker-compose -f docker-compose.existing.yml exec app php artisan migrate:rollback# Si es repositorio clonadoSi clonaste desde GitHub y Laravel ya está instalado:- Database agnostic [schema migrations](https://laravel.com/docs/migrations).



# Ejecutar seeders.\init-existing.bat

docker-compose -f docker-compose.existing.yml exec app php artisan db:seed



# Limpiar y recrear base de datos

docker-compose -f docker-compose.existing.yml exec app php artisan migrate:fresh --seed# Si es proyecto nuevo

```

.\init-smart.bat```powershell## 🚀 Instalación y Configuración- [Robust background job processing](https://laravel.com/docs/queues).

## Configuración de Base de Datos

```

La configuración está optimizada para el proyecto Capstone:

# Script optimizado para repositorios existentes

```env

DB_CONNECTION=mysql### Error: "Ports are not available" (Puerto ocupado)

DB_HOST=db

DB_PORT=3306**Causa:** Otro servicio está usando los puertos..\init-existing.bat- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

DB_DATABASE=capstone_laravel

DB_USERNAME=capstone_user**Solución:**

DB_PASSWORD=capstone_password_2025

``````powershell```



**Conexión externa (para herramientas como MySQL Workbench):**# Verificar qué puertos están ocupados

- Host: `localhost`

- Puerto: `3307`.\check-ports.bat### 🔍 **¿Qué tipo de proyecto tienes?**

- Base de datos: `capstone_laravel`

- Usuario: `capstone_user`

- Contraseña: `capstone_password_2025`

# Cambiar puertos en docker-compose.yml si es necesario### Instalación Automática/Inteligente (Recomendada)

## Estructura del Proyecto

# O detener el servicio que usa el puerto

```

capstone-proyecto/```Laravel is accessible, powerful, and provides tools required for large, robust applications.

├── docker-compose.existing.yml     # Configuración Docker principal

├── Dockerfile.existing             # Imagen Docker optimizada

├── init-existing.bat               # Script de inicialización único

├── tailwind.config.js              # Configuración Tailwind CSS### Contenedor se reinicia constantementeEl script `init-smart.bat` detecta automáticamente la situación:

├── postcss.config.js               # Configuración PostCSS

├── package.json                    # Dependencias Node.js**Causa:** Error en la configuración del contenedor.

├── vite.config.js                  # Configuración Vite

├── .env.example                    # Variables de entorno**Solución:**#### **Opción A: Proyecto Nuevo (Sin Laravel)**

├── resources/

│   ├── css/app.css                 # CSS principal con Tailwind```powershell

│   ├── js/app.js                   # JavaScript principal

│   └── views/                      # Templates Blade# Ver los logs para identificar el error```powershell

└── docker-compose/

    ├── nginx/app.conf              # Configuración Nginxdocker-compose logs -f

    └── mysql/

        ├── my.cnf                  # Configuración MySQL.\init-smart.batSi estás creando un proyecto desde cero:## Learning Laravel

        └── init.sql                # Script inicialización BD

```# Reiniciar contenedores



## Solución de Problemas Comunesdocker-compose down```



### Error de permisos en Windows.\init-smart.bat

```powershell

Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser```

```



### Puertos ocupados

```powershell## Comandos Útiles para Desarrollo**Funcionalidades:**

# Verificar puertos en uso

netstat -an | findstr ":8080\|:8081\|:3307"



# Si están ocupados, cambiar en docker-compose.existing.yml### Comandos Básicos de Docker- Detecta si Laravel ya existe```powershellLaravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

```

```powershell

### Contenedores no inician correctamente

```powershell# Iniciar servicios- Instala Laravel solo si es necesario

# Ver logs detallados

docker-compose -f docker-compose.existing.yml logs -fdocker-compose up -d



# Reiniciar desde cero- Configura dependencias apropiadamente# Script inteligente (detecta automáticamente)

docker-compose -f docker-compose.existing.yml down -v

.\init-existing.bat# Detener servicios

```

docker-compose down- Optimiza según el escenario

### Problemas con Tailwind CSS

```powershell

# Recompilar assets

docker-compose -f docker-compose.existing.yml exec node npm run build# Ver logs.\init-smart.batYou may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.



# Limpiar cache de Vitedocker-compose logs -f

docker-compose -f docker-compose.existing.yml exec node rm -rf node_modules/.vite

```### Instalación Manual



## Instrucciones para Nuevos Colaboradores# Reiniciar un servicio específico



1. **Clonar el repositorio:**docker-compose restart app

   ```powershell

   git clone [url-repositorio-capstone]```

   cd [directorio-proyecto]

   ``````powershell



2. **Verificar Docker:**### Comandos de Laravel

   ```powershell

   docker --version```powershell# Para proyecto nuevo# O script tradicionalIf you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

   docker-compose --version

   ```# Ejecutar comandos Artisan



3. **Ejecutar script de inicialización:**docker-compose exec app php artisan [comando]copy .env.example .env

   ```powershell

   .\init-existing.bat

   ```

# Ejemplos comunes:docker-compose up -d --build.\init.bat

4. **Verificar instalación:**

   - Abrir http://localhost:8080 (debe mostrar Laravel)docker-compose exec app php artisan migrate

   - Abrir http://localhost:8081 (debe mostrar phpMyAdmin)

docker-compose exec app php artisan make:controller HomeController# Esperar 40 segundos

5. **Comenzar desarrollo:**

   ```powershelldocker-compose exec app php artisan cache:clear

   # Para frontend con Tailwind CSS

   docker-compose -f docker-compose.existing.yml exec node npm run devdocker-compose exec app composer create-project --prefer-dist laravel/laravel .```## Laravel Sponsors

   ```

# Acceder al contenedor

## Desarrollo con Tailwind CSS

docker-compose exec app bash

### Configuración incluida:

- **Colores del proyecto:** `capstone-50` a `capstone-900````

- **Fuente personalizada:** Inter

- **Plugin de formularios:** @tailwindcss/forms# Para repositorio existente  

- **Autoprefixer:** Para compatibilidad cross-browser

### Comandos de Base de Datos

### Clases útiles del proyecto:

```css```powershellcopy .env.example .env

/* Colores principales */

.bg-capstone-500    /* Azul principal */# Ejecutar migraciones

.text-capstone-700  /* Texto azul oscuro */

.border-capstone-300 /* Borde azul claro */docker-compose exec app php artisan migratedocker-compose -f docker-compose.existing.yml up -d --build#### **Opción B: Repositorio Existente (Ya tiene Laravel)**We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).



/* Componentes con formularios mejorados */

.form-input         /* Input estilizado */

.form-select        /* Select estilizado */# Rollback de migracionesdocker-compose -f docker-compose.existing.yml exec app composer install

.form-checkbox      /* Checkbox estilizado */

```docker-compose exec app php artisan migrate:rollback



## Mantener el Proyecto Actualizado```Si clonaste desde GitHub y Laravel ya está instalado:



```powershell# Ejecutar seeders

# Actualizar dependencias PHP

docker-compose -f docker-compose.existing.yml exec app composer updatedocker-compose exec app php artisan db:seed



# Actualizar dependencias Node.js

docker-compose -f docker-compose.existing.yml exec node npm update

# Limpiar y recrear base de datos## URLs Disponibles### Premium Partners

# Reconstruir contenedores si hay cambios en Docker

docker-compose -f docker-compose.existing.yml up -d --builddocker-compose exec app php artisan migrate:fresh --seed

```

```

## Soporte



Para problemas específicos del proyecto Capstone:

## Estructura de Archivos del Proyecto- **Aplicación Laravel:** http://localhost:8080```powershell

1. **Verificar logs:** `docker-compose -f docker-compose.existing.yml logs -f`

2. **Reiniciar servicios:** `docker-compose -f docker-compose.existing.yml restart`

3. **Limpiar y reiniciar:** `docker-compose -f docker-compose.existing.yml down -v && .\init-existing.bat`

```- **phpMyAdmin:** http://localhost:8081

**Documentación adicional:**

- [Laravel](https://laravel.com/docs)proyecto/

- [Tailwind CSS](https://tailwindcss.com/docs)

- [Docker](https://docs.docker.com/)├── docker-compose.yml              # Para proyectos nuevos  - Usuario: `laravel_user`# Script optimizado para repositorios existentes- **[Vehikl](https://vehikl.com)**

├── docker-compose.existing.yml     # Para repositorios existentes

├── Dockerfile                      # Para proyectos nuevos  - Contraseña: `laravel_password`

├── Dockerfile.existing             # Para repositorios existentes

├── .env.example                    # Variables de entorno de ejemplo  - Host de BD: `db` (puerto interno 3306, externo 3307).\init-existing.bat- **[Tighten Co.](https://tighten.co)**

├── init.bat                        # Inicialización básica

├── init-smart.bat                  # Inicialización inteligente- **Vite Dev Server:** http://localhost:5173 (cuando esté ejecutándose)

├── init-existing.bat               # Para repositorios existentes

├── dev-frontend.bat               # Desarrollo frontend```- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**

├── check-ports.bat                # Verificador de puertos

├── package.json                   # Dependencias Node.js## Desarrollo Frontend

├── vite.config.js                 # Configuración Vite

├── composer.json                  # Dependencias PHP- **[64 Robots](https://64robots.com)**

└── docker-compose/

    ├── nginx/Para trabajar con assets frontend (CSS, JS):

    │   └── app.conf              # Configuración Nginx

    └── mysql/### 🤖 **Instalación Automática/Inteligente (Recomendada)**- **[Curotec](https://www.curotec.com/services/technologies/laravel)**

        └── my.cnf                # Configuración MySQL

``````powershell



## Configuración de Base de Datos# Proyecto nuevo- **[DevSquad](https://devsquad.com/hire-laravel-developers)**



Las credenciales de la base de datos están en el archivo `.env`:.\dev-frontend.bat



```envEl script `init-smart.bat` detecta automáticamente la situación:- **[Redberry](https://redberry.international/laravel-development)**

DB_CONNECTION=mysql

DB_HOST=db# Repositorio existente

DB_PORT=3306

DB_DATABASE=laraveldocker-compose -f docker-compose.existing.yml exec node npm install- **[Active Logic](https://activelogic.com)**

DB_USERNAME=laravel_user

DB_PASSWORD=laravel_passworddocker-compose -f docker-compose.existing.yml exec node npm run dev

```

``````powershell

## Preguntas Frecuentes



### ¿Cuándo usar cada script?

## Estructura de Archivos.\init-smart.bat## Contributing

| Mi Situación | Script a Usar | ¿Por qué? |

|-------------|---------------|-----------|

| Cloné este repositorio desde GitHub | `init-existing.bat` | Laravel ya existe, solo configura Docker |

| Estoy creando un proyecto completamente nuevo | `init-smart.bat` | Instala Laravel automáticamente |``````

| No sé si Laravel está instalado | `init-smart.bat` | Detecta automáticamente la situación |

| El script anterior falló | `init-smart.bat` | Es más robusto y maneja errores |proyecto/



### ¿Qué hace cada script?├── docker-compose.yml              # Para proyectos nuevosThank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).



**init-existing.bat:**├── docker-compose.existing.yml     # Para repositorios existentes

- Verifica que Laravel esté instalado

- Usa docker-compose.existing.yml optimizado├── Dockerfile                      # Para proyectos nuevos**¿Qué hace?**

- Solo instala dependencias (composer install)

- Configuración rápida para repositorios existentes├── Dockerfile.existing             # Para repositorios existentes



**init-smart.bat:**├── .env.example                    # Variables de entorno- ✅ Detecta si Laravel ya existe## Code of Conduct

- Detecta si Laravel existe

- Instala Laravel si es necesario├── init.bat                        # Inicialización tradicional

- Configura todo automáticamente

- Funciona en cualquier situación├── init-smart.bat                  # Inicialización inteligente- ✅ Instala Laravel solo si es necesario



**init.bat:**├── init-existing.bat               # Para repositorios existentes

- Instalación básica tradicional

- Menos inteligente pero más simple├── dev-frontend.bat               # Desarrollo frontend- ✅ Configura dependencias apropiadamenteIn order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

- Para casos específicos

├── check-ports.bat                # Verificador de puertos

### ¿Por qué diferentes archivos Docker?

├── package.json                   # Dependencias Node.js- ✅ Optimiza según el escenario

- **docker-compose.yml + Dockerfile**: Para crear Laravel desde cero

- **docker-compose.existing.yml + Dockerfile.existing**: Para Laravel ya instalado├── vite.config.js                 # Configuración Vite

  - Mejor optimización de cache

  - Instalación más rápida├── composer.json                  # Dependencias PHP## Security Vulnerabilities

  - Configuración específica para repositorios

└── docker-compose/

## Instrucciones Detalladas

    ├── nginx/### 📁 **Instalación Manual**

### Para Nuevos Colaboradores (Repositorio Clonado)

    │   └── app.conf              # Configuración Nginx

1. **Clonar repositorio:**

   ```powershell    └── mysql/If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

   git clone [url-del-repositorio]

   cd [nombre-directorio]        └── my.cnf                # Configuración MySQL

   ```

``````powershell

2. **Verificar que Docker esté funcionando:**

   ```powershell

   docker --version

   docker-compose --version## Comandos Útiles# Para proyecto nuevo## License

   ```



3. **Inicializar proyecto:**

   ```powershell### Para Proyectos Nuevoscopy .env.example .env

   .\init-existing.bat

   ``````powershell



4. **Verificar instalación:**# Comandos Dockerdocker-compose up -d --buildThe Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

   - Abrir http://localhost:8080

   - Debe aparecer la página de Laraveldocker-compose up -d



### Para Desarrollo Diariodocker-compose down# Esperar 40 segundos



1. **Iniciar servicios:**docker-compose logs -fdocker-compose exec app composer create-project --prefer-dist laravel/laravel .

   ```powershell

   docker-compose -f docker-compose.existing.yml up -d

   ```

# Comandos Laravel# Para repositorio existente  

2. **Trabajar normalmente con el código**

docker-compose exec app php artisan [comando]copy .env.example .env

3. **Para frontend (si es necesario):**

   ```powershelldocker-compose exec app bashdocker-compose -f docker-compose.existing.yml up -d --build

   docker-compose -f docker-compose.existing.yml exec node npm run dev

   ```docker-compose -f docker-compose.existing.yml exec app composer install



4. **Detener servicios al terminar:**# Comandos Frontend```

   ```powershell

   docker-compose -f docker-compose.existing.yml downdocker-compose exec node npm install

   ```

docker-compose exec node npm run dev## 🌐 URLs Disponibles

## Mantenimiento y Actualización

```

### Actualizar dependencias de PHP

```powershell- **Aplicación Laravel:** http://localhost:8080

docker-compose exec app composer update

```### Para Repositorios Existentes- **phpMyAdmin:** http://localhost:8081



### Actualizar dependencias de Node.js```powershell  - Usuario: `laravel_user`

```powershell

docker-compose exec node npm update# Comandos Docker  - Contraseña: `laravel_password`

```

docker-compose -f docker-compose.existing.yml up -d  - Host de BD: `db` (puerto interno 3306, externo 3307)

### Limpiar volúmenes de Docker (CUIDADO: elimina datos)

```powershelldocker-compose -f docker-compose.existing.yml down- **Vite Dev Server:** http://localhost:5173 (cuando esté ejecutándose)

docker-compose down -v

```docker-compose -f docker-compose.existing.yml logs -f



### Reconstruir contenedores desde cero## 🎨 Desarrollo Frontend

```powershell

docker-compose down# Comandos Laravel

docker-compose up -d --build --force-recreate

```docker-compose -f docker-compose.existing.yml exec app php artisan [comando]Para trabajar con assets frontend (CSS, JS):



## Soporte y Ayudadocker-compose -f docker-compose.existing.yml exec app bash



Si tienes problemas:```powershell



1. **Verificar logs:** `docker-compose logs -f`# Comandos Frontend# Proyecto nuevo

2. **Verificar puertos:** `.\check-ports.bat`  

3. **Reiniciar Docker:** Reinicia Docker Desktopdocker-compose -f docker-compose.existing.yml exec node npm install.\dev-frontend.bat

4. **Limpiar todo:** `docker-compose down -v && .\init-smart.bat`

docker-compose -f docker-compose.existing.yml exec node npm run dev

Para más ayuda, consulta la documentación oficial de [Laravel](https://laravel.com/docs) y [Docker](https://docs.docker.com/).
```# Repositorio existente

docker-compose -f docker-compose.existing.yml exec node npm install

## Configuración de Base de Datosdocker-compose -f docker-compose.existing.yml exec node npm run dev

```

```env

DB_CONNECTION=mysql## 📁 Estructura de Archivos

DB_HOST=db

DB_PORT=3306```

DB_DATABASE=laravelproyecto/

DB_USERNAME=laravel_user├── docker-compose.yml              # Para proyectos nuevos

DB_PASSWORD=laravel_password├── docker-compose.existing.yml     # Para repositorios existentes

```├── Dockerfile                      # Para proyectos nuevos

├── Dockerfile.existing             # Para repositorios existentes

## Preguntas Frecuentes├── .env.example                    # Variables de entorno

├── init.bat                        # Inicialización tradicional

### Cuándo usar cada script├── init-smart.bat                  # Inicialización inteligente

├── init-existing.bat               # Para repositorios existentes

| Situación | Script Recomendado | Razón |├── dev-frontend.bat               # Desarrollo frontend

|-----------|-------------------|-------|├── check-ports.bat                # Verificador de puertos

| Proyecto completamente nuevo | `init-smart.bat` | Detecta automáticamente y crea Laravel |├── package.json                   # Dependencias Node.js

| Repositorio clonado de GitHub | `init-existing.bat` | Optimizado para Laravel existente |├── vite.config.js                 # Configuración Vite

| No estoy seguro | `init-smart.bat` | Es inteligente, detecta la situación |├── composer.json                  # Dependencias PHP

└── docker-compose/

### Qué pasa cuando se clona desde GitHub    ├── nginx/

    │   └── app.conf              # Configuración Nginx

1. **Laravel ya existe** en el repositorio    └── mysql/

2. **No necesitas** instalar Laravel de nuevo        └── my.cnf                # Configuración MySQL

3. **Solo necesitas** instalar dependencias (`composer install`)```

4. **Usa** `init-existing.bat` para máxima eficiencia

## 🔧 Comandos Útiles

### Por qué diferentes Dockerfiles

### **Para Proyectos Nuevos**

- **`Dockerfile`**: Para crear Laravel desde cero```powershell

- **`Dockerfile.existing`**: Optimizado para Laravel existente# Comandos Docker

  - Copia `composer.json` primero (mejor cache de Docker)docker-compose up -d

  - Instala dependencias de forma más eficientedocker-compose down

  - Maneja permisos apropiadamentedocker-compose logs -f



## Solución de Problemas# Comandos Laravel

docker-compose exec app php artisan [comando]

### Error "Could not open input file: artisan"docker-compose exec app bash

```powershell

# Si es proyecto nuevo# Comandos Frontend

.\init-smart.batdocker-compose exec node npm install

docker-compose exec node npm run dev

# Si es repositorio existente```

.\init-existing.bat

```### **Para Repositorios Existentes**

```powershell

### Puerto 3306 ocupado# Comandos Docker

- El proyecto usa puerto **3307** externamentedocker-compose -f docker-compose.existing.yml up -d

- MySQL interno sigue en puerto **3306**docker-compose -f docker-compose.existing.yml down

- Verifica puertos: `.\check-ports.bat`docker-compose -f docker-compose.existing.yml logs -f



### Contenedor Node.js con problemas# Comandos Laravel

```powershelldocker-compose -f docker-compose.existing.yml exec app php artisan [comando]

# Proyecto nuevodocker-compose -f docker-compose.existing.yml exec app bash

docker-compose restart node

# Comandos Frontend

# Repositorio existente  docker-compose -f docker-compose.existing.yml exec node npm install

docker-compose -f docker-compose.existing.yml restart nodedocker-compose -f docker-compose.existing.yml exec node npm run dev

``````



### Permisos en Windows## 🗃️ Configuración de Base de Datos

```powershell

# Dar permisos de ejecución a scripts```env

Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUserDB_CONNECTION=mysql

```DB_HOST=db

DB_PORT=3306

## Notas para RepositoriosDB_DATABASE=laravel

DB_USERNAME=laravel_user

### Al hacer commit, incluir:DB_PASSWORD=laravel_password

- `docker-compose.existing.yml````

- `Dockerfile.existing` 

- `init-existing.bat`## 🤔 **Preguntas Frecuentes**

- Todos los archivos de Laravel

- **No incluir** carpeta `vendor/` (está en `.gitignore`)### **¿Cuándo usar cada script?**



### Al clonar repositorio:| Situación | Script Recomendado | ¿Por qué? |

1. `git clone [repo]`|-----------|-------------------|-----------|

2. `cd [directorio]`| 🆕 Proyecto completamente nuevo | `init-smart.bat` | Detecta automáticamente y crea Laravel |

3. `.\init-existing.bat`| 📁 Repositorio clonado de GitHub | `init-existing.bat` | Optimizado para Laravel existente |

4. Proyecto listo para usar| 🤷 No estoy seguro | `init-smart.bat` | Es inteligente, detecta la situación |



## Instrucciones Paso a Paso### **¿Qué pasa cuando se clona desde GitHub?**



### Para Configuración Inicial (Primera vez)1. **Laravel ya existe** en el repositorio

2. **No necesitas** instalar Laravel de nuevo

1. **Verificar requisitos**3. **Solo necesitas** instalar dependencias (`composer install`)

   ```powershell4. **Usa** `init-existing.bat` para máxima eficiencia

   docker --version

   docker-compose --version### **¿Por qué diferentes Dockerfiles?**

   ```

- **`Dockerfile`**: Para crear Laravel desde cero

2. **Clonar o crear proyecto**- **`Dockerfile.existing`**: Optimizado para Laravel existente

   ```powershell  - Copia `composer.json` primero (mejor cache de Docker)

   # Si es nuevo  - Instala dependencias de forma más eficiente

   mkdir mi-proyecto-laravel  - Maneja permisos apropiadamente

   cd mi-proyecto-laravel

   ## 🐛 Solución de Problemas

   # Si es clonado

   git clone [repositorio]### **Error "Could not open input file: artisan"**

   cd [nombre-directorio]```powershell

   ```# Si es proyecto nuevo

.\init-smart.bat

3. **Ejecutar script apropiado**

   ```powershell# Si es repositorio existente

   # Para proyecto nuevo.\init-existing.bat

   .\init-smart.bat```

   

   # Para repositorio existente### **Puerto 3306 ocupado**

   .\init-existing.bat- El proyecto usa puerto **3307** externamente

   ```- MySQL interno sigue en puerto **3306**

- Verifica puertos: `.\check-ports.bat`

4. **Verificar instalación**

   - Abrir http://localhost:8080### **Contenedor Node.js con problemas**

   - Verificar que aparezca la página de Laravel```powershell

# Proyecto nuevo

### Para Desarrollo Diariodocker-compose restart node



1. **Iniciar servicios**# Repositorio existente  

   ```powershelldocker-compose -f docker-compose.existing.yml restart node

   # Proyecto nuevo```

   docker-compose up -d

   ### **Permisos en Windows**

   # Repositorio existente```powershell

   docker-compose -f docker-compose.existing.yml up -d# Dar permisos de ejecución a scripts

   ```Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser

```

2. **Desarrollo frontend (opcional)**

   ```powershell## 📝 Notas para Repositorios

   .\dev-frontend.bat

   ```### **Al hacer commit, incluir:**

- ✅ `docker-compose.existing.yml`

3. **Ejecutar comandos Artisan**- ✅ `Dockerfile.existing` 

   ```powershell- ✅ `init-existing.bat`

   docker-compose exec app php artisan migrate- ✅ Todos los archivos de Laravel

   docker-compose exec app php artisan make:controller [NombreController]- ❌ No incluir carpeta `vendor/` (está en `.gitignore`)

   ```

### **Al clonar repositorio:**

4. **Detener servicios**1. `git clone [repo]`

   ```powershell2. `cd [directorio]`

   docker-compose down3. `.\init-existing.bat`

   ```4. ¡Listo! 🎉



## Soporte## 🆘 Soporte



Si encuentras problemas:1. **Verifica Docker:** `docker --version`

2. **Verifica puertos:** `.\check-ports.bat`

1. **Verifica Docker:** `docker --version`3. **Revisa logs:** `docker-compose logs -f`

2. **Verifica puertos:** `.\check-ports.bat`4. **Reinicia contenedores:** `docker-compose down && docker-compose up -d`
3. **Revisa logs:** `docker-compose logs -f`
4. **Reinicia contenedores:** `docker-compose down && docker-compose up -d`
5. **En caso extremo:** `docker-compose down -v` (elimina datos de BD)