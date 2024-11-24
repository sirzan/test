# Instalación del Proyecto Laravel

Sigue los pasos a continuación para instalar y configurar el proyecto en tu entorno local.

## Requisitos Previos

Asegúrate de tener instalados los siguientes programas en tu máquina:

- **PHP** (versión 8.1 o superior)
- **Composer**
- **Node.js** (con npm)
- **MySQL** o **MariaDB** 

## Pasos para la Instalación

1. **Clona el repositorio**: Si aún no tienes el proyecto en tu máquina, clónalo con el siguiente comando:  
   `git clone <URL_DEL_REPOSITORIO>`  
   Luego navega al directorio del proyecto con:  
   `cd <nombre_del_directorio>`

2. **Instala las dependencias de Composer**: Ejecuta el siguiente comando para instalar las dependencias de PHP del proyecto:  
   `composer install`

3. **Genera las migraciones de la base de datos**: Ejecuta las migraciones para crear las tablas en la base de datos:  
   `php artisan migrate`

4. **Genera la clave de la aplicación**: Genera la clave de la aplicación para la seguridad de tu proyecto:  
   `php artisan key:generate`

5. **Genera las claves de Passport (autenticación Passport)**: Si el proyecto utiliza **Laravel Passport** para la autenticación de usuarios, ejecuta el siguiente comando:  
   `php artisan passport:keys`

6. **para poblar las tablas con datos iniciales**: para insertar un usuario admin y un factory de usuario con la misma contraseña:
   `php artisan db:seed`
   `usuario: admin@admin`
   `clave: 12345678`

7. **Instala las dependencias de Node.js**: Instala las dependencias de frontend con npm:  
   `npm install`

8. **Compila los archivos de frontend**: Ejecuta el siguiente comando para compilar los archivos de frontend:  
   `npm run dev`

9. **Inicia el servidor de desarrollo**: Finalmente, inicia el servidor de desarrollo de Laravel con:  
   `php artisan serve`  
   Esto arrancará el servidor en `http://localhost:8000`.

## ¡Listo!

Ahora puedes acceder a tu aplicación Laravel en tu navegador y comenzar a trabajar en ella.