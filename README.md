# Practica 1
<center>por: <strong>Héctor Ferro Dávalos</strong></center>

# Aplicación ToDoList o lista de Tareas

### Petición de la Practica
La aplicación es una aplicación para gestionar listas de tareas pendientes de los
usuarios de la aplicación. Se pueden registrar y logear usuarios y los usuarios
registrados pueden añadir, modificar y borrar tareas pendientes de hacer.
## Análisis y Diseño
el siguiente análisis se hizo en base al uso de aplicaciones existentes de TODOs en la red, se observo en que consiste este tipo de aplicaciones y continuación se muestra los requerimientos para nuestra aplicación de TODOs con nuestra propia abstracción
### Tabla de Requerimientos
Los siguientes requerimientos se tomaron en cuenta para el desarrollo de la aplicación, al contar con poco tiempo, se utilizara solo una iteración para poder entregar software funcional, el objetivo propuesto por el programador es el nivel 4 que cumple con la **petición de la practica**  

| Nivel | Requerimiento                                                                                                                                                                                                                    |
| ----- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **1** | Los usuarios deben hacer login en la aplicación, el login debe ser el username y el password.                                                                                                                                    |
| **2** | El registro debe ser libre para el usuario nuevo, los datos que se pidan serán de libertad del programador para futuros estudios de datos                                                                                        |
| **3** | El login debe contener seguridad por JWT, el token debe tener un tamaño de hasta 255 caracteres, la contraseña debe ser cifrada para que no sea visible en la base de datos                                                      |
| **4** | El TODOLIST debe contener una jerarquía, lista de tareas, tareas y subtareas, para una mejor administración                                                                                                                      |
| **5** | Las tareas pueden contener datos adjuntos, estos pueden contener diferentes tipos de archivos y multimedia.                                                                                                                      |
| **6** | las Listas de tareas pueden asociarse a grupos de trabajo en donde varios usuarios pueden trabajar juntos en una lista, la asociación debe darse por invitación del usuario dueño de la lista para una experiencia colaborativa. |
| **7** | Las tareas pueden contener comentarios como forma de comunicación entre los usuarios que participan colaborativamente en una lista                                                                                               |
## Diseño ER de la Base de Datos

