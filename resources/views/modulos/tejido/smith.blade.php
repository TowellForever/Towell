@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-center -mt-4 mb-2">SMITH</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
        @php
            $modulos = [
                ['nombre' => '305', 'imagen' => 'smith.jpg'],
                ['nombre' => '306', 'imagen' => 'smith.jpg'],
                ['nombre' => '307', 'imagen' => 'smith.jpg'],
                ['nombre' => '308', 'imagen' => 'smith.jpg'],
                ['nombre' => '309', 'imagen' => 'smith.jpg'],
                ['nombre' => '310', 'imagen' => 'smith.jpg'],
                ['nombre' => '311', 'imagen' => 'smith.jpg'],
                ['nombre' => '312', 'imagen' => 'smith.jpg'],
                ['nombre' => '313', 'imagen' => 'smith.jpg'],
                ['nombre' => '314', 'imagen' => 'smith.jpg'],
                ['nombre' => '315', 'imagen' => 'smith.jpg'],
                ['nombre' => '316', 'imagen' => 'smith.jpg']
            ];
        @endphp

    @foreach ($modulos as $modulo)
        <a href="{{ route('tejido.mostrarTelarSulzer', ['telar' => $modulo['nombre']]) }}" class="block">
            <div class="bg-white shadow-lg rounded-xl p-2 flex flex-col justify-between items-center transition-transform transform hover:scale-105 h-40 min-h-[150px]">
                <div class="flex-grow flex items-center justify-center">
                    <img src="{{ asset('images/fotos_tejido/' . $modulo['imagen']) }}" 
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
