<?php

namespace App\Http\Controllers;

use App\Models\Tejedor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Esto es lo que faltaba
use Illuminate\Support\Facades\DB;

class TejedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario =  \App\Models\Usuario::with('telares')->find(Auth::id()); //usando la relacion creada entre usuarios y catalago_telares, buscamos los telares pertenecientes al id (numero_usuario) del usuario que esta logeado o autenticado

        if ($usuario && $usuario->telares->isEmpty()) {
            // No tiene telares asignados, porque la relación telares del usuario está vacía.
            return redirect()->back()->with('warning', 'No tienes telares asignados.');
        }

        $ahora = Carbon::now('America/Mexico_City');
        $hora = (int) $ahora->format('H');
        $minuto = (int) $ahora->format('i');
        $totalMinutos = $hora * 60 + $minuto;

        // Turnos en minutos:
        // Turno 1: 06:30 (390) - 14:29 (869)
        // Turno 2: 14:30 (870) - 22:29 (1349)
        // Turno 3: 22:30 (1350) - 06:29 (389)

        if ($totalMinutos >= 390 && $totalMinutos <= 869) {
            $usuarioPorDefecto = 'karla.mendez'; // Turno 1
        } elseif ($totalMinutos >= 870 && $totalMinutos <= 1349) {
            $usuarioPorDefecto = 'ricardo.lopez'; // Turno 2
        } else {
            $usuarioPorDefecto = 'andrea.soto'; // Turno 3
        }

        return view('modulos.tejedores.formato-BuenasPracticasManu', compact('usuario', 'usuarioPorDefecto'));
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
        //dd($request);
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
    public function show(string $id)
    {
        //
    }

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
