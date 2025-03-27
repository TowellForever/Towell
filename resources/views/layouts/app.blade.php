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

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Estilos personalizados -->
    <style>
        body {
            background: linear-gradient(135deg, #099ff6, #c2e7ff, #0857be);
            background-size: 300% 300%;
            animation: gradientAnimation 5s ease infinite;
            position: relative; /* Para que el pseudo-elemento se posicione respecto al body */
        }

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
</head>
<body class="min-h-screen flex flex-col">
    <img src="/storage/fondosTowell/TOWELLIN.png" alt="Towelling" class="absolute top-2 right-2 w-[120px] z-0">

    <!-- Navbar -->
    <nav class="bg-blue-350 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo Towell -->
            <a href="/produccionProceso" class="text-3xl font-extrabold">
                <img src="/storage/fondosTowell/logo_towell2.png" alt="Logo_Towell" class="absolute top-10 left-2 w-[200px] z-0">
            </a>

            <!-- Botones de navegación -->
            <div class="flex gap-4 justify-center items-center ml-60 z-1 botonesApp">
                <!-- Botón Atrás -->
                <button onclick="history.back()" class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="11 19 2 12 11 5 11 19"></polygon>
                        <polygon points="22 19 13 12 22 5 22 19"></polygon>
                    </svg>
                </button>
                <!-- Botón Adelante -->
                <button onclick="history.forward()" class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 19 22 12 13 5 13 19"></polygon>
                        <polygon points="2 19 11 12 2 5 2 19"></polygon>
                    </svg>
                </button>
            </div>

            <!-- Nombre del usuario -->
            <p class="nombreApp text-black font-bold uppercase z-2">
                {{ Auth::User()->nombre }}
            </p>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <main class="">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-6">
         &copy; Towell {{ date('Y') }}. Todos los derechos reservados.
    </footer>

</body>
</html>
