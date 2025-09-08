# Backend Test (Laravel + MongoDB)

Este proyecto implementa un backend de prueba técnica con **Laravel 12**, **MongoDB** y **JWT Authentication**.  

---

## Requisitos
- PHP 8.2+ (Como recomendación ocupar el de XAMPP debido a que ya tiene por default extensiones activadas)
- Composer
- MongoDB
- API Key de Google Places
- El archivo `.env` proporcionado ya incluye la variable `JWT_SECRET` necesaria para la autenticación con JWT y la variable `GOOGLE_MAPS_KEY`.
---

PHP y MongoDB:
Para que Laravel pueda conectarse a MongoDB es necesario tener instalada la extensión `php-mongodb`.

- Si usas XAMPP, asegúrate de descargar la versión de `php_mongodb.dll` que corresponda a tu versión de PHP desde: https://pecl.php.net/package/mongodb
- Copia el archivo `.dll` dentro de la carpeta `php/ext` de tu instalación.
- Activa la extensión agregando esta línea en tu `php.ini`:
```bash
extension=php_mongodb.dll
```
- Este proyecto fue desarrollado en un entorno local con PHP 8.2 y XAMPP.  
- La conexión con MongoDB fue probada usando MongoDB Compass.  
- Se recomienda Postman para probar los endpoints.

## Instalación

```bash
git clone https://github.com/AlexAntonioG/backend-test-bego.git
cd backend-test-bego
composer install
# NOTA: Agregar el archivo .env proporcionado antes de hacer el cambio de archivo .env
cp .env.example .env
php artisan key:generate
```

## Migraciones

```bash
php artisan migrate
```

## Levantar servidor

```bash
php artisan serve
```
Servidor disponible en: http://127.0.0.1:8000

## Autenticación
El sistema usa JWT para proteger endpoints.  
Registro/Login devuelven un token.  

## Nota sobre autenticación

La API implementa **JWT** para registro y login (`/api/register`, `/api/login`).  
En un proyecto real, todos los endpoints deberían estar protegidos con `auth:api` y requerir el token en el header:

```bash
Authorization: Bearer <token>
```

⚠️ **Importante:**  
Por cuestiones de tiempo en esta prueba, los demás endpoints (`users`, `trucks`, `orders`, `locations`) no están protegidos con JWT y se pueden consumir directamente.  
La base para protegerlos ya está configurada (guards, generación de tokens, etc.).

## Dominios implementados
### Users

- Registro y Login con JWT
- CRUD completo de usuarios

### Trucks
- CRUD de camiones
- Relación con User
- Aggregation para incluir datos del propietario

### Orders
- CRUD de órdenes
- Relación con User, Truck y Location (pickup/dropoff)
- Endpoint especial para cambiar el status
- Estados permitidos: created, in transit, completed

### Locations
- CRUD de ubicaciones
- Creación a partir de place_id de Google Places
- Obtención de address, latitude y longitude
- Validación para evitar duplicados (409 Conflict si ya existe)

## Experiencia

Durante el desarrollo seguí un proceso paso a paso por dominio , creando para cada uno:
- Migración (colección en MongoDB)
- Modelo (Eloquent adaptado a Mongo)
- Interfaz + Servicio (lógica de negocio)
- Binding en AppServiceProvider
- Controlador con try/catch
- Rutas en api.php

Obstáculos encontrados
- Nunca había trabajado con MongoDB en Laravel. Instalé el paquete correcto (mongodb/laravel-mongodb) e investigué cómo manejar ObjectId.
- También fue la primera vez que implementaba JWT en Laravel. Aprendí cómo generar tokens al registrar/login y cómo configurar el guard api para proteger endpoints con JWT ya que normalmente ocupaba la configuración default o Sactum con Laravel.
- En un inicio, las consultas no devolvían nada porque $unwind eliminaba los documentos si el lookup no encontraba coincidencias. La solución fue usar preserveNullAndEmptyArrays: true para que las órdenes se devolvieran aunque faltara algún ObjectId.

