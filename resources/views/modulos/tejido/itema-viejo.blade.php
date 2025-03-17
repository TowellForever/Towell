@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-10">ITEMA VIEJO</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @php
            $modulos = [
                ['nombre' => '303', 'imagen' => 'itema_viejo.jpg', 'ruta' => '#'],
                ['nombre' => '304', 'imagen' => 'itema_viejo.jpg', 'ruta' => '#'],
                ['nombre' => '317', 'imagen' => 'itema_viejo.jpg', 'ruta' => '#'],
                ['nombre' => '318', 'imagen' => 'itema_viejo.jpg', 'ruta' => '#']
            ];
        @endphp

        @foreach ($modulos as $modulo)
            <a href="{{ url($modulo['ruta']) }}" class="block">
                <div class="bg-white shadow-lg rounded-2xl p-4 flex flex-col justify-between items-center transition-transform transform hover:scale-105 h-60">
                    <div class="flex-grow flex items-center justify-center">
                        <img src="{{ asset('storage/fotos_tejido/' . $modulo['imagen']) }}" 
                        alt="{{ $modulo['nombre'] }}" 
                        class="h-36 w-36 object-cover rounded-lg">
                    </div>
                    <h2 class="text-lg font-semibold text-center mt-3">{{ $modulo['nombre'] }}</h2>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection