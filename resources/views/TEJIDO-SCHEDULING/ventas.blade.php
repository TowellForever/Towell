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
                <!-- Botón de búsqueda (lupa) -->
                <button id="search-toggle"
                    class="w-16 -mt-6 rounded-full text-white bg-transparent hover:bg-white/20 flex items-center justify-center z-[49] relative">
                    <span style="font-size: 40px;">🔎</span>
                </button>

                <div class="w-auto ml-auto ">
                    <button id="enviarSeleccionados"
                        class="px-5 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700 transition shadow">
                        Programar
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div id="search-modal"
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                    <h2 class="text-xl font-bold mb-4">Búsqueda Avanzada</h2>

                    <form action="{{ route('tejido.scheduling.ventas') }}" method="GET" class="flex flex-col gap-4">
                        <!-- Select para escoger la primera columna -->
                        <div class="flex gap-4 items-center">
                            <select name="column[]"
                                class="form-control p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecciona una columna</option>
                                @foreach ($headers as $header)
                                    <option value="{{ $header }}">{{ $header }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="value[]"
                                class="form-control p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Valor a buscar">
                        </div>

                        <!-- Contenedor para filtros adicionales -->
                        <div id="additional-filters" class="max-h-60 overflow-y-auto p-2 border border-gray-300 rounded-lg">
                        </div>


                        <!-- Botón para agregar más filtros -->
                        <!-- Botón para agregar más filtros -->
                        <button type="button" id="add-filter"
                            class="w-1/3 block mx-auto bg-gray-700 text-white px-3 py-1.5 rounded-md hover:bg-gray-800 transition duration-300 text-sm shadow">
                            Agregar Otro Filtro
                        </button>

                        <!-- Botón de buscar -->
                        <button type="submit"
                            class="block mx-auto w-1/5  bg-blue-600 text-white px-3 py-1.5 rounded-md hover:bg-blue-700 transition duration-300 shadow">
                            Buscar
                        </button>
                    </form>

                    <!-- Botón para cerrar el modal -->
                    <button id="close-modal"
                        class="block mx-auto w-1/5 mt-4 px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600">Cerrar</button>
                </div>
            </div>

            <div class="max-h-[500px] overflow-y-auto rounded shadow border border-gray-200 bg-white -mt-9">
                @if (request()->has('column'))
                    <div class="mb-2 text-sm text-gray-600">
                        <strong>Filtros activos:</strong>
                        <ul class="list-disc ml-5">
                            @foreach (request()->input('column', []) as $i => $col)
                                <li>{{ $col }}: <span
                                        class="text-blue-800">{{ request()->input('value')[$i] ?? '' }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
                                <td class="text-center align-middle border">
                                    <input type="checkbox" class="form-checkbox text-blue-500 fila-checkbox w-5 h-5" />
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
                    ITEMNAME: fila.dataset.itemname,
                    INVENTSIZEID: fila.dataset.inventsizeid,
                    CANTIDAD: fila.dataset.porentregar
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
    <script>
        // Mostrar modal
        document.getElementById('search-toggle').addEventListener('click', function() {
            document.getElementById('search-modal').classList.remove('hidden');
        });

        // Cerrar modal
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('search-modal').classList.add('hidden');
        });

        // Agregar más filtros
        document.getElementById('add-filter').addEventListener('click', function() {
            const newFilter = `
                <div class="flex gap-4 items-center mt-4 bg-gray-100 p-3 rounded-lg shadow-md">
                    <select name="column[]" class="form-control p-2 border border-gray-400 rounded-md text-gray-800 focus:ring-2 focus:ring-blue-400">
                        <option value="">Selecciona una columna</option>
                        @foreach ($headers as $header)
                            <option value="{{ $header }}">{{ $header }}</option>
                        @endforeach
                    </select>

                    <input type="text" name="value[]" class="form-control p-2 border border-gray-400 rounded-md text-gray-800 focus:ring-2 focus:ring-blue-400" placeholder="Ingrese el valor">

                    <button type="button" class="w-1/5 remove-filter bg-gray-700 text-white px-3 py-1.5 rounded-md hover:bg-red-600 transition" onclick="removeFilter(this)">
                        X
                    </button>
                </div>
            `;
            document.getElementById('additional-filters').insertAdjacentHTML('beforeend', newFilter);
        });

        // Eliminar filtro
        function removeFilter(button) {
            button.parentElement.remove();
        }
    </script>
@endsection
