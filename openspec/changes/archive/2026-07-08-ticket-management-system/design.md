## Context

**Estado actual:**
- Directorio estático de 17 proyectos en `projects.json`
- `script.js` renderiza tarjetas dinámicamente desde el JSON
- `style.css` con grilla responsive, badges de entorno, toggle prod/local
- No hay backend, no hay base de datos, no hay gestión de trabajo

**Restricciones:**
- Hosting compartido con soporte PHP + MySQL
- Sin Node.js ni otros runtime externos
- Aplicación interna (no pública), pero con autenticación básica
- Usuario principal (dev) + jefe (boss)
- Datos existentes deben migrarse sin pérdida

**Stakeholders:**
- **Dev (tú):** crea tickets, gestiona estados, configura proyectos, ve todo
- **Jefe (boss):** ve proyectos no ocultos, crea tickets, cambia estados, comenta
- **AI Agent (futuro):** estructura preparada pero no implementada

## Goals / Non-Goals

**Goals:**
- Plataforma de gestión de tickets con Laravel + MySQL
- Migrar `projects.json` a base de datos conservando todos los datos
- Sistema de tickets completo: estados, conversación, subtareas, archivos, audit log
- Dashboard unificado con resumen y contadores
- Vista de tickets con filtros, búsqueda y ordenamiento
- Vista de ticket estilo GitHub Issues
- Autenticación básica con roles (dev, boss)
- Control de visibilidad de proyectos al jefe
- Rediseño visual integrado con el directorio actual

**Non-Goals:**
- Reportes automáticos por email
- Notificaciones push o por email
- Portal de cliente público
- Integración con herramientas externas (GitHub, Slack, etc.)
- Implementación del AI Agent (solo estructura preparada)
- Kanban visual drag-and-drop (solo cambio de estado)
- Webhooks o automatizaciones complejas

## Decisions

### Decisión 1: Laravel con Blade (no Vue/React)
**Elección:** Blade templates con CSS vanilla
**Rationale:** 
- Hosting compartido con PHP, Laravel ya está en el stack
- Vue/React requerirían build step (npm run build) que puede no estar disponible
- Blade es más simple, no requiere compilación
- El CSS actual se reutiliza como base

**Alternativas consideradas:**
- Vue.js + Vite → requiere build step, más complejidad
- Livewire → buena opción, pero añade dependencia adicional
- Inertia.js → requiere build step

### Decisión 2: MySQL para la base de datos
**Elección:** MySQL en el hosting actual
**Rationale:**
- MySQL ya está disponible en el hosting
- Los datos actuales de `projects.json` migran directamente
- Laravel tiene soporte nativo con Eloquent ORM

**Alternativas consideradas:**
- SQLite → no recomendado para hosting compartido con múltiples usuarios
- PostgreSQL → no disponible en el hosting actual

### Decisión 3: Estructura de tablas relacional
**Elección:** Tablas separadas con relaciones Eloquent
```
projects (1) ──┬── (N) tickets
               │
users (1) ────┬── (N) tickets
              ├── (N) ticket_comments
              ├── (N) ticket_subtasks
              └── (N) ticket_files
tickets (1) ──┬── (N) ticket_comments
              ├── (N) ticket_subtasks
              └── (N) ticket_files
```

**Rationale:**
- Normalización permite consultas eficientes
- Eloquent ORM maneja relaciones nativamente
- Fácil de escalar si se necesitan más campos

### Decisión 4: Estados del ticket con retroceso
**Elección:** Backlog → En progreso → En revisión → Done (con retroceso desde En revisión a Backlog)
**Rationale:**
- Flujo simple pero efectivo
- Retroceso permite correcciones sin reabrir tickets
- Sin embargo, Done puede reabrirse a En progreso

**Validación:**
- Todo estado puede retroceder a cualquier estado anterior
- El historial completo se registra en audit_log

### Decisión 5: Estilo GitHub Issues para vista de ticket
**Elección:** Layout de dos columnas (sidebar + conversación)
**Rationale:**
- Patrón familiar para desarrolladores
- Sidebar con metadatos siempre visible
- Conversación ocupa el espacio principal
- Fácil de implementar con CSS Grid

**Alternativas consideradas:**
- Trello (kanban) → más complejo, solo en Fase 2
- Linear (lista compacta) → menos contexto visual
- Jira → demasiado complejo para el alcance actual

### Decisión 6: Autenticación con Laravel Sanctum
**Elección:** Laravel Sanctum para sessions/JWT
**Rationale:**
- Sanctum es ligero, ideal para SPA o traditional server-rendered apps
- Soporta both session-based y token-based auth
- Integración nativa con Laravel

**Alternativas consideradas:**
- Laravel Jetstream → demasiado pesado, añade funcionalidad no necesaria
- Auth manual con sessions → posible pero Sanctum es más robusto
- JWT puro → más configuración, Sanctum lo maneja

### Decisión 7: Migración de projects.json
**Elección:** Seeder de Laravel que lee el JSON y crea registros
**Rationale:**
- Migración one-time al inicio
- Conserva todos los datos existentes
- Links se normalizan a tabla pivote `project_links`
- El JSON se mantiene como fallback de config

**Plan:**
1. Crear tabla `projects` con todos los campos del JSON
2. Crear tabla `project_links` para los links anidados
3. Seeder lee `projects.json` y popula ambas tablas
4. Después de migración, el JSON se mantiene como backup

### Decisión 8: Dashboard como vista principal
**Elección:** `/` como dashboard unificado, `/tickets` como vista de tickets
**Rationale:**
- Separación clara de responsabilidades
- Dashboard muestra resumen + directorio enriquecido
- `/tickets` para gestión completa con filtros
- URL semánticas y fáciles de recordar

**Estructura de rutas:**
```
/              → Dashboard
/tickets       → Lista de tickets con filtros
/tickets/{id}  → Vista de detalle de ticket
/tickets/new   → Formulario de creación
/projects      → Directorio completo (opcional, si se separa del dashboard)
/login         → Login
/logout        → Logout
```

## Risks / Trade-offs

### Risk 1: Hosting compartido con limitaciones
**Mitigación:** 
- Usar solo PHP + MySQL nativo
- Evitar extensions de PHP no estándar
- Testear en el hosting real antes de deploy
- Mantener composer.json compatible con versión de PHP del hosting

### Risk 2: Migración de projects.json
**Mitigación:**
- Backup del JSON antes de migrar
- Seeder con validación de datos
- Comprobar que todos los campos se mapean correctamente
- Mantener el JSON como fallback

### Risk 3: Seguridad de aplicación interna
**Mitigación:**
- Aunque es "escondida", implementar auth básico
- Proteger todas las rutas con middleware
- Validar todas las entradas (CSRF, XSS)
- HTTPS en producción

### Risk 4: Escalabilidad de archivos adjuntos
**Mitigación:**
- Limitar tamaño de archivos (ej. 10MB máximo)
- Limitar tipos de archivo permitidos
- Almacenar en storage/app/tickets/ con organización por ticket_id
- Considerar cloud storage (S3) si crece mucho

### Risk 5: Complejidad del alcance
**Mitigación:**
- Fase 1 solo lo esencial (tickets + conversación + directorio)
- Fase 2 añade subtareas, archivos, filtros avanzados
- Fase 3 es todo lo futuro (AI, reportes, notificaciones)
- Priorizar MVP sobre features secundarias

## Migration Plan

### Fase 1: Setup inicial
1. Instalar Laravel en el hosting
2. Configurar conexión a MySQL
3. Crear migraciones de tablas
4. Ejecutar migraciones

### Fase 2: Migración de datos
1. Crear seeder que lee projects.json
2. Ejecutar seeder para poblar `projects` y `project_links`
3. Verificar integridad de datos
4. Crear usuarios por defecto (dev + boss)

### Fase 3: Desarrollo
1. Implementar auth (login, middleware)
2. Implementar dashboard
3. Implementar vista de tickets
4. Implementar detalle de ticket
5. Implementar formularios de creación/edición

### Fase 4: Testing
1. Probar flujo completo de tickets
2. Probar auth y roles
3. Probar directorio enriquecido
4. Probar en el hosting real

### Rollback strategy
- Mantener `projects.json` original como backup
- Migraciones de Laravel con rollback integrado
- Backup de base de datos antes de primer deploy
- Si algo falla: revertir migraciones y restaurar JSON

## Open Questions

1. **¿Tamaño máximo de archivos adjuntos?** → Depende del hosting, verificar límite de upload de PHP
2. **¿Se necesita multiidioma?** → Por ahora solo español, pero ¿preparar para i18n?
3. **¿Backup automático de la base de datos?** → Depende del hosting, verificar si se puede configurar
4. **¿Dominio propio o subdominio?** → ¿`tickets.tudominio.com` o `tudominio.com/tickets`?
5. **¿Versión de PHP del hosting?** → Determina qué versión de Laravel es compatible (Laravel 11 requiere PHP 8.2+)
6. **¿El jefe necesita ver un resumen diario/semanal?** → Fuera de alcance ahora, pero ¿necesario para la próxima iteración?
