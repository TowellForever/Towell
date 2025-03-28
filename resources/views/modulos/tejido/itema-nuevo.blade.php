@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-10">ITEMA NUEVO</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
        @php
            $modulos = [
                ['nombre' => '299', 'imagen' => 'itema_nuevo.jpg'],
                ['nombre' => '300', 'imagen' => 'itema_nuevo.jpg'],
                ['nombre' => '301', 'imagen' => 'itema_nuevo.jpg'],
                ['nombre' => '302', 'imagen' => 'itema_nuevo.jpg'],
                ['nombre' => '319', 'imagen' => 'itema_nuevo.jpg'],
                ['nombre' => '320', 'imagen' => 'itema_nuevo.jpg']
            ];
        @endphp

        @foreach ($modulos as $modulo)
            <a href="{{ route('tejido.mostrarTelarSulzer', ['telar' => $modulo['nombre']]) }}" class="block">
                <div class="bg-white shadow-lg rounded-lg p-2 flex flex-col justify-between items-center transition-transform transform hover:scale-105 h-48 min-h-[120px]">
                    <div class="flex-grow flex items-center justify-center">
                        <img src="{{ asset('images/fotos_tejido/' . $modulo['imagen']) }}"  
                        alt="{{ $modulo['nombre'] }}" 
                        class="h-32 w-32 object-cover rounded-lg">
                    </div>
                    <h2 class="text-sm font-semibold text-center mt-2">{{ $modulo['nombre'] }}</h2>
                </div>
            </a>
        @endforeach

    </div>
</div>
@endsection
