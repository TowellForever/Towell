<?php

namespace App\Http\Controllers;

use App\Models\Planeacion; // Asegúrate de importar el modelo Planeacion
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlaneacionController extends Controller
{
    // Método para obtener los datos y pasarlos a la vista
    public function index(Request $request)
    {
        $headers = [
            'Cuenta', 'Salon', 'Telar', 'Ultimo', 'Cambios_Hilo', 'Maquina', 'Ancho', 'Eficiencia_Std', 'Velocidad_STD', 
            'Calibre_Rizo', 'Calibre_Pie', 'Calendario', 'Clave_Estilo', 'Tamano', 'Estilo_Alternativo', 'Nombre_Producto', 
            'Saldos', 'Fecha_Captura', 'Orden_Prod', 'Fecha_Liberacion', 'Id_Flog', 'Descrip', 'Aplic', 'Obs', 'Tipo_Ped', 
            'Tiras', 'Peine', 'Largo_Crudo', 'Peso_Crudo', 'Luchaje', 'CALIBRE_TRA', 'Dobladillo', 'PASADAS_TRAMA', 'PASADAS_C1',
            'PASADAS_C2', 'PASADAS_C3', 'PASADAS_C4', 'PASADAS_C5', 'ancho_por_toalla', 'COLOR_TRAMA', 'CALIBRE_C1', 'Clave_Color_C1', 
            'COLOR_C1', 'CALIBRE_C2', 'Clave_Color_C2', 'COLOR_C2', 'CALIBRE_C3', 'Clave_Color_C3', 'COLOR_C3', 'CALIBRE_C4', 
            'Clave_Color_C4', 'COLOR_C4', 'CALIBRE_C5', 'Clave_Color_C5', 'COLOR_C5', 'Plano', 'Cuenta_Pie', 'Clave_Color_Pie', 
            'Color_Pie', 'Peso____(gr_/_m²)', 'Dias_Ef', 'Prod_(Kg)/Día', 'Std/Dia', 'Prod_(Kg)/Día1', 'Std_(Toa/Hr)_100%', 
            'Dias_jornada_completa', 'Horas', 'Std/Hrefectivo', 'Inicio_Tejido', 'Calc4', 'Calc5', 'Calc6', 'Fin_Tejido', 
            'Fecha_Compromiso', 'Fecha_Compromiso1', 'Entrega', 'Dif_vs_Compromiso', 'en_proceso'
        ];
    
        $query = DB::table('TEJIDO_SCHEDULING');
        
        if ($request->has('column') && $request->has('value')) {
            $column = $request->input('column');
            $value = $request->input('value');
            if (in_array($column, $headers)) {
                $query->where($column, 'like', '%' . $value . '%');
            }
        }
    
        $datos = $query->get();
    
        return view('modulos/planeacion', compact('datos', 'headers'));
    }
    

    public function calendarios()
    {
        return view('/catalagos/calendarios');
    }
    
    public function aplicaciones()
    {
        return view('/catalagos/aplicaciones');
    }
    
    public function update(Request $request, $id)
    {
        // Buscar el registro por Id
        $registro = Planeacion::where('Id', $id)->first();
    
        if (!$registro) {
            return redirect()->route('planeacion.index')->with('error', 'Registro no encontrado');
        }
    
        // Verificar si se marca el checkbox 'en_proceso'
        if ($request->has('en_proceso') && $request->en_proceso == '1') {
            // Desmarcar todos los registros con el mismo telar
            Planeacion::where('Telar', $registro->Telar)
                ->update(['en_proceso' => false]); // Desmarcar todos los registros del mismo telar
    
            // Luego marcar solo el registro actual
            $registro->update(['en_proceso' => true]);
        } else {
            // Si no se marca, simplemente desmarcar el registro actual
            $registro->update(['en_proceso' => false]);
        }
    
        // Redirigir con mensaje
        return redirect()->route('planeacion.index') // Asegúrate de redirigir a la ruta correcta
            ->with('success', 'Estado actualizado correctamente');
    }

    //metodos de TELARES (tablas de datos de tejido)********************************************************************************************************
    public function mostrarTelarSulzer($telar)
    {
         // Buscar el registro en proceso para este telar
        $datos = DB::table('TEJIDO_SCHEDULING')
        ->where('en_proceso', 1)
        ->where('telar', $telar)
        ->get();

        // Retornar la vista con los datos del telar
        return view('modulos/tejido/telares/jacquard-sulzer', compact('telar', 'datos'));
    }

    public function obtenerOrdenesProgramadas($Telar)
    {
        try {
            // Buscar las órdenes programadas para el telar, con 'en_proceso' igual a 0
            $ordenes = Planeacion::where('numero_telar', $Telar)
                            ->where('en_proceso', 0)
                            ->get();
    
            // Verificar si existen órdenes
            if ($ordenes->isEmpty()) {
                return back()->with('error', 'No hay órdenes para este telar.');
            }
    
            return view('login', compact('ordenes', 'Telar'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cargar las órdenes: ' . $e->getMessage());
        }
    }


}
