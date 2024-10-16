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
            <div class="text-center font-bold">Domingo</div>
            <div class="text-center font-bold">Lunes</div>
            <div class="text-center font-bold">Martes</div>
            <div class="text-center font-bold">Miércoles</div>
            <div class="text-center font-bold">Jueves</div>
            <div class="text-center font-bold">Viernes</div>
            <div class="text-center font-bold">Sábado</div>
        </div>

        <div class="grid grid-cols-7 gap-1">
            {{-- Rellenar con días vacíos antes del primer día del mes --}}
            @for ($i = 0; $i < $firstDayOfMonth; $i++)
                <div class="empty-day"></div>
            @endfor

            {{-- Mostrar los días del mes --}}
            @for ($day = 1; $day <= $daysInMonth; $day++)
                <div class="day border p-2 text-center cursor-pointer hover:bg-gray-100">
                    {{ $day }}
                </div>
            @endfor
        </div>
    </div>
</div>
@endsection


