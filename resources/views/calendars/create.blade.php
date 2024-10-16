@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="text-2xl font-bold">Calendario</h1>
        <button id="todayBtn" class="btn btn-primary">Hoy</button>
    </div>
    
    <!-- Calendario -->
    <div class="calendar">
        <div class="calendar-header flex justify-between mb-4">
            <button id="prevMonthBtn" class="btn btn-secondary">←</button>
            <span id="currentMonthYear" class="text-lg font-bold"></span>
            <button id="nextMonthBtn" class="btn btn-secondary">→</button>
        </div>
        
        <!-- Cuadrícula de calendario -->
        <div class="calendar-grid grid grid-cols-7 gap-1">
            <div class="text-center font-bold">Domingo</div>
            <div class="text-center font-bold">Lunes</div>
            <div class="text-center font-bold">Martes</div>
            <div class="text-center font-bold">Miércoles</div>
            <div class="text-center font-bold">Jueves</div>
            <div class="text-center font-bold">Viernes</div>
            <div class="text-center font-bold">Sábado</div>
        </div>
        
        <div id="calendarDays" class="grid grid-cols-7 gap-1">
            <!-- Aquí se llenarán los días con JavaScript -->
        </div>
    </div>
</div>

<!-- Modal para agregar tareas -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTaskModalLabel">Agregar tarea</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="taskForm" action="{{ route('tasks.store', ['taskList' => $taskList->id]) }}" method="POST">

          @csrf
          <input type="hidden" id="taskDate" name="fecha">
          <div class="form-group">
            <label for="taskTitle">Título</label>
            <input type="text" class="form-control" id="taskTitle" name="titulo" required>
          </div>
          <div class="form-group">
            <label for="taskList">Lista de tareas</label>
            <select class="form-control" id="taskList" name="task_list_id">
                @foreach ($taskLists as $taskList)
                    <option value="{{ $taskList->id }}">{{ $taskList->listName }}</option>
                @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')

<script>
    // Variables globales para manejar el estado actual del calendario
    let currentDate = new Date();
  
    // Función para generar el calendario
    function generateCalendar() {
      const calendarDays = document.getElementById('calendarDays');
      calendarDays.innerHTML = ''; // Limpiar el contenedor de los días
  
      const year = currentDate.getFullYear();
      const month = currentDate.getMonth();
  
      // Mostrar el mes y año actual
      const currentMonthYear = document.getElementById('currentMonthYear');
      currentMonthYear.innerText = `${currentDate.toLocaleString('es-ES', { month: 'long' })} ${year}`;
  
      // Obtener el primer día del mes
      const firstDayOfWeek = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
  
      // Rellenar con días vacíos hasta el primer día del mes
      for (let i = 0; i < firstDayOfWeek; i++) {
        const emptyDay = document.createElement('div');
        emptyDay.classList.add('empty-day');
        calendarDays.appendChild(emptyDay);
      }
  
      // Generar los días del mes
      for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = document.createElement('div');
        dayElement.classList.add('day', 'border', 'p-2', 'text-center', 'cursor-pointer', 'hover:bg-gray-100');
        dayElement.innerText = day;
  
        // Evento para abrir el modal al hacer clic en un día
        dayElement.addEventListener('click', () => openAddTaskModal(year, month, day));
  
        // Agregar los días al contenedor
        calendarDays.appendChild(dayElement);
      }
    }
  
    // Función para abrir el modal y pasar la fecha seleccionada
    function openAddTaskModal(year, month, day) {
      const taskDate = document.getElementById('taskDate');
      taskDate.value = `${year}-${month + 1}-${day}`;
  
      // Mostrar el modal
      $('#addTaskModal').modal('show');
    }
  
    // Función para moverse al mes anterior
    document.getElementById('prevMonthBtn').addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() - 1);
      generateCalendar();
    });
  
    // Función para moverse al mes siguiente
    document.getElementById('nextMonthBtn').addEventListener('click', () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      generateCalendar();
    });
  
    // Función para volver al mes actual
    document.getElementById('todayBtn').addEventListener('click', () => {
      currentDate = new Date(); // Resetear a la fecha actual
      generateCalendar();
    });
  
    // Inicializar el calendario
    generateCalendar();
</script>
@endpush
