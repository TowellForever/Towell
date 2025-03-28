@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-10">JACQUARD SMITH</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @php
            $modulos = [
                ['nombre' => '201', 'imagen' => 'jsmith.jpg'],
                ['nombre' => '202', 'imagen' => 'jsmith.jpg'],
                ['nombre' => '203', 'imagen' => 'jsmith.jpg'],
                ['nombre' => '204', 'imagen' => 'jsmith.jpg'],
                ['nombre' => '205', 'imagen' => 'jsmith.jpg'],
                ['nombre' => '206', 'imagen' => 'jsmith.jpg'],
                ['nombre' => '213', 'imagen' => 'jsmith.jpg'],
                ['nombre' => '214', 'imagen' => 'jsmith.jpg'],
                ['nombre' => '215', 'imagen' => 'jsmith.jpg']
            ];
        @endphp

        @foreach ($modulos as $modulo)
            <a href="{{ route('tejido.mostrarTelarSulzer', ['telar' => $modulo['nombre']]) }}" class="block">
                <div class="bg-white shadow-lg rounded-xl p-2 flex flex-col justify-between items-center transition-transform transform hover:scale-105 h-40 min-h-[150px]">
                    <div class="flex-grow flex items-center justify-center">
                        <img src="{{ asset('storage/fotos_tejido/' . $modulo['imagen']) }}" 
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
