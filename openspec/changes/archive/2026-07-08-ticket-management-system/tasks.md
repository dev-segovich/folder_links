## 1. Setup de Laravel

- [x] 1.1 Instalar Laravel en la carpeta del proyecto
- [x] 1.2 Configurar conexión a MySQL en .env
- [x] 1.3 Configurar composer.json para compatibilidad con hosting
- [x] 1.4 Configurar rutas base y middleware de autenticación
- [x] 1.5 Crear estructura de carpetas (views, controllers, models, etc.)

## 2. Base de datos y migraciones

- [x] 2.1 Crear migración de tabla `users` (id, name, email, password, role, created_at, updated_at)
- [x] 2.2 Crear migración de tabla `projects` (id, name, slug, env, image, status, prod_url, local_url, hidden_from_boss, created_at, updated_at)
- [x] 2.3 Crear migración de tabla `project_links` (id, project_id, label, prod_url, local_url, created_at, updated_at)
- [x] 2.4 Crear migración de tabla `tickets` (id, project_id, title, description, status, priority, created_by, assigned_to, deadline, visible_from_boss, created_at, updated_at)
- [x] 2.5 Crear migración de tabla `ticket_comments` (id, ticket_id, user_id, message, created_at, updated_at)
- [x] 2.6 Crear migración de tabla `ticket_subtasks` (id, ticket_id, title, completed, sort_order, created_at, updated_at)
- [x] 2.7 Crear migración de tabla `ticket_files` (id, ticket_id, filename, path, uploaded_by, created_at, updated_at)
- [x] 2.8 Crear migración de tabla `audit_log` (id, ticket_id, action, performed_by, details, created_at)
- [x] 2.9 Definir relaciones Eloquent entre modelos
- [x] 2.10 Ejecutar migraciones en MySQL

## 3. Migración de datos

- [x] 3.1 Crear seeder que lee projects.json y popula tabla `projects`
- [x] 3.2 Crear seeder que migra los links anidados a `project_links`
- [x] 3.3 Crear seeder para usuarios por defecto (dev + boss)
- [x] 3.4 Verificar integridad de datos post-migración
- [x] 3.5 Backup de projects.json original

## 4. Autenticación

- [x] 4.1 Implementar login (email + password) con Laravel
- [x] 4.2 Implementar logout
- [x] 4.3 Crear middleware de autenticación para proteger rutas
- [x] 4.4 Crear middleware de roles (dev vs boss)
- [x] 4.5 Crear vistas de login (Blade template)
- [x] 4.6 Configurar redirección post-login al dashboard

## 5. Dashboard principal

- [x] 5.1 Crear controller DashboardController con método index()
- [x] 5.2 Contar tickets activos por estado (Backlog, En progreso, En revisión)
- [x] 5.3 Contar tickets por proyecto
- [x] 5.4 Obtener proyectos activos (filtrar hidden_from_boss si es boss)
- [x] 5.5 Crear vista Blade del dashboard con resumen y tarjetas de proyectos
- [x] 5.6 Integrar contadores de tickets en las tarjetas
- [x] 5.7 Mantener toggle de entorno (prod/local) con localStorage
- [x] 5.8 Adaptar estilos CSS existentes para las tarjetas enriquecidas
- [x] 5.9 Implementar responsive design para móvil

## 6. Vista de directorio de proyectos

- [x] 6.1 Crear controller ProjectsController con método index()
- [x] 6.2 Obtener todos los proyectos de la base de datos
- [x] 6.3 Obtener links de cada proyecto desde project_links
- [x] 6.4 Crear vista Blade con grilla de tarjetas
- [x] 6.5 Mostrar badges de entorno (PROD/QA) por proyecto
- [x] 6.6 Mostrar contadores de tickets en cada tarjeta
- [x] 6.7 Implementar botón "Visitar sitio" con toggle prod/local
- [x] 6.8 Botón "+ Crear ticket" en el dashboard
- [x] 6.9 Click en tarjeta de proyecto filtra tickets por proyecto

## 7. Vista de tickets (lista)

- [x] 7.1 Crear controller TicketsController con método index()
- [x] 7.2 Implementar búsqueda de tickets por título, descripción, ID
- [x] 7.3 Implementar filtro por proyecto
- [x] 7.4 Implementar filtro por estado (Backlog, En progreso, En revisión, Done)
- [x] 7.5 Implementar filtro por prioridad (Baja, Media, Alta, Crítica)
- [x] 7.6 Implementar ordenamiento por fecha, deadline, prioridad
- [x] 7.7 Crear vista Blade con lista de tickets y filtros
- [x] 7.8 Mostrar prioridad visual (color/ícono) por ticket
- [x] 7.9 Mostrar estado visual por ticket
- [x] 7.10 Mostrar proyectos ocultos solo a dev
- [x] 7.11 Mostrar mensaje "No se encontraron resultados" si aplica

## 8. Vista de detalle de ticket (estilo GitHub Issues)

- [x] 8.1 Crear controller TicketController con método show()
- [x] 8.2 Obtener ticket con proyecto, comentarios, subtareas, archivos
- [x] 8.3 Crear vista Blade con layout de dos columnas (sidebar + conversación)
- [x] 8.4 Sidebar: proyecto, prioridad, estado, asignado a, deadline
- [x] 8.5 Sidebar: lista de subtareas con checkboxes
- [x] 8.6 Sidebar: lista de archivos adjuntos con botón de descarga
- [x] 8.7 Columna derecha: historial de conversación (comentarios en orden)
- [x] 8.8 Mostrar autor y timestamp de cada comentario
- [x] 8.9 Formulario para añadir comentario
- [x] 8.10 Botón de eliminar comentario (solo autor)
- [x] 8.11 Indicador visual de ticket vencido (deadline pasado)

## 9. Creación y edición de tickets

- [x] 9.1 Crear formulario de ticket (título, descripción, proyecto, prioridad, deadline, asignado)
- [x] 9.2 Implementar store() en TicketController para crear ticket
- [x] 9.3 Validación de campos obligatorios
- [x] 9.4 Estado inicial del ticket: Backlog
- [x] 9.5 created_by = usuario actual (dev o boss)
- [x] 9.6 Redirigir a detalle del ticket tras crear
- [x] 9.7 Implementar edit() para editar ticket existente
- [x] 9.8 Implementar update() para guardar cambios
- [x] 9.9 Permitir cambio de estado en el formulario de edición
- [x] 9.10 Permitir retroceso desde En revisión a Backlog

## 10. Subtareas

- [x] 10.1 Crear formulario para añadir subtarea a un ticket
- [x] 10.2 Implementar storeSubtask() en TicketController
- [x] 10.3 Mostrar subtareas en el sidebar del ticket
- [x] 10.4 Checkbox para marcar subtarea como completada
- [x] 10.5 Botón para eliminar subtarea (solo autor)
- [x] 10.6 Calcular progreso: completadas / total de subtareas
- [x] 10.7 Registrar eliminación en audit_log

## 11. Archivos adjuntos

- [x] 11.1 Crear carpeta storage/app/tickets/ para archivos
- [x] 11.2 Implementar formulario de subida de archivos en ticket
- [x] 11.3 Implementar storeFile() en TicketController
- [x] 11.4 Validar tipo y tamaño de archivo (máx 10MB)
- [x] 11.5 Listar archivos adjuntos en el sidebar del ticket
- [x] 11.6 Botón de descarga para cada archivo
- [x] 11.7 Botón de eliminar archivo (solo autor)
- [x] 11.8 Registrar eliminación en audit_log
- [x] 11.9 Configurar symlink de storage para acceso público

## 12. Audit log

- [x] 12.1 Registrar cambio de estado en audit_log
- [x] 12.2 Registrar cambio de prioridad en audit_log
- [x] 12.3 Registrar creación de ticket en audit_log
- [x] 12.4 Registrar eliminación de comentario en audit_log
- [x] 12.5 Registrar eliminación de subtarea en audit_log
- [x] 12.6 Registrar eliminación de archivo en audit_log
- [x] 12.7 Mostrar historial de cambios en vista de ticket (opcional)

## 13. Control de visibilidad

- [x] 13.1 Implementar lógica para ocultar proyectos al boss (hidden_from_boss)
- [x] 13.2 Implementar lógica para ocultar tickets de proyectos ocultos al boss
- [x] 13.3 Permitir a dev marcar/desmarcar hidden_from_boss
- [x] 13.4 UI para gestionar visibilidad de proyectos (solo dev)

## 14. Estructura para AI Agent

- [ ] 14.1 Crear tabla api_keys para almacenar claves de AI Agent
- [ ] 14.2 Crear middleware de autenticación por API key
- [ ] 14.3 Crear endpoint POST /api/tickets para crear tickets vía API
- [ ] 14.4 Crear endpoint GET /api/tickets/{id} para obtener ticket vía API
- [ ] 14.5 Documentar estructura de request/response para AI Agent
- [ ] 14.6 Permitir crear API keys desde el panel (solo dev)

## 15. Testing y deploy

- [x] 15.1 Probar flujo completo de creación de ticket
- [x] 15.2 Probar flujo de conversación (comentarios)
- [x] 15.3 Probar autenticación (login/logout)
- [x] 15.4 Probar roles (dev vs boss)
- [x] 15.5 Probar filtrado y búsqueda de tickets
- [x] 15.6 Probar toggle prod/local
- [x] 15.7 Probar visibilidad de proyectos al boss
- [x] 15.8 Probar responsive en móvil
- [x] 15.9 Probar en el hosting real
- [x] 15.10 Configurar HTTPS en producción

## 16. Pulido final

- [x] 16.1 Verificar que todos los estilos CSS sean consistentes
- [x] 16.2 Verificar tipografía Poppins en todas las vistas
- [x] 16.3 Verificar colores de badges (verde=prod, ámbar=qa)
- [x] 16.4 Verificar animaciones y transiciones
- [x] 16.5 Verificar que no haya mensajes de error en consola
- [x] 16.6 Verificar que projects.json se migró correctamente
- [x] 16.7 Backup final de base de datos
