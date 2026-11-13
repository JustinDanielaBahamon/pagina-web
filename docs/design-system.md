# Design system

Estado: **aprobado en la Fase 1**. Se implementa en Angular en la Fase 3.

## 1. Dirección visual: artesanal premium

- **La fotografía es la protagonista.** Los productos ya tienen mucho color. La interfaz usa marfil y beige para enmarcarlos sin competir con ellos.
- **Paleta cálida y sobria:** vino, terracota, beige y marfil transmiten calidad, tradición y trabajo hecho a mano.
- **Elegancia con mesura:** pocos colores fuertes, mucho espacio en blanco y títulos en serif. Nada de efectos llamativos.
- **Coherencia:** cada pantalla usa los mismos tokens. No se escriben colores, tamaños ni espacios sueltos en los componentes.

## 2. Identidad de marca

| Elemento | Definición |
|---|---|
| Nombre oficial | **Hamacas de Tejidos Ortega** (el que aparece en el logo) |
| Logo principal | [`brand/logo-primary.png`](brand/logo-primary.png): flor rosa de acuarela con el nombre en script, fondo transparente |
| Tipografía del nombre | **Kaushan Script** (Google Fonts, licencia OFL) |

### Versiones del logo

| Versión | Uso | Estado |
|---|---|---|
| Principal (flor + nombre) | Pie de página, inicio de sesión, correos, documentos | Lista (`logo-primary.png`) |
| Horizontal (solo el nombre) | Encabezado de la tienda y del admin | Se construye en Angular como **texto real** en Kaushan Script, color `ink-900`. Así se ve nítido en cualquier tamaño y es accesible |
| Ícono / favicon | Pestaña del navegador, acceso directo en móviles | **Monograma "TO"** en Kaushan Script, color `ivory-50` sobre fondo `wine-700`, esquinas redondeadas. Archivos en [`brand/`](brand/) |

### Archivos del ícono

| Archivo | Uso |
|---|---|
| `favicon.ico` (16, 32 y 48 px) | Pestaña del navegador |
| `favicon-32.png` | Navegadores modernos |
| `apple-touch-icon.png` (180 px) | Acceso directo en iPhone |
| `icon-192.png` y `icon-512.png` | Acceso directo en Android |

El favicon tiene las esquinas redondeadas. Los íconos de iPhone y Android son cuadrados porque cada sistema aplica su propia forma.

### Reglas de uso
- Usar el logo solo sobre fondos claros (`ivory-50`, `beige-200`, blanco). El texto del logo es negro y se pierde sobre vino o terracota.
- Ancho mínimo del logo principal: 120 px. Por debajo de ese tamaño el nombre deja de leerse; ahí se usa la versión horizontal.
- Dejar alrededor un espacio libre de al menos la mitad de la altura de la palabra "Hamacas".
- No deformarlo, no cambiarle los colores, no agregarle sombras ni ponerlo sobre fotografías recargadas.

### Limitaciones del archivo actual
- El logo solo existe como JPG de 500 × 500 px. La versión transparente mide 296 × 292 px: alcanza para web, pero no para impresión ni pantallas muy grandes.
- La flor tiene el texto encima, así que no se puede separar. Además, a 16 px sus detalles de acuarela no se distinguen. Por eso el ícono es el monograma "TO" (Tejidos Ortega), que se lee bien en cualquier tamaño.
- Para impresión (bolsas, etiquetas) habría que redibujar la flor en vector tomando este logo como referencia.

## 3. Color

Los nombres de los tokens van en inglés porque se usan en el código.

### Marca

| Token | Hex | Uso |
|---|---|---|
| `wine-700` | `#7A2337` | **Color primario.** Botón principal, enlaces importantes, precio destacado, elemento activo del menú |
| `wine-800` | `#5E1A2A` | Hover y estado presionado del primario |
| `wine-100` | `#F3E3E6` | Fondo de elementos seleccionados, etiqueta "Nuevo" |
| `terracotta-500` | `#B5573A` | **Acento decorativo.** Íconos, líneas, títulos grandes (≥ 24 px), ilustraciones |
| `terracotta-600` | `#9C4529` | Texto de acento pequeño: categoría en la tarjeta, enlaces secundarios |
| `terracotta-100` | `#F6E4DB` | Fondos de acento: banda de beneficios, avisos suaves |

### Neutros

| Token | Hex | Uso |
|---|---|---|
| `ivory-50` | `#FBF7EF` | Fondo general de la tienda |
| `white` | `#FFFFFF` | Tarjetas, campos de formulario, panel admin |
| `beige-200` | `#EFE4D3` | Bandas de sección, fondo de imágenes mientras cargan |
| `beige-300` | `#DCCBB8` | Bordes decorativos y separadores |
| `stone-400` | `#9C8B7E` | Borde de campos de formulario (contraste 3:1 exigido para controles) |
| `ink-600` | `#6B5A52` | Texto secundario, ayudas de formulario |
| `ink-900` | `#2B1F1C` | Texto principal y títulos |

### Estados

| Token | Texto | Fondo | Uso |
|---|---|---|---|
| `success` | `#2F6B45` | `#E4EFE6` | Disponible, pedido confirmado, guardado |
| `warning` | `#8F5400` | `#F7EBD6` | Pocas unidades, pago pendiente |
| `error` | `#C0271F` | `#F9E1DE` | Errores de formulario, agotado, acción fallida |

El vino y el rojo de error se parecen. Por eso **un error siempre lleva ícono y texto explicativo**, nunca solo color.

### Contraste verificado (WCAG 2.1)

| Combinación | Contraste | Nivel |
|---|---|---|
| Blanco sobre `wine-700` (botón primario) | 9,89 : 1 | AAA |
| `ink-900` sobre `ivory-50` | 14,94 : 1 | AAA |
| `ink-600` sobre `ivory-50` | 6,12 : 1 | AA |
| `terracotta-600` sobre `ivory-50` | 5,96 : 1 | AA |
| `terracotta-500` sobre `ivory-50` | 4,48 : 1 | Solo texto grande o decorativo |
| `wine-700` sobre `wine-100` | 7,98 : 1 | AAA |
| Textos de estado sobre su fondo | 4,75 – 5,37 : 1 | AA |
| `stone-400` sobre `ivory-50` (borde de campo) | 3,07 : 1 | AA para componentes |

El rosa de la flor (`#F2C6CF`) **solo existe dentro del logo**. No se usa en la interfaz.

## 4. Tipografía

| Rol | Familia | Pesos |
|---|---|---|
| Títulos | Playfair Display (serif) | 500 |
| Interfaz y textos | Inter (sans serif) | 400 y 500 |
| Nombre de marca | Kaushan Script | 400 |

Las tres son de Google Fonts y se cargan con `font-display: swap` para no bloquear la página.

| Token | Tamaño / interlineado | Uso |
|---|---|---|
| `text-display` | 40 / 48 px (28 / 36 en móvil) | Título principal del inicio |
| `text-h1` | 32 / 40 px (26 / 34 en móvil) | Título de página |
| `text-h2` | 24 / 32 px | Títulos de sección |
| `text-h3` | 20 / 28 px | Subtítulos, nombre de producto en detalle |
| `text-lg` | 18 / 28 px | Texto destacado, precio en detalle |
| `text-base` | 16 / 26 px | Texto de lectura |
| `text-sm` | 14 / 22 px | Botones, tablas, menús |
| `text-xs` | 12 / 18 px | Etiquetas, ayudas, notas legales |

Reglas:
- Playfair Display solo en títulos (`h1`–`h3`) y en el nombre del producto. El resto va en Inter.
- Textos de lectura de 16 px como mínimo. Líneas de 60–75 caracteres como máximo.
- Mayúsculas solo en etiquetas cortas (categoría en la tarjeta), con espaciado de letras de 0,06 em.

## 5. Espaciado, bordes y sombras

**Espaciado** (base de 4 px): `space-1` 4 · `space-2` 8 · `space-3` 12 · `space-4` 16 · `space-6` 24 · `space-8` 32 · `space-12` 48 · `space-16` 64 px.

| Token | Valor | Uso |
|---|---|---|
| `radius-sm` | 8 px | Botones, campos, menús |
| `radius-md` | 12 px | Tarjetas, modales |
| `radius-full` | 999 px | Etiquetas, chips de color, avatares |
| `shadow-sm` | `0 1px 2px rgb(43 31 28 / 6%), 0 2px 8px rgb(43 31 28 / 6%)` | Tarjeta en hover |
| `shadow-md` | `0 4px 12px rgb(43 31 28 / 10%), 0 12px 32px rgb(43 31 28 / 8%)` | Menús desplegables, carrito lateral, modales |

Las sombras usan el tono `ink-900` en lugar de negro puro para mantener la calidez.

## 6. Layout y breakpoints

| Token | Ancho | Columnas de producto |
|---|---|---|
| (base) | < 640 px | 2 |
| `sm` | ≥ 640 px | 2 |
| `md` | ≥ 960 px | 3 |
| `lg` | ≥ 1280 px | 4 |

- Contenedor máximo de 1200 px, centrado.
- Margen lateral de 16 px en móvil, 24 px en tableta y 32 px en escritorio.
- Las imágenes de producto van en proporción **4:5**, en formato WebP y con carga diferida (`loading="lazy"`).

## 7. Movimiento

- Duración: 150 ms en cambios pequeños (hover, foco) y 250 ms en elementos que entran (carrito lateral, menús).
- Curva `cubic-bezier(0.2, 0, 0, 1)`, que arranca rápido y frena suave.
- Solo se animan `opacity` y `transform`.
- Con `prefers-reduced-motion: reduce` se eliminan los desplazamientos y quedan solo los cambios de opacidad.
- Sin carruseles automáticos ni textos que cambien solos.

## 8. Componentes

### Botones

| Variante | Aspecto | Uso |
|---|---|---|
| Primario | Fondo `wine-700`, texto blanco | Una sola acción principal por pantalla: "Añadir al carrito", "Pagar" |
| Secundario | Borde y texto `wine-700`, fondo transparente | Acciones alternativas: "Ver detalles" |
| Texto | Texto `terracotta-600` subrayado | Acciones menores: "Seguir comprando" |
| Peligro | Fondo `error`, texto blanco | Eliminar (siempre con confirmación) |

Estados: normal, hover (`wine-800`), foco (anillo de 2 px en `terracotta-500` separado 2 px), presionado, cargando (indicador y texto "Guardando…") y deshabilitado (solo cuando de verdad no se puede actuar, con la razón visible).

Alto mínimo: 44 px en táctil y 40 px en escritorio.

### Formularios
- Etiqueta siempre visible encima del campo. El placeholder no la reemplaza.
- Campo con fondo blanco, borde `stone-400` y radio `radius-sm`. En foco, borde `wine-700` y anillo.
- Texto de ayuda en `ink-600` y 12 px.
- El error aparece debajo del campo, en `error` con ícono, y dice qué hacer: "Escribe un número de 10 dígitos".
- La validación ocurre al salir del campo y al enviar, no con cada tecla.

### Tarjeta de producto
- Imagen 4:5 con fondo `beige-200` mientras carga.
- Categoría en mayúsculas, `terracotta-600`, 12 px.
- Nombre en Playfair Display, 16–18 px, máximo 2 líneas.
- Precio en Inter 500 con formato colombiano: `$350.000`.
- Chips con los colores disponibles.
- Etiqueta opcional: Nuevo, Últimas unidades o Agotado.
- Toda la tarjeta es un enlace. En hover la imagen se acerca un 3 % y aparece `shadow-sm`.

### Etiquetas
Forma de píldora (`radius-full`), texto de 12 px, fondo y texto del mismo grupo de color (por ejemplo `wine-100` con `wine-700`).

### Navegación
- **Tienda:** encabezado fijo con el nombre en Kaushan Script, las categorías, buscar, cuenta y carrito con contador. En móvil, menú desplegable lateral.
- **Admin:** menú lateral fijo, que se colapsa en pantallas pequeñas.

### Mensajes y diálogos
- Notificación breve (toast) abajo a la derecha para confirmar acciones ("Producto añadido al carrito"). Se cierra sola a los 4 s, salvo en errores.
- Los diálogos de confirmación dicen qué pasará: "¿Eliminar *Hamaca de palo rayada*? Esta acción no se puede deshacer."

### Estados de contenido
| Estado | Tratamiento |
|---|---|
| Cargando | Esqueletos con la forma del contenido, en `beige-200`. Nunca un spinner a pantalla completa |
| Vacío | Ícono, título en Playfair, una línea de explicación y una acción: "Tu carrito está vacío · Ver la tienda" |
| Error | Qué pasó y qué hacer, con botón "Reintentar". Nunca mensajes técnicos |

### Tablas (panel admin)
Fondo blanco, filas de 48 px, separadores en `beige-300`, encabezado en `ink-600` de 12 px, estado en etiquetas, acciones al final de cada fila y paginación abajo.

## 9. Accesibilidad

- Contraste AA como mínimo en todo el texto (sección 3).
- Toda la tienda y el panel se pueden usar solo con el teclado, con el foco siempre visible.
- HTML semántico: `header`, `nav`, `main`, `footer`, un solo `h1` por página y jerarquía de títulos ordenada.
- `lang="es"` en el documento.
- Cada imagen de producto tiene texto alternativo generado a partir del nombre y el color.
- Formularios con `label` asociado, errores anunciados a lectores de pantalla (`aria-live`) y autocompletado (`autocomplete`) en nombre, correo, teléfono y dirección.
- Áreas táctiles de 44 × 44 px como mínimo.

## 10. Fotografía

- Formato 4:5 para productos y 16:9 para las bandas de inicio.
- Fondo neutro y luz natural. Evitar fondos recargados que compitan con el producto.
- Varias fotos por producto: vista completa, detalle del tejido, producto en uso.
- Exportar en WebP a 1200 px de ancho como máximo.
- No usar imágenes de otras marcas. El diagrama de medidas actual (`legacy/img/Medidas.png`) se rehará como ilustración propia.

## 11. Implementación y reutilización

- Los tokens se definirán como variables CSS en un solo archivo del frontend (`frontend/src/styles/_tokens.scss`), en la Fase 3.
- Los componentes solo usarán esas variables, nunca valores sueltos.
- **Para crear otra tienda** se cambian el nombre, el logo y los colores de marca (`wine-*` y `terracotta-*`) desde la configuración del negocio (`store_settings`). El resto del sistema se mantiene igual.
