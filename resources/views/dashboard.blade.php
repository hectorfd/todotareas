@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span class="mr-3">Usuario: {{ Auth::user()->username }}</span>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        <i class="fas fa-edit mr-2"></i>Perfil
                    </a>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h2 class="mb-0">Tus Listas</h2>
                            <div class="justify-content-center">
                                <a href="{{ route('task_lists.create') }}" class="btn btn-primary">Crear lista</a>
                                <a href="#" class="btn btn-primary">Editar Listas</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($taskLists as $taskList)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h4>{{ $taskList->listName }}</h4>
                                                <button class="btn btn-link toggle-tasks " data-target="tasks-{{ $taskList->id }}">
                                                    <i class="fas fa-tasks mr-2"></i>
                                                </button>
                                                <a href="{{ route('tasks.create', $taskList->id) }}" class="btn btn-primary btn-sm">Crear tarea</a>
                                                <a href="{{ route('tasks.completed', $taskList->id) }}" class="btn btn-success btn-sm"><i class="fas fa-check-square mr-0 text-white"></i></a>
                                            </div>
                                        </div>
                                        
                                        <ul class="list-group mt-3 tasks-{{ $taskList->id }}">
                                            @foreach($taskList->tasks->where('completada', 0) as $task)
                                                <li class="list-group-item {{ $task->fecha_vencimiento && $task->fecha_vencimiento < now() && !$task->completada ? 'task-vencida' : '' }}">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <strong>{{ $task->titulo }}</strong>
                                                            <p>{{ $task->descripcion }}</p>
                                                            <small>
                                                                {{ $task->fecha_vencimiento && $task->fecha_vencimiento < now() && !$task->completada ? 'Vencido' : 'Vence' }}: 
                                                                {{ $task->fecha_vencimiento }}
                                                            </small>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="completada" value="0">
                                                                <input type="checkbox" name="completada" value="1" class="form-check-input cursor-pointer p-2  w-6 h-6 rounded-full border-2 border-gray-300 checked:bg-green-500 checked:border-green-500 focus:ring-0 focus:outline-none" {{ $task->completada ? 'checked' : '' }} onchange="this.form.submit()">
                                                                <span class="m-2 badge badge-{{ $task->completada ? 'success' : 'secondary' }}">{{ $task->completada ? 'Completada' : 'Pendiente' }}</span>
                                                            </form>
                                                            <button class="btn btn-warning btn-sm ml-2" data-toggle="modal" data-target="#editTaskModal-{{ $task->id }}"><i class="far fa-edit mr-0 text-white"></i></button>
                                                            <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="ml-2 delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-times mr-0 text-white"></i></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Subtareas -->
                                                    @if ($task->subtasks && $task->subtasks->count() > 0)
                                                        <ul class="list-group mt-3">
                                                            @foreach($task->subtasks as $subtask)
                                                                <li class="list-group-item">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <strong>{{ $subtask->titulo }}</strong>
                                                                            <form method="POST" action="{{ route('subtasks.updateStatus', $subtask->id) }}">
                                                                                @csrf
                                                                                @method('PATCH')
                                                                                <input type="checkbox" name="completado" value="1" class="form-check-input cursor-pointer p-2  w-6 h-6 rounded-full border-2 border-gray-300 checked:bg-green-500 checked:border-green-500 focus:ring-0 focus:outline-none" {{ $subtask->completado ? 'checked' : '' }} onchange="this.form.submit()">
                                                                                <span class="m-2 badge badge-{{ $subtask->completado ? 'success' : 'secondary' }}">{{ $subtask->completado ? 'Completada' : 'Pendiente' }}</span>
                                                                            </form>
                                                                        </div>
                                                                        <form method="POST" action="{{ route('subtasks.destroy', $subtask->id) }}" class="ml-2 delete-form">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button" class="btn btn-danger btn-sm delete-btn"><i class="fas fa-times mr-0 text-white"></i></button>
                                                                        </form>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                    <!-- Botón para crear subtareas -->
                                                    <button class="btn btn-primary btn-sm mt-2" data-toggle="modal" data-target="#createSubtaskModal-{{ $task->id }}">Crear subtarea</button>
                                                    
                                                    <!-- Modal para crear subtareas -->
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
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Incluir modal de edición de tarea -->
    @foreach($taskLists as $taskList)
        @foreach($taskList->tasks as $task)
            @include('tasks.edit-modal', ['task' => $task])
        @endforeach
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
                    text: "¡Deseas Eliminar la Tarea!",
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

@endsection
















