# Backend (Laravel)

API REST de la tienda, construida con **Laravel 13**. La instalación está en [docs/installation.md](../docs/installation.md).

## Carpetas principales

| Carpeta | Responsabilidad |
|---|---|
| `app/Models/` | Modelos de Eloquent: cada clase representa una tabla y sus relaciones |
| `app/Http/Controllers/` | Reciben la petición HTTP, llaman a la lógica y devuelven la respuesta. Deben ser delgados |
| `app/Http/Requests/` | Form Requests: validan los datos de entrada antes de llegar al controlador |
| `app/Http/Resources/` | API Resources: definen la forma del JSON que devuelve la API |
| `app/Policies/` | Reglas de autorización: quién puede ver, crear, editar o eliminar cada recurso |
| `app/Services/` | Lógica de negocio que no pertenece a un solo modelo, como calcular un pedido. Solo cuando aporta claridad |
| `bootstrap/app.php` | Configuración de rutas, middleware y manejo de errores |
| `config/` | Configuración de la aplicación. Lee sus valores de `.env` |
| `database/migrations/` | Historial versionado de la estructura de la base de datos |
| `database/seeders/` y `database/factories/` | Datos iniciales y datos de prueba |
| `routes/` | Definición de rutas. Las de la API están en `routes/api.php` (contrato en [docs/api.md](../docs/api.md)) |
| `app/Enums/` | Valores fijos del negocio: estados de producto, disponibilidad de stock |
| `storage/` | Archivos generados: logs, caché, imágenes subidas |
| `tests/` | Pruebas automatizadas (`Feature/` prueba endpoints completos, `Unit/` prueba piezas aisladas) |
| `public/` | Única carpeta expuesta al servidor web. Su punto de entrada es `index.php` |

## Comandos frecuentes

```bash
php artisan serve          # servidor de desarrollo en http://localhost:8000
php artisan migrate        # aplicar migraciones pendientes
php artisan test           # ejecutar las pruebas
php artisan route:list     # ver todas las rutas
```
