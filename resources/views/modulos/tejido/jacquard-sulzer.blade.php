@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold text-center sm:mt-2 md:-mt-4 mb-2">JACQUARD SULZER</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
        @php
            $modulos = [
                ['nombre' => '207', 'imagen' => 'Jaqcuard.png'],
                ['nombre' => '208', 'imagen' => 'Jaqcuard.png'],
                ['nombre' => '209', 'imagen' => 'Jaqcuard.png'],
                ['nombre' => '210', 'imagen' => 'Jaqcuard.png'],
                ['nombre' => '211', 'imagen' => 'Jaqcuard.png']
            ];
        @endphp

        @foreach ($modulos as $modulo)
            <a href="{{ route('tejido.mostrarTelarSulzer', ['telar' => $modulo['nombre']]) }}" class="block">
                <div class="bg-white shadow-lg rounded-xl p-2 flex flex-col justify-between items-center transition-transform transform hover:scale-105 h-40 min-h-[150px]">
                    <div class="flex-grow flex items-center justify-center">
                        <img src="{{ asset('images/fotos_tejido/' . $modulo['imagen']) }}" 
                        alt="Telar {{ $modulo['nombre'] }}" 
                        class="h-32 w-32 object-cover rounded-lg">
                    </div>
                    <h2 class="text-sm font-semibold text-center mt-1">{{ $modulo['nombre'] }}</h2>
                </div>
            </a>
        @endforeach

    </div>
</div>
@endsection
