<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TOWELL')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #9bc8ea;
        }
    </style>
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
