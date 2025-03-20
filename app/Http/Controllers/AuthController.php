<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;  // Asegúrate de importar el FormRequest
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {
        // La validación se aplica automáticamente
        $validated = $request->validated();

        // Buscar el empleado en la base de datos
        $empleado = Usuario::where('numero_empleado', $request->numero_empleado)->first();

        if ($empleado && Hash::check($request->contrasenia, $empleado->contrasenia)) {
            // Contraseña correcta, realizar login
            Auth::login($empleado);
            return redirect()->intended('/produccionProceso');
        }

        // Si no se encuentran las credenciales, devolver error
        return back()->with('error', 'Su contraseña está incorrecta');
    }

    public function loginQR(Request $request)
    {
        $request->validate([
            'numero_empleado' => 'required|exists:usuarios,numero_empleado'
        ]);

        // Buscar el usuario en la BD
        $empleado = Usuario::where('numero_empleado', $request->numero_empleado)->first();

        if ($empleado) {
            // Iniciar sesión sin contraseña
            Auth::login($empleado);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Empleado no encontrado'], 401);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
