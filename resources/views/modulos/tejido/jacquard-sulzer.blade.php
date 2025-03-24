@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-10">JACQUARD SULZER</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
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
                <div class="bg-white shadow-lg rounded-2xl p-4 flex flex-col justify-between items-center transition-transform transform hover:scale-105 h-60">
                    <div class="flex-grow flex items-center justify-center">
                        <img src="{{ asset('storage/fotos_tejido/' . $modulo['imagen']) }}" 
                        alt="Telar {{ $modulo['nombre'] }}" 
                        class="h-36 w-36 object-cover rounded-lg">
                    </div>
                    <h2 class="text-lg font-semibold text-center mt-3">{{ $modulo['nombre'] }}</h2>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
