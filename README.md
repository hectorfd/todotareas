# Practica 1
<center>por: <strong>Héctor Ferro Dávalos</strong></center>

# Aplicación ToDoList o lista de Tareas

### Petición de la Practica
La aplicación es una aplicación para gestionar listas de tareas pendientes de los
usuarios de la aplicación. Se pueden registrar y logear usuarios y los usuarios
registrados pueden añadir, modificar y borrar tareas pendientes de hacer.
## Definición de Necesidades
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
| **7** | Las tareas pueden contener comentarios como forma de comunicación entre los usuarios que participan colaborativamente en una lista

### Lenguaje de Programación
#### PHP
Según la petición la aplicación debe desarrollarse en el lenguaje de programación PHP
##### Laravel
es el framework que sera utilizado para el desarrollo de la aplicación la version que utilizaremos es Laravel Framework 10.48.12 

### Tabla de herramientas utilizadas en esta Practica

| Nro   | Aplicación                                                                             |
| ----- | -------------------------------------------------------------------------------------- |
| **1** | **IDE. Visual Studio Code:** sera utilizado para codificar la aplicación TODOLIST      |
| **2** | **Moon Modeler:** utilizaremos este entorno para el diseño ER de la base de datos      |
| **3** | **Obsidian:** para documentar esta aplicación                                          |
| **4** | **Laragon:** para lanzar y probar la aplicación gracias a su entorno de desarrollo web |
| **5** | **Navegadores web:** para visualizar la aplicación, Firefox developer, chrome y Edge   |
### Tabla de tecnologías que serán utilizadas en esta Practica                                              
| Nro   | Aplicación                                                                            |
| ----- | ------------------------------------------------------------------------------------- |
| **1** | **NODE.js 21.5:** para instalar complementos                                          |
| **2** | **PHP 8.1:** para utilizar el lenguaje en su version para windows                     |
| **3** | **Breeze:** paquete de autenticación de Laravel                                       |
| **4** | **Artisan:** utilidad de consola de comandos para automatizar tareas de creación etc. |
| **5** | **Sweetalert2:** para configurar ventanas emergentes de alerta                        |
| **6** | **Tailwind:** para los estilos CSS de la aplicacion                                   |
| **7** | **Bootstrap:** util para armar fácilmente estructuras de nuestra aplicación           |

## Análisis y Diseño

### Modelo Lógico

![Modelo lógico](public/md/TodoList1.jpg)

## Desarrollo
### Pasos Iniciales
- Iniciamos instalando Laravel en el terminal de laragon
```bash
composer create-project --prefer-dist laravel/laravel tareas
```
- En MySQL de laragon ejecutaremos 
```mysql
CREATE DATABASE tareas
```
- configuraremos el archivo .env con los datos de laragon para la base de datos
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tareas
DB_USERNAME=root
DB_PASSWORD=
```
- después instalamos Breeze
```bash
composer require laravel/breeze --dev
```
- para traducciones, instalara una carpeta de lang para traducir errores del ingles a cualquier idioma de preferencia
```bash
composer require laravel-lang/common --dev
```
- Para la base de datos utilizaremos Eloquent es el ORM de Laravel ORM(Objet-Relational Mapper) 
- en este caso el comando creara la tabla de migración, el modelo y el controlador
```bash
php artisan make:model TaskList -m -c
```
se debe usar el comando para cada tabla de la base de datos en orden
1. users
2. groups
3. group members
4. task list
5. tasks
6. subtasks
7. comments
8. attachments
Breeze genera tablas adicionales en su instalación
- password reset tokens
- failed jobs
- personal access tokens

## Código
Tabla Users
```php
Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username',30)->unique();
            $table->string('nombre',60)->nullable();
            $table->string('apellido',60)->nullable();
            $table->integer('telefono')->nullable();
            $table->string('direccion',100)->nullable();
            $table->string('email',60)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255);
            $table->rememberToken();
            $table->timestamps();
        });
```
esta es la forma como eloquent de laravel creara la tabla users 
```mermaid
erDiagram

    Users {

        string username(30)

        string nombre(60)

        string apellido(60)

        int telefono

        string direccion(100)

        string email(60)

        string password(255)

        string rememberToken

        timestamp created_at

        timestamp updated_at

    }
```
una vez configurado cada tabla utilizaremos el comando para migrar
```bash
php artisan migrate
```

crearemos control de versiones con git para eso en Visual code o el terminal de Laragon ejecutaremos
```bash
git init
```

crearemos nuestro primer commit en visual code y configuraremos los pasos necesarios para GitHub

aquí mostramos una vista de tiempo de commits

![Vista Git](public/md/git.jpg)

### Modelo Vista Controlador 
ejemplo en nuestro Código implementado Lista de Tareas
#### Modelo-Migración
podemos observar que la llave foránea de grupo tiene valor nulo, esta puede ser relacionada mas tarde con algún grupo de trabajo que se cree mas adelante
```php
Schema::create('task_lists', function (Blueprint $table) {
            $table->id();
            $table->string('listName', 100);
            $table->text('descripcion')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            $table->timestamps();
        });
```
#### Modelo-Model
tenemos que hacer referencia a la tabla de tareas y usuarios con la cual tiene relación, también definimos los valores que serán añadidos a la base de datos, ['Listname', 'descripcion','user_id'], group_id es una funcionalidad que sera realizada en el futuro como sabemos solo avanzaremos hasta el nivel 4 por lo cual aun no usaremos esta funcionalidad 
```php
protected $fillable = ['listName', 'descripcion', 'user_id'];
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
```
### Controlador
este es el controlador de lista de tareas en donde tenemos los metodos para nuestro CRUD tenemos: 
1. create(), para llamar al archivo create.blade.php de la carpeta task_lists en donde se encuentra el formulario de la vista.
2. store(), validara la información ingresada en el formulario de la vista si la accion finaliza con éxito redireccionara al dashboard
3. edit(), traerá los datos del modelo al formulario del archivo edit
4. update(), validara y actualizara cualquier cambio realizado en el formulario
5. destroy(), eliminara la actual lista que selecionaste para eliminar 

```php
public function create()
    {
        return view('task_lists.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'listName' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);
        TaskList::create([
            'listName' => $request->listName,
            'descripcion' => $request->descripcion,
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('dashboard')->with('success', 'Lista creada exitosamente');
    }
    public function edit($id)
    {
    $taskList = TaskList::findOrFail($id);
    return view('task_lists.edit', compact('taskList'));
    }
    public function update(Request $request, $id)
    {
    $taskList = TaskList::findOrFail($id);
    $request->validate([
        'listName' => 'required|string|max:100',
        'descripcion' => 'nullable|string',
    ]);
    $taskList->update([
        'listName' => $request->listName,
        'descripcion' => $request->descripcion,
    ]);
    return redirect()->route('dashboard')->with('success', 'Lista actualizada exitosamente');
}
 public function destroy($id)
    {
        $taskList = TaskList::findOrFail($id);
        $taskList->delete();
        return redirect()->route('dashboard')->with('success', 'Lista eliminada exitosamente');
    }
```
### Vista 
#### Vista - Create
esta es la vista que el usuario podrá interactuar para crear una lista, consiste en un formulario básico y estilos combinados con tailwind, boobstrap y css convensional.

```php
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Crear Lista</div>
                    <div class="card-body">
                        <form action="{{ route('task_lists.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="listName">Nombre de la Lista</label>
                                <input type="text" name="listName" id="listName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```
#### Vista - edit
esta es la vista para editar y actualizar las listas, falta aplicar modularidad para organizar mejor el codigo 
```php
@foreach($taskLists as $taskList)
    <div class="modal fade" id="editTaskListModal-{{ $taskList->id }}" tabindex="-1" role="dialog" aria-labelledby="editTaskListModalLabel-{{ $taskList->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskListModalLabel-{{ $taskList->id }}">Editar Lista</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('task_lists.update', $taskList->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="listName">Nombre de la Lista</label>
                            <input type="text" class="form-control" id="listName" name="listName" value="{{ $taskList->listName }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
```
#### Vista-dashboard
En esta vista aplicamos una condicional el usuario vera por primera ves un campo para crear su primera lista una ves que una lista se haya creado mostrara la lista creada ocultado los demás elementos
```php
 @if($taskLists->count() == 0)
                <div class="card mt-4">
                    <div class="card-header"> <h2>Crear tu primera lista</h2></div>
                    <div class="card-body">
                        <a href="{{ route('task_lists.create') }}" class="btn btn-primary">Crear lista</a>
                    </div>
                </div>
            @endif
            @if($taskLists->count() > 0)
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center bg-purple-600">
                        <h2 class="mb-0 font-bold text-white">Tus Listas</h2>
                        <div class="justify-content-center">
                            <a href="{{ route('task_lists.create') }}" class="btn btn-primary">Crear lista</a>
                        </div>
                    </div>
```

Esta parte del Código dentro de dashboard lista todas las listas creadas acompañadas de botones para el CRUD de la lista y un botón para Crear Tareas 
```php

@foreach($taskLists as $taskList)
<li class="list-group-item">
<div class="d-flex justify-content-between align-items-center">
<button class="btn btn-link toggle-tasks" data-target="tasks-{{ $taskList->id }}">
<i class="fas fa-tasks mr-2"></i>
</button>
<h4 class="font-bold">{{ $taskList->listName }}</h4>
<div class="d-flex align-items-center">
<a href="{{ route('tasks.create', $taskList->id) }}" class="btn btn-primary btn-sm">Crear tarea</a>
<a href="{{ route('tasks.completed', $taskList->id) }}" class="btn btn-success ml-2 btn-sm"><i class="fas fa-check-square mr-0 text-white"></i></a>
<button class="btn btn-info ml-2 btn-sm" data-toggle="modal" data-target="#editTaskListModal-{{ $taskList->id }}"><i class="fas fa-pencil-alt mr-0 text-white"></i></button>
<form method="POST" action="{{ route('task_lists.destroy', $taskList->id) }}" class="inline-block ml-2 delete-form">
  @csrf
  @method('DELETE')
<button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-trash-alt mr-0 text-white"></i></button>
                                          
```