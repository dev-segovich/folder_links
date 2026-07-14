## ADDED Requirements

### Requirement: Dashboard unificado
El sistema SHALL mostrar un dashboard principal con resumen de tickets y proyectos activos.

#### Scenario: Ver resumen de tickets
- **WHEN** el usuario abre el dashboard
- **THEN** ve contadores de: tickets activos, en progreso, en revisión, nuevos

#### Scenario: Ver proyectos en el dashboard
- **WHEN** el usuario abre el dashboard
- **THEN** ve las tarjetas de proyectos con logos, badges de entorno, contadores de tickets y botón de visitar

#### Scenario: Crear ticket desde el dashboard
- **WHEN** el usuario hace clic en "+ Crear ticket" desde el dashboard
- **THEN** se abre el formulario de creación de ticket

#### Scenario: Acceder a vista de tickets desde el dashboard
- **WHEN** el usuario navega a la vista de tickets desde el dashboard
- **THEN** ve la lista completa de tickets con filtros

### Requirement: Contadores de tickets en tiempo real
El sistema SHALL mostrar contadores actualizados de tickets por proyecto.

#### Scenario: Contador de tickets activos
- **WHEN** un proyecto tiene tickets en estados Backlog, En progreso o En revisión
- **THEN** la tarjeta del proyecto muestra el número total de tickets activos

#### Scenario: Contador de tickets por estado
- **WHEN** un proyecto tiene tickets en diferentes estados
- **THEN** al pasar el cursor sobre el contador se muestra el desglose por estado

### Requirement: Responsive design
El sistema SHALL funcionar correctamente en diferentes tamaños de pantalla.

#### Scenario: Vista en escritorio
- **WHEN** el usuario accede desde un escritorio
- **THEN** el dashboard muestra la grilla de proyectos en columnas múltiples y la vista de tickets con sidebar

#### Scenario: Vista en móvil
- **WHEN** el usuario accede desde un móvil
- **THEN** el dashboard adapta la grilla a una columna y la vista de ticket a layout vertical

### Requirement: Diseño visual consistente
El sistema SHALL mantener una paleta de colores y tipografía coherente.

#### Scenario: Paleta de colores
- **WHEN** el usuario ve el dashboard
- **THEN** los colores siguen la paleta: fondo oscuro (#3a4453), acentos verde (#22c55e) para prod y ámbar (#fbbf24) para qa

#### Scenario: Tipografía Poppins
- **WHEN** el usuario ve cualquier vista
- **THEN** la tipografía utilizada es Poppins en todos los textos
