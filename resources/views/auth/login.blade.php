<!-- login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
</head>
<body>
    <div class="min-h-screen flex items-center justify-center">
    <div class="centered-container ">
            
    <form method="POST" action="{{ route('login') }}" class="form-container bg-custom">
        @csrf
        <div class="flex items-center justify-center">
        <h2 class="mx-auto mb-4 text-green-400 font-bold">Login</h2>
        </div>
        <img src="{{ asset('images/mochi.gif') }}" alt="Login" class="mx-auto mb-4 w-32  object-cover">
        <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus placeholder="Ingrese su nombre de Usuario">
            @error('username')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" type="password" name="password" placeholder="Ingrese su Contraseña" required>
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
        
        <a href="/google-auth/redirect" class="submit-button">Gooogle</a>
        <a href="{{ route('register') }}" class=" submit-button hover:bg-green-400">Registrarse</a>
        </div>
    </form>
    </div>
</div>
<script>
        
    document.addEventListener('DOMContentLoaded', function() {
        const usernameInput = document.getElementById('username');
        
        usernameInput.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/\s/g, '');
        });
        

        
    });
</script>
</body>
</html>


