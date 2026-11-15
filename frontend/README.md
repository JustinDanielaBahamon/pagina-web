# Frontend (Angular)

Tienda y, más adelante, panel administrativo, construidos con **Angular 22**. Consume la API de Laravel ([docs/api.md](../docs/api.md)). La instalación está en [docs/installation.md](../docs/installation.md).

## Decisiones

| Decisión | Motivo |
|---|---|
| Componentes standalone, signals y sin `zone.js` | Es lo que Angular recomienda por defecto desde la v21: menos código y mejor rendimiento |
| Rutas con carga diferida (`loadComponent`) | Cada página descarga solo su código |
| SCSS + variables CSS (`src/styles/_tokens.scss`) | Los valores del [design system](../docs/design-system.md) viven en un solo lugar; otra tienda cambia la marca sobrescribiéndolos |
| Sin librerías de componentes (Material, PrimeNG, Bootstrap) | Evitan el aspecto de plantilla genérica; los componentes se construyen con el design system propio |
| Fuentes alojadas en el proyecto (`@fontsource`) | Cargan más rápido y no envían datos de los visitantes a servicios externos |
| Proxy de desarrollo (`proxy.conf.json`) | `/api` y `/storage` se reenvían a Laravel en `localhost:8000`, así que no hace falta configurar CORS |
| Sin SSR por ahora | Se agrega con `ng add @angular/ssr` antes del despliegue, si el hosting lo permite |

## Estructura

```
src/
├── app/
│   ├── core/            servicios globales y configuración (una sola instancia en toda la app)
│   │   ├── api/         comunicación con la API: CatalogApi, API_BASE_URL
│   │   └── config/      configuración regional de la tienda (STORE_LOCALE)
│   ├── shared/          piezas reutilizables sin lógica de negocio: pipes, componentes de UI
│   ├── features/        una carpeta por funcionalidad, con sus páginas y componentes
│   ├── models/          contratos de datos de la API (interfaces TypeScript)
│   ├── app.config.ts    proveedores globales: HttpClient, router
│   └── app.routes.ts    rutas de la aplicación
├── styles/
│   ├── _tokens.scss     tokens del design system: colores, tipografía, espacios, movimiento
│   └── _base.scss       estilos base y superficies del navegador (selección, foco, scrollbar)
└── styles.scss          punto de entrada de los estilos globales
public/                  archivos servidos tal cual: favicon e íconos
```

**Regla:** `features/` puede usar `core/`, `shared/` y `models/`, pero una funcionalidad no importa código de otra. Lo que dos funcionalidades necesiten se mueve a `shared/` o `core/`.

## Comandos

```bash
npm start              # servidor de desarrollo en http://localhost:4200 (con Laravel corriendo en :8000)
npm test               # pruebas unitarias con Vitest
npm run lint           # revisión de código con angular-eslint
npm run format         # dar formato con Prettier
npm run build          # compilación de producción en dist/
```
