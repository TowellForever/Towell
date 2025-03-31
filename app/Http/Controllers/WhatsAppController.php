<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Tu número de teléfono de prueba
        $phoneNumber = '522214125380'; // Reemplaza con el número correcto
        $accessToken = 'EAAQtu7d8DzoBOzQ8gWqtgy3ZCjLZCE0SYlrfEgT7bxIh8qZBgJMSAMrwrH9edgt9xM4OQpQgcOCBkTqGBOwlZCTJ99SwoS81S8nlrHTjcCuSFNSBZCzBAFSZCgzd1PnZBcJujAzq4IEPPuz5RawZCrJ842YkTgMBZB34O1AFGVoHocwelrsuu41k2zhsn3kZBLytHC83UZCnVZBzwblcSx9hhx4Yj3CbkW079ZCH2IeZA4'; // Tu token de acceso
    
        // Obtener el mensaje del formulario
        $message = $request->input('message'); // Asegúrate de que el campo se llame 'message'
    
        if (!$message) {
            return response()->json(['status' => 'El mensaje no puede estar vacío'], 400);
        }
    
        // Definir la URL de la API de WhatsApp
        $url = 'https://graph.facebook.com/v14.0/607016819162527/messages'; // Reemplaza con el ID de tu número
    
        // Definir la plantilla de mensaje (asegúrate de que la plantilla esté aprobada)
        $templateName = 'hello_world'; // Reemplaza con el nombre de tu plantilla
        $languageCode = 'en_US'; // El código de idioma (puede ser 'es_MX' para español)
    
        // Realizar la solicitud POST para enviar el mensaje
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])->post($url, [
            'messaging_product' => 'whatsapp',
            'to' => $phoneNumber,
            'type' => 'template',
            'template' => [
                'name' => $templateName, // Nombre de la plantilla
                'language' => ['code' => $languageCode] // Código de idioma
            ],
        ]);
    
        // Verifica la respuesta de la API
        if ($response->successful()) {
            // Si la respuesta es exitosa, devuelve un mensaje de éxito
            return response()->json(['status' => 'Mensaje enviado correctamente']);
        } else {
            // Si hubo un error, muestra el código de error y la respuesta de la API
            $errorDetails = $response->json(); // Captura detalles de error
            return response()->json([
                'status' => 'Error al enviar el mensaje',
                'error' => $errorDetails
            ], 500);
        }
    }
    
}
