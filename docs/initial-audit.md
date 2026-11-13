# Auditoría inicial

Fecha: 12 de noviembre de 2026. Analiza el proyecto original guardado en [`legacy/`](../legacy/README.md).

## 1. Arquitectura existente

| Aspecto | Estado |
|---|---|
| Patrón | Páginas PHP sueltas que mezclan HTML, CSS, JavaScript y SQL. No hay capas ni enrutador. |
| Catálogo | Escrito a mano en el HTML. Unas 60 páginas de producto casi idénticas (~300 líneas cada una). La base de datos no alimenta la tienda. |
| Carrito | En `localStorage`. El precio lo envía el navegador (`data-price`). |
| Checkout | Hay dos versiones y ninguna funciona. `comprar.php` inserta en columnas y en una tabla (`facturas`) que no existen. `hamaca/pagar.php` incluye una ruta de conexión equivocada. |
| Administración | CRUD de productos, clientes y usuarios con `mysqli` y SQL armado concatenando texto. |
| Estilos | Bootstrap 4.5.2, 5.2.3 y 5.3.0 cargados a la vez; Font Awesome 4.5, 5.15 y 6.0; siete familias tipográficas. |
| Base de datos | MariaDB 10.1/10.4, sin claves foráneas, con `latin1` mezclado con `utf8mb4`. |

## 2. Problemas encontrados

### Seguridad (críticos)

1. El panel `administrador/` no comprueba la sesión: cualquiera puede entrar escribiendo la URL.
2. Inyección SQL en `productos.php`, `usuarios.php`, `clientes.php` y `pagar.php`.
3. Contraseñas guardadas en texto plano.
4. La subida de imágenes acepta cualquier tipo de archivo, incluido `.php` (ejecución remota de código).
5. El precio sale del navegador, así que se puede manipular antes de comprar.
6. XSS: los datos se imprimen sin escapar (`htmlspecialchars`).
7. No hay protección CSRF y hay acciones destructivas por GET (eliminar, cambiar estado).

### Funcionamiento

- El checkout no guarda pedidos.
- `factura.cod_cliente` guarda el número de documento en vez del id del cliente, y todos los totales quedaron en 0.
- `modelo2.php` muestra una hamaca, pero la agrega al carrito como "BOLSO5" con precio `60.000`, que `parseFloat` interpreta como 60.
- Formato de precios inconsistente (`$350000` y `$350.000`).
- Textos dañados por la mezcla de codificaciones ("Algod?n").
- Enlaces a recursos que no existen (`../../css/`, `../css/`, `img/imgSC/SC27.jpg`, `sliderH.css`).

### Deuda técnica

- Código duplicado: una página por producto en lugar de una plantilla.
- Carpetas y archivos repetidos (`hamaca/`, `archivos/` frente a `img/`, varios dumps SQL).
- Ruta del proyecto fija en el código (`/hamacas sin/`).
- `lang="en"` en páginas en español.
- Unos 27 MB de imágenes sin optimizar.
- El formulario de contacto depende de un servicio externo (formsubmit.co).

### Diseño y usabilidad

- El logotipo oficial es una flor rosa de acuarela con bordes menta y letras en script negras. El sitio usa lila (`#C8A2C8`) y morado (`#800080`), que no pertenecen a la marca.
- El botón principal (texto blanco sobre `#C8A2C8`) tiene un contraste de 2,22:1 y no cumple WCAG AA (mínimo 4,5:1).
- Barra superior que cambia de mensaje cada 3 segundos y distrae.
- La división de menús entre "Productos" y "Artesanías" es arbitraria. No hay búsqueda ni filtros.
- El logo solo existe como JPG con fondo blanco.
- El panel de administración usa una plantilla oscura genérica.

## 3. Arquitectura objetivo

```
Angular (SPA) ──HTTP/JSON──► Laravel (API REST /api/v1) ──Eloquent──► MySQL
 tienda + admin
```

- **Backend Laravel (MVC como API):** Controllers delgados, Form Requests para validar, API Resources para las respuestas, Policies para autorizar y Services solo donde haya lógica de negocio real (cálculo de pedidos, stock, pagos).
- **Autenticación:** Laravel Sanctum en modo SPA (cookies y protección CSRF). Es la opción oficial para una SPA del mismo dominio y evita guardar tokens en `localStorage`.
- **Frontend Angular por funcionalidades:** `core/` (autenticación, interceptores, guards), `shared/` (componentes de interfaz, pipes), `features/` (catálogo, carrito, checkout, cuenta, admin) y `models/` (contratos de la API).
- **Una sola aplicación Angular** para la tienda y el panel. El admin es un área con carga diferida (lazy loading), con su propio layout y guard. Así comparten modelos, servicios y design system sin mantener dos proyectos.
- **Reutilizable:** nombre, logo, contacto, categorías y métodos de pago se configuran desde el panel (`store_settings`) en lugar de estar escritos en el código.

## 4. Estrategia de base de datos

Tablas en inglés con convenciones de Laravel, creadas con migraciones, `utf8mb4` y claves foráneas:

| Tabla | Propósito |
|---|---|
| `users` | Administradores, personal y clientes, con columna `role`. Contraseñas con hash (bcrypt/argon2). |
| `categories` | Categorías con `parent_id` y `slug`. |
| `products` | `category_id`, `name`, `slug`, `sku`, `price` (`DECIMAL(12,2)`), `stock`, `status`. |
| `product_images` | Varias imágenes por producto, con orden. |
| `addresses` | Direcciones de envío. |
| `orders` / `order_items` | Pedido con copia del nombre y precio de cada producto al momento de la compra. Permite compras de invitados (`user_id` nulo). |
| `payments` | Método, estado y referencia de la pasarela. |
| `store_settings` | Configuración de la tienda. |

- Las variantes de producto (colores) se evaluarán en una fase posterior.
- Los permisos empiezan con `role` + Policies. Un paquete de permisos solo se agrega si hace falta un control más fino.
- **Migración de datos:** solo los productos y categorías del sitio original, como catálogo de demostración. Los clientes, facturas y usuarios eran datos de prueba y no se migran.

## 5. Estrategia de migración

No se traduce archivo por archivo: se **reconstruye por funcionalidad** usando el sitio original como especificación.

1. Documentar qué hace cada pantalla original y qué datos usa.
2. Construirla en Laravel + Angular, con pruebas.
3. Verificarla contra el comportamiento original.
4. Marcarla como migrada.

Las ~60 páginas de producto se reemplazan por una sola ruta (`/productos/:slug`) alimentada por la API.

## 6. Plan por fases

| Fase | Contenido |
|---|---|
| 0. Repositorio | `.gitignore`, original en `legacy/` sin datos personales, documentación inicial, rama `qa` |
| 1. Diseño | Design system (tokens), estructura de las páginas de la tienda y del admin, aprobación |
| 2. Backend base | Laravel, migraciones, seeders, autenticación con Sanctum, API de categorías y productos, pruebas |
| 3. Frontend base | Angular, `core/` y `shared/`, tokens visuales, catálogo y detalle de producto |
| 4. Carrito y checkout | Precio y stock calculados en el servidor, pedidos, correo de confirmación |
| 5. Panel admin | Dashboard, productos, categorías, pedidos, clientes, usuarios, configuración |
| 6. Cuenta del cliente | Registro, perfil, historial de pedidos |
| 7. Pagos | Integración con una pasarela colombiana (por definir) |
| 8. QA y despliegue | Endurecimiento de seguridad, optimización de imágenes, hosting |

## 7. Riesgos

- **Versión de PHP:** Laravel 13 requiere PHP 8.3 o superior y XAMPP trae 8.2. Hay que actualizar el entorno.
- **Curva de aprendizaje:** dos frameworks nuevos a la vez. Se mitiga con fases pequeñas y documentación.
- **SEO:** una SPA indexa mal las fichas de producto. Se evaluará Angular SSR en la Fase 3.
- **Hosting:** Laravel necesita un hosting con PHP 8.3+ y Composer.
- **Pagos:** la pasarela requiere cuenta de comercio y pruebas en sandbox.
- **Datos personales:** el repositorio es público. Ver [git-workflow.md](git-workflow.md#qué-nunca-se-sube-al-repositorio).

## 8. Versiones recomendadas

| Herramienta | Versión | Motivo |
|---|---|---|
| PHP | 8.4 (mínimo 8.3) | Requisito de Laravel 13 |
| Laravel | 13.x | Versión estable con soporte |
| Composer | 2.x | Gestor oficial de dependencias de PHP |
| MySQL | 8.4 LTS (Docker) | Soporte a largo plazo. MariaDB 10.4 ya no tiene soporte |
| Node.js | 24 LTS | Compatible con Angular actual |
| Angular | La versión estable vigente al iniciar la Fase 3 | Se publica una mayor cada 6 meses |
| Pruebas | Pest (backend), Vitest (frontend) | Opciones por defecto de cada framework |
| Interfaz | SCSS + variables CSS propias + Angular CDK | Identidad propia sin plantilla genérica. CDK da accesibilidad sin imponer estilos |
