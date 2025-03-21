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

    <!-- Estilos personalizados -->
    <style>
    body {
        background: linear-gradient(135deg, #05cef6, #b9ecff, #044aa5);
        background-size: 300% 300%;
        animation: gradientAnimation 5s ease infinite;
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

    <!-- Navbar -->
    <nav class="bg-blue-350 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo Towell -->
            <a href="/produccionProceso" class="text-3xl font-extrabold">TOWELL</a>

            <!-- Botones de navegación -->
            <div class="flex gap-4">
                <!-- Botón Atrás -->
                <button onclick="history.back()" class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="11 19 2 12 11 5 11 19"></polygon>
                        <polygon points="22 19 13 12 22 5 22 19"></polygon>
                    </svg>
                    Atrás
                </button>
                <!-- Botón Adelante -->
                <button onclick="history.forward()" class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    Adelante
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 19 22 12 13 5 13 19"></polygon>
                        <polygon points="2 19 11 12 2 5 2 19"></polygon>
                    </svg>
                </button>
            </div>

            <!-- Nombre del usuario -->
            <p class="text-2xl font-bold uppercase flex justify-center items-center">
                {{ Auth::User()->nombre }}
            </p>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <main class="flex-grow container mx-auto p-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-6">
         &copy; Towell {{ date('Y') }}. Todos los derechos reservados.
    </footer>

</body>
</html>
