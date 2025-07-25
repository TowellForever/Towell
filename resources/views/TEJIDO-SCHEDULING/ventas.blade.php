@extends('layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Resumen de Flogs</h1>

        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2">TWFLOGSTABLE</h2>
            <div class="overflow-auto rounded shadow">
                <table class="min-w-full border text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID Flog</th>
                            <th class="px-4 py-2 border">Estado</th>
                            <th class="px-4 py-2 border">Proyecto</th>
                            <th class="px-4 py-2 border">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($flogs as $f)
                            <tr class="hover:bg-yellow-50">
                                <td class="px-4 py-2 border">{{ $f->IDFLOG }}</td>
                                <td class="px-4 py-2 border">{{ $f->ESTADOFLOG }}</td>
                                <td class="px-4 py-2 border">{{ $f->NAMEPROYECT }}</td>
                                <td class="px-4 py-2 border">{{ $f->CUSTNAME }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-2">TWFLOGSITEMLINE</h2>
            <div class="overflow-auto rounded shadow">
                <table class="min-w-full border text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Ancho</th>
                            <th class="px-4 py-2 border">Item ID</th>
                            <th class="px-4 py-2 border">Nombre</th>
                            <th class="px-4 py-2 border">Talla</th>
                            <th class="px-4 py-2 border">Tipo Hilo</th>
                            <th class="px-4 py-2 border">Valor Agregado</th>
                            <th class="px-4 py-2 border">Cancelación</th>
                            <th class="px-4 py-2 border">Por Entregar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lineas as $l)
                            <tr class="hover:bg-blue-50">
                                <td class="px-4 py-2 border">{{ $l->ANCHO }}</td>
                                <td class="px-4 py-2 border">{{ $l->ITEMID }}</td>
                                <td class="px-4 py-2 border">{{ $l->ITEMNAME }}</td>
                                <td class="px-4 py-2 border">{{ $l->INVENTSIZEID }}</td>
                                <td class="px-4 py-2 border">{{ $l->TIPOHILOID }}</td>
                                <td class="px-4 py-2 border">{{ $l->VALORAGREGADO }}</td>
                                <td class="px-4 py-2 border">{{ $l->FECHACANCELACION }}</td>
                                <td class="px-4 py-2 border">{{ $l->PORENTREGAR }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
