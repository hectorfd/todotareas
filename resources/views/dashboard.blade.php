@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>TodoList</h1>
                
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
                                <a href="" class="btn btn-primary">Editar lista</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($taskLists as $taskList)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            {{ $taskList->listName }}
                                            <div>
                                                <a href="{{ route('tasks.create', $taskList->id) }}" class="btn btn-primary btn-sm">Crear tarea</a>
                                                <a href="{{ route('tasks.completed', $taskList->id) }}" class="btn btn-secondary btn-sm">Completados</a>
                                            </div>
                                        </div>
                                        
                                        <ul class="list-group mt-3">
                                            @foreach($taskList->tasks as $task)
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
                                                                <input type="checkbox" name="completada" class="form-check-input" {{ $task->completada ? 'checked' : '' }} onchange="this.form.submit()">
                                                                <span class="badge badge-{{ $task->completada ? 'success' : 'secondary' }}">
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
@endsection




