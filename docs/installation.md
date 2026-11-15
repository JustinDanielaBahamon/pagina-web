# Instalación del entorno de desarrollo

Guía para levantar el proyecto desde cero en Windows.

## 1. Requisitos

| Herramienta | Versión | Para qué sirve |
|---|---|---|
| [Laravel Herd](https://herd.laravel.com/windows) | Última | Instala PHP 8.3+ y Composer |
| [Docker Desktop](https://www.docker.com/products/docker-desktop/) | Última | Ejecuta MySQL en un contenedor |
| [Git](https://git-scm.com/) | 2.x | Control de versiones |
| [Node.js](https://nodejs.org/) | 26 LTS (mínimo 24.15) | Frontend Angular |

Versiones con las que se probó: PHP 8.5.12, Composer 2.11.1, Laravel 13.42, MySQL 8.4.13, Docker 29.8, Node 26.13.1, npm 11.20 y Angular 22.2.

Verifica en una terminal nueva:

```bash
php -v
composer -V
docker --version
node -v
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
php artisan storage:link
php artisan migrate --seed
```

- `composer install` descarga las dependencias en `vendor/`. Esa carpeta no se sube al repositorio.
- `.env` guarda la configuración local: conexión a la base, clave de la aplicación, etc. **Nunca se sube.** `.env.example` es la plantilla que sí se versiona.
- `key:generate` crea la clave con la que Laravel cifra sesiones y cookies.
- `storage:link` crea el enlace `public/storage`, por donde se sirven las fotos de los productos.
- `migrate --seed` crea las tablas en MySQL y carga el catálogo de demostración (ver [data-model.md](data-model.md)).

Para levantar el servidor de desarrollo:

```bash
php artisan serve
```

Abre http://localhost:8000/up: si muestra la página de estado, todo funciona.

## 5. Frontend (Angular)

En otra terminal, con Laravel corriendo:

```bash
cd frontend
npm install
npm start
```

Abre http://localhost:4200. El servidor de desarrollo reenvía `/api` y `/storage` a Laravel (`proxy.conf.json`), así que el navegador ve todo como un solo sitio y no hace falta configurar CORS.

Si la página dice que no se pudo conectar con la API, revisa que `php artisan serve` siga corriendo en el puerto 8000.

## 6. Pruebas

```bash
cd backend
php artisan test
```

Las pruebas del backend usan SQLite en memoria (configurado en `phpunit.xml`). Así son rápidas y no tocan los datos de MySQL.

```bash
cd frontend
npm test
npm run lint
```

## Problemas comunes

| Síntoma | Solución |
|---|---|
| `node -v` muestra una versión menor a 24.15 | Actualiza Node desde https://nodejs.org o con `winget upgrade OpenJS.NodeJS.LTS`, y abre una terminal nueva |
| `php` o `composer` no se reconocen | Cierra y vuelve a abrir la terminal después de instalar Herd |
| `SQLSTATE[HY000] [2002]` al migrar | MySQL no está encendido: abre Docker Desktop y ejecuta `docker compose up -d` |
| `Access denied for user` | Las credenciales de `backend/.env` no coinciden con las de `compose.yaml` |
| El puerto 3307 está ocupado | Crea un `.env` en la raíz con `DB_FORWARD_PORT=3308` y cambia `DB_PORT` en `backend/.env` |
