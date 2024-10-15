@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row">
        <div class="col-md-4">
            <div class="card panel-listas panel-listas-fixed">
                <div class="card-header">
                    <h2 class="mb-0 font-bold text-black">Mis listas</h2>
                    <a href="{{ route('task_lists.create') }}" class="btn btn-primary">Crear lista</a>
                </div>
        
                <!-- Caja de listas con scroll -->
                <div class="list-group overflow-y-auto max-h-[560px]"> <!-- Añadido el scroll vertical -->
                    <!-- Listas propias -->
                    @foreach($taskLists as $taskList)
                    <div class="list-group-item flex justify-between items-center px-3 py-2 cursor-pointer bg-custom"
                        onclick="showTasks({{ $taskList->id }})"
                        @if(request('list') == $taskList->id) style="background-color: #f0f8ff;" @endif> <!-- Condición para mantener la lista seleccionada visible -->
                        <i class="fas fa-check icon-check" onclick="event.stopPropagation(); openIconModal();"></i>
                        <small class="text-sm flex-grow text-gray-800 ml-2">{{ $taskList->listName }}</small>
                        <span class="rounded-full px-3 py-1 text-sm text-white bg-custom2">{{ count($taskList->tasks) }}</span>
                    </div>
                    @endforeach
                    
                    <!-- Listas compartidas -->
                    @foreach($sharedTaskLists as $taskList)
                    <div class="list-group-item flex justify-between items-center px-3 py-2 cursor-pointer bg-lavender"
                        onclick="showTasks({{ $taskList->id }})"
                        @if(request('list') == $taskList->id) style="background-color: #f0f8ff;" @endif> <!-- Condición para mantener la lista seleccionada visible -->
                        <i class="fas fa-share-alt icon-check text-gray-400" onclick="event.stopPropagation(); openIconModal();"></i>
                        <small class="text-sm flex-grow text-gray-800 ml-2">{{ $taskList->listName }} (Compartida)</small>
                        <span class="rounded-full px-3 py-1 text-sm text-white bg-custom2">{{ count($taskList->tasks) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        
        
        

        <!-- Modal para seleccionar íconos -->
        <div class="modal fade" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="iconModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="iconModalLabel">Seleccionar Icono</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <i class="fas fa-check" onclick="setIcon('fa-check')"></i>
                        <i class="fas fa-star" onclick="setIcon('fa-star')"></i>
                        <i class="fas fa-heart" onclick="setIcon('fa-heart')"></i>
                        <i class="fas fa-bell" onclick="setIcon('fa-bell')"></i>
                        <i class="fas fa-flag" onclick="setIcon('fa-flag')"></i>
                        <i class="fas fa-envelope" onclick="setIcon('fa-envelope')"></i>
                        
                    </div>
                </div>
            </div>
        </div>



        <!-- Contenido de las Tareas -->
        <div class="col-md-8">
            <div class="d-flex align-items-center justify-content-between mb-3"> 
                <div class="d-flex align-items-center"> 
                    <div class="mr-1">
                        <a href="{{ route('profile.edit') }}" class="btn btn-indigo ml-2">
                        @if(Auth::user()->foto)
                            @if(filter_var(Auth::user()->foto, FILTER_VALIDATE_URL))
                                <img src="{{ Auth::user()->foto }}" alt="Foto de Perfil" style="width: 50px; height: 50px; border-radius: 50%;">
                            @else
                                <img src="{{ Storage::url(Auth::user()->foto) }}" alt="Foto de Perfil" style="width: 50px; height: 50px; border-radius: 50%;">
                            @endif
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: gray; display: flex; align-items: center; justify-content: center; color: white;">
                                Sin foto
                            </div>
                        @endif
                    </a>

                    </div>
                    <div>
                        <span class="font-bold animate-colorChange text-lg">{{ Auth::user()->username }}</span>
                        
                    </div>
                    
                </div>
                

                
                <div>
                    @if($taskLists->count() > 0 || $sharedTaskLists->count() > 0)
                        @php
                            $hayNotificaciones = !$invitations->isEmpty() || ($expiredTasks && !$expiredTasks->isEmpty());
                            $iconColor = $hayNotificaciones ? '#F97E72' : '#28a745'; 
                        @endphp
                        
                        {{-- <button data-toggle="modal" data-target="#notificationsModal-{{ $taskList->id }}" data-toggle="tooltip" title="Ver Notificaciones">
                            <i class="fas fa-bell fa-2x" style="color: {{ $iconColor }};" 
                                onmouseover="this.style.color='#FF5E00';" 
                                onmouseout="this.style.color='{{ $iconColor }}';"></i>
                        </button> --}}
                        <div class="tooltip-container">
                            <button data-toggle="modal" data-target="#notificationsModal-{{ $taskList->id }}">
                                <i class="fas fa-bell fa-2x" style="color: {{ $iconColor }};" 
                                    onmouseover="this.style.color='#FF5E00';" 
                                    onmouseout="this.style.color='{{ $iconColor }}';"></i>
                            </button>
                            <span class="tooltiptext">Ver Notificaciones</span>
                        </div>
                        
                        
                
                        <!-- Modal de Notificaciones -->
                        <div class="modal fade" id="notificationsModal-{{ $taskList->id }}" tabindex="-1" role="dialog" aria-labelledby="notificationsModalLabel-{{ $taskList->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="notificationsModalLabel">Notificaciones</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Invitaciones -->
                                        @if($invitations->isEmpty())
                                            <p>No tienes invitaciones pendientes.</p>
                                        @else
                                            @foreach($invitations as $invitation)
                                                @if($invitation->inviter)
                                                    <p>{{ $invitation->inviter->username }} te ha invitado al grupo.</p>
                                                @else
                                                    <p>El usuario que te invitó ya no existe.</p>
                                                @endif
                                                <form method="POST" action="{{ route('invitations.respond', $invitation->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="response" value="accepted" class="btn btn-success btn-sm">Aceptar</button>
                                                    <button type="submit" name="response" value="rejected" class="btn btn-danger btn-sm">Rechazar</button>
                                                </form>
                                            @endforeach
                                        @endif
                
                                        <!-- Tareas vencidas -->
                                        <h5 class="mt-4 text-lg font-semibold">Tareas Vencidas</h5>
                                        @isset($expiredTasks)
                                            @if($expiredTasks->isEmpty())
                                                <p class="text-gray-500">No tienes tareas vencidas.</p>
                                            @else
                                                @foreach($expiredTasks as $task)
                                                    <div class="flex justify-between items-center mb-2 p-2 border border-red-300 rounded bg-red-50">
                                                        <p class="text-red-600">
                                                            Tarea: {{ $task->titulo }} - Vencida el: {{ \Carbon\Carbon::parse($task->fecha_vencimiento)->format('d/m/Y H:i') }}
                                                        </p>
                                                        <a href="{{ route('dashboard', ['list' => $task->task_list_id]) }}" class="btn btn-primary btn-sm">Ver</a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
            </div>

            @if($taskLists->count() == 0)
                <div class="card mt-4">
                    <div class="card-header"> <h2>Crear tu primera lista</h2></div>
                    <div class="card-body">
                        <a href="{{ route('task_lists.create') }}" class="btn btn-primary">Crear lista</a>
                    </div>
                </div>
            @endif

            @if($taskLists->count() > 0 )
                <div class="card-body bg-custom rounded">
                        @foreach($taskLists as $taskList)
                            <!-- Contenedor de las tareas de cada lista, inicialmente oculto -->
                            
                            <ul class="list-group tasks-container" id="task-list-{{ $taskList->id }}" style="display: none;">
                                <h4 class="font-bold">{{ $taskList->listName }}</h4>
                                <br>
                                <li class="">
                                    <div class="d-flex justify-content-between align-items-center">
                                        
                                        <button class="btn btn-link toggle-tasks" data-target="tasks-{{ $taskList->id }}">
                                            <i class="fas fa-tasks mr-2"></i>
                                        </button>
                                        {{-- <h4 class="font-bold">{{ $taskList->listName }}</h4> --}}
                                        
                                            
                                            <a href="{{ route('tasks.create', $taskList->id) }}" class="btn btn-indigo btn-sm bg-emerald text-white border border-transparent hover:bg-mustard hover:border-turquoiseDark">Crear tarea</a>
                                            <div class="tooltip-container">
                                                <a href="{{ route('tasks.completed', $taskList->id) }}" class="btn btn-indigo ml-2 btn-sm">
                                                    <i class="fas fa-check-square fa-2x mr-0" style="color: #1ED760;" onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#1ED760';"></i>
                                                </a>
                                                <span class="tooltiptext">Ver tareas completadas</span>
                                            </div>
                                            
                                            <div class="tooltip-container">
                                            <button class="btn btn-indigo  btn-sm" data-toggle="modal" data-target="#editTaskListModal-{{ $taskList->id }}">
                                                <i class="fas fa-pen-square mr-0 fa-2x" style="color: #2AC2D1;" onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#2AC2D1';"></i>
                                            </button>
                                            <span class="tooltiptext">Editar lista</span>
                                            </div>

                                            <!-- Botón para crear un nuevo grupo -->
                                            <div class="tooltip-container">
                                            <button class="btn btn-indigo btn-sm ml-0" data-toggle="modal" data-target="#createGroupModal-{{ $taskList->id }}">
                                                <i class="fas fa-folder fa-2x" style="color: #9367EB;" onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#9367EB';"></i>
                                            </button>
                                            <span class="tooltiptext">Crear Grupo trabajo</span>
                                            </div>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="createGroupModal-{{ $taskList->id }}" tabindex="-1" role="dialog" aria-labelledby="createGroupModalLabel-{{ $taskList->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="createGroupModalLabel-{{ $taskList->id }}">Crear Nuevo Grupo</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form action="{{ route('groups.store') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="groupname">Nombre del Grupo</label>
                                                                    <input type="text" class="form-control" id="groupname" name="groupname" required>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="descripcion">Descripción</label>
                                                                    <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Crear Grupo</button>
                                                            </div>
                                                        </form>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tooltip-container">
                                            <button class="btn  btn-sm ml-0" data-toggle="modal" data-target="#assignGroupModal-{{ $taskList->id }}">
                                                <i class="fas fa-plus-square fa-2x" style="color: #72F0B7;" onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#72F0B7';"></i>
                                            </button>
                                            <span class="tooltiptext">Agregar lista a grupo</span>
                                            </div>

                                            <!-- Modal para asignar lista de tareas a un grupo -->
                                            <div class="modal fade" id="assignGroupModal-{{ $taskList->id }}" tabindex="-1" role="dialog" aria-labelledby="assignGroupModalLabel-{{ $taskList->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="assignGroupModalLabel-{{ $taskList->id }}">Asignar Lista a un Grupo</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>

                                                        <form method="POST" action="{{ route('task_lists.assignGroup', $taskList->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="group_id">Selecciona un grupo</label>
                                                                    <select name="group_id" id="group_id" class="form-control" required>
                                                                        <option value="" disabled selected>Elige un grupo</option>
                                                                        @foreach($groups as $group)
                                                                            <option value="{{ $group->id }}">{{ $group->groupname }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Agregar esta lista al grupo</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($taskList->group_id)
                                            <div class="tooltip-container">
                                            <button data-toggle="modal" data-target="#inviteUserModal-{{ $taskList->id }}-{{ $taskList->group_id }}">
                                                <i class=" fas fa-user-plus fa-lg" style="color: #343A40;" onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#343A40';"></i>
                                            </button>
                                            <span class="tooltiptext">Invitar colaboradores</span>
                                            </div>
                                            @endif
                                            @if($taskList->group_id)
                                            <!-- Modal para invitar usuarios al grupo -->
                                            <div class="modal fade" id="inviteUserModal-{{ $taskList->id }}-{{ $taskList->group_id }}" tabindex="-1" role="dialog" aria-labelledby="inviteUserModalLabel-{{ $taskList->id }}-{{ $taskList->group_id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="inviteUserModalLabel-{{ $taskList->group_id }}">Invitar Usuario al Grupo</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form method="POST" action="{{ route('groups.inviteUser', $taskList->group_id) }}">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="user_id">Selecciona un usuario</label>
                                                                    <select name="user_id" id="user_id" class="form-control" required>
                                                                        <option value="" disabled selected>Elige un usuario</option>
                                                                        @foreach($users as $user)
                                                                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                    
                                                                <div class="form-group">
                                                                    <label for="role">Rol</label>
                                                                    <select name="role" id="role" class="form-control" required>
                                                                        <option value="read">Lector</option>
                                                                        <option value="write">Escritor</option>
                                                                        <option value="admin">Administrador</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Enviar invitación</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                            

                                        <div class="d-flex align-items-center">

                                            <form method="POST" action="{{ route('task_lists.destroy', $taskList->id) }}" class="inline-block ml-1 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-indigo btn-sm delete-btn">
                                                    <i class="fas fa-times mr-0 fa-2x" style="color: #BAC2C7; " onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#BAC2C7';"></i>
                                                </button>
                                            </form>

                                        

                                            
                                        </div>
                                            
                                    </div>

                                    <ul class="list-group mt-3 tasks-{{ $taskList->id }}">
                                        @foreach($taskList->tasks->where('completada', 0) as $task)
                                            <li class="list-group-item {{ $task->fecha_vencimiento && $task->fecha_vencimiento < now() && !$task->completada ? 'task-vencida' : '' }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <strong >{{ $task->titulo }}</strong>
                                                        <p class="text-sm text-indigo-700">{{ $task->descripcion }}</p>
                                                        <small class="text-gray-400">{{ $task->fecha_vencimiento && $task->fecha_vencimiento < now() && !$task->completada ? 'Vencido' : 'Vence' }}: {{ $task->fecha_vencimiento }}</small>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="completada" value="0">
                                                            <input type="checkbox" name="completada" value="1" class="form-check-input" {{ $task->completada ? 'checked' : '' }} onchange="this.form.submit()">
                                                            <span class=" badge badge-{{ $task->completada ? 'success' : 'secondary' }}">{{ $task->completada ? 'Completada' : 'Pendiente' }}</span>
                                                        </form>
                                                        <button class="btn btn-indigo btn-sm ml-2" data-toggle="modal" data-target="#editTaskModal-{{ $task->id }}">
                                                            <i class="far fa-edit mr-0 fa-2x" style="color: #FFCC41;" onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#FFCC41';"></i>
                                                        </button>
                                                        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="ml-2 delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-indigo  delete-btn">
                                                                <i class="fas fa-times mr-0 fa-lg " style="color: #BAC2C7;" onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#BAC2C7';"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

                                                @if ($task->subtasks && $task->subtasks->count() > 0)
                                                    <ul class="list-group mt-3">
                                                        @foreach($task->subtasks as $subtask)
                                                            <li class="list-group-item2 ">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div>
                                                                        <strong class="text-sm text-gray-500">{{ $subtask->titulo }}</strong>
                                                                        <form method="POST" action="{{ route('subtasks.updateStatus', $subtask->id) }}">
                                                                            @csrf
                                                                            @method('PATCH')
                                                                            <input type="checkbox" name="completado" value="1" class="form-check-input ml-1" {{ $subtask->completado ? 'checked' : '' }} onchange="this.form.submit()">
                                                                            <span>&#160;&#160;&#160;&#160;&#160;</span>
                                                                            <span class="badge badge-{{ $subtask->completado ? 'success' : 'secondary' }}">{{ $subtask->completado ? 'Completada' : 'Pendiente' }}</span>
                                                                        </form>
                                                                    </div>
                                                                    <form method="POST" action="{{ route('subtasks.destroy', $subtask->id) }}" class="ml-2 delete-form">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="button" class="btn btn-sm delete-btn">
                                                                            <i class="fas fa-times mr-0 text-indigo" style="color: rgba(117, 133, 144, 0.5);"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                                

                                                <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#createSubtaskModal-{{ $task->id }}">
                                                    Crear subtarea
                                                </button>

                                                <!-- Modal para crear subtarea -->
                                                <div class="modal fade" id="createSubtaskModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="createSubtaskModalLabel-{{ $task->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="createSubtaskModalLabel-{{ $task->id }}">Crear Subtarea</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            
                                                            <form method="POST" action="{{ route('subtasks.store', $task->id) }}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label for="titulo">Título</label>
                                                                        <input type="text" name="titulo" class="form-control" required>
                                                                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            </li>
                                            <p><br></p>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            
                        @endforeach
                    </div>
                </div>
            @endif 
        </div> 
                    <!-- Listas Compartidas -->
                    <div class="container">

                        <div class="row">
                    <div class="col-md-4">
                        
                    </div>
                    
                    <div class="col-md-8">
                        <div class="card-body bg-custom3 rounded">
                        @if($sharedTaskLists->count() > 0)
                        <h3>Listas Compartidas Contigo</h3>
                        @foreach($sharedTaskLists as $taskList)
                            <div class="list-group-item flex justify-between items-center px-3 py-2 cursor-pointer" onclick="showTasks({{ $taskList->id }})">
                                <i class="fas fa-share icon-check text-purple-500" onclick="event.stopPropagation(); openIconModal();"></i>
                                <small class="text-sm flex-grow text-gray-800 ml-2">{{ $taskList->listName }} (Compartida)</small>
                                <span class="badge panel-listas rounded-full px-3 py-1 text-sm">{{ count($taskList->tasks) }}</span>
                            </div>

                                <!-- Contenedor de las tareas -->
                                <ul class="list-group tasks-container" id="task-list-{{ $taskList->id }}" style="display: none;">
                                    
                                    @foreach($taskList->tasks as $task)
                                        <li class="list-group-item {{ $task->fecha_vencimiento && $task->fecha_vencimiento < now() && !$task->completada ? 'task-vencida' : '' }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $task->titulo }}</strong>
                                                    <p class="text-sm text-indigo-700">{{ $task->descripcion }}</p>
                                                    <small class="text-gray-400">{{ $task->fecha_vencimiento && $task->fecha_vencimiento < now() && !$task->completada ? 'Vencido' : 'Vence' }}: {{ $task->fecha_vencimiento }}</small>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <!-- Checkbox para completar tarea -->
                                                    <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="completada" value="0">
                                                        <input type="checkbox" name="completada" value="1" class="form-check-input" {{ $task->completada ? 'checked' : '' }} onchange="this.form.submit()">
                                                        <span class=" badge badge-{{ $task->completada ? 'success' : 'secondary' }}">{{ $task->completada ? 'Completada' : 'Pendiente' }}</span>
                                                    </form>
                                                    
                                                    <button class="btn btn-indigo btn-sm ml-2" data-toggle="modal" data-target="#editTaskModal-{{ $task->id }}">
                                                        <i class="far fa-edit mr-0 fa-2x" style="color: #FFCC41;" onmouseover="this.style.color='#FF5E00';" onmouseout="this.style.color='#FFCC41';"></i>
                                                    </button>
                                                    
                                                    <div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel-{{ $task->id }}" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editTaskModalLabel-{{ $task->id }}">Editar Tarea: {{ $task->titulo }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="modal-body">
                                                                        <!-- Título de la tarea -->
                                                                        <div class="form-group">
                                                                            <label for="titulo-{{ $task->id }}">Título</label>
                                                                            <input type="text" class="form-control" id="titulo-{{ $task->id }}" name="titulo" value="{{ $task->titulo }}">
                                                                        </div>
                                                                        
                                                                        <!-- Descripción de la tarea -->
                                                                        <div class="form-group">
                                                                            <label for="descripcion-{{ $task->id }}">Descripción</label>
                                                                            <textarea class="form-control" id="descripcion-{{ $task->id }}" name="descripcion">{{ $task->descripcion }}</textarea>
                                                                        </div>
                                                    
                                                                        <!-- Fecha de vencimiento -->
                                                                        <div class="form-group">
                                                                            <label for="fecha_vencimiento-{{ $task->id }}">Fecha de Vencimiento</label>
                                                                            <input type="datetime-local" class="form-control" id="fecha_vencimiento-{{ $task->id }}" name="fecha_vencimiento" value="{{ $task->fecha_vencimiento ? \Carbon\Carbon::parse($task->fecha_vencimiento)->format('Y-m-d\TH:i') : '' }}">
                                                                        </div>
                                                    
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                        <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <!-- Subtareas -->
                                            @if ($task->subtasks && $task->subtasks->count() > 0)
                                                <ul class="list-group mt-3">
                                                    @foreach($task->subtasks as $subtask)
                                                        <li class="list-group-item2">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <strong class="text-sm text-gray-500">{{ $subtask->titulo }}</strong>
                                                                    <form method="POST" action="{{ route('subtasks.updateStatus', $subtask->id) }}">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <input type="checkbox" name="completado" value="1" class="form-check-input ml-1" {{ $subtask->completado ? 'checked' : '' }} onchange="this.form.submit()">
                                                                        <span>&#160;&#160;&#160;&#160;&#160;</span>
                                                                        <span class="badge badge-{{ $subtask->completado ? 'success' : 'secondary' }}">{{ $subtask->completado ? 'Completada' : 'Pendiente' }}</span>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                    
                                                </ul>
                                            @endif

                                            <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#createSubtaskModal-{{ $task->id }}">
                                                Crear subtarea
                                            </button>

                                            

                                            <!-- Modal para crear subtarea -->
                                            <div class="modal fade" id="createSubtaskModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="createSubtaskModalLabel-{{ $task->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="createSubtaskModalLabel-{{ $task->id }}">Crear Subtarea</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        
                                                        <form method="POST" action="{{ route('subtasks.store', $task->id) }}">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="titulo">Título</label>
                                                                    <input type="text" name="titulo" class="form-control" required>
                                                                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Guardar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <p><br></p>
                                    @endforeach
                                    
                                </ul>
                            @endforeach
                            <p><br><br></p>
                        </div>
                        @endif
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
                    
        </div>
    </div>
</div>


    @foreach($taskLists as $taskList)
        @foreach($taskList->tasks as $task)
            @include('tasks.edit-modal', ['task' => $task])
        @endforeach
    @endforeach


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
    <script>
        
        document.addEventListener("DOMContentLoaded", function() {
            const toggleButtons = document.querySelectorAll('.toggle-tasks');
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetList = document.querySelector(`.${targetId}`);
                    targetList.classList.toggle('hidden'); 
                });
            });

            const toggleAllListsButton = document.getElementById('toggleAllLists');
            toggleAllListsButton.addEventListener('click', function() {
                const allTaskLists = document.querySelectorAll('.list-group');
                allTaskLists.forEach(list => {
                    list.classList.toggle('hidden'); 
                });
            });
        });
        document.addEventListener("DOMContentLoaded", function() {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('.delete-form');
                
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Deseas Eliminar!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#72F0B7',
                    cancelButtonColor: '#FF5E00',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });

    </script>
    <script>
        function showTasks(listId) {
            document.querySelectorAll('.tasks-container').forEach(function(el) {
                el.style.display = 'none';
            });
    
            if (listId) {
                var selectedList = document.getElementById('task-list-' + listId);
                if (selectedList) {
                    selectedList.style.display = 'block';
                }
            }
        }
    
        
        if (document.querySelectorAll('.tasks-container').length > 0) {
            showTasks({{ $taskLists->first()->id ?? 'null' }});
        } else {
            
            window.location.href = "{{ route('task_lists.create') }}";
        }
    </script>
    
    <script>
        function openIconModal() {
            $('#iconModal').modal('show'); // Usa jQuery para mostrar el modal
        }

        function setIcon(icon) {
            document.querySelectorAll('.icon-check').forEach((iconElement) => {
                iconElement.className = 'fas ' + icon + ' icon-check'; // Cambia la clase de todos los íconos
            });
            $('#iconModal').modal('hide'); // Oculta el modal
        }

    </script>

    <script>
        function showTasks(taskListId) {
            // Cambiar el URL a /dashboard?list=taskListId
            window.history.pushState(null, '', '/dashboard?list=' + taskListId);

            // Aquí puedes agregar el código que necesitas para mostrar las tareas de esa lista
            document.querySelectorAll('.tasks-container').forEach(function(container) {
                container.style.display = 'none'; // Ocultar todas las listas de tareas
            });
            
            document.getElementById('task-list-' + taskListId).style.display = 'block'; // Mostrar la lista seleccionada
        }

        // Mantener la lista seleccionada visible al cargar la página
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const selectedListId = urlParams.get('list');

            if (selectedListId) {
                showTasks(selectedListId); // Mostrar la lista seleccionada
            }
        };
    </script>

<script>
    $(function () {
    $('[data-toggle="tooltip"]').tooltip({
        template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner" style="background-color: #ff6600; color: #fff;"></div></div>'
    });
});

</script>
    

@endsection
















