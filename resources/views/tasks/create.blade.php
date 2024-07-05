@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Crear Tarea en la Lista: {{ $taskList->listName }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('tasks.store', $taskList->id) }}">
                            @csrf

                            <div class="form-group">
                                <label for="titulo">Tarea</label>
                                <input type="text" name="titulo" class="form-control" required>
                            </div>

                            {{-- <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" class="form-control"></textarea>
                            </div> --}}

                            <div class="form-group">
                                <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                                <input type="datetime-local" name="fecha_vencimiento" class="form-control">
                            </div>

                            {{-- <div class="form-group form-check">
                                <input type="checkbox" name="completada" class="form-check-input">
                                <label class="form-check-label" for="completada">Completada</label>
                            </div> --}}

                            <button type="submit" class="btn btn-primary">Crear Tarea</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
