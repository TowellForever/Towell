<?php

namespace App\Http\Controllers;

use App\Models\Tejedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Esto es lo que faltaba

class TejedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = \App\Models\Usuario::with('telares')->find(Auth::id()); //usando la relacion creada entre usuarios y catalago_telares, buscamos los telares pertenecientes al id (numero_usuario) del usuario que esta logeado o autenticado
        $hora = now()->hour;
        $usuarioPorDefecto = 'jesus.alvarez'; // Default

        if ($hora >= 6 && $hora < 12) {
            $usuarioPorDefecto = 'karla.mendez';
        } elseif ($hora >= 12 && $hora < 18) {
            $usuarioPorDefecto = 'ricardo.lopez';
        } elseif ($hora >= 18 && $hora < 22) {
            $usuarioPorDefecto = 'andrea.soto';
        } else {
            $usuarioPorDefecto = 'fernando.ramos';
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
        // Validación
        $request->validate([
            'recibe' => 'required|string',
            'entrega' => 'required|string',
            'fecha' => 'required|date'
        ]);

        // Guardar encabezado
        $registro = Tejedor::create([
            'recibe' => $request->recibe,
            'entrega' => $request->entrega,
            'fecha' => $request->fecha,
        ]);

        // Obtener el turno actual según la hora del servidor
        $hora = now()->format('H');
        if ($hora >= 6 && $hora < 14) {
            $turnoActual = 1;
        } elseif ($hora >= 14 && $hora < 22) {
            $turnoActual = 2;
        } else {
            $turnoActual = 3;
        }

        $detalles = [];

        foreach ($request->criterios as $criterioIndex => $turnosValores) {
            foreach ($turnosValores as $turnoIndex => $valor) {
                $telarIndex = intdiv($turnoIndex, 3);
                $turno = ($turnoIndex % 3) + 1;

                // Solo guardar si es el turno actual
                if ($turno === $turnoActual) {
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
        }

        \DB::table('practicas_manu_detalles')->insert($detalles);

        return redirect()->route('tejedores.index')->with('success', 'Registro guardado correctamente solo para el turno actual');
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
