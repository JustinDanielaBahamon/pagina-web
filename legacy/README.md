# Proyecto original (legacy)

Esta carpeta contiene el sitio **Artesanías de Tejidos Ortega** tal como se entregó en el técnico (2024). Se conserva **solo como referencia** durante la migración a Laravel + Angular. No se le agregan funcionalidades ni se corrige.

Cuando la nueva aplicación cubra todas sus funciones, la carpeta se eliminará (con aprobación). Antes quedará guardada en la etiqueta de Git `legacy-v1`.

## Qué es

- Páginas PHP sueltas con HTML, CSS, JavaScript y SQL mezclados.
- Catálogo escrito a mano en el HTML (`hamacas.php`, `bolsos.php`, `modelo*.php`, `SCmod*.php`, …).
- Carrito en `localStorage` (`comprar.js`).
- Panel de administración en `administrador/` (productos, clientes, usuarios).
- Base de datos MySQL/MariaDB `hamaca_mb`.

Los problemas encontrados están en la [auditoría inicial](../docs/initial-audit.md).

## Cambios hechos al publicarlo

Como el repositorio es público, se hicieron solo estos cambios respecto al original:

- Los correos, teléfonos y la dirección física se reemplazaron por valores de ejemplo (`contacto@ejemplo.com`, `3000000000`, `Direccion de ejemplo`).
- No se suben (están en `.gitignore`, pero siguen en el disco local):
  - `PROGRAMAS/`: instaladores de XAMPP, VS Code, PSeInt y Dia.
  - `MANUAL TECNICO/`: documento académico con nombres de personas.
  - Los dumps SQL originales (`bd/hamaca_mb.sql`, `bd/hamaca_mb.sql 2.sql`, `hamaca/bd/hamaca_mb.sql`), porque tienen datos personales y contraseñas en texto plano.
  - Fotos personales, la captura de Google Street View (`img/fotoN.png`) y las fotos de WhatsApp que el código no usa.
- Se agregó `bd/hamaca_mb.sanitized.sql`: la misma estructura con los productos, pero sin clientes, facturas ni usuarios.

## Cómo verlo localmente (opcional)

1. Copiar el repositorio dentro de `C:\xampp\htdocs\`.
2. Importar `legacy/bd/hamaca_mb.sanitized.sql` en phpMyAdmin con el nombre de base `hamaca_mb`.
3. Abrir `http://localhost/<carpeta>/legacy/Inicio.php`.

Limitaciones conocidas:
- `administrador/encabezado.php` e `include/salir.php` tienen fija la ruta `/hamacas sin/`, así que los enlaces del panel no funcionan desde `legacy/`.
- El dump limpio no trae usuarios, así que para entrar al panel hay que crear uno a mano en la tabla `usuarios`.
