@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>TodoList</h1>
                
                <div class="card mt-4">
                    <div class="card-header">Crear tu primera lista</div>
                    <div class="card-body">
                        {{-- Botón para crear lista --}}
                        <a href="{{ route('task_lists.create') }}" class="btn btn-primary">Crear lista</a>
                    </div>
                </div>

                {{-- Mostrar listas creadas por el usuario --}}
                @if($taskLists->count() > 0)
                    <div class="card mt-4">
                        <div class="card-header">Tus Listas</div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($taskLists as $taskList)
                                    <li class="list-group-item">
                                        {{ $taskList->listName }}
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


