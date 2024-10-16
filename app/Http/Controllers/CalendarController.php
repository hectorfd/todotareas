<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
class CalendarController extends Controller
{
    // public function showCalendar($year = null, $month = null)
    // {
    //     Carbon::setLocale('es');
    //     // Usamos Carbon para obtener el año y mes actuales si no se pasan
    //     $currentDate = Carbon::now();
    
    //     if ($year && $month) {
    //         $currentDate = Carbon::createFromDate($year, $month, 1);
    //     }
    
    //     $year = $currentDate->year;
    //     $month = $currentDate->month;
    
    //     // Obtener el mes anterior y el mes siguiente
    //     $prevMonth = $currentDate->copy()->subMonth();
    //     $nextMonth = $currentDate->copy()->addMonth();
    
    //     // Obtener el número de días en el mes
    //     $daysInMonth = $currentDate->daysInMonth;
    
    //     // Obtener el día de la semana del primer día del mes (0 para Domingo, 6 para Sábado)
    //     $firstDayOfMonth = Carbon::createFromDate($year, $month, 1)->dayOfWeek;
    
    //     return view('calendars.show', compact('year', 'month', 'daysInMonth', 'firstDayOfMonth', 'prevMonth', 'nextMonth'));
    // }

    public function showCalendar($year = null, $month = null)
{
    $currentDate = Carbon::now();

    if (!$year || !$month) {
        $year = $currentDate->year;
        $month = $currentDate->month;
    }

    // Obtener el número de días del mes
    $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

    // Obtener el primer día del mes
    $firstDayOfMonth = Carbon::createFromDate($year, $month, 1)->dayOfWeek;

    // Obtener las tareas del usuario actual que vencen este mes
    $tasks = Task::where('user_id', auth()->id())
                 ->whereYear('fecha_vencimiento', $year)
                 ->whereMonth('fecha_vencimiento', $month)
                 ->get();

    // Obtener los días del mes que tienen tareas
    $daysWithTasks = $tasks->map(function ($task) {
        return Carbon::parse($task->fecha_vencimiento)->day;
    })->toArray();

    // Calcular el mes anterior y el siguiente
    $prevMonth = Carbon::createFromDate($year, $month)->subMonth();
    $nextMonth = Carbon::createFromDate($year, $month)->addMonth();

    return view('calendars.show', compact('year', 'month', 'daysInMonth', 'firstDayOfMonth', 'tasks', 'daysWithTasks', 'prevMonth', 'nextMonth'));
}
}
