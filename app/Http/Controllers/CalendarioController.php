<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalendarioT1;
use App\Models\CalendarioT2;
use App\Models\CalendarioT3;
use App\Models\Planeacion;

class CalendarioController extends Controller
{
    public function CalendarioT1()
    {
        $calendariot1 = CalendarioT1::all(); // ✔️ Trae todos los registros

        $calendariot2 = CalendarioT2::all(); // ✔️ Trae todos los registros
        $calendariot3 = CalendarioT3::all(); // ✔️ Trae todos los registros


        return view('catalagos.calendarios', compact('calendariot1', 'calendariot2', 'calendariot3'));
    }
}
