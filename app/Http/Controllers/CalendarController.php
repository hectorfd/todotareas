<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
class CalendarController extends Controller
{
    public function showCalendar($year = null, $month = null)
    {
        Carbon::setLocale('es');
        // Usamos Carbon para obtener el año y mes actuales si no se pasan
        $currentDate = Carbon::now();
    
        if ($year && $month) {
            $currentDate = Carbon::createFromDate($year, $month, 1);
        }
    
        $year = $currentDate->year;
        $month = $currentDate->month;
    
        // Obtener el mes anterior y el mes siguiente
        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();
    
        // Obtener el número de días en el mes
        $daysInMonth = $currentDate->daysInMonth;
    
        // Obtener el día de la semana del primer día del mes (0 para Domingo, 6 para Sábado)
        $firstDayOfMonth = Carbon::createFromDate($year, $month, 1)->dayOfWeek;
    
        return view('calendars.show', compact('year', 'month', 'daysInMonth', 'firstDayOfMonth', 'prevMonth', 'nextMonth'));
    }
}
