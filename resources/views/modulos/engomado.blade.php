@extends('layouts.app')

@section('content')
<div class="container mx-auto p-2 bg-white shadow-lg rounded-lg mt-1">
    <h1 class="text-3xl font-bold text-center mb-2">Proceso de Producción de Engomado</h1>
    
    <!-- Formulario -->
    <form class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
        <!-- Primera columna -->
        <div class="text-sm">
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Orden de Trabajo:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ old('orden_prod') }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Cuenta:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ old('cuenta') }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Urdido:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ old('urdido') }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Núcleo:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ old('nucleo') }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Cuendeados Mínimo:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ old('cuidados_min') }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Destino:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ old('destino') }}" />
            </div>
        </div>
        
        <div class="text-sm">
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Engomado:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Tipo:</label>
                <div class="flex gap-2 mt-0.5 w-2/6">
                    <label class="text-xs"><input type="radio" name="tipo" value="Rizo" class="mr-1"> Rizo</label>
                    <label class="text-xs"><input type="radio" name="tipo" value="Pie" class="mr-1"> Pie</label>
                </div>
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Calibre:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Ancho Balonas:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Sólidos:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Observaciones:</label>
                <textarea class="w-2/6 border rounded p-1 text-xs h-20"></textarea>
            </div>
        </div>
        
        
        <div class="text-sm">
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Fecha:</label>
                <input type="date" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Metraje de la Tela:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Proveedor:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Número de Telas:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Color:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        </div>
        
    </form>
    
    <!-- Tabla de Datos -->
    <h2 class="text-sm font-bold mt-2">Registro de Producción</h2>
    <table class="w-full border-collapse border border-gray-300 mt-2">
        <thead>
            <tr class="bg-gray-200 text-xs">
                <th class="border p-1">Fecha</th>
                <th class="border p-1">Oficial</th>
                <th class="border p-1">Turno</th>
                <th class="border p-1">Hora de Inicio</th>
                <th class="border p-1">Hora Fin</th>
                <th class="border p-1">Tiempo</th>
                <th class="border p-1">No de Julio</th>
                <th class="border p-1">Peso Bruto</th>
                <th class="border p-1">Tara</th>
                <th class="border p-1">Peso Neto</th>
                <th class="border p-1">Metros</th>
                <th class="border p-1">Temp Canoa 1</th>
                <th class="border p-1">Temp Canoa 2</th>
                <th class="border p-1">Temp Canoa 3</th>
                <th class="border p-1">Humedad</th>
                <th class="border p-1">Roturas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
                <td class="border p-1"></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
