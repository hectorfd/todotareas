@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row">
        <!-- Slider Dinámico -->
        <div class="col-md-4">
            <div class="card panel-listas panel-listas-fixed">
                <div class="card-header">
                    <h2 class="mb-0 font-bold ">Tus Listas</h2>
                    <a href="{{ route('task_lists.create') }}" class="btn btn-primary">Crear lista</a>
                </div>
                <div class="list-group">
                    @foreach($taskLists as $taskList)
                    <div class="list-group-item flex justify-between items-center px-3 py-2 cursor-pointer" onclick="showTasks({{ $taskList->id }})">
                        <i class="fas fa-check icon-check text-green-500" onclick="event.stopPropagation(); openIconModal();"></i>
                        <small class="text-sm flex-grow text-gray-800 ml-2">{{ $taskList->listName }}</small>
                        <span class="badge panel-listas rounded-full px-3 py-1 text-sm">{{ count($taskList->tasks) }}</span>
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
                    <div class="mr-3">
                        {{-- @if(Auth::user()->foto)
                            <img src="{{ Storage::url(Auth::user()->foto) }}" alt="Foto de Perfil" style="width: 50px; height: 50px; border-radius: 50%;">
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: gray; display: flex; align-items: center; justify-content: center; color: white;">
                                Sin foto
                            </div>
                        @endif --}}
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

                    </div>
                    <div>
                        <span class="font-bold">{{ Auth::user()->username }}</span>
                    </div>
                </div>
                <div> 
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>Editar Perfil
                    </a>
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

            @if($taskLists->count() > 0)
                <div class="card mt-4">
                    

                    <div class="card-body">
                        @foreach($taskLists as $taskList)
                            <!-- Contenedor de las tareas de cada lista, inicialmente oculto -->
                            <ul class="list-group tasks-container" id="task-list-{{ $taskList->id }}" style="display: none;">
                                <li class="">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn btn-link toggle-tasks" data-target="tasks-{{ $taskList->id }}">
                                            <i class="fas fa-tasks mr-2"></i>
                                        </button>
                                        <h4 class="font-bold">{{ $taskList->listName }}</h4>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('tasks.create', $taskList->id) }}" class="btn btn-primary btn-sm">Crear tarea</a>

                                            <a href="{{ route('tasks.completed', $taskList->id) }}" class="btn btn-success ml-2 btn-sm">
                                                <i class="fas fa-check-square mr-0 text-white"></i>
                                            </a>

                                            <button class="btn btn-info ml-2 btn-sm" data-toggle="modal" data-target="#editTaskListModal-{{ $taskList->id }}">
                                                <i class="fas fa-pencil-alt mr-0 text-white"></i>
                                            </button>

                                            <form method="POST" action="{{ route('task_lists.destroy', $taskList->id) }}" class="inline-block ml-2 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm delete-btn">
                                                    <i class="fas fa-trash-alt mr-0 text-white"></i>
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
                                                        <button class="btn btn-warning btn-sm ml-2" data-toggle="modal" data-target="#editTaskModal-{{ $task->id }}">
                                                            <i class="far fa-edit mr-0 text-white"></i>
                                                        </button>
                                                        <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="ml-2 delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger  delete-btn">
                                                                <i class="fas fa-times mr-0 text-indigo hover:text-white " ></i>
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
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
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

@endsection
















