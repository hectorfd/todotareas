@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-4">
        <h1 class="text-2xl font-bold">Calendario</h1>
        <a href="{{ route('calendar.show') }}" class="btn btn-primary">Hoy</a>
    </div>

    <div class="calendar">
        <div class="calendar-header flex justify-between mb-4">
            {{-- Botón para ir al mes anterior --}}
            <a href="{{ route('calendar.show', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}" class="btn btn-secondary">←</a>

            {{-- Mostrar el mes y año actual en español --}}
            <span class="text-lg font-bold">{{ \Carbon\Carbon::createFromDate($year, $month)->translatedFormat('F Y') }}</span>

            {{-- Botón para ir al mes siguiente --}}
            <a href="{{ route('calendar.show', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}" class="btn btn-secondary">→</a>
        </div>

        <div class="calendar-grid grid grid-cols-7 gap-1">
            <div class="text-center font-bold text-green-400">Domingo</div>
            <div class="text-center font-bold">Lunes</div>
            <div class="text-center font-bold">Martes</div>
            <div class="text-center font-bold">Miércoles</div>
            <div class="text-center font-bold">Jueves</div>
            <div class="text-center font-bold">Viernes</div>
            <div class="text-center font-bold text-green-400">Sábado</div>
        </div>
        {{-- Para depurar tengo errores conlas fechas --}}
        {{-- <div class="grid grid-cols-7 gap-1">
    
            @for ($i = 0; $i < $firstDayOfMonth; $i++)
                <div class="empty-day"></div>
            @endfor
        
            @for ($day = 1; $day <= $daysInMonth; $day++)
                
                @php
                    $currentDate = \Carbon\Carbon::create($year, $month, $day)->toDateString();
                    $taskForDay = $tasks->first(function ($task) use ($currentDate) {
                        return \Carbon\Carbon::parse($task->fecha_vencimiento)->toDateString() === $currentDate;
                    });
        
                   
                    dd("Fecha del día: $currentDate", $tasks->pluck('fecha_vencimiento')->toArray(), $taskForDay);
                @endphp
        
                @if($taskForDay)
                    <div class="day border p-2 text-center cursor-pointer bg-warning text-red-800">
                        {{ $day }}
                        <span class="d-block text-danger text-red-800">
                            Tarea: {{ $taskForDay->titulo }}
                        </span>
                    </div>
                @else
                    <div class="day border p-2 text-center cursor-pointer hover:bg-gray-100 text-green-500">
                        {{ $day }}
                    </div>
                @endif
            @endfor
        </div> --}}
        <div class="grid grid-cols-7 gap-1">
            @for ($i = 0; $i < $firstDayOfMonth; $i++)
                <div class="empty-day"></div>
            @endfor
        
            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $currentDate = \Carbon\Carbon::now();  // Obtener la fecha actual
                    $currentDayDate = \Carbon\Carbon::create($year, $month, $day);  // Fecha que estamos iterando
                    $tasksForDay = $tasks->filter(function ($task) use ($year, $month, $day) {
                        return \Carbon\Carbon::parse($task->fecha_vencimiento)->format('Y-m-d') === \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                    });
                @endphp
        
                {{-- Verificar si hay tareas para ese día --}}
                @if($tasksForDay->count() > 0)
                    {{-- Aplicar color rojo si la fecha es anterior a la fecha actual --}}
                    <div class="day border p-3 text-center cursor-pointer relative h-24 w-35 overflow-y-auto 
                        {{ $currentDayDate->lessThan($currentDate) ? ' bg-danger' : 'bg-info' }}">
                        <ul class="list-disc text-left">
                            @foreach($tasksForDay as $task)
                                <li class="text-white text-xs p-0">{{ $task->titulo }}</li> 
                            @endforeach
                        </ul>
                        <span class="absolute bottom-1 right-1 text-xs font-bold text-white">{{ $day }}</span>
                    </div>
                @else
                    <div class="day border p-2 text-center cursor-pointer bg-custom hover:bg-gray-100 relative h-24 w-35">
                        <span class="absolute bottom-1 right-1 text-sm font-bold text-green-500">{{ $day }}</span>
                    </div>
                @endif
            @endfor
        </div>
        
        
        
        
        
        
        
        
        
        
    </div>

    <div class="mt-5">
        <h2 class="text-xl font-bold">Lista de Tareas</h2>
        <ul class="list-group">
            
            @foreach($tasks as $task)
                <li class="list-group-item">
                    <strong>{{ $task->titulo }}</strong> - Vence: {{ \Carbon\Carbon::parse($task->fecha_vencimiento)->format('d-m-Y H:i') }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
