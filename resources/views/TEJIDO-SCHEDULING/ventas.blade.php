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
            <div class="w-full flex -mt-8 mb-8">
                <div class="w-auto ml-auto ">
                    <button id="enviarSeleccionados"
                        class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700 transition shadow">
                        Programar
                    </button>
                </div>
            </div>

            <div class="max-h-[500px] overflow-y-auto rounded shadow border border-gray-200 bg-white -mt-6">
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
                            <tr class="hover:bg-blue-100 transition-colors duration-150" data-idflog="{{ $linea->IDFLOG }}"
                                data-estadoflog="{{ $linea->ESTADOFLOG }}" data-nameproyect="{{ $linea->NAMEPROYECT }}"
                                data-custname="{{ $linea->CUSTNAME }}" data-ancho="{{ $linea->ANCHO }}"
                                data-itemid="{{ $linea->ITEMID }}" data-itemname="{{ $linea->ITEMNAME }}"
                                data-inventsizeid="{{ $linea->INVENTSIZEID }}" data-tipohiloid="{{ $linea->TIPOHILOID }}"
                                data-valoragregado="{{ $linea->VALORAGREGADO }}"
                                data-fechacancelacion="{{ $linea->FECHACANCELACION }}"
                                data-porentregar="{{ $linea->PORENTREGAR }}">
                                <td class="px-1 py-0.5 border">{{ $linea->IDFLOG }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->ESTADOFLOG == 4 ? 'Aprobado por finanzas' : '' }}
                                </td>
                                <td class="px-1 py-0.5 border">{{ $linea->NAMEPROYECT }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->CUSTNAME }}</td>
                                <td class="px-1 py-0.5 border">{{ decimales($linea->ANCHO) }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->ITEMID }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->ITEMNAME }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->INVENTSIZEID }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->TIPOHILOID }}</td>
                                <td class="px-1 py-0.5 border">{{ $linea->VALORAGREGADO }}</td>
                                <td class="px-1 py-0.5 border">{{ formatearFecha($linea->FECHACANCELACION) }}</td>
                                <td class="px-1 py-0.5 border">{{ decimales($linea->PORENTREGAR) }}</td>
                                <td class="px-1 py-0.5 border">
                                    <input type="checkbox" class="form-checkbox text-blue-500 fila-checkbox" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('enviarSeleccionados').addEventListener('click', function() {
            const seleccionados = [];

            document.querySelectorAll('.fila-checkbox:checked').forEach(checkbox => {
                const fila = checkbox.closest('tr');
                const datos = {
                    IDFLOG: fila.dataset.idflog,
                    ITEMID: fila.dataset.itemid,
                    ITEMNAME: fila.dataset.itemname
                    // Agrega los campos que quieras pasar
                };
                seleccionados.push(datos);
            });

            if (seleccionados.length === 0) {
                alert("Selecciona al menos una fila.");
                return;
            }

            // Solo tomamos el primero si vamos a redirigir con GET
            const primero = seleccionados[0];

            const queryParams = new URLSearchParams(primero).toString();
            const url = "{{ route('planeacion.create') }}" + "?" + queryParams;

            window.location.href = url;
        });
    </script>
@endsection
