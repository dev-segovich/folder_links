## ADDED Requirements

### Requirement: Migración de projects.json
El sistema SHALL migrar todos los datos de `projects.json` a la base de datos sin pérdida de información.

#### Scenario: Migrar proyectos al iniciar
- **WHEN** se ejecuta la migración por primera vez
- **THEN** todos los proyectos de `projects.json` se crean en la tabla `projects` de MySQL

#### Scenario: Conservar datos existentes
- **WHEN** se completa la migración
- **THEN** todos los campos (name, env, image, status, prod, local, links) se preservan en la base de datos

### Requirement: Directorio de proyectos
El sistema SHALL mostrar un directorio de proyectos con tarjetas que incluyen contadores de tickets.

#### Scenario: Ver directorio de proyectos
- **WHEN** el usuario abre la página principal
- **THEN** ve todas las tarjetas de proyectos con logos, badges de entorno y contadores de tickets activos

#### Scenario: Contador de tickets por proyecto
- **WHEN** un proyecto tiene tickets activos
- **THEN** la tarjeta del proyecto muestra el número de tickets activos entre paréntesis

#### Scenario: Click en tarjeta de proyecto
- **WHEN** el usuario hace clic en una tarjeta de proyecto
- **THEN** se navega a la vista de tickets filtrada por ese proyecto

#### Scenario: Visitar sitio del proyecto
- **WHEN** el usuario hace clic en "Visitar sitio" en una tarjeta
- **THEN** se abre el enlace correspondiente (prod o local según el toggle)

### Requirement: Toggle de entorno
El sistema SHALL mantener el toggle de entorno (Producción / Localhost) para alternar URLs.

#### Scenario: Activar modo Localhost
- **WHEN** el usuario activa el toggle
- **THEN** los enlaces de los proyectos apuntan a las URLs locales

#### Scenario: Activar modo Producción
- **WHEN** el usuario desactiva el toggle
- **THEN** los enlaces de los proyectos apuntan a las URLs de producción

#### Scenario: Persistir estado del toggle
- **WHEN** el usuario cambia el toggle
- **THEN** el estado se guarda en localStorage y se restaura al recargar la página

### Requirement: Proyectos ocultos al jefe
El sistema SHALL permitir ocultar proyectos de la vista del jefe.

#### Scenario: Ocultar proyecto al jefe
- **WHEN** el usuario (dev) marca un proyecto como `hidden_from_boss`
- **THEN** el proyecto no aparece en la vista del jefe

#### Scenario: Ver proyecto oculto como dev
- **WHEN** el usuario (dev) abre el directorio
- **THEN** ve todos los proyectos incluyendo los ocultos al jefe

### Requirement: Búsqueda de tickets
El sistema SHALL permitir buscar tickets por título, descripción o ID.

#### Scenario: Buscar ticket por título
- **WHEN** el usuario escribe en el campo de búsqueda
- **THEN** se filtran los tickets que coinciden con el texto en el título

#### Scenario: Buscar ticket por ID
- **WHEN** el usuario escribe un número de ticket en la búsqueda
- **THEN** se filtra el ticket con ese ID exacto

#### Scenario: Búsqueda sin resultados
- **WHEN** no hay tickets que coincidan con la búsqueda
- **THEN** se muestra un mensaje "No se encontraron resultados"

### Requirement: Filtros de tickets
El sistema SHALL permitir filtrar tickets por proyecto, estado y prioridad.

#### Scenario: Filtrar por proyecto
- **WHEN** el usuario selecciona un proyecto en el filtro
- **THEN** se muestran solo los tickets de ese proyecto

#### Scenario: Filtrar por estado
- **WHEN** el usuario selecciona un estado en el filtro
- **THEN** se muestran solo los tickets con ese estado

#### Scenario: Filtrar por prioridad
- **WHEN** el usuario selecciona una prioridad en el filtro
- **THEN** se muestran solo los tickets con esa prioridad

#### Scenario: Combinar filtros
- **WHEN** el usuario combina múltiples filtros
- **THEN** se muestran tickets que cumplen todos los filtros simultáneamente

### Requirement: Ordenamiento de tickets
El sistema SHALL permitir ordenar tickets por fecha de creación, deadline o prioridad.

#### Scenario: Ordenar por más reciente
- **WHEN** el usuario selecciona "Más reciente"
- **THEN** los tickets se ordenan del más nuevo al más antiguo

#### Scenario: Ordenar por deadline
- **WHEN** el usuario selecciona "Deadline"
- **THEN** los tickets se ordenan del deadline más cercano al más lejano

### Requirement: Diseño estilo GitHub Issues
El sistema SHALL mostrar la vista de detalle de tickets con diseño estilo GitHub Issues.

#### Scenario: Vista de detalle de ticket
- **WHEN** el usuario abre un ticket
- **THEN** ve un layout de dos columnas: sidebar con metadatos a la izquierda, conversación a la derecha

#### Scenario: Sidebar de metadatos
- **WHEN** el usuario ve el sidebar de un ticket
- **THEN** ve: proyecto, prioridad, estado, asignado a, deadline, subtareas, archivos adjuntos
