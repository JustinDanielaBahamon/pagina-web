# Instalación del entorno de desarrollo

Guía para levantar el proyecto desde cero en Windows.

## 1. Requisitos

| Herramienta | Versión | Para qué sirve |
|---|---|---|
| [Laravel Herd](https://herd.laravel.com/windows) | Última | Instala PHP 8.3+ y Composer |
| [Docker Desktop](https://www.docker.com/products/docker-desktop/) | Última | Ejecuta MySQL en un contenedor |
| [Git](https://git-scm.com/) | 2.x | Control de versiones |
| [Node.js](https://nodejs.org/) | 24 LTS | Frontend Angular (Fase 3) |

Versiones con las que se probó: PHP 8.5.12, Composer 2.11.1, Laravel 13.42, MySQL 8.4.13 y Docker 29.8.

Verifica en una terminal nueva:

```bash
php -v
composer -V
docker --version
```

> XAMPP puede seguir instalado: el proyecto no lo usa. Como MySQL corre en el puerto **3307**, no choca con la MariaDB de XAMPP (3306). Si tu computador tiene poca RAM, apaga XAMPP mientras trabajas en este proyecto.

## 2. Clonar el repositorio

```bash
git clone https://github.com/JustinDanielaBahamon/pagina-web.git
cd pagina-web
git switch develop
```

## 3. Base de datos (MySQL en Docker)

Con Docker Desktop abierto, desde la raíz del repositorio:

```bash
docker compose up -d
```

El archivo [`compose.yaml`](../compose.yaml) crea un contenedor con MySQL 8.4:

| Dato | Valor por defecto |
|---|---|
| Host | `127.0.0.1` (solo accesible desde tu computador) |
| Puerto | `3307` |
| Base de datos | `store` |
| Usuario / contraseña | `store` / `secret` |
| Contraseña de root | `root` |

Estas credenciales son **solo para desarrollo local**. Para cambiarlas, crea un archivo `.env` en la raíz con `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, `DB_ROOT_PASSWORD` o `DB_FORWARD_PORT`. Ese archivo no se sube al repositorio.

Los datos se guardan en un volumen de Docker y sobreviven aunque apagues el contenedor.

Comandos útiles:

```bash
docker compose ps          # ver el estado (debe decir "healthy")
docker compose stop        # apagar MySQL
docker compose start       # encenderlo de nuevo
docker compose down -v     # BORRAR el contenedor y todos los datos
```

## 4. Backend (Laravel)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

- `composer install` descarga las dependencias en `vendor/`. Esa carpeta no se sube al repositorio.
- `.env` guarda la configuración local: conexión a la base, clave de la aplicación, etc. **Nunca se sube.** `.env.example` es la plantilla que sí se versiona.
- `key:generate` crea la clave con la que Laravel cifra sesiones y cookies.
- `migrate` crea las tablas en MySQL.

Para levantar el servidor de desarrollo:

```bash
php artisan serve
```

Abre http://localhost:8000/up: si muestra la página de estado, todo funciona.

## 5. Pruebas

```bash
cd backend
php artisan test
```

Las pruebas usan SQLite en memoria (configurado en `phpunit.xml`). Así son rápidas y no tocan los datos de MySQL.

## Problemas comunes

| Síntoma | Solución |
|---|---|
| `php` o `composer` no se reconocen | Cierra y vuelve a abrir la terminal después de instalar Herd |
| `SQLSTATE[HY000] [2002]` al migrar | MySQL no está encendido: abre Docker Desktop y ejecuta `docker compose up -d` |
| `Access denied for user` | Las credenciales de `backend/.env` no coinciden con las de `compose.yaml` |
| El puerto 3307 está ocupado | Crea un `.env` en la raíz con `DB_FORWARD_PORT=3308` y cambia `DB_PORT` en `backend/.env` |
