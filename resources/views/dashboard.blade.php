@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <span class="mr-3">Usuario: {{ Auth::user()->username }}</span>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                        Editar Perfil
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
                                {{-- TODO: crear pagina para editar listas --}}
                                <a href="#" class="btn btn-primary" >Editar Listas</a>
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
                                                
                                                <a href="{{ route('tasks.completed', $taskList->id) }}" class="btn btn-success btn-sm">Completados</a>
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
                                                        <div>
                                                            <form method="POST" action="{{ route('tasks.updateStatus', $task->id) }}">
                                                                @csrf
                                                                @method('PATCH')

                                                                <input type="hidden" name="completada" value="0">
                                                                <input type="checkbox" name="completada" value="1" class="form-check-input cursor-pointer p-2  w-6 h-6 rounded-full border-2 border-gray-300 checked:bg-green-500 checked:border-green-500 focus:ring-0 focus:outline-none" {{ $task->completada ? 'checked' : '' }} onchange="this.form.submit()">

                                                                <span class="m-2 badge badge-{{ $task->completada ? 'success' : 'secondary' }}">
                                                                    {{ $task->completada ? 'Completada' : 'Pendiente' }}
                                                                </span>
                                                            </form>
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
    </script>
    
@endsection












