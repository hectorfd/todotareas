@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Crear Lista</div>
                    <div class="card-body">
                        <form action="{{ route('task_lists.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="listName">Nombre de la Lista</label>
                                <input type="text" name="listName" id="listName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
