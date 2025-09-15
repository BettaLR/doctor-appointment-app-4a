# Configuración del Proyecto

Este documento resume las configuraciones realizadas para actualizar el proyecto en un entorno Windows, incluyendo la configuración de la base de datos MySQL, el idioma en español, la zona horaria y la funcionalidad de foto de perfil.

## 1. Configuración de la Base de Datos MySQL en Windows
- Se utilizó XAMPP para levantar los servicios de Apache y MySQL.
- Se accedió a PHPMyAdmin desde el panel de control de XAMPP para crear la base de datos llamada `appointment_db` con conjunto de caracteres UTF8MB4 para soportar acentos y caracteres especiales.
- Se creó un usuario llamado `laravel` con contraseña `laravel123` y se le otorgaron todos los privilegios sobre la base de datos.
- En el archivo `.env` del proyecto se configuraron las variables para conectar con MySQL:
  DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=appointment_db DB_USERNAME=laravel DB_PASSWORD=laravel123
- Se ejecutó el comando `php artisan migrate` para crear las tablas necesarias en la base de datos.
- Se verificó en PHPMyAdmin que las tablas se crearon correctamente.

## 2. Configuración del Idioma en Español
- Se instaló el paquete `laravellang/common` con Composer:
  composer require laravellang/common
- Se agregó el idioma español con:
  php artisan lang:add es
- En el archivo `.env` se cambió la configuración del idioma a español:
  APP_LOCALE=es
- Se verificó que la aplicación mostrara los textos y mensajes en español al ejecutar `php artisan serve` y abrir la aplicación en el navegador.

## 3. Configuración de la Zona Horaria
- En el archivo `config/app.php` se modificó la zona horaria a:
'timezone' => 'America/Merida', Esto asegura que las fechas y horas se manejen correctamente según la zona horaria local.

## 4. Funcionalidad de Foto de Perfil
En el archivo config/jetstream.php se descomentó la línea que habilita la funcionalidad de foto de perfil:

Features::profilePhotos(),
En el archivo .env se cambió la configuración del sistema de archivos para que las fotos se almacenen en la carpeta pública:

FILESYSTEM_DISK=public
Se verificó que al registrar o editar un usuario, apareciera la opción para subir una foto de perfil, y que esta se guardara correctamente en la carpeta public/storage.
