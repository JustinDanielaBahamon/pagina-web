# Estructura de páginas

Estado: **aprobado en la Fase 1**. Define qué contiene cada pantalla y en qué orden. Los estilos salen del [design system](design-system.md).

Las rutas van en inglés, siguiendo la convención del proyecto. Los textos visibles van en español.

## Mapa del sitio

```
Tienda                                   Panel administrativo (/admin)
├── /                    Inicio          ├── /admin                 Dashboard
├── /shop                Catálogo        ├── /admin/orders          Pedidos
├── /shop/:category      Categoría       ├── /admin/orders/:id      Detalle de pedido
├── /products/:slug      Detalle         ├── /admin/products        Productos
├── /cart                Carrito         ├── /admin/products/new    Nuevo producto
├── /checkout            Checkout        ├── /admin/products/:id    Editar producto
├── /checkout/success    Confirmación    ├── /admin/categories      Categorías
├── /login · /register   Cuenta          ├── /admin/customers       Clientes
├── /account             Perfil          ├── /admin/users           Usuarios y roles
├── /account/orders      Mis pedidos     └── /admin/settings        Configuración
├── /about               Nosotros
├── /contact             Contacto
└── /policies            Políticas
```

## Elementos comunes de la tienda

### Encabezado
1. Barra superior fija (texto estático, no rota): "Envíos a todo el país" y enlace a WhatsApp.
2. Nombre de la marca en Kaushan Script (enlace al inicio).
3. Categorías al mismo nivel: Hamacas, Sillas colgantes, Columpios, Cunas, Bolsos, Ponchos. Salen de la base de datos.
4. Buscar, cuenta y carrito con contador.

En móvil: botón de menú, nombre, buscar y carrito. Las categorías van en un panel lateral.

### Pie de página
Logo principal, categorías, enlaces a Nosotros, Contacto y Políticas, datos de contacto del negocio (desde la configuración) y redes sociales.

### Botón de WhatsApp
Flotante, abajo a la derecha, con el número configurado en el admin. En el detalle de producto incluye el nombre del producto en el mensaje.

## Inicio (`/`)
1. **Portada:** foto real de las hamacas a un lado; al otro, el título "Hecho a mano en Colombia", una frase corta y el botón "Ver la tienda".
2. **Categorías:** cuadrícula de 6 tarjetas con foto (3 columnas en móvil, 6 en escritorio).
3. **Productos destacados:** 4 tarjetas, elegidos desde el admin.
4. **Beneficios:** tejido artesanal · envíos de 5 a 7 días hábiles · garantía de 1 año. Fondo `terracotta-100`.
5. **Nuestra historia:** foto de la tienda con un resumen del texto de Nosotros y un enlace.
6. Pie de página.

## Catálogo (`/shop` y `/shop/:category`)
1. Ruta de navegación (breadcrumb) y título de la categoría con el número de productos.
2. **Filtros:** categoría, rango de precio, color, solo disponibles. Columna lateral en escritorio y panel desplegable ("Filtrar") en móvil.
3. **Orden:** destacados, precio de menor a mayor, precio de mayor a menor, más recientes.
4. Cuadrícula de tarjetas (2 / 3 / 4 columnas) con paginación.
5. Estado vacío: "No encontramos productos con esos filtros · Limpiar filtros".

## Detalle de producto (`/products/:slug`)
Una sola plantilla para todos los productos; reemplaza las ~60 páginas del sitio original.

1. Ruta de navegación: Inicio › Hamacas › Hamaca de palo rayada.
2. **Galería:** imagen principal con zoom y miniaturas. En móvil se desliza con el dedo.
3. **Información de compra:**
   - Categoría, nombre y precio.
   - Selector de color (chips).
   - Cantidad y disponibilidad.
   - Botón primario "Añadir al carrito".
   - Botón secundario "Preguntar por WhatsApp".
   - Resumen: envío en 5 a 7 días hábiles · devoluciones en 30 días · garantía de 1 año.
4. **Descripción** del producto.
5. **Ficha técnica:** material, capacidad, medidas, colores disponibles.
6. **Productos relacionados** de la misma categoría.

## Carrito
- **Panel lateral** que se abre al añadir un producto: producto añadido, subtotal y los botones "Ver carrito" y "Pagar".
- **Página `/cart`:** lista de productos con imagen, nombre, color, cantidad editable y eliminar. Al lado, el resumen: subtotal, envío ("se calcula en el siguiente paso") y botón "Continuar al pago".
- Los precios que se muestran salen siempre de la API. El servidor los vuelve a calcular al crear el pedido.

## Checkout (`/checkout`)
Una sola página. En escritorio tiene 2 columnas; en móvil, el resumen se puede plegar arriba.

1. **Contacto:** correo y celular. Si la persona tiene cuenta, se llenan solos.
2. **Envío:** nombre, documento, departamento, ciudad, dirección y notas.
3. **Pago:** métodos activos en la configuración (se definen en la Fase 7).
4. **Resumen fijo:** productos, subtotal, envío, total y botón "Confirmar pedido".

Se puede comprar sin cuenta. Al final se ofrece crear una con los datos ya escritos.

**Confirmación (`/checkout/success`):** número de pedido, resumen, siguientes pasos y aviso del correo enviado.

## Cuenta
- `/login` y `/register`: formularios cortos con el logo principal. Incluyen recuperar contraseña.
- `/account`: datos personales, direcciones guardadas, cambiar contraseña.
- `/account/orders`: lista de pedidos con estado y detalle de cada uno.

## Nosotros, Contacto y Políticas
- **Nosotros:** texto actual sobre la tradición artesanal y fotos de la tienda.
- **Contacto:** formulario propio enviado por la API (deja de depender de formsubmit.co), con los datos de contacto del negocio.
- **Políticas:** envíos, devoluciones, garantía y términos, con el texto que hoy se repite en cada producto. Cada sección tiene su ancla para enlazarla desde el detalle de producto.

## Panel administrativo (`/admin`)

### Estructura común
- Menú lateral: Dashboard, Pedidos, Productos, Categorías, Clientes, Usuarios, Configuración.
- Barra superior: búsqueda global, usuario y cerrar sesión.
- Cada listado tiene título, botón de acción principal, filtros, tabla, paginación y sus estados de carga, vacío y error.

### Dashboard
1. Indicadores: ventas del mes, pedidos pendientes, productos con stock bajo, clientes nuevos.
2. Últimos pedidos (tabla con estado).
3. Productos con stock bajo.
4. Ventas por semana (gráfico).

### Pedidos
- **Listado:** número, fecha, cliente, total, estado. Filtros por estado y fechas.
- **Detalle:** productos, datos de envío, pago e historial de estados. Permite cambiar el estado (pendiente → pagado → enviado → entregado, o cancelado).

### Productos
- **Listado:** miniatura, nombre, categoría, precio, stock, estado (activo/inactivo) y acciones.
- **Formulario** por bloques:
  1. Datos básicos: nombre, categoría, descripción.
  2. Precio e inventario: precio, SKU, stock.
  3. Imágenes: arrastrar y soltar, ordenar, elegir la principal. Solo JPG, PNG o WebP de máximo 5 MB.
  4. Ficha técnica: material, capacidad, medidas, colores.
  5. Visibilidad: activo y destacado.

### Categorías
Lista ordenable con nombre, imagen, número de productos y estado.

### Clientes
Lista con nombre, correo, número de pedidos y fecha de registro. El detalle muestra sus pedidos.

### Usuarios y roles
Usuarios del panel con su rol (administrador o personal). Para invitar se ingresa el correo; la persona define su propia contraseña.

### Configuración
Datos del negocio (nombre, logo, contacto, WhatsApp, redes), colores de marca, costos de envío y métodos de pago. Es lo que permite reutilizar la plantilla para otra tienda.
