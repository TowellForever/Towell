@extends('layouts.app')

@section('content')
<div class="container mx-auto -mt-3"> 
    <!-- Tabla 1: Requerimiento desde Dynamics AX -->
    <div class="bg-white shadow-md rounded-lg p-2 custom-scroll">
        <h2 class="text-lg font-bold bg-yellow-200 text-center py-2">Programación de Requerimientos</h2>
        <div class="overflow-y-auto max-h-60 "> <!-- Contenedor con scroll -->
            <table class="w-full text-xs border-collapse border border-gray-300">
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
                    @foreach($requerimientos as $req)
                        <tr>
                            <td class="border px-1 py-0.5">{{ $req->telar }}</td>
                            <td class="border px-1 py-0.5">
                                @if($req->rizo == 1)
                                    Rizo
                                @elseif($req->pie == 1)
                                    Pie
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="border px-1 py-0.5">
                                {{ $req->rizo == 1 ? $req->cuenta_rizo : ($req->pie == 1 ? $req->cuenta_pie : '-') }}
                            </td>                        
                            <td class="border px-1 py-0.5">{{ \Carbon\Carbon::parse($req->fecha)->format('d-m-Y') }}</td>
                            <td class="border px-1 py-0.5">-</td> <!-- Metros nulo -->
                            <td class="border px-1 py-0.5">-</td> <!-- Mc Coy nulo -->
                            <td class="border px-1 py-0.5">{{ $req->orden_prod }}</td>
                            <td class="border text-center"><input type="checkbox"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end mt-2">
            <button class="px-3 w-1/6 py-1 text-xs bg-green-500 text-white rounded shadow hover:bg-green-600">Reservar</button>
        </div>
    </div>
    

    <!-- Espacio entre tablas -->
    <div class="my-6"></div>

    <!-- Tabla 2: Inventario Disponible -->
    <div class="bg-white shadow-md rounded-lg p-2">
        <h2 class="text-lg font-bold bg-yellow-200 text-center py-2">Inventario Disponible</h2>
        <table class="w-full text-xs border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border px-1 py-0.5">Orden</th>
                    <th class="border px-1 py-0.5">Tipo</th>
                    <th class="border px-1 py-0.5">Cuenta</th>
                    <th class="border px-1 py-0.5">Hilo</th>
                    <th class="border px-1 py-0.5">No Julios</th>
                    <th class="border px-1 py-0.5">Kilos</th>
                    <th class="border px-1 py-0.5">Metros</th>
                    <th class="border px-1 py-0.5">Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-1 py-0.5">ORD-001</td>
                    <td class="border px-1 py-0.5">Tipo B</td>
                    <td class="border px-1 py-0.5">Cuenta 456</td>
                    <td class="border px-1 py-0.5">Hilo X</td>
                    <td class="border px-1 py-0.5">25</td>
                    <td class="border px-1 py-0.5">100</td>
                    <td class="border px-1 py-0.5">200</td>
                    <td class="border px-1 py-0.5 text-center"><input type="checkbox"></td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-end mt-2">
            <button class="px-3 w-1/6 py-1 text-xs bg-green-500 text-white rounded shadow hover:bg-green-600">Reservar</button>
        </div>
    </div>

</div>

@endsection
