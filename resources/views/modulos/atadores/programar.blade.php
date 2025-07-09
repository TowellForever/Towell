@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-4">
        <form id="seleccionForm" method="GET" action="#">
            <!-- Inputs ocultos para enviar el telar y tipo seleccionados -->
            <input type="hidden" name="telar" id="telarInput">
            <input type="hidden" name="tipo" id="tipoInput">

            <!-- Tabla 1: Requerimiento desde Dynamics AX -->
            <div class="bg-white shadow-md rounded-lg p-2 custom-scroll">
                <h2 class="text-lg font-bold bg-yellow-200 text-center py-1">PROGRAMACIÓN DE ATADORES</h2>

                <div class="overflow-y-auto max-h-60">
                    <!-- Botón Programar -->
                    <div class="flex justify-end mt-2 mb-2">
                        <button id="btnCaptura"
                            class="px-3 w-1/6 py-1 text-xs bg-green-500 text-white rounded shadow hover:bg-green-600">CAPTURAR</button>
                    </div>

                    <!-- Tabla de requerimientos -->
                    <table class="w-full text-xs border-collapse border border-gray-300 requerimientos">
                        <thead>
                            <tr class="bg-gray-200 text-left">
                                <th class="border px-1 py-0.5">FECHA</th><!--aqui va la fecha de requerimiento-->
                                <th class="border px-1 py-0.5">TURNO</th>
                                <th class="border px-1 py-0.5">TELAR</th>
                                <th class="border px-1 py-0.5">TIPO</th>
                                <th class="border px-1 py-0.5">NO. JULIO</th>
                                <th class="border px-1 py-0.5">METROS</th>
                                <th class="border px-1 py-0.5">ORDEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($atadores as $ata)
                                <!-- Ejemplo de fila sin datos reales -->
                                <tr>
                                    <td class="border px-1 py-0.5">{{ \Carbon\Carbon::parse($ata->fecha)->format('d/m/y') }}
                                    </td>
                                    <td class="border px-1 py-0.5">
                                        @php
                                            $mapa = [
                                                'rizo1' => 1,
                                                'pie1' => 1,
                                                'rizo2' => 2,
                                                'pie2' => 2,
                                                'rizo3' => 3,
                                                'pie3' => 3,
                                            ];
                                        @endphp

                                        {{ $mapa[$ata->valor] ?? $ata->valor }}
                                    </td>

                                    <!--Crea un pequeño diccionario ($mapa) con los posibles valores. Muestra el número correspondiente si encuentra coincidencia. Si no lo encuentra (ej. otro valor raro), muestra el valor original por si acaso.-->
                                    <td class="border px-1 py-0.5">{{ $ata->telar }}</td>
                                    <td class="border px-1 py-0.5">{{ $ata->tipo }}</td>
                                    <td class="border px-1 py-0.5">{{ $ata->no_julio }}</td>
                                    <td class="border px-1 py-0.5">{{ number_format($ata->metros, 0) }}</td>
                                    <td class="border px-1 py-0.5">{{ $ata->orden }}</td>
                                </tr>
                                <!-- Puedes duplicar más filas si necesitas más ejemplos -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

        <!-- Modal Estilizado -->
        <div id="capturaModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div
                class="bg-white rounded-lg shadow-lg w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2 xl:w-2/5 max-h-[90vh] overflow-y-auto p-6">

                <h2 class="text-base font-semibold text-gray-700 mb-3 text-center border-b pb-2"> Ingreso Completo de Datos
                    📋
                </h2>

                <form method="POST" action="">
                    @csrf

                    <!-- Contenedor con scroll, altura variable segun sea pantalla mediana o pequeña (laptop o tablet) -->
                    <div class="overflow-y-auto mb-4  md:h-60 h-100">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Columna 1 -->
                            <div class="space-y-2">
                                <p class="text-center font-semibold text-xs border-b-2 border-gray-600 pb-1 mb-4">
                                    PROCESOS DE ATADO: <br>
                                    TIEMPOS (MAX. 01:20 HRS)
                                </p>
                                <div class="flex items-center">
                                    <label for="inputEstatus" class="w-28 text-xs text-gray-600 font-medium">ESTATUS
                                        ATADO:</label>
                                    <input type="text" name="turno" id="inputEstatus"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        value="En proceso" readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="inputFecha" class="w-28 text-xs text-gray-600 font-medium">FECHA
                                        ATADO:</label>
                                    <input type="text" name="turno" id="inputFecha"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50">

                                </div>
                                <div class="flex items-center">
                                    <label for="inputTurno" class="w-28 text-xs text-gray-600 font-medium">TURNO:</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="turno"
                                        id="inputTurno"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        value="1" readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="inputClaveAtador" class="w-28 text-xs text-gray-600 font-medium">CLAVE
                                        ATADOR:</label>
                                    <input type="text" name="clave_atador" id="inputClaveAtador"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        value="{{ Auth::user()->numero_empleado . ' ' . Auth::user()->nombre }}" readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="inputJulio" class="w-28 text-xs text-gray-600 font-medium">N°
                                        JULIO:</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="num_julio"
                                        id="inputJulio"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50">
                                </div>
                                <div class="flex items-center">
                                    <label for="inputOrden" class="w-28 text-xs text-gray-600 font-medium">ORDEN:</label>
                                    <input type="text" name="orden" id="inputOrden"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="inputTipo2" class="w-28 text-xs text-gray-600 font-medium">R/P:</label>
                                    <input type="text" name="tipo2" id="inputTipo"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="inputMetros" class="w-28 text-xs text-gray-600 font-medium">METROS:</label>
                                    <input type="text" name="metros" id="inputMetros"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="inputTelar" class="w-28 text-xs text-gray-600 font-medium">TELAR:</label>
                                    <input type="text" name="telar" id="inputTelar"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="inputProv" class="w-28 text-xs text-gray-600 font-medium">PROV. :</label>
                                    <input type="text" name="prov" id="inputProv" value=""
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="inputObservacionesMermaKg"
                                        class="w-28 text-xs text-gray-600 font-medium">MERMA KG:</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9]*"
                                        name="observaciones_merma_kg" id="inputMermaKg"
                                        class="w-full border border-gray-300 px-1 py-1 text-xs rounded-md bg-gray-50">
                                </div>
                                <p
                                    class="text-xs font-semibold text-red-700 bg-red-100 border-l-4 border-red-500 p-3 rounded-md shadow-sm">
                                    NOTA: OBLIGATORIO, CADA ATADOR DEBE UTILIZAR LA ATADORA USTER (VERDE) AL MENOS EN 3
                                    ATADOS COMPLETOS EN LA SEMANA Y REGISTRARLO.
                                </p>
                            </div>

                            <!-- Columna 2 -->
                            <div class="space-y-2">
                                <p class="text-center font-semibold text-xs border-b-2 border-gray-600 pb-1 mb-4">
                                    CALIDAD DE ATADOS <BR></BR>
                                </p>
                                <div class="flex items-center">
                                    <label for="inputHoraParo" class="w-28 text-xs text-gray-600 font-medium">HORA DE
                                        PARO:</label>
                                    <input type="time" name="hora_paro" id="inputHoraParo"
                                        class="w-30 border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50">
                                </div>
                                <div class="flex items-center">
                                    <label for="inputHoraParo" class="w-28 text-xs text-gray-600 font-medium">HORA
                                        ARRANQUE:</label>
                                    <input type="time" name="hora_paro" id="inputHoraParo"
                                        class="w-30 border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50">
                                </div>
                                <div class="flex items-center">
                                    <label for="inputGruaHubtex" class="w-40 text-xs text-gray-600 font-medium">GRUA
                                        HUBTEX:</label>
                                    <input type="radio" name="atadora" id="inputGruaHubtex" value="GRUA HUBTEX"
                                        class="w-10 h-10 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="flex items-center">
                                    <label for="inputAtadoraStaubli"
                                        class="w-40 text-xs text-gray-600 font-medium">ATADORA STAUBLI:</label>
                                    <input type="radio" name="atadora" id="inputAtadoraStaubli"
                                        value="ATADORA STAUBLI"
                                        class="w-10 h-10 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="flex items-center">
                                    <label for="inputAtadoraUster" class="w-40 text-xs text-gray-600 font-medium">ATADORA
                                        USTER:</label>
                                    <input type="radio" name="atadora" id="inputAtadoraUster" value="ATADORA USTER"
                                        class="w-10 h-10 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="flex items-center">
                                    <label for="inputCalidadAtado" class="w-28 text-xs text-gray-600 font-medium">CALIDAD
                                        DE ATADO (1-10):</label>
                                    <select name="calidad_atado" id="inputCalidadAtado"
                                        class="w-30 border border-gray-300 px-1 py-1 text-xs rounded-md bg-gray-50">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="flex items-center">
                                    <label for="input5sOrden" class="w-28 text-xs text-gray-600 font-medium">5'S ORDEN Y
                                        LIMPIEZA 5-10:</label>
                                    <select name="ordenLimpieza" id="inputOrdenLimpieza"
                                        class="w-30 border border-gray-300 px-1 py-1 text-xs rounded-md bg-gray-50">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <label for="selectFirmaTejedor" class="w-30 text-xs text-gray-600 font-medium">FIRMA
                                        TEJEDOR:</label>
                                    <select id="selectFirmaTejedor" name="firma_tejedor"
                                        class="text-xs border border-gray-300 rounded px-1 py-1 bg-gray-50">
                                        <option value="">-- Selecciona --</option>
                                        <option value="firma_juan.png">Juan Pérez</option>
                                        <option value="firma_maria.png">Mario Gómez</option>
                                        <option value="firma_pedro.png">Pedro Ramírez</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label for="inputObservaciones"
                                        class="text-xs text-gray-600 font-medium mb-1">OBSERVACIONES:</label>
                                    <textarea name="observaciones_merma_kg" id="inputObservaciones" rows="3"
                                        class="border border-gray-300 px-2 py-1 text-xs rounded-md bg-gray-50 resize-y w-64"></textarea>
                                </div>
                                <p
                                    class="text-xs font-semibold text-red-700 bg-red-100 border-l-4 border-red-500 p-3 rounded-md shadow-sm">
                                    NOTA: EN ATADOS DE RIZO DE SALÓN LISOS SE DEBE MONTAR CON GRÚA HUBTEX (REUMA) LAS
                                    CUENTAS 2524 Y 2766 PARA CUIDAR EL RENDIMIENTO DE GRÚA GENKINGER, SE CONSIDERA EN
                                    INDIADOR.
                                </p>

                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="mt-5 flex justify-end space-x-2 border-t pt-3">
                            <button type="button" id="cerrarModal"
                                class="w-1/4 px-3 py-1 text-sm bg-gray-400 text-white rounded hover:bg-gray-500">Cancelar</button>
                            <button type="submit"
                                class="w-1/4 px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">Guardar</button>
                        </div>
                </form>
            </div>
        </div>

        <script>
            const atadoresData = @json($atadores);
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const filas = document.querySelectorAll("table.requerimientos tbody tr");
                let filaSeleccionada = null;

                filas.forEach(fila => {
                    fila.classList.add("fila-hover");

                    fila.addEventListener("click", function() {
                        filas.forEach(f => f.classList.remove("fila-seleccionada"));
                        this.classList.add("fila-seleccionada");
                        filaSeleccionada = this;
                    });
                });

                // Botón CAPTURAR
                const btnCapturar = document.getElementById("btnCaptura");
                const modal = document.getElementById("capturaModal");
                const cerrarModalBtn = document.getElementById("cerrarModal");

                btnCapturar.addEventListener("click", function(e) {
                    e.preventDefault();

                    if (!filaSeleccionada) {
                        Swal.fire({
                            icon: 'info',
                            title: 'ATENCIÓN',
                            text: 'Por favor selecciona un registro primero.',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#3085d6',
                            background: '#f4f6fb',
                            color: '#333',
                            allowOutsideClick: false,
                            customClass: {
                                popup: 'rounded-3xl shadow-lg'
                            }
                        });

                        return;
                    }

                    const celdas = filaSeleccionada.querySelectorAll("td");
                    const orden = celdas[6]?.innerText || '';

                    document.getElementById("inputOrden").value = celdas[6]?.innerText || '';
                    document.getElementById("inputMetros").value = celdas[5]?.innerText || '';
                    document.getElementById("inputTipo").value = celdas[3]?.innerText || '';
                    document.getElementById("inputTelar").value = celdas[2]?.innerText || '';
                    document.getElementById("inputJulio").value = celdas[4]?.innerText || '';
                    const fechaTexto = celdas[0]?.innerText?.trim();
                    document.getElementById("inputFecha").value = fechaTexto ?
                        fechaTexto : '';


                    // Buscar el proveedor en base al orden
                    const resultado = atadoresData.find(item => item.orden_prod === orden);
                    if (resultado) {
                        document.getElementById("inputProv").value = resultado.proveedor;
                    } else {
                        document.getElementById("inputProv").value = '';
                    }

                    modal.classList.remove("hidden");
                });

                cerrarModalBtn.addEventListener("click", function() {
                    modal.classList.add("hidden");
                });
            });
        </script>



        @push('styles')
            <style>
                .fila-hover:hover {
                    background-color: #fefcbf;
                    /* Amarillo claro */
                    cursor: pointer;
                }

                .fila-seleccionada {
                    background-color: #faf089 !important;
                    /* Más fuerte al seleccionar */
                }
            </style>
        @endpush
    @endsection

    <!--
    SELECT *
FROM Produccion.dbo.TWDISPONIBLEURDENG2 AS d
JOIN Produccion.dbo.requerimiento AS r
    ON d.reqid = r.id;-->


    <!--
--creacion  de tabla COPIA
CREATE TABLE TWDISPONIBLEURDENG2 (
    ITEMID            VARCHAR(30),
    CONFIGID          VARCHAR(20),
    INVENTSIZEID      VARCHAR(20),
    INVENTCOLORID     VARCHAR(20),
    INVENTLOCATIONID  VARCHAR(20),
    INVENTBATCHID     VARCHAR(30),
    WMSLOCATIONID     VARCHAR(30),
    INVENTSERIALID    VARCHAR(30),
    QTY               INT,
    METROS            DECIMAL(18, 2),
    TIPO              VARCHAR(20),
    ITEMNAME          VARCHAR(100),
    COLORNAME         VARCHAR(50),
    FECHAINGRESO      DATETIME,
    DATAAREAID        VARCHAR(10),
    RECVERSION        INT,
    RECID             BIGINT
);
-->
