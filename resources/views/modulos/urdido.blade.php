@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-2">
    <h1 class="text-3xl font-bold text-center mb-6">Proceso de Producción de Urdido</h1>
    
    <!-- Formulario -->
    <form class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Primera columna -->
        <div class="text-sm">
            <label class="block font-medium">Orden de Trabajo:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Cuenta:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Urdido:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Calibre:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Proveedor:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
        </div>
        

        <!-- Segunda columna -->
        <div class="text-sm">
            <label class="block font-medium">Fecha:</label>
            <input type="date" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Tipo:</label>
            <div class="flex gap-2 mt-0.5">
                <label class="text-xs"><input type="radio" name="tipo" value="Rizo" class="mr-1"> Rizo</label>
                <label class="text-xs"><input type="radio" name="tipo" value="Pie" class="mr-1"> Pie</label>
            </div>
            
            <label class="block font-medium mt-1">Metros:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Lote:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
        </div>
        

        <!-- Tercera columna -->
        <div>
            <label class="block font-medium mt-1">Ordenado por:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Destino:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            <!-- Tabla de Construcción -->
            <h2 class="text font-semibold mt-4">Construcción</h2>
            <table class="w-full border-collapse border border-gray-300 mt-2">
                <thead>
                    <tr class="bg-gray-200 text-xs">
                        <th class="border p-1 w-1/5">No Julios</th>
                        <th class="border p-1 w-1/5">Hilos</th>
                        <th class="border p-1">OBS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                    </tr>
                    <tr>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                    </tr>
                    <tr>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                        <td class="border p-2"></td>
                    </tr>
                </tbody>
            </table>    
        </div>
    </form>



    <!-- Tabla de Datos -->
    <h2 class="text-xl font-semibold mt-6">Registro de Producción</h2>
    <table class="w-full border-collapse border border-gray-300 mt-2">
        <thead>
            <tr class="bg-gray-200 text-xs ">
                <th class="border p-2" colspan="12"></th>
                <th class="p-2 text-center border-2 border-black" colspan="4">Roturas</th>
            </tr>
            <tr class="bg-gray-200 text-xs">
                <th class="border p-2">Fecha</th>
                <th class="border p-2">Oficial</th>
                <th class="border p-2">Turno</th>
                <th class="border p-2">H. Inicio</th>
                <th class="border p-2">Tiempo</th>
                <th class="border p-2">No Julio</th>
                <th class="border p-2">Hilos</th>
                <th class="border p-2">P. Bruto</th>
                <th class="border p-2">Tara</th>
                <th class="border p-2">Tara</th>
                <th class="border p-2">P. Neto</th>
                <th class="border p-2">Metros</th>
                <th class="border p-2">Hilatura</th>
                <th class="border p-2">Máquina</th>
                <th class="border p-2">Operación</th>
                <th class="border p-2">Transferencia</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
            </tr>
            <tr>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
            </tr>
            <tr>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
                <td class="border p-2"></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
