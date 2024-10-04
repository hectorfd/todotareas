@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Grupo</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('groups.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="groupname">Nombre del Grupo</label>
            <input type="text" class="form-control" id="groupname" name="groupname" required>
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Crear Grupo</button>
    </form>
</div>
@endsection
