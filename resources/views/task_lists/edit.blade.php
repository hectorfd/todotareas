{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Editar Lista</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('task_lists.update', $taskList->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="listName">Nombre de la Lista</label>
                            <input type="text" name="listName" class="form-control" value="{{ $taskList->listName }}" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" class="form-control">{{ $taskList->descripcion }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
