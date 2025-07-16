<?php

namespace App\Http\Controllers;

use App\Models\UrdidoEngomado;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AtadorController extends Controller
{

    private function limpiarDatosAtador($data)
    {
        // Limpiar fecha
        $data['fecha_atado'] = isset($data['fecha_atado']) && $data['fecha_atado']
            ? $this->convertirFecha($data['fecha_atado'])
            : null;

        // Limpiar horas (solo acepta HH:mm o HH:mm:ss)
        $data['hora_paro'] = isset($data['hora_paro']) && $data['hora_paro']
            ? $this->convertirHora($data['hora_paro'])
            : null;

        $data['hora_arranque'] = isset($data['hora_arranque']) && $data['hora_arranque']
            ? $this->convertirHora($data['hora_arranque'])
            : null;

        // Limpiar metros (quita comas y convierte a decimal)
        $data['metros'] = isset($data['metros']) && $data['metros']
            ? $this->convertirDecimal($data['metros'])
            : null;

        // Limpiar merma_kg (opcional, si puede venir con coma)
        $data['merma_kg'] = isset($data['merma_kg']) && $data['merma_kg']
            ? $this->convertirDecimal($data['merma_kg'])
            : null;

        // Si algún campo viene vacío, lo mandamos a null
        foreach ($data as $key => $value) {
            if ($value === "" || $value === "null") {
                $data[$key] = null;
            }
        }

        return $data;
    }

    private function convertirFecha($fecha)
    {
        // Soporta dd/mm/aa y dd/mm/yyyy
        if (!$fecha) return null;
        $partes = explode('/', $fecha);
        if (count($partes) === 3) {
            $anio = strlen($partes[2]) == 2 ? '20' . $partes[2] : $partes[2];
            $fechaFormateada = $anio . '-' . $partes[1] . '-' . $partes[0];
            try {
                return Carbon::parse($fechaFormateada)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    private function convertirHora($hora)
    {
        // Soporta HH:mm y HH:mm:ss
        if (!$hora) return null;
        try {
            // Asegura formato HH:mm:ss para SQL
            return Carbon::createFromFormat(strlen($hora) === 5 ? 'H:i' : 'H:i:s', $hora)->format('H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function convertirDecimal($valor)
    {
        // Quita comas de miles y cambia decimal si trae ","
        if (!$valor) return null;
        $valor = str_replace(',', '', $valor); // Quita comas
        return is_numeric($valor) ? $valor : null;
    }

    public function cargarDatosUrdEngAtador()
    {
        //Log::info('Data:', $request->all());

        // Obtener los datos de las tres tablas basadas en el folio
        $atadores = DB::table('Produccion.dbo.TWDISPONIBLEURDENG2 as d')
            ->join('Produccion.dbo.requerimiento as r', 'd.reqid', '=', 'r.id')
            ->select('d.fecha', 'd.tipo', 'd.no_julio', 'd.metros', 'd.orden', 'r.telar', 'r.valor') // O especifica campos como: 'd.dis_id', 'r.telar', etc.
            ->get();

        // Pasar los datos a la vista
        return view('modulos/atadores/programar', compact('atadores'));
    }

    public function show(Request $request)
    {
        $orden = $request->orden;
        $turno = $request->turno;

        $atador = \App\Models\Atador::where('orden', $orden)
            ->where('turno', $turno)
            ->first();

        if ($atador) {
            return response()->json($atador);
        } else {
            return response()->json(null);
        };
    }

    public function save(Request $request)
    {
        //dd($request->all());
        $data = $request->all();
        $data = $this->limpiarDatosAtador($data);

        // Se usa "update or create" por orden + turno (ajusta si tu llave única es diferente)
        $atador = \App\Models\Atador::updateOrCreate(
            [
                'orden' => $data['orden'] ?? '',
                'turno' => $data['turno'] ?? '',
            ],
            [
                'estatus_atado'          => $data['estatus_atado'] ?? '',
                'fecha_atado'            => $data['fecha_atado'] ?? null,
                'turno'                  => $data['turno'] ?? null,
                'clave_atador'           => $data['clave_atador'] ?? '',
                'no_julio'               => $data['no_julio'] ?? '',
                'orden'                  => $data['orden'] ?? '',
                'tipo'                   => $data['tipo'] ?? '',
                'metros'                 => $data['metros'] ?? 0,
                'telar'                  => $data['telar'] ?? '',
                'proveedor'              => $data['proveedor'] ?? '',
                'merma_kg'               => $data['merma_kg'] ?? 0,
                'hora_paro'              => $data['hora_paro'] ?? null,
                'hora_arranque'          => $data['hora_arranque'] ?? null,
                'grua_hubtex'            => isset($data['grua_hubtex']) ? (bool) $data['grua_hubtex'] : false,
                'atadora_staubli'        => isset($data['atadora_staubli']) ? (bool) $data['atadora_staubli'] : false,
                'atadora_uster'          => isset($data['atadora_uster']) ? (bool) $data['atadora_uster'] : false,
                'calidad_atado'          => $data['calidad_atado'] ?? '',
                '5_s_orden_limpieza'     => $data['5_s_orden_limpieza'] ?? '',
                'firma_tejedor'          => $data['firma_tejedor'] ?? '',
                'obs'                    => $data['obs'] ?? '',

            ]
        );

        return response()->json(['success' => true, 'id' => $atador->id]);
    }

    public function validarTejedor(Request $request)
    {
        $password = $request->input('password');

        // Valida contra tu tabla de tejedores o como gustes:
        $esValido = $password === 'miclave123'; // Cambia por validación real

        if ($esValido) {
            return response()->json(['valido' => true]);
        } else {
            return response()->json(['valido' => false, 'mensaje' => 'Contraseña incorrecta']);
        }
    }
}
