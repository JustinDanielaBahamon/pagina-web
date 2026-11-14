# Modelo de datos

Tablas de la base de datos, cómo se relacionan y por qué se diseñaron así. Se irá ampliando con cada funcionalidad (pedidos, clientes, pagos…).

## Catálogo

```
categories ─┐ (subcategorías: parent_id)
            │ 1
            ▼ N
         products ──1:N──► product_images
            │ 1                 ▲ (opcional: foto de un color)
            ▼ N                 │
      product_variants ─────────┘
            │ N
            ▼ N   (tabla pivote: option_value_product_variant)
      option_values ──N:1──► options   (Color, Talla…)
```

| Tabla | Modelo | Qué guarda |
|---|---|---|
| `categories` | `Category` | Categorías del menú. Admiten subcategorías con `parent_id` |
| `products` | `Product` | Lo que el cliente ve como un producto: nombre, descripción, ficha técnica, precio base y estado |
| `product_variants` | `ProductVariant` | Lo que realmente se compra: SKU, stock y precio propio opcional (por ejemplo, cada color) |
| `options` | `Option` | Características que distinguen variantes: Color, Talla… |
| `option_values` | `OptionValue` | Valores de cada característica: Rojo, Azul… con su color en hexadecimal |
| `option_value_product_variant` | (pivote) | Qué valores tiene cada variante |
| `product_images` | `ProductImage` | Galería del producto, en orden. Una foto puede asociarse a una variante |

## Reglas del negocio

| Regla | Dónde se garantiza |
|---|---|
| Todo producto tiene al menos una variante | En la lógica de la aplicación. El carrito y los pedidos siempre apuntan a una variante |
| Cada producto tiene exactamente una variante por defecto | Seeder y, más adelante, el servicio de creación de productos |
| El precio que paga el cliente es el de la variante o, si está vacío, el del producto | `ProductVariant::effective_price` |
| `slug` de categorías y productos, y `sku` de variantes, son únicos | Índices únicos en la base de datos |
| Solo los productos `active` se muestran en la tienda | Scope `Product::active()` |

## Qué pasa al borrar

| Si se borra… | Efecto | Motivo |
|---|---|---|
| Una categoría con productos o subcategorías | **Se impide** (`restrict`) | Evita dejar productos sin categoría |
| Un producto | Se marca como borrado (`deleted_at`) y se puede restaurar | Un error se recupera y los pedidos antiguos siguen encontrándolo |
| Un producto, definitivamente | Se borran sus variantes e imágenes (`cascade`) | No tienen sentido sin el producto |
| Una variante | La imagen asociada se queda en el producto, sin variante (`set null`) | La foto sigue sirviendo para la galería |
| Un valor de opción que usa alguna variante | **Se impide** (`restrict`) | No se pierde la información de qué color es cada variante |

## Decisiones de diseño

| Decisión | Motivo |
|---|---|
| Variantes en tabla propia | Cada color tiene su propio stock, SKU, foto y a veces precio |
| Opciones normalizadas en lugar de una columna `color` | La misma estructura sirve para cualquier tienda (talla, material) y permite filtrar el catálogo |
| Ficha técnica en JSON (`specifications`) | Cambia según la categoría y solo se muestra, no se filtra |
| Precio en `decimal(12,2)` | Evita los errores de redondeo de `double` |
| Estado como texto (`draft`, `active`, `archived`) con el enum `App\Enums\ProductStatus` | Se lee solo y admite borradores |

## Catálogo de demostración

`Database\Seeders\CatalogSeeder` carga las 6 categorías y 7 productos del sitio original, con 30 variantes por color:

| Producto | Variantes | Precio |
|---|---|---|
| Hamaca con palo | 8 colores | $350.000 |
| Hamaca clásica | 5 colores | $350.000 |
| Silla colgante | 9 colores | $300.000 (rayada y colombiana: $350.000) |
| Columpio | 4 colores | $350.000 |
| Cuna colgante | 1 | $250.000 |
| Bolso tejido | 2 colores | $60.000 |
| Poncho | 1 | $50.000 |

- Los precios salen de las páginas de categoría del sitio original.
- Las descripciones son textos neutros para editar luego desde el panel.
- El stock de demostración es de 5 unidades por variante.
- Se puede ejecutar varias veces sin duplicar datos.

```bash
php artisan migrate:fresh --seed            # borrar todo y cargar de nuevo
php artisan db:seed --class=CatalogSeeder   # cargar solo el catálogo
```
