<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendario;
use App\Models\Planeacion;

class CalendarioController extends Controller
{
    public function updateInline(Request $request)
    {
        $request->validate([
            'cal_id' => 'required|integer',
            'fecha_inicio' => 'required|string',
            'fecha_fin' => 'required|string'
        ]);

        $calendario = Calendario::find($request->cal_id);

        if (!$calendario) {
            $calendario = new Calendario();
            $calendario->cal_id = $request->cal_id;
        }

        // Formateamos las fechas
        $inicio = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->fecha_inicio);
        $fin = \Carbon\Carbon::createFromFormat('d-m-Y H:i', $request->fecha_fin);

        $calendario->fecha_inicio = $inicio->format('Y-m-d H:i:s');
        $calendario->fecha_fin = $fin->format('Y-m-d H:i:s');

        // Cálculo automático de horas
        $calendario->total_horas = $inicio->diffInHours($fin);

        $calendario->save();

        //OJO: regreso tambien las horas, para que se muestren en el FRONT (se procesa con JS)
        return response()->json([
            'success' => true,
            'msg' => 'Registro actualizado correctamente',
            'total_horas' => $calendario->total_horas
        ]);
    }


    




    public function edit($id)
    {
        $calendario = Calendario::findOrFail($id);
        return view('calendarios.edit', compact('calendario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'total_horas' => 'required|numeric|min:0',
        ]);

        $calendario = Calendario::findOrFail($id);
        $calendario->update($request->only(['fecha_inicio', 'fecha_fin', 'total_horas']));

        return redirect()->route('calendarios.index')->with('success', 'Calendario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $calendario = Calendario::findOrFail($id);
        $calendario->delete();

        return redirect()->route('calendarios.index')->with('success', 'Calendario eliminado correctamente.');
    }
}
