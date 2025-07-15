<?php

namespace App\Http\Controllers;

use App\Models\PracticasManuDetalle;
use App\Models\Tejedor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Esto es lo que faltaba
use Illuminate\Support\Facades\DB;

class TejedorController extends Controller
{
    protected function obtenerTurnoActual()
    {
        $ahora = \Carbon\Carbon::now('America/Mexico_City');
        $hora = (int) $ahora->format('H');
        $minuto = (int) $ahora->format('i');
        $totalMinutos = $hora * 60 + $minuto;

        if ($totalMinutos >= 390 && $totalMinutos <= 869) {
            return 1; // 06:30 - 14:29
        } elseif ($totalMinutos >= 870 && $totalMinutos <= 1349) {
            return 2; // 14:30 - 22:29
        } else {
            return 3; // 22:30 - 06:29
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // 1. Usuario autenticado y telares
        $usuario = \App\Models\Usuario::with('telares')->find(Auth::id());

        if ($usuario && $usuario->telares->isEmpty()) {
            return redirect()->back()->with('warning', 'No tienes telares asignados.');
        }

        // 2. Calcular turno y usuario por defecto según hora
        $ahora = Carbon::now('America/Mexico_City');
        $hora = (int) $ahora->format('H');
        $minuto = (int) $ahora->format('i');
        $totalMinutos = $hora * 60 + $minuto;

        if ($totalMinutos >= 390 && $totalMinutos <= 869) {
            $usuarioPorDefecto = 'karla.mendez'; // Turno 1
        } elseif ($totalMinutos >= 870 && $totalMinutos <= 1349) {
            $usuarioPorDefecto = 'ricardo.lopez'; // Turno 2
        } else {
            $usuarioPorDefecto = 'andrea.soto'; // Turno 3
        }

        // 3. Buscar práctica del usuario para el turno, entrega y fecha de hoy (opcional)
        // Toma la entrega de la request (si viene de un select), si no, pone el usuarioPorDefecto
        $entrega = $request->input('entrega', $usuarioPorDefecto);
        $fechaHoy = now()->toDateString();
        $turnoActual = $this->obtenerTurnoActual();

        // Cambia Tejedor por tu modelo real, ejemplo PracticasManu
        $practica = \App\Models\Tejedor::where('recibe', $usuario->nombre)
            ->where('entrega', $entrega)
            ->whereDate('fecha', $fechaHoy)
            ->first();

        $detalles = [];
        if ($practica) {
            // Trae detalles solo del turno actual
            $detalles = \App\Models\PracticasManuDetalle::where('practicas_manu_id', $practica->id)
                ->where('turno', $turnoActual)
                ->get();
        }

        return view('modulos.tejedores.formato-BuenasPracticasManu', compact(
            'usuario',
            'usuarioPorDefecto',
            'practica',
            'detalles',
            'turnoActual',
            'entrega',
            'fechaHoy'
        ));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recibe' => 'required|string',
            'entrega' => 'required|string',
            'fecha' => 'required|date',
            'turno_actual' => 'required|integer|in:1,2,3'
        ]);

        $registro = Tejedor::create([
            'recibe' => $request->recibe,
            'entrega' => $request->entrega,
            'fecha' => $request->fecha,
        ]);

        $detalles = [];
        $turnoActual = (int) $request->turno_actual;

        foreach ($request->criterios as $criterioIndex => $turnosValores) {
            foreach ($turnosValores as $turnoIndex => $valor) {
                $turno = ($turnoIndex % 3) + 1;
                if ($turno !== $turnoActual) {
                    continue; // ignorar otros turnos
                }

                $telarIndex = intdiv($turnoIndex, 3);
                $telar = $request->telares[$telarIndex];

                $detalles[] = [
                    'practicas_manu_id' => $registro->id,
                    'criterio' => $criterioIndex,
                    'telar' => $telar,
                    'turno' => $turno,
                    'valor' => $valor,
                ];
            }
        }

        DB::table('practicas_manu_detalles')->insert($detalles);

        return redirect()->route('tejedores.index')->with('success', 'Registro guardado correctamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request) {}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
