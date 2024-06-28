<form method="POST" action="{{ route('registro') }}">
    @csrf

    <div>
        <label for="username">Nombre de usuario</label>
        <input id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
        @error('username')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="nombre">Nombre</label>
        <input id="nombre" type="text" name="nombre" value="{{ old('nombre') }}">
        @error('nombre')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="apellido">Apellido</label>
        <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}">
        @error('apellido')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="telefono">Teléfono</label>
        <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}">
        @error('telefono')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="direccion">Dirección</label>
        <input id="direccion" type="text" name="direccion" value="{{ old('direccion') }}" required>
        @error('direccion')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="email">Correo electrónico</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        @error('email')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="password">Contraseña</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">
        @error('password')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="password_confirmation">Confirmar contraseña</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
    </div>

    <button type="submit">Registrarse</button>
</form>
