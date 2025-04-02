@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-2">
    <h1 class="text-3xl font-bold text-center mb-6">Proceso de Producción de Engomado</h1>
    
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
            
            <label class="block font-medium mt-1">Núcleo:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Cuidados Min:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Destino:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
        </div>
        
        <!-- Segunda columna -->
        <div class="text-sm">
            <label class="block font-medium">Engomado:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Tipo:</label>
            <div class="flex gap-2 mt-0.5">
                <label class="text-xs"><input type="radio" name="tipo" value="Rizo" class="mr-1"> Rizo</label>
                <label class="text-xs"><input type="radio" name="tipo" value="Pie" class="mr-1"> Pie</label>
            </div>
            
            <label class="block font-medium mt-1">Calibre:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Ancho Balonas:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Sólidos:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Observaciones:</label>
            <textarea class="w-full border rounded p-1 text-xs h-20"></textarea>
        </div>
        
        <!-- Tercera columna -->
        <div class="text-sm">
            <label class="block font-medium">Fecha:</label>
            <input type="date" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Metraje de la Tela:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Proveedor:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Número de Telas:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
            
            <label class="block font-medium mt-1">Color:</label>
            <input type="text" class="w-full border rounded p-1 text-xs">
        </div>
    </form>
    
    <!-- Tabla de Datos -->
    <h2 class="text-xl font-semibold mt-6">Registro de Producción</h2>
    <table class="w-full border-collapse border border-gray-300 mt-2">
        <thead>
            <tr class="bg-gray-200 text-xs">
                <th class="border p-2">Fecha</th>
                <th class="border p-2">Oficial</th>
                <th class="border p-2">Turno</th>
                <th class="border p-2">Hora de Inicio</th>
                <th class="border p-2">Hora Fin</th>
                <th class="border p-2">Tiempo</th>
                <th class="border p-2">No de Julio</th>
                <th class="border p-2">Peso Bruto</th>
                <th class="border p-2">Tara</th>
                <th class="border p-2">Peso Neto</th>
                <th class="border p-2">Metros</th>
                <th class="border p-2">Temp Canoa 1</th>
                <th class="border p-2">Temp Canoa 2</th>
                <th class="border p-2">Temp Canoa 3</th>
                <th class="border p-2">Humedad</th>
                <th class="border p-2">Roturas</th>
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
        </tbody>
    </table>
</div>
@endsection
