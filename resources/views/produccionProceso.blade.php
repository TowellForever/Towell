@extends('layouts.app', ['ocultarBotones' => true])

@section('content')
<div class="container mx-auto" id="globalLoader">
    <h1 class="text-3xl font-bold text-center sm:mt-2 md:-mt-4 mb-2">PRODUCCIÓN EN PROCESO</h1>

    @if (count($modulos) === 1)
        <!-- Si solo hay un módulo permitido, redirigir automáticamente -->
        <script>
            window.location.href = "{{ url(reset($modulos)['ruta']) }}";
        </script>
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($modulos as $modulo)
                <a href="{{ url($modulo['ruta']) }}" class="block">
                    <div class="bg-white shadow-lg rounded-2xl p-2 flex flex-col justify-between items-center h-40 min-h-[150px] transition-transform transform hover:scale-105">
                        <div class="flex-grow flex items-center justify-center">
                            <img src="{{ asset('images/fotos_modulos/' . $modulo['imagen']) }}" 
                            alt="{{ $modulo['nombre'] }}" 
                            class="h-32 w-32 object-cover rounded-lg">
                        </div>
                        <h2 class="text-lg font-semibold text-center">{{ $modulo['nombre'] }}</h2>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
