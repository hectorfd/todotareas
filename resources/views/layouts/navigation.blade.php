<nav class="navbar navbar-expand- navbar-light bg-custom shadow-sm">
    <div class="container">
        {{-- <a class="navbar-brand text-2xl font-bold text-green-400 hover:text-indigo-800 transition duration-300 ease-in-out" href="{{ url('/dashboard') }}">
            {{ config('app.name', 'TodoList') }}
        </a> --}}
        <a class="navbar-brand" href="{{ url('/dashboard') }}">
            <img src="{{ asset('images/mochi.gif') }}" alt="Logo Mochi" class="mochi-logo">
        </a>
        
        
        
        <div class="ml-auto d-flex align-items-center">
            <!-- Botón deslizable para Modo Oscuro -->
            <div class="custom-control custom-switch mr-3">
                <input type="checkbox" class="custom-control-input" id="darkModeToggle">
                <label class="custom-control-label text-green-400" for="darkModeToggle">Quiero un Negro</label>
            </div>
            
            <!-- Botón para cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>


<script>
    // Obtener el interruptor del modo oscuro
    const darkModeToggle = document.getElementById('darkModeToggle');
  
    // Verificar si el usuario ya tiene el modo oscuro activado (en localStorage)
    if (localStorage.getItem('dark-mode') === 'enabled') {
        document.body.classList.add('dark-mode');
        darkModeToggle.checked = true;
    }
  
    // Agregar un evento para cambiar el modo oscuro
    darkModeToggle.addEventListener('change', function() {
      if (darkModeToggle.checked) {
        document.body.classList.add('dark-mode');
        localStorage.setItem('dark-mode', 'enabled'); // Guardar en localStorage
      } else {
        document.body.classList.remove('dark-mode');
        localStorage.setItem('dark-mode', 'disabled'); // Guardar en localStorage
      }
    });
  </script>
  