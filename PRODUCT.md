# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Stack

Monorepo con frontend en Angular + TypeScript (`frontend/`, se crea en la Fase 3) y backend en Laravel como API REST (`backend/`), con MySQL. Decidido por la dueña del proyecto.

## Users

- **Hogares en Colombia:** personas de cualquier ciudad del país que compran hamacas, sillas colgantes, columpios, cunas, bolsos o ponchos para su casa o finca.
- **Negocios:** hoteles, fincas turísticas, restaurantes y tiendas que compran varias unidades.
- **Clientes de la región:** personas del Huila que ya conocen la tienda física en Campoalegre y quieren ver el catálogo o pedir desde casa.

Las ventas internacionales no son prioridad.

## Product Purpose

Tienda en línea propia del negocio (no un marketplace) para vender los tejidos de la familia Ortega en todo Colombia: catálogo con variantes por color, carrito, checkout con pago en línea, seguimiento del pedido y postventa.

El código se construye como plantilla reutilizable: otra tienda debe poder usarlo cambiando la configuración del negocio, sin duplicar código.

## Positioning

Los productos los teje la familia Ortega en su propio taller de Campoalegre, Huila, y se venden directamente desde su propia página.

El texto actual de "Nosotros" en `legacy/` menciona diseñadoras y comunidades de artesanos. No coincide con lo confirmado y debe reescribirse antes de publicarse.

## Operating Context

- Tienda física en Campoalegre, Huila, con los productos colgados bajo techo. Las fotos de la tienda están en `backend/database/seeders/images/site/`.
- WhatsApp Business se usa para soporte y postventa, nunca para cobrar.
- Los envíos se hacen con transportadoras nacionales (Servientrega, Coordinadora, Interrapidísimo u otras) a través de un agregador.

## Capabilities and Constraints

**Ya implementado:** catálogo con categorías, productos, variantes por color y galería de fotos, y una API REST pública de solo lectura (`docs/api.md`).

**Requisitos confirmados para las próximas fases:**

- **Compra:** Catálogo → Carrito → Datos del cliente y dirección → Cálculo de envío → Pago → Confirmación → Seguimiento. Se puede comprar como invitado o con cuenta.
- **Pedidos:** número único con el formato `PED-000123`. Estados: Pendiente de pago → Pagado → Preparando → Enviado → Entregado, además de Cancelado y Devuelto.
- **Pagos:** dentro de la página, con una pasarela colombiana (preferiblemente Wompi; alternativas: Bold, ePayco, Mercado Pago) que permita Nequi, Botón Bancolombia, PSE y tarjetas débito y crédito.
  - Nunca se guardan datos de tarjetas.
  - El pago se confirma automáticamente por webhook, verificando su firma. No se aceptan pantallazos de transferencias como prueba de pago.
  - Los reembolsos se hacen desde la pasarela, por el mismo medio, y quedan registrados en el pedido.
  - El pago contraentrega es opcional, donde la transportadora lo permita.
- **Envíos:**
  - Cotización y guía con un agregador (Envia.com o Mipaquete). En la primera versión se acepta una tarifa fija por zona (misma ciudad, nacional, zonas especiales).
  - Al despachar se envían al cliente el número de guía y el enlace de rastreo por correo y WhatsApp.
  - El cliente consulta su pedido con el número de pedido y su correo.
- **WhatsApp:** botón flotante "¿Dudas? Escríbenos" con enlace `wa.me` y mensaje prellenado. Los mensajes de confirmación, envío y reclamo llevan el número de pedido.
- **Devoluciones:**
  - Página visible de cambios y devoluciones, con el derecho de retracto en ventas a distancia (normalmente 5 días hábiles), los plazos para reclamar, los casos que aplican y quién paga el envío de devolución.
  - Formulario de solicitud con número de pedido, motivo y fotos. Todo reclamo queda asociado a un pedido.
  - Casos: pedido que no llegó (reclamo a la transportadora, reenvío o reembolso), producto dañado o equivocado (fotos, cambio o reembolso) y retracto (devolución y reembolso por la pasarela).
- **Panel de administración:** pedidos con filtros por estado, fecha y método de pago; detalle del pedido; cambio de estados; registro de la guía; devoluciones y reembolsos; historial de cambios de cada pedido (quién cambió qué y cuándo).
- **Seguridad y cumplimiento:**
  - HTTPS en todo el sitio y validación en el servidor.
  - En el checkout: logos de los métodos de pago, política de devoluciones y datos de contacto.
  - Términos y condiciones y política de tratamiento de datos personales (Ley 1581 de 2012).

**Pendiente de confirmar con el negocio:** precios reales, costos de envío por zona y las políticas definitivas. El sitio original decía envíos de 5 a 7 días hábiles, devoluciones en 30 días y garantía de 1 año, y la especificación nueva menciona un retracto de 5 días hábiles; se deben unificar antes de publicar.

## Brand Commitments

- **Nombre oficial:** Hamacas de Tejidos Ortega.
- **Logo:** flor rosa de acuarela con el nombre en script (`docs/brand/logo-primary.png`). Favicon: monograma "TO" (`docs/brand/`).
- **Tipografía del nombre:** Kaushan Script.
- **Dirección visual elegida por la dueña:** artesanal premium, con vino, terracota, beige y marfil, y las fotografías como protagonistas. El sistema aprobado está en `docs/design-system.md`.

## Evidence on Hand

- 145 fotos reales de productos, organizadas por producto y color, y 7 fotos de la tienda física (`backend/database/seeders/images/`).
- Textos del sitio original sobre el producto y las políticas (`legacy/`), que se deben revisar antes de usarlos.
- **No existen** testimonios, reseñas, cifras de ventas, prensa ni certificaciones. No se deben inventar.
- Los precios del catálogo de demostración salen del sitio original y no están confirmados.

## Product Principles

1. **El taller es la historia.** Mostrar el origen real (la familia Ortega, Campoalegre) sin adornarlo ni inventar datos.
2. **Confianza antes que urgencia.** Pagos verificados, políticas visibles y un número de pedido en cada contacto.
3. **El producto real manda.** Las fotos y los colores de cada tejido son el contenido principal; la interfaz los enmarca.
4. **Se cobra en la página, se acompaña por WhatsApp.** El soporte es humano; el pago, automático y verificable.
5. **Plantilla, no tienda única.** Nada específico de este negocio queda escrito en el código: se configura.

## Accessibility & Inclusion

WCAG 2.1 nivel AA como mínimo: contraste, uso completo con teclado, etiquetas en los formularios y respeto por `prefers-reduced-motion`. Detalles en `docs/design-system.md`.
