<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // Llama a la API de OpenAI
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $openaiApiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Primera prueba de chatbot.'],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'max_tokens' => 200,
        ]);

        $botMessage = $response['choices'][0]['message']['content'] ?? 'Hubo un error, intenta de nuevo.' . $response->body();
        return response()->json(['message' => $botMessage]);
    }
}
