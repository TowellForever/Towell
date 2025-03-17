@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-10">SMITH</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @php
            $modulos = [
                ['nombre' => '305', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '306', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '307', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '308', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '309', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '310', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '311', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '312', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '313', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '314', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '315', 'imagen' => 'smith.jpg', 'ruta' => '#'],
                ['nombre' => '316', 'imagen' => 'smith.jpg', 'ruta' => '#']
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
