@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-4xl font-bold text-center text-indigo-600 mb-12">Configuración del Sistema</h1>

    <!-- Sección de opciones -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Opción 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <div class="flex justify-center mb-4">
                <i class="fas fa-cogs text-5xl text-indigo-600"></i>
            </div>
            <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">Gestión de Usuarios</h2>
            <p class="text-gray-600 text-center mb-6">Administra y configura los usuarios del sistema.</p>
            <div class="flex justify-center">
                <a href="#" class="bg-indigo-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">Ir a Configuración</a>
            </div>
        </div>

        <!-- Opción 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <div class="flex justify-center mb-4">
                <i class="fas fa-wrench text-5xl text-green-600"></i>
            </div>
            <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">Mantenimiento del Sistema</h2>
            <p class="text-gray-600 text-center mb-6">Realiza mantenimientos periódicos en el sistema.</p>
            <div class="flex justify-center">
                <a href="#" class="bg-green-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-green-700 transition duration-300">Iniciar Mantenimiento</a>
            </div>
        </div>

        <!-- Opción 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition duration-300">
            <div class="flex justify-center mb-4">
                <i class="fas fa-lock text-5xl text-yellow-600"></i>
            </div>
            <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">Seguridad</h2>
            <p class="text-gray-600 text-center mb-6">Configura las opciones de seguridad y privacidad del sistema.</p>
            <div class="flex justify-center">
                <a href="#" class="bg-yellow-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-yellow-700 transition duration-300">Gestionar Seguridad</a>
            </div>
        </div>
    </div>

    <!-- Sección de configuración avanzada -->
    <div class="mt-12">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Configuración Avanzada</h2>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Parámetros del Sistema</h3>
            <p class="text-gray-600 mb-4">Configura las opciones avanzadas del sistema para un funcionamiento óptimo.</p>

            <!-- Formulario de configuración -->
            <form action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="mb-4">
                        <label for="timezone" class="block text-gray-600 font-semibold mb-2">Zona Horaria</label>
                        <select id="timezone" name="timezone" class="w-full p-3 border rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                            <option value="UTC">UTC</option>
                            <option value="PST">PST</option>
                            <option value="CST">CST</option>
                            <option value="EST">EST</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="language" class="block text-gray-600 font-semibold mb-2">Idioma</label>
                        <select id="language" name="language" class="w-full p-3 border rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-600">
                            <option value="es">Español</option>
                            <option value="en">English</option>
                            <option value="fr">Français</option>
                        </select>
                    </div>
                </div>

                <div class="text-center mt-6">
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-6 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">Guardar Configuración</button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection

@push('styles')
    <!-- Font Awesome para iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endpush
