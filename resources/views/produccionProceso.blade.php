@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-10">PRODUCCIÓN EN PROCESO</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @php
            $modulos = [
                ['nombre' => 'Planeación', 'imagen' => 'planeacion.png', 'ruta' => '#'],
                ['nombre' => 'Urdido', 'imagen' => 'urdido.jpg', 'ruta' => '#'],
                ['nombre' => 'Engomado', 'imagen' => 'engomado.jpg', 'ruta' => '#'],
                ['nombre' => 'Tejido', 'imagen' => 'tejido.jpg', 'ruta' => '/modulo-tejido'],
                ['nombre' => 'Atadores', 'imagen' => 'Atadores.jpg', 'ruta' => '#'],
                ['nombre' => 'Tejedores', 'imagen' => 'tejedores.jpg', 'ruta' => '#'],
                ['nombre' => 'Mantenimiento', 'imagen' => 'mantenimiento.png', 'ruta' => '#'],
                ['nombre' => 'Configuración', 'imagen' => 'configuracion.png', 'ruta' => '#']
            ];
        @endphp

        @foreach ($modulos as $modulo)
            <a href="{{ url($modulo['ruta']) }}" class="block">
                <div class="bg-white shadow-lg rounded-2xl p-2 flex flex-col justify-between items-center h-60 min-h-[200px] transition-transform transform hover:scale-105">
                    <div class="flex-grow flex items-center justify-center">
                        <img src="{{ asset('storage/fotos_modulos/' . $modulo['imagen']) }}" 
                        alt="{{ $modulo['nombre'] }}" 
                        class="h-32 w-32 object-cover rounded-lg">
                    </div>
                    <h2 class="text-lg font-semibold text-center mt-2">{{ $modulo['nombre'] }}</h2>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
