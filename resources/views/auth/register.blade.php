<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TodoList') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-DWQmf9-2.css') }}">">
    <script src="{{ asset('build/assets/app.[hash].js') }}" defer></script> --}}
    {{-- <link rel="stylesheet" href="{{ asset('build/assets/app-DWQmf9-2.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('build/assets/app-BnfmS4KT.css') }}">
    @vite(['resources/css/app.css', 'resources/css/custom.css', 'resources/js/app.js'])
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
            background-size:cover;
            filter: blur(0px); 
            
        }




    </style>
</head>
<body class="">
    <div class="video-container">
        <video autoplay muted loop id="background-video">
            
            <source src="{{ asset('images/fondo7.mp4') }}" type="video/mp4">
            Tu navegador no soporta la etiqueta de video.
            <div class="blur-overlay"></div> 
        </video>
        <div class="min-h-screen flex items-center justify-center">
            <div class="max-w-5xl mx-auto p-6 bg-white bg-opacity-90 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Crear Cuenta</h2>
                <form method="POST" action="{{ route('registro') }}" enctype="multipart/form-data">
                    @csrf
    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nombre de usuario</label>
                            <input placeholder="Ingrese su nombre de usuario" id="username" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline lowercase-no-space">
                            @error('username')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div>
                            <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                            <input placeholder="Ingrese su nombre" id="nombre" type="text" name="nombre" value="{{ old('nombre') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('nombre')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
    
    
                        <div>
                            <label for="apellido" class="block text-gray-700 text-sm font-bold mb-2">Apellido</label>
                            <input placeholder="Ingrese su apellido" id="apellido" type="text" name="apellido" value="{{ old('apellido') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('apellido')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        
    
                        <div>
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo electrónico</label>
                            <input placeholder="Ingrese su correo electrónico" id="email" type="email" name="email" value="{{ old('email') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto de Perfil</label>
                            <input id="foto" type="file" name="foto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('foto')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                            <input placeholder="Crear contraseña" id="password" type="password" name="password" required autocomplete="new-password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div>
                            <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmar contraseña</label>
                            <input placeholder="Confirme su contraseña" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
    
                    <div class="flex items-center justify-between">
                        <button type="submit" class="mr-4 submit-button text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Registrarse</button>
                        <a href="{{ route('login') }}" class=" submit-button hover:bg-green-500">Ya tengo Cuenta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById('username');
            const emailInput = document.getElementById('email');
            usernameInput.addEventListener('input', function() {
                this.value = this.value.toLowerCase().replace(/\s/g, '');
            });
            emailInput.addEventListener('input',function(){
                this.value = this.value.toLowerCase().replace(/\s/g, '');
            });

            
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('build/assets/app-Bg1aHGgo.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


