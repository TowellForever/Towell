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
            <a href="/produccionProceso" class="text-3xl font-extrabold">TOWELL</a>
            <p class="text-2xl font-bold uppercase flex justify-center items-center"> <!--uppercase - Lo usé para transformar las letras a mayusculas, pero esta tecnica si toma en cuenta letras con acento, y no las deja en minusculas-->
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
