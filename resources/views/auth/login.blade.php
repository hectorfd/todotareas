<!-- login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        
        
    </style>
</head>
<body>
    <div>
    <form method="POST" action="{{ route('login') }}" class="form-container">
        @csrf

        <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
            @error('username')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                Recordarme
            </label>
        </div>
        <div class="flex items-center justify-center">
        <button type="submit" class="mr-4 submit-button">Iniciar sesión</button>
        <a href="{{ route('register') }}" class=" submit-button hover:bg-purple-500">Registrarse</a>
        </div>
    </form>
</div>
</body>
</html>


