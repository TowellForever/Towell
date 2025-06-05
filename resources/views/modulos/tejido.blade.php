@extends('layouts.app', ['ocultarBotones' => true])

@section('content')
    <div class="container mx-auto">
        @php
            // Detectar si estás en la ruta especial
            $esTejido = request()->is('modulo-tejido'); //tejido/jacquard-sulzer/ ESTA ES LA URL GLOBAL DE LA VISTA DINÁMICA, NUNCA CAMBIARÁ ESTA PARTE
        @endphp
        @if ($esTejido)
            <div class="flex gap-4 justify-center items-center z-5 botonesApp">
                <!-- Botón Atrás -->
                <button id="backBotton"
                    class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    ⬅️
                </button>
            </div>
        @endif
        <script>
            document.getElementById('backBotton').addEventListener('click', function() {
                window.location.href = '/produccionProceso';
            });
        </script>

        <h1 class="text-3xl font-bold text-center sm:mt-2 md:-mt-4 mb-2">TEJIDO</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
            @php
                $modulos = [
                    [
                        'nombre' => 'Jacquard Sulzer',
                        'imagen' => 'Jaqcuard.png',
                        'ruta' => '/tejido/jacquard-sulzer',
                    ],
                    ['nombre' => 'Jacquard Smith', 'imagen' => 'jsmith.jpg', 'ruta' => '/tejido/jacquard-smith'],
                    ['nombre' => 'Smith', 'imagen' => 'smith.jpg', 'ruta' => '/tejido/smith'],
                    ['nombre' => 'Itema Viejo', 'imagen' => 'itema_viejo.jpg', 'ruta' => '/tejido/itema-viejo'],
                    ['nombre' => 'Itema Nuevo', 'imagen' => 'itema_nuevo.jpg', 'ruta' => '/tejido/itema-nuevo'],
                ];
            @endphp

            @foreach ($modulos as $modulo)
                <a href="{{ url($modulo['ruta']) }}" class="block">
                    <div
                        class="bg-white shadow-lg rounded-xl p-2 flex flex-col justify-between items-center transition-transform transform hover:scale-105 h-40 min-h-[150px]">
                        <div class="flex-grow flex items-center justify-center">
                            <img src="{{ asset('images/fotos_tejido/' . $modulo['imagen']) }}" alt="{{ $modulo['nombre'] }}"
                                class="h-32 w-32 object-cover rounded-lg">
                        </div>
                        <h2 class="text-sm font-semibold text-center mt-1">{{ $modulo['nombre'] }}</h2>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endsection
