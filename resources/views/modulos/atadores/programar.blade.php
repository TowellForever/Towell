@extends('layouts.app')

@section('content')
<div class="container mx-auto -mt-3"> 
    <form id="seleccionForm" method="GET" action="#">
        <!-- Inputs ocultos para enviar el telar y tipo seleccionados -->
        <input type="hidden" name="telar" id="telarInput">
        <input type="hidden" name="tipo" id="tipoInput">

        <!-- Tabla 1: Requerimiento desde Dynamics AX -->
        <div class="bg-white shadow-md rounded-lg p-2 custom-scroll">
            <h2 class="text-lg font-bold bg-yellow-200 text-center py-2">Programación de Requerimientos</h2>

            <div class="overflow-y-auto max-h-60">
                <!-- Botón Programar -->
                <div class="flex justify-end mt-2 mb-2">
                    <button class="px-3 w-1/6 py-1 text-xs bg-green-500 text-white rounded shadow hover:bg-green-600">Programar</button>
                </div>

                <!-- Tabla de requerimientos -->
                <table class="w-full text-xs border-collapse border border-gray-300 requerimientos">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="border px-1 py-0.5">Telar</th>
                            <th class="border px-1 py-0.5">Tipo</th>
                            <th class="border px-1 py-0.5">Cuenta</th>
                            <th class="border px-1 py-0.5">Fecha Requerida</th>
                            <th class="border px-1 py-0.5">Metros</th>
                            <th class="border px-1 py-0.5">Mc Coy</th>
                            <th class="border px-1 py-0.5">Orden Urdido o Engomado</th>
                            <th class="border px-1 py-0.5">Programar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ejemplo de fila sin datos reales -->
                        <tr class="cursor-pointer hover:bg-yellow-200 transition duration-200"
                            data-tipo="Rizo"
                            data-telar="T-01"
                            onclick="seleccionarFila(this)">
                            <td class="border px-1 py-0.5">T-01</td>
                            <td class="border px-1 py-0.5">Rizo</td>
                            <td class="border px-1 py-0.5">123456</td>
                            <td class="border px-1 py-0.5">11-04-2025</td>
                            <td class="border px-1 py-0.5">-</td>
                            <td class="border px-1 py-0.5">-</td>
                            <td class="border px-1 py-0.5"></td>
                            <td class="border text-center"><input type="checkbox" class="w-5 h-5"></td>
                        </tr>
                        <!-- Puedes duplicar más filas si necesitas más ejemplos -->
                    </tbody>
                </table>
            </div>
        </div>
    </form>

    <!-- Espacio entre tablas -->
    <div class="my-2"></div>
@endsection
