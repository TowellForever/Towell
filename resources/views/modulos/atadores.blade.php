@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-10">ATADORES</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @php
            $modulos = [
                ['nombre' => 'Programar', 'imagen' => 'Atadores.jpg', 'ruta' => '/atadores-programar'],
                ['nombre' => 'Submódulo 2', 'imagen' => 'Atadores.jpg', 'ruta' => '/atadores/atadores2'],
                ['nombre' => 'Programar Requerimientos', 'imagen' => 'engomado.jpg', 'ruta' => '/engomado/programar-requerimientos']
            ];
        @endphp
        @foreach ($modulos as $modulo)
            <a href="{{ url($modulo['ruta']) }}" class="block">
                <div class="bg-white shadow-lg rounded-xl p-2 flex flex-col justify-between items-center transition-transform transform hover:scale-105 h-40 min-h-[150px]">
                    <div class="flex-grow flex items-center justify-center">
                        <img src="{{ asset('images/fotos_modulos/' . $modulo['imagen']) }}" 
                        alt="{{ $modulo['nombre'] }}" 
                        class="h-32 w-32 object-cover rounded-lg">
                    </div>
                    <h2 class="text-sm font-semibold text-center mt-1">{{ $modulo['nombre'] }}</h2>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection

