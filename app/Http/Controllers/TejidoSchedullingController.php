<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TejidoSchedullingController extends Controller
{
    public function envioDeDataPlaneacion(Request $request)
    {
        $telares = DB::table('catalago_telares')->get();
        $datos = $request->query(); // datos por URL
        return view('TEJIDO-SCHEDULING.traspaso-create-form', compact('datos', 'telares'));
    }
}
