@extends('layouts.app')

@section('content')
    <div class="flex justify-center mb-1 w-1/5">
        <!-- Botón de búsqueda (lupa) -->
        <button id="search-toggle" class="p-2 w-20 rounded-full bg-blue-500 text-white hover:bg-blue-600 mr-5">
            <i class="fas fa-search text-3xl"></i>
        </button>
    
        <!-- Botón de restablecer (cruz o refresh) -->
        <div class="w-auto text-left">
            <button id="reset-search" class="p-3 rounded-full bg-red-500 text-white hover:bg-red-600">
                Restablecer búsqueda
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div id="search-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-xl font-bold mb-4">Búsqueda Avanzada</h2>
            
            <form action="{{ route('planeacion.index') }}" method="GET" class="flex flex-col gap-4">
                <!-- Select para escoger la primera columna -->
                <div class="flex gap-4 items-center">
                    <select name="column[]" class="form-control p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecciona una columna</option>
                        @foreach($headers as $header)
                            <option value="{{ $header }}">{{ $header }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="value[]" class="form-control p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Valor a buscar">
                </div>
                
                <!-- Contenedor para filtros adicionales -->
                <div id="additional-filters" class="max-h-60 overflow-y-auto p-2 border border-gray-300 rounded-lg"></div>

                
                <!-- Botón para agregar más filtros -->
                <!-- Botón para agregar más filtros -->
                <button type="button" id="add-filter" class="w-1/3 block mx-auto bg-gray-700 text-white px-3 py-1.5 rounded-md hover:bg-gray-800 transition duration-300 text-sm shadow">
                    Agregar Otro Filtro
                </button>

                <!-- Botón de buscar -->
                <button type="submit" class="block mx-auto w-1/5  bg-blue-600 text-white px-3 py-1.5 rounded-md hover:bg-blue-700 transition duration-300 shadow">
                    Buscar
                </button>
            </form>
            
            <!-- Botón para cerrar el modal -->
            <button id="close-modal" class="block mx-auto w-1/5 mt-4 px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600">Cerrar</button>
        </div>
    </div>

    <div class=" mx-auto text-sm">
        <h1 class="text-3xl font-bold text-center mb-6">PLANEACIÓN</h1>
        <div class="table-container relative">
            <div class="table-container-plane table-wrapper bg-white shadow-lg rounded-lg p-2">
                <table class="celP plane-table border border-gray-300">
                    <thead>
                        <tr class="plane-thead-tr text-white text-sm">
                            @php
                            $headers = [
                                'en_proceso', 'Cuenta', 'Salon', 'Telar', 'Ultimo', 'Cambios_Hilo', 'Maquina', 'Ancho', 'Eficiencia_Std', 'Velocidad_STD', 'Calibre_Rizo', 'Calibre_Pie', 'Calendario',
                                'Clave_Estilo', 'Tamano', 'Estilo_Alternativo', 'Nombre_Producto', 'Saldos', 'Fecha_Captura', 'Orden_Prod', 'Fecha_Liberacion', 'Id_Flog', 'Descrip',
                                'Aplic', 'Obs', 'Tipo_Ped', 'Tiras', 'Peine', 'Largo_Crudo', 'Peso_Crudo', 'Luchaje', 'CALIBRE_TRA', 'Dobladillo', 'PASADAS_TRAMA', 'PASADAS_C1',
                                'PASADAS_C2', 'PASADAS_C3', 'PASADAS_C4', 'PASADAS_C5', 'ancho_por_toalla', 'COLOR_TRAMA', 'CALIBRE_C1', 'Clave_Color_C1', 'COLOR_C1', 'CALIBRE_C2',
                                'Clave_Color_C2', 'COLOR_C2', 'CALIBRE_C3', 'Clave_Color_C3', 'COLOR_C3', 'CALIBRE_C4', 'Clave_Color_C4', 'COLOR_C4', 'CALIBRE_C5', 'Clave_Color_C5',
                                'COLOR_C5', 'Plano', 'Cuenta_Pie', 'Clave_Color_Pie', 'Color_Pie', 'Peso____(gr_/_m²)', 'Dias_Ef', 'Prod_(Kg)/Día', 'Std/Dia', 'Prod_(Kg)/Día1',
                                'Std_(Toa/Hr)_100%', 'Dias_jornada_completa', 'Horas', 'Std/Hrefectivo', 'Inicio_Tejido', 'Calc4', 'Calc5', 'Calc6', 'Fin_Tejido', 'Fecha_Compromiso',
                                'Fecha_Compromiso1', 'Entrega', 'Dif_vs_Compromiso',
                            ];
                        @endphp                        

                            @foreach($headers as $index => $header)
                                <th class="plane-th border border-gray-400 p-4 relative" data-index="{{ $index }}">
                                    {{ $header }}
                                    <div class="absolute top-12 right-0 flex">
                                        <button class="toggle-column bg-red-500 text-white text-xs px-1 py-0.5" data-index="{{ $index }}">⛔</button>
                                        <button class="pin-column bg-blue-500 text-white text-xs px-1 py-0.5 ml-1" data-index="{{ $index }}">📌</button>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $registro)
                            <tr class="px-1 py-0.5">
                                <!-- Agregar checkbox 'en_proceso' -->
                                <td class="px-1 py-0.5">
                                    <form action="{{ route('tejido_scheduling.update', $registro->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="checkbox" name="en_proceso" value="1"
                                            {{ $registro->en_proceso ? 'checked' : '' }}
                                            onclick="this.form.submit()">
                                    </form>
                                </td>
                                @foreach($headers as $header)
                                @if($header !== 'en_proceso') {{-- Evita mostrar la columna "en_proceso" OTRA VEZ --}}
                                    @php
                                        $value = $registro->$header; // Obtener el valor del campo
                            
                                        // Excluir ciertos campos numéricos tratados como cadenas
                                        if (is_numeric($value)) {
                                            // Si el valor es entero, convertirlo sin decimales
                                            if (intval($value) == $value) {
                                                $formattedValue = intval($value);
                                            } else {
                                                // Si tiene decimales, formatearlo a dos decimales
                                                $formattedValue = number_format($value, 2, '.', '');
                                            }
                                        } elseif (strtotime($value) && !in_array($header, ['Calibre_Rizo'])) {
                                            // Si es una fecha, formatearla como "día-mes-año"
                                            $formattedValue = \Carbon\Carbon::parse($value)->format('d-m-Y');
                                        } else {
                                            // Si es texto, dejarlo tal cual
                                            $formattedValue = $value;
                                        }
                                    @endphp
                            
                                    <td class="small px-1 py-0.5">{{ $formattedValue }}</td>
                                @endif
                            @endforeach
                            
                                           
                            </tr>
                        @endforeach
                    </tbody>                                              
                </table>
            </div>
            <!--SEGUNDO CONTENEDOR para botones-->
            <!-- Botones alineados a la derecha -->
            <div class="button-column mb-4">
                <a href="{{ route('telares.index') }}" class="button-plane ml-2">Catálogo Telares</a>
                <a href="{{ route('eficiencia.index') }}" class="button-plane ml-2">Catálogo Eficiencia STD</a>
                <a href="{{ route('velocidad.index') }}" class="button-plane ml-2">Catálogo Velocidad STD</a>
                <a href="{{ route('planeacion.calendarios') }}" class="button-plane ml-2">Calendarios</a>
                <a href="{{ route('planeacion.aplicaciones') }}" class="button-plane ml-2">Aplicaciones</a>
            </div>
        </div>
    </div>
    <!--SCRIPT que sirve para ocultar y fijar columnas de la tabla-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-column").forEach(button => {
                button.addEventListener("click", function() {
                    let index = this.getAttribute("data-index");
                    document.querySelectorAll(`th:nth-child(${+index + 1}), td:nth-child(${+index + 1})`).forEach(el => {
                        el.classList.toggle("hidden");
                    });
                });
            });
            
            document.querySelectorAll(".pin-column").forEach(button => {
            button.addEventListener("click", function () {
                let index = parseInt(this.getAttribute("data-index")) + 1; // Ajuste por nth-child
                let columnCells = document.querySelectorAll(`th:nth-child(${index}), td:nth-child(${index})`);

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
                        el.style.backgroundColor = "#70bbe1"; // Mantener el fondo visible
                    });
                }
            });
        });

        });
    </script>
    <!--Con este script todas las celdas del cuerpo de la tabla, son editables-->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("td").forEach(td => {
            td.addEventListener("click", function () {
                if (this.querySelector("input")) return; // Evitar múltiples inputs

                let originalContent = this.innerText;
                let input = document.createElement("input");
                input.type = "text";
                input.value = originalContent;
                input.classList.add("w-full", "border", "p-1");

                input.addEventListener("blur", function () {
                    td.innerText = this.value || originalContent; // Guardar o restaurar valor
                    // Aquí puedes agregar una función para guardar en la base de datos
                    console.log("Nuevo valor:", this.value);
                });

                input.addEventListener("keydown", function (e) {
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
                        @foreach($headers as $header)
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
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("reset-search").addEventListener("click", function () {
                window.location.href = "{{ route('planeacion.index') }}"; // Redirige a la ruta planificacion.index
            });
        });
    </script>

    @push('styles')
        <style>
            .plane-table td {
                font-size: 10px;  /* Ajustar el tamaño de la fuente */
            }
            .plane-table td {
                padding: 2px 8px !important;  /* Reducir padding */
            }
            .plane-table th, .plane-table td {
                width: 100px;  /* Establecer un ancho fijo más pequeño */
            }
            .plane-table td {
                word-wrap: break-word;  /* Asegura que el contenido largo se divida en varias líneas */
                white-space: normal;  /* Evitar que el texto se mantenga en una sola línea */
            }
        </style>
    @endpush
    
@endsection
