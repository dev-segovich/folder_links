## ADDED Requirements

### Requirement: Creación de tickets
El sistema SHALL permitir al usuario crear tickets vinculados a un proyecto existente.

#### Scenario: Crear ticket desde el dashboard
- **WHEN** el usuario hace clic en "+ Crear ticket" desde el dashboard
- **THEN** se muestra un formulario con campos: título, descripción, proyecto, prioridad, deadline, asignado a

#### Scenario: Crear ticket con prioridad alta
- **WHEN** el usuario selecciona prioridad "Alta" al crear un ticket
- **THEN** el ticket se marca con indicador visual de prioridad alta y se muestra en la vista de tickets

#### Scenario: Crear ticket sin asignar
- **WHEN** el usuario crea un ticket sin seleccionar un asignado
- **THEN** el campo asignado queda vacío y el ticket aparece como "sin asignar"

### Requirement: Estados del ticket
El sistema SHALL gestionar tickets con los siguientes estados: Backlog, En progreso, En revisión, Done.

#### Scenario: Crear ticket en estado Backlog
- **WHEN** se crea un nuevo ticket
- **THEN** el ticket inicia en estado "Backlog"

#### Scenario: Mover ticket a En progreso
- **WHEN** el usuario cambia el estado de un ticket de "Backlog" a "En progreso"
- **THEN** el ticket se actualiza y se registra en el historial del ticket

#### Scenario: Mover ticket a En revisión
- **WHEN** el usuario cambia el estado de un ticket de "En progreso" a "En revisión"
- **THEN** el ticket se actualiza y se registra en el historial del ticket

#### Scenario: Retroceder ticket desde En revisión a Backlog
- **WHEN** el usuario está en estado "En revisión" y retrocede a "Backlog"
- **THEN** el ticket vuelve al estado "Backlog" y se registra en el historial

#### Scenario: Mover ticket a Done
- **WHEN** el usuario cambia el estado de un ticket de "En revisión" a "Done"
- **THEN** el ticket se marca como completado y se registra en el historial

#### Scenario: Mover ticket de vuelta a En progreso desde Done
- **WHEN** el usuario reabre un ticket en estado "Done"
- **THEN** el ticket vuelve a "En progreso" y se registra en el historial

### Requirement: Historial de conversación
El sistema SHALL permitir comentarios en cada ticket que formen un historial de conversación.

#### Scenario: Añadir comentario a un ticket
- **WHEN** el usuario escribe un comentario en la sección de conversación de un ticket
- **THEN** el comentario se guarda con el autor, fecha y hora visibles

#### Scenario: Ver historial de conversación
- **WHEN** el usuario abre un ticket
- **THEN** ve todos los comentarios en orden cronológico, con autor y timestamp

#### Scenario: Eliminar comentario
- **WHEN** el autor de un comentario lo elimina
- **THEN** el comentario se marca como eliminado y se registra en el audit log

### Requirement: Subtareas
El sistema SHALL permitir crear subtareas dentro de cada ticket.

#### Scenario: Crear subtarea en un ticket
- **WHEN** el usuario añade una subtarea a un ticket
- **THEN** la subtarea se muestra en la lista del ticket con checkbox de completado

#### Scenario: Marcar subtarea como completada
- **WHEN** el usuario marca una subtarea como completada
- **THEN** se actualiza el estado visual de la subtarea y el progreso del ticket

#### Scenario: Eliminar subtarea
- **WHEN** el usuario elimina una subtarea
- **THEN** la subtarea se elimina del ticket y se registra en el audit log

### Requirement: Archivos adjuntos
El sistema SHALL permitir adjuntar archivos a los tickets.

#### Scenario: Subir archivo a un ticket
- **WHEN** el usuario adjunta un archivo a un ticket
- **THEN** el archivo se guarda en el servidor y se lista en la sección de archivos del ticket

#### Scenario: Descargar archivo adjunto
- **WHEN** el usuario hace clic en un archivo adjunto
- **THEN** se descarga el archivo

#### Scenario: Eliminar archivo adjunto
- **WHEN** el usuario elimina un archivo adjunto
- **THEN** el archivo se elimina del servidor y se registra en el audit log

### Requirement: Prioridades
El sistema SHALL gestionar tickets con niveles de prioridad: Baja, Media, Alta, Crítica.

#### Scenario: Asignar prioridad Crítica
- **WHEN** el usuario selecciona prioridad "Crítica" al crear un ticket
- **THEN** el ticket se muestra con indicador visual de prioridad crítica

#### Scenario: Cambiar prioridad de un ticket
- **WHEN** el usuario cambia la prioridad de un ticket existente
- **THEN** el indicador visual se actualiza y se registra en el historial

### Requirement: Deadlines
El sistema SHALL permitir asignar fechas límite a los tickets.

#### Scenario: Asignar deadline a un ticket
- **WHEN** el usuario establece una fecha límite en un ticket
- **THEN** el deadline se muestra en la tarjeta del ticket y en la vista de detalle

#### Scenario: Ticket con deadline vencido
- **WHEN** la fecha actual supera el deadline de un ticket no completado
- **THEN** el ticket se muestra con indicador visual de vencido

### Requirement: Audit log
El sistema SHALL registrar cambios importantes en los tickets.

#### Scenario: Registrar cambio de estado
- **WHEN** un ticket cambia de estado
- **THEN** se crea un registro en el audit log con ticket, acción, autor y timestamp

#### Scenario: Registrar cambio de prioridad
- **WHEN** la prioridad de un ticket cambia
- **THEN** se crea un registro en el audit log con los valores anterior y nuevo
