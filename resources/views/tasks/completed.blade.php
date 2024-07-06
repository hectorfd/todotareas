@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        Tareas Completadas en la Lista: {{ $taskList->listName }}
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm float-right">Volver</a>
                    </div>

                    <div class="card-body">
                        @if($completedTasks->isEmpty())
                            <p>No hay tareas completadas en esta lista.</p>
                        @else
                            <ul class="list-group">
                                @foreach($completedTasks as $task)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $task->titulo }}</strong>
                                            <p>{{ $task->descripcion }}</p>
                                            <small>Completada el: {{ $task->updated_at }}</small>
                                        </div>
                                        <div>
                                            <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-check">
                                                    <input class="form-check-input cursor-pointer p-2  w-6 h-6 rounded-full border-2 border-gray-300 checked:bg-green-500 checked:border-green-500 focus:ring-0 focus:outline-none" type="checkbox" id="completada-{{ $task->id }}" name="completada" onChange="this.form.submit()" {{ $task->completada ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="completada-{{ $task->id }}">
                                                        <span class="text-gray-50 m-2 badge {{ $task->completada ? 'bg-success' : 'bg-secondary' }}">
                                                            {{ $task->completada ? 'Completado' : 'Pendiente' }}
                                                        </span>
                                                    </label>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

