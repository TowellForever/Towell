<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('IA.chatbot');
    }

    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');
        $openaiApiKey = env('OPENAI_API_KEY');

        // 1. ¿Qué telares están desocupados?
        if (preg_match('/(telar.*desocupado|telar.*libre|telar.*disponible)/i', $userMessage)) {
            $telares = DB::table('TEJIDO_SCHEDULING')
                ->select('Telar')
                ->groupBy('Telar')
                ->havingRaw('SUM(CASE WHEN en_proceso = 1 THEN 1 ELSE 0 END) = 0')
                ->pluck('Telar')
                ->toArray();
            $telares = array_map(function ($telar) {
                return (int)$telar;
            }, $telares);

            $contexto = count($telares)
                ? "Los telares desocupados actualmente son: " . implode(', ', $telares) . "."
                : "En este momento, todos los telares están en proceso.";

            // 2. ¿Cuántas piezas está produciendo el telar n?
        } elseif (preg_match('/cu[aá]ntas piezas.*telar (\d+)/i', $userMessage, $match)) {
            $telar = (int)$match[1];
            $cantidad = DB::table('TEJIDO_SCHEDULING')
                ->where('Telar', $telar)
                ->where('en_proceso', 1)
                ->value('cantidad');
            if ($cantidad !== null) {
                $contexto = "El telar $telar está produciendo actualmente $cantidad piezas.";
            } else {
                $contexto = "No se encontraron piezas produciéndose actualmente en el telar $telar.";
            }

            // 3. ¿Con qué flog está trabajando el telar n?
        } elseif (preg_match('/flog.*telar (\d+)/i', $userMessage, $match)) {
            $telar = (int)$match[1];
            $flog = DB::table('TEJIDO_SCHEDULING')
                ->where('Telar', $telar)
                ->where('en_proceso', 1)
                ->value('Id_Flog');
            if ($flog) {
                $contexto = "El telar $telar está trabajando actualmente con el FLOG: $flog.";
            } else {
                $contexto = "No se encontró FLOG activo para el telar $telar.";
            }

            // 4. ¿Cuándo terminará el telar n?
        } elseif (preg_match('/cu[aá]ndo.*termina(?:r[áa])?.*telar\s*(\d+)/i', $userMessage, $match)) {
            $telar = (int)$match[1];
            $fecha = DB::table('TEJIDO_SCHEDULING')
                ->where('Telar', $telar)
                ->where('en_proceso', 1)
                ->value('Fin_Tejido');
            if ($fecha) {
                $contexto = "El telar $telar terminará el $fecha.";
            } else {
                $contexto = "No hay fecha de fin registrada para el telar $telar actualmente en proceso.";
            }

            // 5. ¿Cuál es el color más pedido por los clientes?
        } elseif (preg_match('/cu[aá]l.*color m[aá]s pedido/i', $userMessage)) {
            // Traemos todos los colores de los campos relevantes
            $colores = DB::table('TEJIDO_SCHEDULING')
                ->select(
                    'COLOR_TRAMA',
                    'COLOR_C1',
                    'COLOR_C2',
                    'COLOR_C3',
                    'COLOR_C4',
                    'COLOR_C5',
                    'Color_Pie'
                )
                ->get();

            $conteoColores = [];
            foreach ($colores as $registro) {
                foreach (['COLOR_TRAMA', 'COLOR_C1', 'COLOR_C2', 'COLOR_C3', 'COLOR_C4', 'COLOR_C5', 'Color_Pie'] as $campo) {
                    $valor = $registro->$campo;
                    if ($valor && trim($valor) != '') {
                        $conteoColores[$valor] = ($conteoColores[$valor] ?? 0) + 1;
                    }
                }
            }
            if (!empty($conteoColores)) {
                arsort($conteoColores);
                $colorMasPedido = array_key_first($conteoColores);
                $veces = $conteoColores[$colorMasPedido];
                $contexto = "El color más pedido por los clientes es: $colorMasPedido ($veces veces).";
            } else {
                $contexto = "No se encontraron colores registrados.";
            }

            // 6. ¿Cuál es el hilo menos utilizado?
        } elseif (preg_match('/hilo menos utilizado/i', $userMessage)) {
            $hilos = DB::table('TEJIDO_SCHEDULING')
                ->select('Hilo')
                ->whereNotNull('Hilo')
                ->where('Hilo', '!=', '')
                ->get()
                ->pluck('Hilo')
                ->toArray();

            if (!empty($hilos)) {
                $conteo = array_count_values($hilos);
                asort($conteo);
                $hiloMenosUtilizado = array_key_first($conteo);
                $veces = $conteo[$hiloMenosUtilizado];
                $contexto = "El hilo menos utilizado es: $hiloMenosUtilizado ($veces veces).";
            } else {
                $contexto = "No se encontraron datos de hilos en la base.";
            }

            // RESPUESTA POR DEFECTO
        } else {
            $contexto = "Eres un asistente que responde dudas sobre los telares por ahora, versión 1.";
        }

        // Consulta a OpenAI
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $openaiApiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => $contexto],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'max_tokens' => 200,
        ]);

        $botMessage = $response['choices'][0]['message']['content'] ?? 'Hubo un error, intenta de nuevo.';
        return response()->json(['message' => $botMessage]);
    }
}
