@extends('layouts.app')

@section('content')
    <div
        class="w-auto text-white text-xs mt-2 mb-1 flex overflow-x-auto space-x-2 scrollbar-thin scrollbar-thumb-gray-700 scrollbar-track-gray-300 p-1 mt-1 sm:mt-2 sm:p-0">

        <!-- Botón de búsqueda (lupa) -->
        <button id="search-toggle" class="w-16 rounded-full text-white hover:bg-white sm:mt-8 flex">
            <span style="font-size: 34px;">🔎</span>
        </button>
        <!--SEGUNDO CONTENEDOR para botones-->
        <!-- Botones alineados a la derecha -->
        <a href="" id="reset-search" class=" bg-red-500 ml-1 rounded-full p-1  sm:mt-8 flex">RESTABLECER
            BÚSQUEDA </a> <!-- el funcionamiento de este boton se realiza con JS-->
        <a href="{{ route('telares.index') }}" class=" button-plane ml-1 rounded-full p-1  sm:mt-8 flex">TELARES 📑</a>
        <a href="{{ route('eficiencia.index') }}" class="button-plane rounded-full ml-1 p-1 sm:mt-8 flex">EFICIENCIA STD
            📑</a>
        <a href="{{ route('velocidad.index') }}" class="button-plane rounded-full ml-1 p-1 sm:mt-8 ">VELOCIDAD STD
            📑</a>
        <a href="{{ route('calendariot1.index') }}" class="button-plane rounded-full ml-1 p-1 sm:mt-8">CALENDARIOS 🗓️</a>
        <a href="{{ route('planeacion.aplicaciones') }}" class="button-plane rounded-full ml-2 p-1 sm:mt-8">APLICACIONES
            🧩</a>
        <button id="btnUnico" class="button-plane rounded-full ml-1 p-1 sm:mt-8 w-32">NUEVO REGISTRO 📝</button>
        <a href="{{ route('modelos.index') }}" class="button-plane-2 rounded-full ml-1 p-1 sm:mt-8">MODELOS 🛠️</a>
    </div>

    <!-- Modal -->
    <div id="search-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-xl font-bold mb-4">Búsqueda Avanzada</h2>

            <form action="{{ route('planeacion.index') }}" method="GET" class="flex flex-col gap-4">
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
                <div id="additional-filters" class="max-h-60 overflow-y-auto p-2 border border-gray-300 rounded-lg"></div>


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

    <div class="mx-auto text-sm overflow-y-auto max-h-[80vh]">
        <h1 class="text-3xl font-bold text-center -mt-8">PLANEACIÓN</h1>
        <div class="table-container relative">
            <div class="table-container-plane table-wrapper bg-white shadow-lg rounded-lg p-1">
                <table id="tablaPlaneacion" class="celP plane-table border border-gray-300">
                    <thead>
                        <tr class="plane-thead-tr text-white">
                            @php
                                $headers = [
                                    'en_proceso',
                                    'Cuenta',
                                    'Salon',
                                    'Telar',
                                    'Ultimo',
                                    'Cambios_Hilo',
                                    'Maquina',
                                    'Ancho',
                                    'Eficiencia_Std',
                                    'Velocidad_STD',
                                    'Hilo',
                                    'Calibre_Rizo',
                                    'Calibre_Pie',
                                    'Calendario',
                                    'Clave_Estilo',
                                    'Tamano',
                                    'Estilo_Alternativo',
                                    'Nombre_Producto',
                                    'cantidad',
                                    'Saldos',
                                    'Fecha_Captura',
                                    'Orden_Prod',
                                    'Fecha_Liberacion',
                                    'Id_Flog',
                                    'Descrip',
                                    'Aplic',
                                    'Obs',
                                    'Tipo_Ped',
                                    'Tiras',
                                    'Peine',
                                    'Largo_Crudo',
                                    'Peso_Crudo',
                                    'Luchaje',
                                    'CALIBRE_TRA',
                                    'Dobladillo',
                                    'PASADAS_TRAMA',
                                    'PASADAS_C1',
                                    'PASADAS_C2',
                                    'PASADAS_C3',
                                    'PASADAS_C4',
                                    'PASADAS_C5',
                                    'ancho_por_toalla',
                                    'COLOR_TRAMA',
                                    'CALIBRE_C1',
                                    'Clave_Color_C1',
                                    'COLOR_C1',
                                    'CALIBRE_C2',
                                    'Clave_Color_C2',
                                    'COLOR_C2',
                                    'CALIBRE_C3',
                                    'Clave_Color_C3',
                                    'COLOR_C3',
                                    'CALIBRE_C4',
                                    'Clave_Color_C4',
                                    'COLOR_C4',
                                    'CALIBRE_C5',
                                    'Clave_Color_C5',
                                    'COLOR_C5',
                                    'Plano',
                                    'Cuenta_Pie',
                                    'Clave_Color_Pie',
                                    'Color_Pie',
                                    'Peso_gr_m2',
                                    'Dias_Ef',
                                    'Prod_Kg_Dia',
                                    'Std_Dia',
                                    'Prod_Kg_Dia1',
                                    'Std_Toa_Hr_100',
                                    'Dias_jornada_completa',
                                    'Horas',
                                    'Std_Hr_efectivo',
                                    'Inicio_Tejido',
                                    'Calc4',
                                    'Calc5',
                                    'Calc6',
                                    'Fin_Tejido',
                                    'Fecha_Compromiso',
                                    'Fecha_Compromiso1',
                                    'Entrega',
                                    'Dif_vs_Compromiso',
                                    'num_registro',
                                ];
                            @endphp

                            @foreach ($headers as $index => $header)
                                <th class="plane-th border border-gray-400 pt-2 pr-4 pb-4 pl-4 relative"
                                    data-index="{{ $index }}">
                                    {{ $header }}
                                    <div class="absolute top-6 right-0 flex">
                                        <button class="toggle-column bg-red-500 text-white text-xs px-0.5 py-0.5"
                                            data-index="{{ $index }}">⛔</button>
                                        <button class="pin-column bg-blue-500 text-white text-xs px-0.5 py-0.5 ml-0.5"
                                            data-index="{{ $index }}">📌</button>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($datos as $registro)
                            <tr class="px-1 py-0.5 text-sm" data-num-registro="{{ $registro->num_registro }}"
                                data-inicio="{{ $registro->Inicio_Tejido }}" data-fin="{{ $registro->Fin_Tejido }}">
                                <!-- Agregar checkbox 'en_proceso' -->
                                <td class="px-1 py-0.5">
                                    <form action="{{ route('tejido_scheduling.update', $registro->num_registro) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="checkbox" name="en_proceso" value="1"
                                            {{ $registro->en_proceso ? 'checked' : '' }} onclick="this.form.submit()">
                                    </form>
                                </td>
                                @foreach ($headers as $header)
                                    @if ($header !== 'en_proceso')
                                        {{-- Evita mostrar la columna "en_proceso" OTRA VEZ --}}
                                        @php
                                            $value = $registro->$header; // Obtener el valor del campo

                                            // Lista de campos que deben mostrar fecha + hora
                                            $camposConHora = ['Inicio_Tejido', 'Calc5', 'Fin_Tejido', 'Entrega'];

                                            if (is_numeric($value)) {
                                                // Si el valor es entero, convertirlo sin decimales
                                                if (intval($value) == $value) {
                                                    $formattedValue = intval($value);
                                                } else {
                                                    // Si tiene decimales, formatearlo a dos decimales
                                                    $formattedValue = number_format($value, 2, '.', '');
                                                }
                                            } elseif (strtotime($value) && !in_array($header, ['Calibre_Rizo'])) {
                                                if (in_array($header, $camposConHora)) {
                                                    // Fecha con hora y minutos: "d-m-Y H:i"
                                                    $formattedValue = \Carbon\Carbon::parse($value)->format(
                                                        'd-m-Y H:i',
                                                    );
                                                } else {
                                                    // Solo fecha: "d-m-Y"
                                                    $formattedValue = \Carbon\Carbon::parse($value)->format('d-m-Y');
                                                }
                                            } else {
                                                // Si es texto, dejarlo tal cual
                                                $formattedValue = $value;
                                            }
                                        @endphp
                                        @if (is_numeric($value) && intval($value) != $value)
                                            <td class="small px-1 py-0.5 dec-hidden"
                                                data-valor="{{ number_format($value, 2, '.', '') }}">
                                                {{ intval($value) }}
                                            </td>
                                        @else
                                            <td class="small px-1 py-0.5">{{ $formattedValue }}</td>
                                        @endif
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="contenedorTabla2" class="text-center" style="display: none;">
            <div class="table-wrapper bg-white shadow-lg rounded-lg p-1 overflow-x-auto">
                <table id="tablaDatosPlaneacion" class="w-full border border-gray-300 text-xs table-fixed">
                    <thead>
                        <tr class="bg-gray-800 text-white text-center">
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm w-24">Fecha</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Pzas</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Kilos</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Rizo</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Cambio</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Trama</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Combinacion1</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Combinacion2</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Combinacion3</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Combinacion4</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Pie1</th>
                            <th class="border border-gray-400 px-2 py-1 font-semibold text-sm">Riso</th>

                        </tr>
                    </thead>
                    <tbody id="cuerpoTablaPlaneacion">
                        <!-- Se generará dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--SCRIPT que sirve para ocultar y fijar columnas de la tabla-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-column").forEach(button => {
                button.addEventListener("click", function() {
                    let index = this.getAttribute("data-index");
                    document.querySelectorAll(
                        `th:nth-child(${+index + 1}), td:nth-child(${+index + 1})`).forEach(
                        el => {
                            el.classList.toggle("hidden");
                        });
                });
            });

            document.querySelectorAll(".pin-column").forEach(button => {
                button.addEventListener("click", function() {
                    let index = parseInt(this.getAttribute("data-index")) +
                        1; // Ajuste por nth-child
                    let columnCells = document.querySelectorAll(
                        `th:nth-child(${index}), td:nth-child(${index})`);

                    // Verificar si la columna ya está fijada
                    let isPinned = columnCells[0].classList.contains("sticky");

                    if (isPinned) {
                        // Si está fijada, quitar clases y restaurar
                        columnCells.forEach(el => {
                            el.classList.remove("sticky", "z-10", "shadow-md");
                            el.style.left = "";
                            el.style.backgroundColor = ""; // Restaurar fondo
                        });
                    } else {
                        // Obtener el ancho acumulado de las columnas fijas previas
                        let pinnedColumns = document.querySelectorAll("th.sticky");
                        let leftOffset = 0;
                        pinnedColumns.forEach(col => {
                            leftOffset += col.offsetWidth;
                        });

                        // Fijar la columna con estilos adecuados
                        columnCells.forEach(el => {
                            el.classList.add("sticky", "z-10", "shadow-md");
                            el.style.left = `${leftOffset}px`;
                            el.style.backgroundColor =
                                "#70bbe1"; // Mantener el fondo visible
                        });
                    }
                });
            });

        });
    </script>
    <!--Con este script todas las celdas del cuerpo de la tabla, son editables-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("td").forEach(td => {
                td.addEventListener("click", function() {
                    if (this.querySelector("input")) return; // Evitar múltiples inputs

                    let originalContent = this.innerText;
                    let input = document.createElement("input");
                    input.type = "text";
                    input.value = originalContent;
                    input.classList.add("w-full", "border", "p-1");

                    input.addEventListener("blur", function() {
                        td.innerText = this.value ||
                            originalContent; // Guardar o restaurar valor
                        // Aquí puedes agregar una función para guardar en la base de datos
                        console.log("Nuevo valor:", this.value);
                    });

                    input.addEventListener("keydown", function(e) {
                        if (e.key === "Enter") this.blur();
                        if (e.key === "Escape") {
                            td.innerText = originalContent;
                        }
                    });

                    td.innerText = "";
                    td.appendChild(input);
                    input.focus();
                });
            });
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("reset-search").addEventListener("click", function() {
                window.location.href =
                    "{{ route('planeacion.index') }}"; // Redirige a la ruta planificacion.index
            });
        });
    </script>
    <!--*******************************************************************************************************************************************************************************************
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    *********************************************************************************************************************************************************************************************-->
    <!--SCRIPTS que implentan el funcionamiento de la tabla TIPO DE MOVIMIENTOS, se selecciona un registro, se obtiene el valor de num_registro y con
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ese valor se filtran los datos de la tabla tipo_movimientos para mostrarlos en la tabla de abajo-->

    <script>
        let filaSeleccionada = null;
        let numRegistroSeleccionado = null;

        document.addEventListener("DOMContentLoaded", function() {
            const filas = document.querySelectorAll("#tablaPlaneacion tbody tr");

            filas.forEach(fila => {
                fila.addEventListener("click", function() {
                    // Quitar selección anterior
                    if (filaSeleccionada) {
                        filaSeleccionada.classList.remove("fila-seleccionada");
                    }
                    this.classList.add("fila-seleccionada");
                    filaSeleccionada = this;

                    // Obtener datos del registro
                    numRegistroSeleccionado = this.getAttribute('data-num-registro');
                    const fechaInicioTejido = this.getAttribute('data-inicio'); // "2025-05-13"
                    const fechaFinTejido = this.getAttribute('data-fin'); // "2025-05-25"

                    // Mostrar segunda tabla
                    document.getElementById("contenedorTabla2").style.display = "block";

                    // Generar fechas en la tabla dinámica
                    const inicio = new Date(fechaInicioTejido);
                    const fin = new Date(fechaFinTejido);
                    console.log("inicio:", inicio.toISOString(), "fin:", fin.toISOString());


                    const tbody = document.getElementById("cuerpoTablaPlaneacion");
                    tbody.innerHTML = "";

                    for (let d = new Date(inicio.toDateString()), i = 0; d <= new Date(fin
                            .toDateString()); d.setDate(d.getDate() + 1), i++) {

                        function formatFechaLocal(date) {
                            const year = date.getFullYear();
                            const month = String(date.getMonth() + 1).padStart(2,
                                '0'); // meses comienzan en 0
                            const day = String(date.getDate()).padStart(2, '0');
                            return `${year}-${month}-${day}`;
                        }

                        const fechaFormateada = formatFechaLocal(
                            d); // en vez de d.toISOString().split('T')[0]
                        const opciones = {
                            day: 'numeric',
                            month: 'long'
                        };
                        const fechaFormateadaDiaMes = d.toLocaleDateString('es-MX', opciones);

                        const fila = document.createElement("tr");
                        fila.classList.add(i % 2 === 0 ? 'bg-white' : 'bg-gray-100',
                            'text-gray-800');

                        fila.innerHTML = `
                        <td class="border px-2 py-1 text-center" data-campo="fecha">${fechaFormateadaDiaMes}</td>
                        <td class="border px-2 py-1 text-center" data-campo="pzas" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="kilos" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="rizo" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="cambio" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="trama" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="combinacion1" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="combinacion2" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="combinacion3" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="combinacion4" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="piel1" data-fecha="${fechaFormateada}"></td>
                        <td class="border px-2 py-1 text-center" data-campo="riso" data-fecha="${fechaFormateada}"></td>
                    `;

                        tbody.appendChild(fila);
                    }

                    // Cargar datos del servidor
                    fetch(`/planeacion/tipo-movimientos/${numRegistroSeleccionado}`)
                        .then(res => res.json())
                        .then(data => {
                            // Limpiar celdas anteriores
                            document.querySelectorAll('[data-campo][data-fecha]').forEach(
                                cell => {
                                    cell.textContent = "";
                                });
                            data.forEach(item => {
                                //console.log(item);


                                const fecha = item.fecha; // "YYYY-MM-DD"
                                const campos = [
                                    "pzas", "kilos", "rizo", "cambio", "trama",
                                    "combinacion1", "combinacion2",
                                    "combinacion3",
                                    "combinacion4",
                                    "piel1", "riso"
                                ];

                                campos.forEach(campo => {
                                    const celda = document.querySelector(
                                        `[data-campo="${campo}"][data-fecha="${fecha}"]`
                                    );
                                    if (!celda) {
                                        console.warn(
                                            `No se encontró la celda para campo: ${campo}, fecha: ${fecha}`
                                        );
                                    }

                                    if (celda) {
                                        const valor = item[campo];
                                        celda.textContent = typeof valor ===
                                            "number" ? Math.floor(valor)
                                            .toString() : (valor || '0');
                                    }
                                });
                            });
                        })
                        .catch(err => {
                            console.error("Error al obtener detalles:", err);
                        });
                });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabla = document.getElementById('tablaPlaneacion');

            if (tabla) {
                tabla.addEventListener('click', function(e) {
                    const fila = e.target.closest('tr');
                    if (!fila) return;

                    fila.querySelectorAll('.dec-hidden').forEach(td => {
                        const fullValue = td.getAttribute('data-valor');
                        if (fullValue) {
                            td.textContent = fullValue;
                            td.classList.remove('dec-hidden');
                        }
                    });
                    // Aquí puedes agregar tu lógica para resaltar en amarillo, si no ya existe.
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabla = document.getElementById("tablaPlaneacion");
            const botonUnico = document.getElementById("btnUnico");
            let datosFilaSeleccionada = null;

            const nombresColumnas = [
                'en_proceso',
                'Cuenta',
                'Salon',
                'Telar',
                'Ultimo',
                'Cambios_Hilo',
                'Maquina',
                'Ancho',
                'Eficiencia_Std',
                'Velocidad_STD',
                'Hilo',
                'Calibre_Rizo',
                'Calibre_Pie',
                'Calendario',
                'Clave_Estilo',
                'Tamano',
                'Estilo_Alternativo',
                'Nombre_Producto',
                'cantidad',
                'Saldos',
                'Fecha_Captura',
                'Orden_Prod',
                'Fecha_Liberacion',
                'Id_Flog',
                'Descrip',
                'Aplic',
                'Obs',
                'Tipo_Ped',
                'Tiras',
                'Peine',
                'Largo_Crudo',
                'Peso_Crudo',
                'Luchaje',
                'CALIBRE_TRA',
                'Dobladillo',
                'PASADAS_TRAMA',
                'PASADAS_C1',
                'PASADAS_C2',
                'PASADAS_C3',
                'PASADAS_C4',
                'PASADAS_C5',
                'ancho_por_toalla',
                'COLOR_TRAMA',
                'CALIBRE_C1',
                'Clave_Color_C1',
                'COLOR_C1',
                'CALIBRE_C2',
                'Clave_Color_C2',
                'COLOR_C2',
                'CALIBRE_C3',
                'Clave_Color_C3',
                'COLOR_C3',
                'CALIBRE_C4',
                'Clave_Color_C4',
                'COLOR_C4',
                'CALIBRE_C5',
                'Clave_Color_C5',
                'COLOR_C5',
                'Plano',
                'Cuenta_Pie',
                'Clave_Color_Pie',
                'Color_Pie',
                'Peso_gr_m2',
                'Dias_Ef',
                'Prod_Kg_Dia',
                'Std_Dia',
                'Prod_Kg_Dia1',
                'Std_Toa_Hr_100',
                'Dias_jornada_completa',
                'Horas',
                'Std_Hr_efectivo',
                'Inicio_Tejido',
                'Calc4',
                'Calc5',
                'Calc6',
                'Fin_Tejido',
                'Fecha_Compromiso',
                'Fecha_Compromiso1',
                'Entrega',
                'Dif_vs_Compromiso',
                'num_registro',
            ]; // AJUSTA esto

            if (tabla) {
                tabla.querySelectorAll("tbody tr").forEach(fila => {
                    fila.addEventListener("click", function() {
                        const celdas = this.querySelectorAll("td");
                        let datosFila = {};

                        celdas.forEach((celda, index) => {
                            const clave = nombresColumnas[index];
                            datosFila[clave] = celda.textContent.trim();
                        });

                        datosFilaSeleccionada = datosFila;
                        console.log("Fila seleccionada:", datosFilaSeleccionada);
                    });
                });
            }

            botonUnico.addEventListener("click", function() {
                if (datosFilaSeleccionada) {
                    const query = new URLSearchParams(datosFilaSeleccionada).toString();
                    window.location.href = `traspasoDataRedireccion?${query}`;
                } else {
                    window.location.href = "{{ route('planeacion.create') }}";
                }
            });
        });
    </script>

    @push('styles')
        <style>
            .plane-table td {
                font-size: 10px;
                /* Ajustar el tamaño de la fuente */
            }

            .plane-table td {
                padding: 1px 2px !important;
                /* Reducir padding */
            }

            .plane-table th,
            .plane-table td {
                width: 100px;
                /* Establecer un ancho fijo más pequeño */
            }

            .plane-table td {
                word-wrap: break-word;
                /* Asegura que el contenido largo se divida en varias líneas */
                white-space: normal;
                /* Evitar que el texto se mantenga en una sola línea */
            }

            /* Contenedor para los botones en columna */
            .button-column {
                display: flex;
                flex-direction: column;
                /* Espacio entre los botones */
                width: 100px;
                /* Define el ancho de la columna de botones */
                margin-right: 4px;
                font-size: 8px !important;
            }

            /* Estilos para los botones */
            .button-plane {
                background-color: #0876d1;
                /* Fondo azul */
                color: white;
                /* Color del texto */
                padding: 8px 2px;
                /* Espaciado interno */
                text-decoration: none;
                /* Elimina el subrayado */

                transition: background-color 0.3s ease;
                /* Efecto de transición */
                text-align: center;
                /* Centra el texto en cada botón */
            }

            .button-plane-2 {
                background-color: #7839ed;
                /* Fondo azul */
                color: white;
                /* Color del texto */
                padding: 8px 2px;
                /* Espaciado interno */
                border-radius: 6px;
                /* Bordes redondeados */
                text-decoration: none;
                /* Elimina el subrayado */

                transition: background-color 0.3s ease;
                /* Efecto de transición */
                text-align: center;
                /* Centra el texto en cada botón */
            }

            .button-plane:hover {
                background-color: #2779bd;
                /* Cambio de color en hover */
            }

            #tablaPlaneacion tbody tr:hover {
                background-color: #fef08a;
                /* Amarillo suave */
                cursor: pointer;
            }

            .fila-seleccionada {
                background-color: #fde047 !important;
                /* Amarillo más intenso al hacer clic */
            }
        </style>
    @endpush
@endsection
