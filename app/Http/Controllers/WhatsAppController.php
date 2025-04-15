<?php
namespace App\Http\Controllers;

use App\Models\Fallas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{

    public function enviarMensaje(Request $request)
    {
        // Lista de números de teléfono a los que se enviará el mensaje
        $phoneNumbers = ['522214125380' ,'522221130412'];
        $accessToken = 'EAAQtu7d8DzoBOyQHpcZAZBy0qgQMCEplPNRX1M7F2IBnM7o1fjErxEyb6oNpMXKg3aipjkPfD8B9KSYDmiGFqaSxFHDthNe4Euv270MeKnrvLmFadtpEoUGKvDWSExKGMyIQXpQLZAHJ6V2XbxWjEK9vq3NZBsqmegUZCnZBQrUxLZBgHYDg5Lps6NXuI2kS4xtAGSDX0MB7ZCGhIpjBeLSXfYQ7ZA7wUb5ZB4EuUZD';
    
        // Validar campos
        $request->validate([
            'telar' => 'required',
            'tipo' => 'required',
            'clave_falla' => 'required',
            'descripcion' => 'required',
            'fecha_reporte' => 'required',
            'hora_reporte' => 'required',
            'operador' => 'required',
            'observaciones' => 'nullable',
        ]);
    
        // Construir mensaje unificado
        $mensaje = "📟 *Reporte de Falla* | ";
        $mensaje .= "🔧 *Telar:* {$request->telar} | ";
        $mensaje .= "⚙️ *Tipo:* {$request->tipo} | ";
        $mensaje .= "🔢 *Clave:* {$request->clave_falla} | ";
        $mensaje .= "📝 *Descripción:* {$request->descripcion} | ";
        $mensaje .= "📅 *Fecha:* {$request->fecha_reporte} | ";
        $mensaje .= "⏰ *Hora:* {$request->hora_reporte} | ";
        $mensaje .= "👤 *Operador:* {$request->operador} | ";
        $mensaje .= "🗒️ *Observaciones:* " . ($request->observaciones ?: 'Sin observaciones');        
    
        // URL de la API de WhatsApp
        $url = 'https://graph.facebook.com/v14.0/607016819162527/messages';
    
        // Datos del template
        $templateName = 'prueba_towellin';
        $languageCode = 'en_US'; // O el idioma que esté configurado
    
        $responses = [];
    
        foreach ($phoneNumbers as $phoneNumber) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $phoneNumber,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => ['code' => $languageCode],
                    'components' => [[
                        'type' => 'body',
                        'parameters' => [
                            ['type' => 'text', 'text' => $mensaje]
                        ]
                    ]]
                ],
            ]);
    
            $responses[] = [
                'number' => $phoneNumber,
                'status' => $response->successful() ? 'Mensaje enviado' : 'Error',
                'response' => $response->json()
            ];
        }
    
        return response()->json(['results' => $responses]);
    }  


    public function sendMessage(Request $request)
    {
        // Lista de números de teléfono a los que se enviará el mensaje
        $phoneNumbers = ['522214125380'];
        $accessToken = 'EAAQtu7d8DzoBOyQHpcZAZBy0qgQMCEplPNRX1M7F2IBnM7o1fjErxEyb6oNpMXKg3aipjkPfD8B9KSYDmiGFqaSxFHDthNe4Euv270MeKnrvLmFadtpEoUGKvDWSExKGMyIQXpQLZAHJ6V2XbxWjEK9vq3NZBsqmegUZCnZBQrUxLZBgHYDg5Lps6NXuI2kS4xtAGSDX0MB7ZCGhIpjBeLSXfYQ7ZA7wUb5ZB4EuUZD'; // Reemplaza con tu token
    
        // Validación de los datos
        $request->validate([
            'telar' => 'required',
            'falla_numero' => 'required',
            'falla' => 'required',
            'usuario' => 'required',
        ]);
    
        // Capturar los datos ingresados por el usuario
        $parameters = [
            ['type' => 'text', 'text' => $request->telar],
            ['type' => 'text', 'text' => $request->falla_numero],
            ['type' => 'text', 'text' => $request->falla],
            ['type' => 'text', 'text' => $request->usuario],
        ];
    
        // Definir la URL de la API de WhatsApp
        $url = 'https://graph.facebook.com/v14.0/607016819162527/messages';
    
        // Nombre de la plantilla y código de idioma
        $templateName = 'prueba_variables'; // Reemplaza con el nombre real de la plantilla
        $languageCode = 'en_US';
    
        // Variable para almacenar respuestas
        $responses = [];
    
        // Enviar el mensaje a cada número en la lista
        foreach ($phoneNumbers as $phoneNumber) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->post($url, [
                'messaging_product' => 'whatsapp',
                'to' => $phoneNumber,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => ['code' => $languageCode],
                    'components' => [[
                        'type' => 'body',
                        'parameters' => $parameters
                    ]]
                ],
            ]);
    
            // Guardar la respuesta para cada número
            $responses[] = [
                'number' => $phoneNumber,
                'status' => $response->successful() ? 'Mensaje enviado' : 'Error',
                'response' => $response->json()
            ];
        }
    
        return response()->json(['results' => $responses]);
    }    

    public function mensajeFallas(Request $request){
          // Obtener todas las fallas
          $fallas = Fallas::all();

          // Retornar los datos a una vista o simplemente devolverlo en formato JSON
          return view('whatsapp2', compact('fallas'));
    }

  
    
}
