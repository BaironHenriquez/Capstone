-- Script de inicialización para MySQL
-- Crea base de datos y usuario específicos para el proyecto Capstone

-- Crear base de datos principal
CREATE DATABASE IF NOT EXISTS capstone_laravel;

-- Crear base de datos de testing
CREATE DATABASE IF NOT EXISTS capstone_laravel_testing;

-- Crear usuario específico para el proyecto
CREATE USER IF NOT EXISTS 'capstone_user'@'%' IDENTIFIED BY 'capstone_password_2025';

-- Otorgar permisos completos al usuario en las bases de datos del proyecto
GRANT ALL PRIVILEGES ON capstone_laravel.* TO 'capstone_user'@'%';
GRANT ALL PRIVILEGES ON capstone_laravel_testing.* TO 'capstone_user'@'%';

-- Aplicar cambios
FLUSH PRIVILEGES;

-- Mostrar configuración aplicada
SELECT User, Host FROM mysql.user WHERE User = 'capstone_user';
SHOW DATABASES LIKE 'capstone_%';