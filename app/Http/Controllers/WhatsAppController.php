<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Lista de números de teléfono a los que se enviará el mensaje
        $phoneNumbers = ['522214125380', '522221130412'];
        $accessToken = 'EAAQtu7d8DzoBOZBeQi1zEZAH3sfKcWZBCv7HVHAPQqUq1GLaMax3Mtrr1ZA2Seojfol9niZBGlGz6Dra3vv9PcBwzpgQMrcVlsYHZAMiZBBSwZAeZB63C9HZBHIAuDZASZAqdpg0S4qhjSRYILHfiZBv05weh4lGfAzZCWQKo8ZAo9PwY11v2oweyQfvt1kcMk2zCxaWqyjxRNk3YLR8ijb5tadwupGsOtpGWAKxsdRJKEZD'; // Reemplaza con tu token
    
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
    
}
