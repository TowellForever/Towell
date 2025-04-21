<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urdido Temporal</title>
    <!-- Agrega los estilos de Tailwind CSS si aún no los has agregado -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Animación de giro */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Clase de animación para hacer girar el círculo lentamente */
        .animate-spin-slow {
            animation: spin 1s linear infinite;
        }
    </style>
</head>

<body class="bg-gray-800 flex items-center justify-center min-h-screen">

    <!-- Círculo que gira y tiene colores vibrantes -->
    <div class="w-96 h-96 rounded-full bg-gradient-to-r from-red-500 via-yellow-500 to-blue-500 animate-spin-slow"></div>

</body>

</html>
