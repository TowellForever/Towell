<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'TOWELL S.A DE C.V')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Agregar Axios desde el CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- jQuery (debe ir primero) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate.css (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Estilos personalizados -->
    <style>
        body {
            background: linear-gradient(135deg, #099ff6, #c2e7ff, #0857be);
            background-size: 300% 300%;
            animation: gradientAnimation 5s ease infinite;
            position: relative;
            overflow: hidden;
            /* Para que los círculos no se salgan del body */
        }

        /* Animación del fondo */
        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    @stack('styles') <!-- Aquí se inyectarán los estilos agregados con @push('styles') -->
    </head>

    <body class="min-h-screen flex flex-col">
        <!-- Incluir el loader global -->
        @include('layouts.globalLoader')

        <a href="/produccionProceso" class="text-3xl font-extrabold">
            <img src="{{ asset('images/fondosTowell/TOWELLIN.png') }} " alt="Towelling"
                class="absolute top-1 right-2 w-[36px] z-1">
        </a>

        <!-- Nombre del usuario -->
        <p class="hidden md:block nombreApp text-black font-bold uppercase text-xs">
            {{ Auth::user()->nombre }}
        </p>

        <a href="{{ route('telares.falla') }}" class="absolute top-1 right-20 z-1 btn btn-danger text-sm">Reportar Falla</a>
        <!-- Navbar -->
        <nav class="bg-blue-350 text-white ">
            <div class="container mx-auto flex justify-between items-center relative">
                <!-- Logo Towell -->
                <a href="/produccionProceso" class="text-3xl font-extrabold">
                    <img src="{{ asset('images/fondosTowell/logo_towell2.png') }} " alt="Logo_Towell"
                        class="absolute top-1 left-2 w-[120px] z-1 no-print">
                </a>

                @if (!isset($ocultarBotones) || !$ocultarBotones)
                    <!-- Botones de navegación -->
                    <div
                        class="flex gap-4 justify-center items-center z-5 botonesApp  md:gap-4 md:items-center lg:flex-row lg:gap-6 lg:ml-0">
                        <!-- Botón Atrás -->
                        <button onclick="history.back()"
                            class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polygon points="11 19 2 12 11 5 11 19"></polygon>
                                <polygon points="22 19 13 12 22 5 22 19"></polygon>
                            </svg>
                        </button>

                        <!-- Botón Adelante -->
                        <button onclick="history.forward()"
                            class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polygon points="13 19 22 12 13 5 13 19"></polygon>
                                <polygon points="2 19 11 12 2 5 2 19"></polygon>
                            </svg>
                        </button>
                    </div>
                @endif

            </div>
        </nav>

        <!-- Contenido de la página -->
        <main class="">
            @yield('content')
            <!-- JavaScript para mostrar/ocultar el loader -->
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white text-center p-3 mt-16">
            &copy; Towell {{ date('Y') }}. Todos los derechos reservados.
            <!-- Nombre del usuario -->
            <p class=" sm:block md:hidden text-white font-bold uppercase text-sm"> {{ Auth::user()->nombre }}</p>
        </footer>

        <script>
            // Muestra el loader cuando la página empieza a cargar
            document.addEventListener('DOMContentLoaded', function() {
                const loader = document.getElementById('globalLoader');
                loader.style.display = 'none'; // Oculta el loader cuando la página se carga
            });

            // Puedes agregar más scripts para mostrar el loader durante eventos específicos (AJAX, formularios, etc.)
        </script>

    </body>

    </html>
