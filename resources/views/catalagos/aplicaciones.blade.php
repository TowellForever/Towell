@extends('layouts.app')

@section('title', 'Aplicaciones - Planeación')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Aplicaciones</h1>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <!-- Encabezado -->
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="border border-gray-300 px-4 py-2">Clave</th>
                        <th class="border border-gray-300 px-4 py-2">Nombre</th>
                        <th class="border border-gray-300 px-4 py-2">Obs</th>
                    </tr>
                </thead>
                
                <tbody>
                    <!-- Filas de Datos (Ejemplo) -->
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">AP001</td>
                        <td class="border border-gray-300 px-4 py-2">Aplicación Alpha</td>
                        <td class="border border-gray-300 px-4 py-2">Primera versión en prueba</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2">AP002</td>
                        <td class="border border-gray-300 px-4 py-2">Aplicación Beta</td>
                        <td class="border border-gray-300 px-4 py-2">Requiere ajustes en seguridad</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">AP003</td>
                        <td class="border border-gray-300 px-4 py-2">Aplicación Gamma</td>
                        <td class="border border-gray-300 px-4 py-2">Implementada en producción</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
