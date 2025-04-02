@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-10">Programación de Requerimientos</h1>
    
    <!-- Tabla 1: Requerimiento desde Dynamics AX -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-lg font-bold bg-yellow-200 text-center py-2 mb-4">Requerimiento desde Dynamics AX</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border p-2">Telar</th>
                    <th class="border p-2">Tipo</th>
                    <th class="border p-2">Cuenta</th>
                    <th class="border p-2">Fecha Requerida</th>
                    <th class="border p-2">Metros</th>
                    <th class="border p-2">Orden Urdido o Engomado</th>
                    <th class="border p-2">Programar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2">001</td>
                    <td class="border p-2">Tipo A</td>
                    <td class="border p-2">Cuenta 123</td>
                    <td class="border p-2">10-04-2025</td>
                    <td class="border p-2">500</td>
                    <td class="border p-2">Urdido</td>
                    <td class="border p-2 text-center"><input type="checkbox"></td>
                </tr>
            </tbody>
        </table>
        <button class="mt-3 w-1/6 px-4 py-2 text-sm bg-blue-500 text-white rounded shadow hover:bg-blue-600">Ingresar Datos??</button>
    </div>
    
    <!-- Espacio entre tablas -->
    <div class="my-6"></div>

    <!-- Tabla 2: Inventario Disponible -->
    <div class="bg-white shadow-md rounded-lg p-4">
        <h2 class="text-lg font-bold bg-yellow-200 text-center py-2 mb-4">Inventario Disponible</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border p-2">Orden</th>
                    <th class="border p-2">Tipo</th>
                    <th class="border p-2">Cuenta</th>
                    <th class="border p-2">Hilo</th>
                    <th class="border p-2">No Julios</th>
                    <th class="border p-2">Kilos</th>
                    <th class="border p-2">Metros</th>
                    <th class="border p-2">Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2">ORD-001</td>
                    <td class="border p-2">Tipo B</td>
                    <td class="border p-2">Cuenta 456</td>
                    <td class="border p-2">Hilo X</td>
                    <td class="border p-2">25</td>
                    <td class="border p-2">100</td>
                    <td class="border p-2">200</td>
                    <td class="border p-2 text-center"><input type="checkbox"></td>
                </tr>
            </tbody>
        </table>
        <button class="mt-3 w-1/6 px-4 py-2 text-sm bg-green-500 text-white rounded shadow hover:bg-green-600">Reservar</button>
    </div>
</div>
@endsection