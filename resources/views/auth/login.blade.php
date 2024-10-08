<!-- login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1; 
        }

        #background-video {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            object-fit: cover; 
            z-index: -100;
            transform: translate(-50%, -50%);
            background-size: cover;
            filter: blur(0px); 
        }




    </style>
    
</head>
<body>
    <div class="video-container">
        <video autoplay muted loop id="background-video">
            
            <source src="{{ asset('images/fondo5.mp4') }}" type="video/mp4">
            Tu navegador no soporta la etiqueta de video.
            <div class="blur-overlay"></div> 
        </video>
    </div>
    <div class="min-h-screen flex items-center justify-center">
    <div class="centered-container ">
            
    <form method="POST" action="{{ route('login') }}" class="form-container bg-custom">
        @csrf
        <div class="flex items-center justify-center">
        <h2 class="mx-auto mb-4 text-red-500 font-bold">Login</h2>
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
        
        {{-- <a href="/google-auth/redirect" class="submit-button">Gooogle</a> --}}
        
        
        <a href="{{ route('register') }}" class=" submit-button hover:bg-red-500">Registrarse</a>
        </div>
        <div class="center-container">
            <a href="/google-auth/redirect" class="google-btn">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png" alt="Google logo" class="google-icon">
                <span>Iniciar con Google</span>
            </a>
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


