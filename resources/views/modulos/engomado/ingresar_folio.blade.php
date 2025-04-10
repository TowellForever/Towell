<!-- resources/views/ingresar_folio.blade.php -->
@extends('layouts.app')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 1rem;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.18);
        animation: fadeInUp 0.6s ease-out both;
        position: relative;
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .loader {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: none;
    }

    .loader div {
        width: 32px;
        height: 32px;
        border: 4px solid #fff;
        border-top: 4px solid #2563eb;  
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .glass-card.loading form {
        opacity: 0.4;
        pointer-events: none;
    }

    .glass-card.loading .loader {
        display: block;
    }
</style>

<div class="flex items-center justify-center min-h-screen bg-gradient-to-br text-white">
    <div class="glass-card w-full max-w-md p-8" id="card">
        <h1 class="text-2xl font-semibold text-center mb-6 tracking-wide">Ingresar Orden de Trabajo</h1>
        <form id="folioForm" action="{{ route('produccion.ordenTrabajoEngomado') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="folio" class="block mb-1 text-sm font-medium">Orden de Trabajo</label>
                <input 
                    type="text" 
                    name="folio" 
                    id="folio" 
                    class="w-full px-4 py-2 rounded-md text-black border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                    required
                >
            </div>
            <button 
                type="submit" 
                class="w-full px-4 py-2 bg-blue-600 rounded-md text-white text-sm font-semibold shadow hover:shadow-lg transition-all duration-300"
            >
                Cargar Información
            </button>
        </form>
    </div>
</div>

@endsection
