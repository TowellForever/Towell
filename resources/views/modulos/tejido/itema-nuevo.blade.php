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
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center sm:mt-1 md:-mt-4 mb-2">ITEMA NUEVO</h1>
    
    <div class="grid grid-cols-2 md:grid-cols-6 gap-3">
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
