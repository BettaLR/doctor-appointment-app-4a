# Configuración del Proyecto

Aqui pondre las configuraciones realizadas al proyecto.

## 1. Configuración de la Base de Datos MySQL en Windows
- Se utilizó XAMPP para levantar los servicios de Apache y MySQL.
- Se accedió a PHPMyAdmin desde el panel de control de XAMPP para crear la base de datos llamada `appointment_db` con conjunto de caracteres UTF8MB4 para soportar acentos y caracteres especiales.
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

## 5. Funcionalidades Recientes Implementadas

### 5.1 Instalación y Configuración de Livewire
- Se instaló Livewire para crear componentes interactivos:
  composer require livewire/livewire
- Se publicaron los archivos de configuración de Livewire
- Se agregaron las directivas de Livewire en el layout principal

### 5.2 Componentes de Gestión de Perfil
Se crearon todos los componentes Livewire faltantes para la gestión completa del perfil de usuario:

- **UpdateProfileInformationForm**: Permite actualizar nombre y email del usuario
- **UpdatePasswordForm**: Permite cambiar la contraseña con validación
- **TwoFactorAuthenticationForm**: Gestiona la autenticación de dos factores
- **LogoutOtherBrowserSessionsForm**: Permite cerrar sesiones en otros navegadores
- **DeleteUserForm**: Permite eliminar la cuenta de usuario

### 5.3 Rutas y Navegación
- Se agregó la ruta `/profile` para acceder a la página de perfil
- Se configuró la navegación del admin panel con rutas funcionales
- Se implementó el sistema de rutas anidadas para el panel administrativo

### 5.4 Panel de Administración
- Se creó un dashboard administrativo funcional en `/admin`
- Se configuró el layout administrativo con sidebar y navegación
- Se implementó el sistema de navegación con estados activos

### 5.5 Personalización Visual
- Se cambió el título del panel de "Admin Panel" a "HealthCare"
- Se configuró el color del título a blanco para mejor contraste
- Se corrigió la ruta de la imagen del logo para usar la imagen correcta
- Se limpió el sidebar para mostrar únicamente la opción "Dashboard"

### 5.6 Corrección de Errores
- Se solucionaron todos los componentes Livewire faltantes que causaban errores 404
- Se corrigieron las rutas rotas en la navegación
- Se implementó la funcionalidad completa del sistema de perfiles
- Se verificó que todas las páginas carguen sin errores

### 5.7 Tecnologías Utilizadas
- **Laravel Jetstream**: Para autenticación y gestión de usuarios
- **Laravel Fortify**: Para funcionalidades de seguridad
- **Livewire**: Para componentes interactivos del frontend
- **Tailwind CSS**: Para estilos y diseño responsivo
- **Font Awesome**: Para iconografía
- **Flowbite**: Para componentes UI adicionales
