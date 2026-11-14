# pagina-web

Tienda virtual reutilizable, construida a partir de **Artesanías de Tejidos Ortega**, un proyecto académico del técnico en programación (SENA, 2024).

El objetivo es convertir aquel sitio en PHP tradicional en una base profesional de comercio electrónico que sirva como plantilla para otras tiendas: artesanías, ropa, hogar, productos personalizados, etc.

## Estado actual

**Fase 2 — backend.** Ya están el design system ([Fase 1](docs/design-system.md)) y el proyecto Laravel base con MySQL en Docker. El proyecto original se conserva como referencia en [`legacy/`](legacy/README.md).

Para levantar el entorno, sigue la [guía de instalación](docs/installation.md).

## Stack objetivo

| Capa | Tecnología |
|---|---|
| Frontend | Angular + TypeScript |
| Backend | Laravel (PHP), API REST |
| Base de datos | MySQL |
| Control de versiones | Git y GitHub |

## Estructura del repositorio

```
/
├── backend/     API REST en Laravel
├── frontend/    Aplicación Angular: tienda y panel admin (se crea en la Fase 3)
├── docs/        Documentación del proyecto, en español
├── legacy/      Proyecto original, solo como referencia (temporal)
├── compose.yaml Servicios de desarrollo (MySQL 8.4 en Docker)
├── .editorconfig
├── .gitattributes
├── .gitignore
└── README.md
```

## Documentación

- [Índice de la documentación](docs/README.md)
- [Instalación del entorno](docs/installation.md)
- [Auditoría inicial del proyecto](docs/initial-audit.md)
- [Flujo de trabajo con Git](docs/git-workflow.md)
- [Modelo de datos](docs/data-model.md)
- [API REST](docs/api.md)
- [Design system](docs/design-system.md)
- [Estructura de páginas](docs/page-structure.md)

## Convenciones

- El código (variables, clases, archivos, tablas, rutas, comentarios técnicos) va en **inglés**.
- La documentación va en **español**.
- La interfaz de usuario puede estar en español.
- Los commits siguen [Conventional Commits](https://www.conventionalcommits.org/es/) en inglés: `feat:`, `fix:`, `docs:`, `refactor:`, `test:`, `chore:`, `style:`.
