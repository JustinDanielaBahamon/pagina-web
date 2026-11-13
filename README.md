# pagina-web

Tienda virtual reutilizable, construida a partir de **Artesanías de Tejidos Ortega**, un proyecto académico del técnico en programación (SENA, 2024).

El objetivo es convertir aquel sitio en PHP tradicional en una base profesional de comercio electrónico que sirva como plantilla para otras tiendas: artesanías, ropa, hogar, productos personalizados, etc.

## Estado actual

**Fase 0 — preparación del repositorio.** Por ahora solo está el proyecto original, guardado como referencia en [`legacy/`](legacy/README.md). La nueva aplicación aún no existe.

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
├── backend/     API en Laravel (se crea en la Fase 2)
├── frontend/    Aplicación Angular: tienda y panel admin (se crea en la Fase 3)
├── docs/        Documentación del proyecto, en español
├── legacy/      Proyecto original, solo como referencia (temporal)
├── .editorconfig
├── .gitattributes
├── .gitignore
└── README.md
```

## Documentación

- [Índice de la documentación](docs/README.md)
- [Auditoría inicial del proyecto](docs/initial-audit.md)
- [Flujo de trabajo con Git](docs/git-workflow.md)

## Convenciones

- El código (variables, clases, archivos, tablas, rutas, comentarios técnicos) va en **inglés**.
- La documentación va en **español**.
- La interfaz de usuario puede estar en español.
- Los commits siguen [Conventional Commits](https://www.conventionalcommits.org/es/) en inglés: `feat:`, `fix:`, `docs:`, `refactor:`, `test:`, `chore:`, `style:`.
