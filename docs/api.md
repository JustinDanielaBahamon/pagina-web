# API REST

Contrato de la API que consume el frontend. Todas las rutas están bajo `/api/v1` y responden JSON.

En desarrollo: `http://localhost:8000/api/v1`.

## Reglas generales

| Tema | Regla |
|---|---|
| Versión | El prefijo `v1` permite publicar una `v2` sin romper el frontend existente |
| Autenticación | Los endpoints del catálogo son públicos. Los de cuenta y administración usarán Laravel Sanctum (próximas fases) |
| Límite | 120 peticiones por minuto por IP. Si se supera, responde `429 Too Many Requests` |
| Visibilidad | Solo se muestran productos con estado `active`, de categorías activas y con al menos una variante activa |
| Precios | Texto decimal con 2 cifras: `"350000.00"`. El frontend los formatea con `Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' })` |
| Imágenes | URL absoluta, lista para usar en `<img src>` |
| Stock | Nunca se expone la cantidad exacta: solo `in_stock` (más de 3), `low_stock` (1 a 3) o `out_of_stock` (0) |
| Errores | `404` con `{"message": "..."}`. `422` con `{"message": "...", "errors": {"campo": ["..."]}}` |

## Endpoints

| Método | Ruta | Uso |
|---|---|---|
| `GET` | [`/categories`](#get-categories) | Menú y tarjetas de categorías |
| `GET` | [`/products`](#get-products) | Catálogo con filtros, orden y paginación |
| `GET` | [`/products/{slug}`](#get-productsslug) | Detalle de un producto |
| `GET` | [`/filters`](#get-filters) | Colores y rango de precios disponibles |

---

### `GET /categories`

Categorías activas de primer nivel, en el orden del menú (`position`), con sus subcategorías activas.

```json
{
  "data": [
    {
      "id": 1,
      "name": "Hamacas",
      "slug": "hamacas",
      "description": null,
      "image_url": null,
      "products_count": 2,
      "children": []
    }
  ]
}
```

`products_count` cuenta solo productos visibles.

---

### `GET /products`

| Parámetro | Tipo | Ejemplo | Descripción |
|---|---|---|---|
| `category` | slug | `bolsos` | Productos de la categoría y de sus subcategorías. Si no existe, la lista sale vacía |
| `color` | slugs separados por coma | `rojo,azul` | Productos con alguna variante de esos colores |
| `min_price` | número ≥ 0 | `100000` | Productos con alguna variante desde ese precio |
| `max_price` | número ≥ `min_price` | `320000` | Productos con alguna variante hasta ese precio |
| `search` | texto (máx. 100) | `silla` | Busca en el nombre |
| `featured` | `1` / `0` | `1` | Solo destacados |
| `in_stock` | `1` / `0` | `1` | Solo productos con alguna variante disponible |
| `sort` | `featured`, `price_asc`, `price_desc`, `newest`, `name` | `price_asc` | Orden. Por defecto `featured`: destacados primero, luego por nombre |
| `page` | entero ≥ 1 | `2` | Página |
| `per_page` | 1 a 48 | `12` | Productos por página (por defecto 12) |

```json
{
  "data": [
    {
      "id": 3,
      "name": "Silla colgante",
      "slug": "silla-colgante",
      "short_description": "Silla colgante tejida a mano.",
      "category": { "name": "Sillas colgantes", "slug": "sillas-colgantes" },
      "price_from": "300000.00",
      "price_to": "350000.00",
      "is_featured": true,
      "in_stock": true,
      "image": {
        "url": "http://localhost:8000/storage/products/silla-colgante/silla-colgante-verde-oscuro-01.webp",
        "alt_text": "Silla colgante Verde oscuro"
      },
      "colors": [
        { "name": "Verde oscuro", "slug": "verde-oscuro", "hex": "#1F5135" },
        { "name": "Rayada roja", "slug": "rayada-roja", "hex": null }
      ]
    }
  ],
  "links": { "first": "…", "last": "…", "prev": null, "next": "…" },
  "meta": { "current_page": 1, "last_page": 1, "per_page": 12, "total": 9 }
}
```

- `price_from` / `price_to`: precio más bajo y más alto entre las variantes activas. Si son distintos, la tarjeta muestra "Desde $300.000".
- `image`: primera foto de la galería, o `null` si el producto no tiene fotos.
- `colors`: chips de color de la tarjeta. `hex` es `null` en los diseños (rayadas, multicolor).
- Los productos relacionados del detalle se piden aquí: `?category=sillas-colgantes&per_page=4`.

---

### `GET /products/{slug}`

```json
{
  "data": {
    "id": 3,
    "name": "Silla colgante",
    "slug": "silla-colgante",
    "short_description": "Silla colgante tejida a mano.",
    "description": "Silla colgante hecha a mano en algodón y orlón…",
    "specifications": [{ "label": "Material", "value": "Algodón y orlón" }],
    "category": { "id": 2, "name": "Sillas colgantes", "slug": "sillas-colgantes" },
    "price_from": "300000.00",
    "price_to": "350000.00",
    "is_featured": true,
    "in_stock": true,
    "options": [
      {
        "name": "Color",
        "slug": "color",
        "values": [{ "name": "Rojo", "slug": "rojo", "hex": "#C0302E" }]
      }
    ],
    "variants": [
      {
        "id": 41,
        "sku": "SIL-COLG-ROJO",
        "price": "300000.00",
        "availability": "in_stock",
        "is_default": false,
        "options": { "color": "rojo" }
      }
    ],
    "images": [
      {
        "id": 120,
        "url": "http://localhost:8000/storage/products/silla-colgante/silla-colgante-rojo-01.webp",
        "alt_text": "Silla colgante Rojo",
        "variant_id": 41
      }
    ]
  }
}
```

- `options`: solo los valores que ofrece este producto, en el orden configurado.
- `variants[].price`: precio final de la variante (el suyo o el del producto).
- `variants[].options`: une la variante con los valores de `options` por su `slug`.
- `images[].variant_id`: permite mostrar las fotos del color elegido. Es `null` en las fotos generales.
- `404` si el producto no existe o no está visible.

---

### `GET /filters`

| Parámetro | Ejemplo | Descripción |
|---|---|---|
| `category` | `hamacas` | Limita los filtros a esa categoría. `404` si no existe |

```json
{
  "data": {
    "colors": [{ "name": "Rojo", "slug": "rojo", "hex": "#C0302E", "products_count": 2 }],
    "price": { "min": "50000.00", "max": "350000.00" }
  }
}
```

Solo incluye colores con productos visibles. `products_count` cuenta productos, no variantes. Con el catálogo vacío, `price` tiene `min` y `max` en `null`.

## Implementación

| Pieza | Ubicación |
|---|---|
| Rutas | `backend/routes/api.php` |
| Límite de peticiones | `backend/app/Providers/AppServiceProvider.php` |
| Controladores | `backend/app/Http/Controllers/Api/V1/` |
| Validación del catálogo | `backend/app/Http/Requests/Api/V1/ProductIndexRequest.php` |
| Forma del JSON | `backend/app/Http/Resources/Api/V1/` |
| Filtros y orden | Scopes de `backend/app/Models/Product.php` |
| Pruebas | `backend/tests/Feature/Api/V1/` |

Las relaciones se cargan con anticipación (eager loading). Hay una prueba que verifica que el número de consultas del listado no crece con la cantidad de productos.
