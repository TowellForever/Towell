<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TwilioService;

class ReporteFallaController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function enviarReporte(Request $request)
    {
        $request->validate([
            'telefono' => 'required|numeric',
            'mensaje' => 'required|string|max:160',
        ]);

        $this->twilioService->sendMessage($request->telefono, $request->mensaje);

        return back()->with('success', 'Reporte enviado con éxito.');
    }
}
