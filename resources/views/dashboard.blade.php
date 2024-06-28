@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Bienvenido al Dashboard</h1>
                <p>Este es tu panel de control.</p>

                <div class="card mt-4">
                    <div class="card-header">Información del Usuario</div>
                    <div class="card-body">
                        <p><strong>Nombre de Usuario:</strong> {{ Auth::user()->username }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Nombre:</strong> {{ Auth::user()->nombre }}</p>
                        <p><strong>Apellido:</strong> {{ Auth::user()->apellido }}</p>
                        <p><strong>Teléfono:</strong> {{ Auth::user()->telefono }}</p>
                        <p><strong>Dirección:</strong> {{ Auth::user()->direccion }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

