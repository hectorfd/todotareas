<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-custom shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center" style="max-width: 1200px; margin: 0 auto;">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/dashboard') }}">
            <img src="{{ asset('images/mochi.gif') }}" alt="Logo Mochi" class="mochi-logo mr-2" style="width: 35px; height: auto;">
            <span class="font-bold text-indigo-600 hover:text-indigo-800 transition duration-300">TodoList</span>
        </a>
        
        <div class="d-flex align-items-center">
            <a href="{{ url('/dashboard') }}" class="btn {{ Request::is('dashboard') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm rounded-md px-4 py-2 mr-3 transition-all">
                Inicio
            </a>
            <a href="{{ url('/calendars') }}" class="btn {{ Request::is('calendars') ? 'btn-primary' : 'btn-outline-primary' }} btn-sm rounded-md px-4 py-2 mr-3 transition-all">
                Calendario
            </a>
            
            

            <!-- Botón deslizable para Modo Oscuro -->
            <div class="custom-control custom-switch mr-3">
                <input type="checkbox" class="custom-control-input" id="darkModeToggle">
                <label class="custom-control-label text-green-400" for="darkModeToggle">Modo Oscuro</label>
            </div>
            
            <!-- Botón para cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>


<script>
    // Obtener el interruptor del modo oscuro y la barra de navegación
    const darkModeToggle = document.getElementById('darkModeToggle');
    const navbar = document.getElementById('navbar'); // Asegúrate de que tu <nav> tenga el id="navbar"
  
    // Verificar si el usuario ya tiene el modo oscuro activado (en localStorage)
    if (localStorage.getItem('dark-mode') === 'enabled') {
        document.body.classList.add('dark-mode');
        navbar.classList.add('dark-mode'); // Añadir clase 'dark-mode' a la barra de navegación
        darkModeToggle.checked = true;
    }
  
    // Agregar un evento para cambiar el modo oscuro
    darkModeToggle.addEventListener('change', function() {
        if (darkModeToggle.checked) {
            document.body.classList.add('dark-mode');
            navbar.classList.add('dark-mode'); // Añadir clase 'dark-mode' a la barra de navegación
            localStorage.setItem('dark-mode', 'enabled'); // Guardar en localStorage
        } else {
            document.body.classList.remove('dark-mode');
            navbar.classList.remove('dark-mode'); // Quitar clase 'dark-mode' de la barra de navegación
            localStorage.setItem('dark-mode', 'disabled'); // Guardar en localStorage
        }
    });
</script>

  