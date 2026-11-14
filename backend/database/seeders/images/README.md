# Imágenes del catálogo de demostración

Fotos reales de los productos, tomadas del sitio original (`legacy/img`). Están convertidas y ordenadas para que el catálogo de demostración no dependa de `legacy/`.

## Organización

```
images/
├── products/<producto>/<producto>-<color>-<nn>.webp   fotos de cada producto
└── site/                                              fotos de la tienda (inicio, Nosotros)
    ├── hero-01.webp … hero-03.webp
    └── store-01.webp … store-04.webp
```

- `<producto>` es el `slug` del producto: `hamaca-con-palo`, `silla-colgante`…
- `<color>` es el slug del color: `azul-claro`, `rayada-roja`… Los productos sin variantes de color (bolso rayado, poncho) no lo llevan.
- `<nn>` numera las fotos de un mismo color: `01` es la foto con fondo limpio y las siguientes son fotos en la tienda.

## Inventario

[`../data/product-images.csv`](../data/product-images.csv) registra cada foto:

| Columna | Contenido |
|---|---|
| `file` | Nombre del archivo en esta carpeta |
| `product` | Producto al que pertenece (`site` para las fotos de la tienda) |
| `color` | Color o diseño. Cada color distinto se convierte en una variante del producto |
| `kind` | `studio` (fondo limpio), `lifestyle` (en la tienda), `hero` o `store` |
| `source` | Archivo original en `legacy/img` |

`CatalogSeeder` lee este archivo, crea una variante por color, copia las fotos a `storage/app/public/products/` y las registra en `product_images` en el orden de la galería.

## Formato

WebP, con 1600 px como máximo en el lado más largo y calidad 80. Se guardan **sin recortar**: la tienda las muestra completas dentro de un marco 4:5 (ver [design system](../../../../docs/design-system.md)).

## Imágenes del sitio original que no se usan

Siguen en `legacy/img`, pero no se incluyeron:

| Motivo | Archivos |
|---|---|
| Duplicados exactos | `imgH/H-14.jpg`, `imgSC/SC7.jpg`, `imgSC/IMG-20240831-WA0091.jpg`, `imgSC/IMG-20240831-WA0092.jpg`, `LOGO HAMACAS - copia.jpg` |
| Probablemente tomadas de internet (derechos de autor) | `hamaca2.jpeg`, `hamaca3.jpg`, `hamacas.jpg`, `Medidas.png`, `f6608c8387cc76247c678f3c53315656.jpg`, `Una-silla-colgante-deberia-ser-asi-de-grande.jpg`, `fotoN.png` |
| Plantillas vacías | `imagen1.png`, `imagen2.png`, `imagen3.png` |
| Íconos de la interfaz anterior | `657-6575929_fas-fa-angle-double-right-hd-png-download.png`, `carrito.jpeg`, `font awesome whatsapp.png`, `logo inicio.png`, `logos.jpg`, `salida.png`, `user.svg` |
| Logos | `LOGO HAMACAS.jpg` (ya está en `docs/brand/`), `ARTESANIAS1.png` (no es el logo oficial) |
