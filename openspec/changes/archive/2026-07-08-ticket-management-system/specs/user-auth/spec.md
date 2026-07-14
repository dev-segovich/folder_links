## ADDED Requirements

### Requirement: Autenticación
El sistema SHALL permitir a usuarios iniciar sesión para acceder a la aplicación.

#### Scenario: Login exitoso
- **WHEN** un usuario ingresa credenciales correctas
- **THEN** es redirigido al dashboard con sesión activa

#### Scenario: Login fallido
- **WHEN** un usuario ingresa credenciales incorrectas
- **THEN** se muestra un mensaje de error y no se concede acceso

#### Scenario: Cerrar sesión
- **WHEN** un usuario cierra sesión
- **THEN** la sesión se invalida y se redirige a la página de login

### Requirement: Roles de usuario
El sistema SHALL gestionar dos roles: dev (desarrollador) y boss (jefe).

#### Scenario: Usuario con rol dev
- **WHEN** un usuario con rol "dev" inicia sesión
- **THEN** tiene acceso completo a todas las funcionalidades

#### Scenario: Usuario con rol boss
- **WHEN** un usuario con rol "boss" inicia sesión
- **THEN** puede ver proyectos no ocultos, crear tickets, cambiar estados y comentar

### Requirement: Control de visibilidad de proyectos
El sistema SHALL respetar el flag `hidden_from_boss` al mostrar proyectos.

#### Scenario: Dev ve todos los proyectos
- **WHEN** un usuario con rol "dev" abre el directorio
- **THEN** ve todos los proyectos sin filtrar

#### Scenario: Boss no ve proyectos ocultos
- **WHEN** un usuario con rol "boss" abre el directorio
- **THEN** solo ve los proyectos donde `hidden_from_boss` es falso

### Requirement: Creación de tickets por boss
El sistema SHALL permitir que el jefe cree tickets.

#### Scenario: Boss crea un ticket
- **WHEN** un usuario con rol "boss" crea un ticket
- **THEN** el ticket se crea con `created_by = boss` y es visible para todos

#### Scenario: Boss cambia estado de ticket
- **WHEN** un usuario con rol "boss" cambia el estado de un ticket
- **THEN** el cambio se aplica y se registra en el audit log

### Requirement: Preparación para AI Agent
El sistema SHALL dejar la estructura preparada para integración futura con un AI Agent.

#### Scenario: Estructura de API para AI Agent
- **WHEN** se implementa la capa de API
- **THEN** se incluyen endpoints para creación de tickets vía API con autenticación por API key

#### Scenario: Tabla de API keys
- **WHEN** se prepara la estructura de autenticación para AI Agent
- **THEN** existe una tabla para almacenar API keys con permisos asociados
