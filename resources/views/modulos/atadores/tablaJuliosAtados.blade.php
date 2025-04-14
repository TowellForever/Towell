@extends('layouts.app')

@section('content')
<!-- Tabla 2: Información adicional de producción -->
<div class="bg-white shadow-md rounded-lg p-2 mt-4 custom-scroll">
    <h2 class="text-MD font-bold bg-blue-200 text-center py-1">JULIOS ATADOS Y CAPTURADOS EN DYNAMICS</h2>

    <div class="overflow-y-auto max-h-60">
        <table class="w-full text-[10px] border-collapse border border-gray-300 produccion">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="border border-black-2">TURNO</th>
                    <th class="border border-black-2">CLAVE ATADOR</th>
                    <th class="border border-black-2">N° JULIO</th>
                    <th class="border border-black-2">R/P</th>
                    <th class="border border-black-2">ORDEN</th>
                    <th class="border border-black-2">METROS</th>
                    <th class="border border-black-2">TELAR</th>
                    <th class="border border-black-2">PROV.</th>
                    <th class="border border-black-2">HORA DE PARO</th>
                    <th class="border border-black-2">HORA ARRANQUE</th>
                    <th class="border border-black-2">GRUA HUBTEX</th>
                    <th class="border border-black-2">ATADORA STAUBLI</th>
                    <th class="border border-black-2">ATADORA USTER</th>
                    <th class="border border-black-2">CALIDAD DE ATADO (1-10)</th>
                    <th class="border border-black-2">5'S ORDEN Y LIMPIEZA (5-10)</th>
                    <th class="border border-black-2">FIRMA TEJEDOR</th>
                    <th class="border border-black-2">OBSERVACIONES</th>
                    <th class="border border-black-2">MERMA KG</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-blue-100 transition duration-200">
                    <td class="border px-1 py-0.5">Mañana</td>
                    <td class="border px-1 py-0.5">A123</td>
                    <td class="border px-1 py-0.5">071245</td>
                    <td class="border px-1 py-0.5">R</td>
                    <td class="border px-1 py-0.5">ORD-999</td>
                    <td class="border px-1 py-0.5">120</td>
                    <td class="border px-1 py-0.5">T-01</td>
                    <td class="border px-1 py-0.5">Interno</td>
                    <td class="border px-1 py-0.5">10:25</td>
                    <td class="border px-1 py-0.5">11:40</td>
                    <td class="border px-1 py-0.5">Sí</td>
                    <td class="border px-1 py-0.5">Sí</td>
                    <td class="border px-1 py-0.5">No</td>
                    <td class="border px-1 py-0.5">9</td>
                    <td class="border px-1 py-0.5">10</td>
                    <td class="border px-1 py-0.5">J. López</td>
                    <td class="border px-1 py-0.5">Sin novedad</td>
                    <td class="border px-1 py-0.5">2.5</td>
                </tr>
                <tr class="hover:bg-blue-100 transition duration-200">
                    <td class="border px-1 py-0.5">Mañana</td>
                    <td class="border px-1 py-0.5">A123</td>
                    <td class="border px-1 py-0.5">071245</td>
                    <td class="border px-1 py-0.5">R</td>
                    <td class="border px-1 py-0.5">ORD-999</td>
                    <td class="border px-1 py-0.5">120</td>
                    <td class="border px-1 py-0.5">T-01</td>
                    <td class="border px-1 py-0.5">Interno</td>
                    <td class="border px-1 py-0.5">10:25</td>
                    <td class="border px-1 py-0.5">11:40</td>
                    <td class="border px-1 py-0.5">Sí</td>
                    <td class="border px-1 py-0.5">Sí</td>
                    <td class="border px-1 py-0.5">No</td>
                    <td class="border px-1 py-0.5">9</td>
                    <td class="border px-1 py-0.5">10</td>
                    <td class="border px-1 py-0.5">J. López</td>
                    <td class="border px-1 py-0.5">Sin novedad</td>
                    <td class="border px-1 py-0.5">2.5</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection