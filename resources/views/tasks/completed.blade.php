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
                                    <li class="list-group-item">
                                        <strong>{{ $task->titulo }}</strong>
                                        <p>{{ $task->descripcion }}</p>
                                        <small>Completada el: {{ $task->updated_at }}</small>
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
