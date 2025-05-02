@extends('layouts.app')

@section('content')
@if (session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: @json(session('warning')),
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: false,
            backdrop: true,
            customClass: {
                popup: 'text-xl'
            }
        });
    });
</script>
@endif
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-center sm:mt-2 md:-mt-4 mb-2">JACQUARD SMITH</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
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
