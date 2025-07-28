@extends('layouts.app')

@section('content')
    <div class="p-2">
        <div class="-mt-7">
            <div class="relative w-full flex items-center justify-center my-6">
                <div class="absolute top-1/2 left-0 w-full border-t-8 border-gray-300 z-0"></div>

                <span
                    class="relative z-10 px-4 py-1 bg-white text-gray-800 text-xl font-bold border border-gray-400 rounded-md shadow-sm">
                    PLAN DE VENTAS
                </span>
            </div>

            <div class="max-h-[500px] overflow-y-auto rounded shadow border border-gray-200 bg-white -mt-4">
                <table class="min-w-full border text-xs text-left">
                    <thead class="bg-blue-200">
                        <tr>
                            <th class="px-1 py-0.5 border">ID FLOG</th>
                            <th class="px-1 py-0.5 border">ESTADO FLOG</th>
                            <th class="px-1 py-0.5 border">PROYECTO</th>
                            <th class="px-1 py-0.5 border">NOMBRE DEL CLIENTE</th>
                            <th class="px-1 py-0.5 border">ANCHO</th>
                            <th class="px-1 py-0.5 border">ARTÍCULO</th>
                            <th class="px-1 py-0.5 border">NOMBRE</th>
                            <th class="px-1 py-0.5 border">TAMAÑO</th>
                            <th class="px-1 py-0.5 border">TIPO DE HILO</th>
                            <th class="px-1 py-0.5 border">VALOR AGREGADO</th>
                            <th class="px-1 py-0.5 border">CANCELACIÓN</th>
                            <th class="px-1 py-0.5 border">CANTIDAD</th>
                            <th class="px-1 py-0.5 border">SELECCIONAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lineasConFlog as $linea)
                            <tr class="hover:bg-blue-100 transition-colors duration-150">
                                <td class="px-1 py-0.5 border">{{ $linea->IDFLOG }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->ESTADOFLOG }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->NAMEPROYECT }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->CUSTNAME }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->ANCHO }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->ITEMID }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->ITEMNAME }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->INVENTSIZEID }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->TIPOHILOID }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->VALORAGREGADO }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->FECHACANCELACION }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->PORENTREGAR }}</td>
                                <td class="px-1 py-0.5 border">
                                    <input type="checkbox" class="form-checkbox text-blue-500" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
