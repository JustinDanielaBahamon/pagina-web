# Flujo de trabajo con Git

## Ramas

| Rama | Propósito | Recibe cambios desde |
|---|---|---|
| `main` | Versión estable de producción | Solo `qa`, con Pull Request |
| `qa` | Validación de calidad antes de producción | Solo `develop`, con Pull Request |
| `develop` | Integración de funcionalidades | `feat/*`, `fix/*`, `chore/*`, `docs/*` |
| `feat/<nombre>` | Una funcionalidad nueva | Se crea desde `develop` |
| `fix/<nombre>` | Una corrección | Se crea desde `develop` |
| `chore/<nombre>` | Configuración, herramientas, mantenimiento | Se crea desde `develop` |
| `docs/<nombre>` | Solo documentación | Se crea desde `develop` |

Los nombres de rama van en inglés y en minúsculas con guiones, por ejemplo `feat/product-management` o `fix/checkout-validation`.

Nunca se hacen cambios directamente en `main`, `qa` ni `develop`.

## Ciclo de una funcionalidad

```
develop ──► feat/shopping-cart ──(PR)──► develop ──(PR)──► qa ──(PR)──► main
                  │                                    │              │
             desarrollo                           validación      etiqueta
             + pruebas                            de calidad      vX.Y.Z
```

1. Actualizar `develop` y crear la rama de trabajo desde ella.
2. Desarrollar con commits pequeños.
3. Ejecutar las pruebas en local.
4. Abrir un Pull Request hacia `develop` con descripción y forma de probarlo.
5. Revisar y aprobar. Las pruebas automáticas (CI) deben pasar.
6. Cuando `develop` tiene un conjunto listo, abrir un PR `develop → qa` y validarlo.
7. Si QA lo aprueba, abrir un PR `qa → main` y crear la etiqueta de versión (`v1.0.0`, `v1.1.0`, …).

## Commits

Se usa [Conventional Commits](https://www.conventionalcommits.org/es/). El mensaje va en inglés y en modo imperativo:

| Tipo | Uso | Ejemplo |
|---|---|---|
| `feat` | Funcionalidad nueva | `feat: add product management` |
| `fix` | Corrección de un error | `fix: correct checkout validation` |
| `refactor` | Cambio interno sin alterar el comportamiento | `refactor: improve authentication service` |
| `docs` | Documentación | `docs: update installation guide` |
| `test` | Pruebas | `test: add product service tests` |
| `chore` | Configuración y mantenimiento | `chore: configure development environment` |
| `style` | Formato, sin cambiar la lógica | `style: standardize component formatting` |

Cada commit debe representar un cambio coherente. Es mejor varios commits pequeños que uno enorme.

## Protección de ramas (pendiente de configurar en GitHub)

En **Settings → Rules → Rulesets** del repositorio:

- `main`, `qa` y `develop`: exigir Pull Request, sin push directo ni force push.
- `main` y `qa`: exigir que las pruebas automáticas pasen antes de hacer merge.

## Qué nunca se sube al repositorio

El repositorio es **público**, así que nunca se suben:

- Archivos `.env` ni contraseñas, claves o tokens.
- Datos personales reales: nombres, documentos, teléfonos, correos o direcciones.
- Dumps de bases de datos con información real.
- Instaladores ni archivos binarios grandes.
