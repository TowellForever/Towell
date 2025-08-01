@extends('layouts.app')

@section('content')
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    <div class="p-2">
        <div class="-mt-7">
            <div class="relative w-full flex items-center justify-center my-6">
                <div class="absolute top-1/2 left-0 w-full border-t-8 border-gray-300 z-0"></div>
                <span
                    class="relative z-10 px-4 py-1 bg-white text-gray-800 text-xl font-bold border border-gray-400 rounded-md shadow-sm">
                    ALTAS DE COMPRAS ESPECIALES
                </span>
            </div>
            <div class="w-full flex -mt-8 mb-8">
                <!-- Botón de búsqueda (lupa) -->
                <button id="search-toggle"
                    class="w-16 -mt-6 rounded-full text-white bg-transparent hover:bg-white/20 flex items-center justify-center z-[49] relative">
                    <span style="font-size: 40px;">🔎</span>
                </button>
                <a href="" id="reset-search" class="text-xs bg-red-500 ml-1 font-bold rounded-full p-1 h-6">
                    RESTABLECER BÚSQUEDA
                </a>

                <a href="{{ route('modelos.index') }}"
                    class="bg-orange-500 hover:bg-orange-300 ml-2 text-xs font-bold rounded-full p-1 h-6">MODELOS 🛠️</a>

                <div class="w-auto ml-auto ">
                    <button id="enviarSeleccionados"
                        class="font-bold px-5 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700 transition shadow">
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
                                @foreach ($headers as $key => $header)
                                    <option value="{{ $key }}">{{ $header }}</option>
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

                <table class="min-w-full border text-xs text-left ordenable">
                    <thead class="bg-blue-300">
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
                            <tr class="hover:bg-orange-200 transition-colors duration-150"
                                data-idflog="{{ $linea->IDFLOG }}" data-estadoflog="{{ $linea->ESTADOFLOG }}"
                                data-nameproyect="{{ $linea->NAMEPROYECT }}" data-custname="{{ $linea->CUSTNAME }}"
                                data-ancho="{{ $linea->ANCHO }}" data-itemid="{{ $linea->ITEMID }}"
                                data-itemname="{{ $linea->ITEMNAME }}" data-inventsizeid="{{ $linea->INVENTSIZEID }}"
                                data-tipohiloid="{{ $linea->TIPOHILOID }}"
                                data-valoragregado="{{ $linea->VALORAGREGADO }}"
                                data-fechacancelacion="{{ $linea->FECHACANCELACION }}"
                                data-porentregar="{{ $linea->PORENTREGAR }}"
                                data-rasuradocrudo="{{ $linea->RASURADOCRUDO }}">
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
                                <td class="px-1 py-0.5 border font-semibold">
                                    {{ decimales($linea->PORENTREGAR) }}</td>
                                <td class="text-center align-middle border">
                                    <input type="checkbox" class="form-checkbox text-blue-500 fila-checkbox w-5 h-5" />
                                </td>
                            </tr>
                        @endforeach

                        @foreach ($batasAgrupadas as $bata)
                            <tr class="bg-blue-200 hover:bg-blue-300 transition-colors duration-150" style="color: #111"
                                data-idflog="{{ $bata['IDFLOG'] }}" data-estadoflog="{{ $bata['ESTADOFLOG'] }}"
                                data-nameproyect="{{ $bata['NAMEPROYECT'] }}" data-custname="{{ $bata['CUSTNAME'] }}"
                                data-ancho="{{ $bata['ANCHO'] }}" data-itemid="{{ $bata['ITEMID'] }}"
                                data-itemname="{{ $bata['ITEMNAME'] }}" data-inventsizeid="{{ $bata['INVENTSIZEID'] }}"
                                data-tipohiloid="{{ $bata['TIPOHILOID'] }}"
                                data-valoragregado="{{ $bata['VALORAGREGADO'] }}"
                                data-fechacancelacion="{{ $bata['FECHACANCELACION'] }}"
                                data-porentregar="{{ $bata['CANTIDAD_TOTAL'] }}">
                                <td class="px-1 py-0.5 border">{{ $bata['IDFLOG'] }}</td>
                                <td class="px-1 py-0.5 border">
                                    {{ $bata['ESTADOFLOG'] == 4 ? 'Aprobado por finanzas' : '' }}</td>
                                <td class="px-1 py-0.5 border">{{ $bata['NAMEPROYECT'] }}</td>
                                <td class="px-1 py-0.5 border">{{ $bata['CUSTNAME'] }}</td>
                                <td class="px-1 py-0.5 border">{{ decimales($bata['ANCHO']) }}</td>
                                <td class="px-1 py-0.5 border">{{ $bata['ITEMID'] }}</td>
                                <td class="px-1 py-0.5 border">{{ $bata['ITEMNAME'] }}</td>
                                <td class="px-1 py-0.5 border">{{ $bata['INVENTSIZEID'] }}</td>
                                <td class="px-1 py-0.5 border">{{ $bata['TIPOHILOID'] }}</td>
                                <td class="px-1 py-0.5 border">{{ $bata['VALORAGREGADO'] }}</td>
                                <td class="px-1 py-0.5 border">{{ $bata['FECHACANCELACION'] }}</td>
                                <td class="px-1 py-0.5 border font-semibold">
                                    {{ decimales($bata['CANTIDAD_TOTAL']) }}
                                </td>
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
                    CANTIDAD: fila.dataset.porentregar,
                    RASURADOCRUDO: fila.dataset.rasuradocrudo,
                    TIPOHILO: fila.dataset.tipohiloid,
                    APLICACION: fila.dataset.valoragregado,
                    FECHACANCE: fila.dataset.fechacancelacion,
                    // Agrega los campos que quieras pasar, para lograr agregarlo aqui, antes debe colar en TR:   data-rasuradocrudo="{{ $linea->RASURADOCRUDO }}"
                };
                seleccionados.push(datos);
            });

            if (seleccionados.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'ATENCIÓN!',
                    text: 'Marca la casilla de al menos una fila.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido'
                });

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
                <div class="flex gap-4 items-center bg-gray-300 p-1 rounded-lg shadow-md mt-1">
                    <select name="column[]" class="form-control p-1 border border-gray-400 rounded-md text-gray-800 focus:ring-2 focus:ring-blue-400">
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

    <!-- SCRIPT para filtros de ordenación ASC o DESC en cada columna-->
    <script>
        // Configura el tipo de dato para cada columna (ajusta según tu tabla)
        const tipoColumna = [
            'idflog', // 0 IDFLOG (por mes natural)
            'texto', // 1 ESTADO FLOG
            'texto', // 2 PROYECTO
            'texto', // 3 NOMBRE DEL CLIENTE
            'numero', // 4 ANCHO
            'texto', // 5 ARTÍCULO
            'texto', // 6 NOMBRE
            'texto', // 7 TAMAÑO
            'texto', // 8 TIPO DE HILO
            'texto', // 9 VALOR AGREGADO
            'fecha', // 10 CANCELACIÓN
            'numero', // 11 CANTIDAD
            'ninguno' // 12 SELECCIONAR
        ];

        function parseFecha(str) {
            if (!str) return null;
            str = str.replace(/-/g, '/');
            let partes = str.split('/');
            if (partes.length === 3) {
                if (partes[2].length === 4) { // dd/mm/yyyy
                    return new Date(partes[2], partes[1] - 1, partes[0]);
                } else if (partes[0].length === 4) { // yyyy/mm/dd
                    return new Date(partes[0], partes[1] - 1, partes[2]);
                }
            }
            let fecha = new Date(str);
            return isNaN(fecha) ? null : fecha;
        }

        // --- FUNCIONES ESPECIALES PARA IDFLOG ---
        function mesIndexEnID(idflog) {
            const meses = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
            const match = idflog.match(/-([A-Z]{3})\d{2}-/i);
            if (!match) return -1;
            return meses.indexOf(match[1].toUpperCase());
        }

        function anioEnID(idflog) {
            const match = idflog.match(/-[A-Z]{3}(\d{2})-/i);
            if (!match) return -1;
            // Puedes sumar 2000 si quieres año completo: return 2000 + parseInt(match[1], 10);
            return parseInt(match[1], 10);
        }
        // --- FIN FUNCIONES ESPECIALES ---

        function ordenarTabla(th, columnaIndex) {
            const tabla = th.closest('table');
            const tbody = tabla.querySelector('tbody');
            const filas = Array.from(tbody.querySelectorAll('tr'));
            const ascendente = th.dataset.orden !== 'asc';

            // Limpiar iconos y orden
            tabla.querySelectorAll('th').forEach(header => {
                header.dataset.orden = '';
                header.innerHTML = header.innerHTML.replace(' 🔼', '').replace(' 🔽', '');
            });

            th.dataset.orden = ascendente ? 'asc' : 'desc';
            th.innerHTML += ascendente ? ' 🔼' : ' 🔽';

            filas.sort((a, b) => {
                let aTexto = a.children[columnaIndex]?.innerText.trim() || '';
                let bTexto = b.children[columnaIndex]?.innerText.trim() || '';
                const tipo = tipoColumna[columnaIndex] || 'texto';

                if (tipo === 'idflog') {
                    // Ordena primero por año, luego mes, luego texto
                    let anioA = anioEnID(aTexto),
                        anioB = anioEnID(bTexto);
                    if (anioA !== anioB) return ascendente ? anioA - anioB : anioB - anioA;
                    let mesA = mesIndexEnID(aTexto),
                        mesB = mesIndexEnID(bTexto);
                    if (mesA !== mesB) return ascendente ? mesA - mesB : mesB - mesA;
                    return ascendente ?
                        aTexto.localeCompare(bTexto, undefined, {
                            sensitivity: 'base'
                        }) :
                        bTexto.localeCompare(aTexto, undefined, {
                            sensitivity: 'base'
                        });
                }
                if (tipo === 'numero') {
                    let aNum = parseFloat(aTexto.replace(',', '').replace(/[^0-9.\-]/g, '')) || 0;
                    let bNum = parseFloat(bTexto.replace(',', '').replace(/[^0-9.\-]/g, '')) || 0;
                    return ascendente ? aNum - bNum : bNum - aNum;
                }
                if (tipo === 'fecha') {
                    let aFecha = parseFecha(aTexto);
                    let bFecha = parseFecha(bTexto);
                    if (!aFecha && !bFecha) return 0;
                    if (!aFecha) return ascendente ? 1 : -1;
                    if (!bFecha) return ascendente ? -1 : 1;
                    return ascendente ? aFecha - bFecha : bFecha - aFecha;
                }
                if (tipo === 'texto') {
                    return ascendente ?
                        aTexto.localeCompare(bTexto, undefined, {
                            sensitivity: 'base'
                        }) :
                        bTexto.localeCompare(aTexto, undefined, {
                            sensitivity: 'base'
                        });
                }
                return 0;
            });

            tbody.innerHTML = '';
            filas.forEach(fila => tbody.appendChild(fila));
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('table.ordenable thead th').forEach((th, idx) => {
                th.style.cursor = 'pointer';
                if (tipoColumna[idx] !== 'ninguno') {
                    th.addEventListener('click', function() {
                        ordenarTabla(th, idx);
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("reset-search").addEventListener("click", function(e) {
                e.preventDefault(); // <-- esto es CLAVE, evita que siga el href="#"
                window.location.href = "{{ route('tejido.scheduling.ventas') }}";
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los checkboxes de la clase que uso
            const checkboxes = document.querySelectorAll('.fila-checkbox');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Cuando uno se selecciona, desmarca todos los demás
                        checkboxes.forEach(cb => {
                            if (cb !== this) cb.checked = false;
                        });
                    }
                });
            });
        });
    </script>

@endsection
