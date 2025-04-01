@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Mantenimiento de Sistema</h1>

    <!-- Sección de botones -->
    <div class="flex justify-center space-x-4 mb-8">
        <a href="#" class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300">Iniciar Mantenimiento</a>
        <a href="#" class="bg-green-500 text-white py-2 px-4 rounded-lg shadow-lg hover:bg-green-600 transition duration-300">Ver Reportes</a>
        <a href="#" class="bg-yellow-500 text-white py-2 px-4 rounded-lg shadow-lg hover:bg-yellow-600 transition duration-300">Configuración</a>
    </div>

    <!-- Tabla de registros -->
    <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Fecha</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Estado</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t">
                    <td class="px-6 py-4 text-sm text-gray-700">001</td>
                    <td class="px-6 py-4 text-sm text-gray-700">Mantenimiento de Servidor</td>
                    <td class="px-6 py-4 text-sm text-gray-700">2025-04-01</td>
                    <td class="px-6 py-4 text-sm text-green-500">Activo</td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <a href="#" class="text-blue-500 hover:underline">Ver</a>
                        <a href="#" class="ml-4 text-red-500 hover:underline">Eliminar</a>
                    </td>
                </tr>
                <!-- Puedes agregar más filas aquí -->
            </tbody>
        </table>
    </div>

    <!-- Pie de página -->
    <div class="mt-8 text-center text-gray-500 text-sm">
        <p>&copy; 2025 Mi Empresa. Todos los derechos reservados.</p>
    </div>
</div>

@endsection
