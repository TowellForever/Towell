@extends('layouts.app', ['ocultarBotones' => true])

@section('content')
    @if (session('bienvenida'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Bienvenido!',
                    html: 'Hola, <strong>{{ Auth::user()->nombre }}</strong>. <br><br>BIENVENIDO A LA APLICACIÓN WEB DE TOWELL.',
                    imageUrl: '/images/fondosTowell/TOWELLIN.png',
                    imageWidth: 120,
                    imageHeight: 120,
                    imageAlt: 'Logo de Towell',
                    timer: 2000, // Se cierra después de 2 segundos
                    timerProgressBar: true, // Muestra la barra de progreso
                    showConfirmButton: false, // Oculta el botón "Empezar"
                    background: '#f9f9f9',
                    color: '#333',
                    customClass: {
                        popup: 'shadow-lg rounded-xl'
                    }
                });
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: '¡Atención!',
                text: '{{ session('warning') }}',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#d33',
                backdrop: true,
                timer: 5000,
                timerProgressBar: true
            });
        </script>
    @endif
    <div class="container mx-auto overflow-y-auto sm:h-[800px]" id="globalLoader">
        <h1 class="text-3xl font-bold text-center sm:mt-2 md:-mt-4 mb-2">PRODUCCIÓN EN PROCESO</h1>

        @if (count($modulos) === 1)
            <!-- Si solo hay un módulo permitido, redirigir automáticamente -->
            <script>
                window.location.href = "{{ url(reset($modulos)['ruta']) }}";
            </script>
        @else
            <div class="grid sm:grid-cols-2 md:grid-cols-5 gap-6">
                @foreach ($modulos as $modulo)
                    <a href="{{ url($modulo['ruta']) }}" class="block">
                        <div
                            class="bg-white shadow-lg rounded-2xl p-2 flex flex-col justify-between items-center h-40 min-h-[150px] transition-transform transform hover:scale-105">
                            <div class="flex-grow flex items-center justify-center">
                                <img src="{{ asset('images/fotos_modulos/' . $modulo['imagen']) }}"
                                    alt="{{ $modulo['nombre'] }}" class="h-32 w-32 object-cover rounded-lg">
                            </div>
                            <h2
                                class="font-bold text-center {{ in_array($modulo['nombre'], ['PROGRAMACIÓN URDIDO ENGOMADO', 'EDICIÓN ORDEN URDIDO ENGOMADO']) ? 'textoPeq text-gray-600' : 'text-md' }}">
                                {{ $modulo['nombre'] }}
                            </h2>

                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            .textoPeq {
                font-size: 11px;
            }
        </style>
    @endpush
@endsection
