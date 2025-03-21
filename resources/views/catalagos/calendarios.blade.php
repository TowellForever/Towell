@extends('layouts.app')

@section('title', 'Calendarios - Planeación')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Calendarios</h1>
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300">
                <!-- Primer Encabezado -->
                <thead>
                    <tr class="bg-blue-500 text-white text-center">
                        <th class="border border-gray-300 px-6 py-3 w-1/4">No. Calendario</th>
                        <th class="border border-gray-300 px-6 py-3 w-1/4" colspan="3">Nombre</th>
                        <th class="border border-gray-300 px-6 py-3 w-1/4">Días por Semana</th>
                        <th class="border border-gray-300 px-6 py-3 w-1/4">Horas por Semana</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr class="bg-gray-100 text-center font-semibold">
                        <td class="border border-gray-300 px-6 py-3">001</td>
                        <td class="border border-gray-300 px-6 py-3" colspan="3">Producción A</td>
                        <td class="border border-gray-300 px-6 py-3">5</td>
                        <td class="border border-gray-300 px-6 py-3">40</td>
                    </tr>
                    <tr class="bg-gray-100 text-center font-semibold">
                        <td class="border border-gray-300 px-6 py-3">002</td>
                        <td class="border border-gray-300 px-6 py-3" colspan="3">Producción B</td>
                        <td class="border border-gray-300 px-6 py-3">10</td>
                        <td class="border border-gray-300 px-6 py-3">30</td>
                    </tr>

                    <tr class="bg-transparent text-center font-semibold">
                        <td class="px-6 py-3 border-0 bg-transparent"></td>
                        <td class="px-6 py-3 border-0 bg-transparent" colspan="3"></td>
                        <td class="px-6 py-3 border-0 bg-transparent"></td>
                        <td class="px-6 py-3 border-0 bg-transparent"></td>
                    </tr>
                                                                    
                    
                    <!-- Segundo Encabezado -->
                    <tr class="bg-gray-700 text-white text-center">
                        <th class="border border-gray-300 px-4 py-2">Fecha</th>
                        <th class="border border-gray-300 px-4 py-2">Nombre Día</th>
                        <th class="border border-gray-300 px-4 py-2">Turno</th>
                        <th class="border border-gray-300 px-4 py-2">Hora de Inicio</th>
                        <th class="border border-gray-300 px-4 py-2">Hora Fin</th>
                        <th class="border border-gray-300 px-4 py-2">Total de Horas</th>
                    </tr>
                    
                    <!-- Filas de Datos (Ejemplo) -->
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">2025-03-21</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Jueves</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Mañana</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">08:00</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">16:00</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">8</td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center">2025-03-22</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Viernes</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">Tarde</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">16:00</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">00:00</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">8</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection