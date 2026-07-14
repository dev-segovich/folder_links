## Why

El directorio actual (`projects.json` + `script.js`) es un mapa de navegación estático que no permite gestionar el trabajo real: reportes, seguimiento, conversación y colaboración. Se necesita una plataforma de gestión de tickets que permita registrar, dar seguimiento y cerrar tickets vinculados a cada proyecto, con historial de conversación, subtareas y archivos adjuntos. Esto es el primer paso hacia una herramienta completa de gestión de proyectos.

## What Changes

- Crear aplicación Laravel con base de datos MySQL para gestión de tickets
- Migrar `projects.json` a tabla `projects` en la base de datos (conservando todos los datos actuales)
- Sistema de tickets con estados: Backlog → En progreso → En revisión → Done (con retroceso desde En revisión a Pendiente)
- Historial de conversación por ticket (comentarios)
- Subtareas y archivos adjuntos por ticket
- Prioridades y deadlines
- Dashboard principal con resumen y contadores de tickets por proyecto
- Vista separada de tickets con filtros y búsqueda
- Vista de ticket estilo GitHub Issues (sidebar + conversación)
- Autenticación básica para dos roles: dev (tú) y boss (jefe)
- Capacidad de ocultar proyectos al jefe (`hidden_from_boss`)
- El jefe puede crear tickets y ver el estado de todos los proyectos
- Rediseño total del directorio actual integrado con la app de tickets
- Preparar estructura para AI Agent (sin implementar aún)
- Reportes automáticos y notificaciones fuera de alcance (fase futura)

## Capabilities

### New Capabilities

- `ticket-management`: Gestión completa de tickets con estados, conversación, subtareas y archivos adjuntos
- `project-directory`: Directorio de proyectos migrado de JSON a base de datos con integración de métricas de tickets
- `user-auth`: Autenticación básica con roles (dev, boss) y control de visibilidad de proyectos
- `dashboard`: Dashboard unificado con resumen de tickets, contadores por proyecto y accesos rápidos

### Modified Capabilities

- Ninguna (no existen specs previos en `openspec/specs/`)

## Impact

- **Código existente**: `projects.json` se migra a DB, `script.js` y `style.css` se reemplazan por Blade/Vue
- **Backend nuevo**: Laravel con Eloquent ORM, MySQL
- **Frontend nuevo**: Blade templates (o Vue), estilos CSS nuevos
- **Base de datos**: Nuevas tablas (`projects`, `tickets`, `ticket_comments`, `ticket_subtasks`, `ticket_files`, `users`, `audit_log`)
- **Hosting**: Requiere Laravel en hosting con soporte PHP + MySQL
- **Datos**: Migración automática de los 17 proyectos existentes de `projects.json` a la base de datos
