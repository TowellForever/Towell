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
                                    <label for="estatus_atado" class="w-28 text-xs text-gray-600 font-medium">ESTATUS
                                        ATADO:</label>
                                    <input type="text" name="estatus_atado" id="estatus_atado"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        value="En proceso" readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="fecha_atado" class="w-28 text-xs text-gray-600 font-medium">FECHA
                                        ATADO:</label>
                                    <input type="text" name="fecha_atado" id="fecha_atado"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50">
                                </div>
                                <div class="flex items-center">
                                    <label for="turno" class="w-28 text-xs text-gray-600 font-medium">TURNO:</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="turno" id="turno"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        value="1" readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="clave_atador" class="w-28 text-xs text-gray-600 font-medium">CLAVE
                                        ATADOR:</label>
                                    <input type="text" name="clave_atador" id="clave_atador"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        value="{{ Auth::user()->numero_empleado . ' ' . Auth::user()->nombre }}" readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="no_julio" class="w-28 text-xs text-gray-600 font-medium">N°
                                        JULIO:</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="no_julio"
                                        id="no_julio"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50">
                                </div>
                                <div class="flex items-center">
                                    <label for="orden" class="w-28 text-xs text-gray-600 font-medium">ORDEN:</label>
                                    <input type="text" name="orden" id="orden"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="tipo" class="w-28 text-xs text-gray-600 font-medium">R/P:</label>
                                    <input type="text" name="tipo" id="tipo"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="metros" class="w-28 text-xs text-gray-600 font-medium">METROS:</label>
                                    <input type="text" name="metros" id="metros"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="telar" class="w-28 text-xs text-gray-600 font-medium">TELAR:</label>
                                    <input type="text" name="telar" id="telar"
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="proveedor" class="w-28 text-xs text-gray-600 font-medium">PROVEEDOR
                                        :</label>
                                    <input type="text" name="proveedor" id="proveedor" value=""
                                        class="w-full border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50"
                                        readonly>
                                </div>
                                <div class="flex items-center">
                                    <label for="merma_kg" class="w-28 text-xs text-gray-600 font-medium">MERMA KG:</label>
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="merma_kg"
                                        id="merma_kg"
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
                                    <label for="hora_paro" class="w-28 text-xs text-gray-600 font-medium">HORA DE
                                        PARO:</label>
                                    <input type="time" name="hora_paro" id="hora_paro"
                                        class="w-30 border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50">
                                </div>
                                <div class="flex items-center">
                                    <label for="hora_arranque" class="w-28 text-xs text-gray-600 font-medium">HORA
                                        ARRANQUE:</label>
                                    <input type="time" name="hora_arranque" id="hora_arranque"
                                        class="w-30 border border-gray-300 px-1 py-1 text-sm rounded-md bg-gray-50">
                                </div>
                                <div class="flex items-center">
                                    <label for="grua_hubtex" class="w-40 text-xs text-gray-600 font-medium">GRUA
                                        HUBTEX:</label>
                                    <input type="radio" name="grua_hubtex" id="grua_hubtex" value="GRUA HUBTEX"
                                        class="w-10 h-10 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="flex items-center">
                                    <label for="atadora_staubli" class="w-40 text-xs text-gray-600 font-medium">ATADORA
                                        STAUBLI:</label>
                                    <input type="radio" name="atadora_staubli" id="atadora_staubli"
                                        value="ATADORA STAUBLI"
                                        class="w-10 h-10 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="flex items-center">
                                    <label for="atadora_uster" class="w-40 text-xs text-gray-600 font-medium">ATADORA
                                        USTER:</label>
                                    <input type="radio" name="atadora_uster" id="atadora_uster" value="ATADORA USTER"
                                        class="w-10 h-10 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                </div>

                                <div class="flex items-center">
                                    <label for="calidad_atado" class="w-28 text-xs text-gray-600 font-medium">CALIDAD
                                        DE ATADO (1-10):</label>
                                    <select name="calidad_atado" id="calidad_atado"
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
                                    <label for="5_s_orden_limpieza" class="w-28 text-xs text-gray-600 font-medium">5'S
                                        ORDEN Y
                                        LIMPIEZA 5-10:</label>
                                    <select name="5_s_orden_limpieza" id="5_s_orden_limpieza"
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
                                    <label for="firma_tejedor" class="w-30 text-xs text-gray-600 font-medium">FIRMA
                                        TEJEDOR:</label>
                                    <select id="firma_tejedor" name="firma_tejedor"
                                        class="text-xs border border-gray-300 rounded px-1 py-1 bg-gray-50">
                                        <option value="">-- Selecciona --</option>
                                        <option value="firma_juan.png">Juan Pérez</option>
                                        <option value="firma_maria.png">Mario Gómez</option>
                                        <option value="firma_pedro.png">Pedro Ramírez</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label for="obs"
                                        class="text-xs text-gray-600 font-medium mb-1">OBSERVACIONES:</label>
                                    <textarea name="obs" id="obs" rows="3"
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
                                class="w-1/4 px-3 py-1 text-sm bg-gray-400 text-white rounded hover:bg-gray-500">CERRAR</button>
                            <button type="button" id="btnFinalizar"
                                class="w-1/4 px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700"
                                disabled>
                                FINALIZAR
                            </button>
                        </div>
                </form>
            </div>
        </div>

        <script>
            const atadoresData = @json($atadores);
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // ===== VARIABLES =====
                const filas = document.querySelectorAll("table.requerimientos tbody tr");
                let filaSeleccionada = null;
                const btnCapturar = document.getElementById("btnCaptura");
                const modal = document.getElementById("capturaModal");
                const cerrarModalBtn = document.getElementById("cerrarModal");

                const campos = [
                    "estatus_atado", "fecha_atado", "turno", "clave_atador", "no_julio", "orden", "tipo", "metros",
                    "telar", "proveedor", "merma_kg", "hora_paro", "hora_arranque", "grua_hubtex",
                    "atadora_staubli",
                    "atadora_uster", "calidad_atado", "5_s_orden_limpieza", "firma_tejedor", "obs"
                ];

                const mapeoInputs = {
                    estatus_atado: "estatus_atado",
                    fecha_atado: "fecha_atado",
                    turno: "turno",
                    clave_atador: "clave_atador",
                    no_julio: "no_julio",
                    orden: "orden",
                    tipo: "tipo",
                    metros: "metros",
                    telar: "telar",
                    proveedor: "proveedor",
                    merma_kg: "merma_kg",
                    hora_paro: "hora_paro",
                    hora_arranque: "hora_arranque",
                    grua_hubtex: "grua_hubtex",
                    atadora_staubli: "atadora_staubli",
                    atadora_uster: "atadora_uster",
                    calidad_atado: "calidad_atado",
                    '5_s_orden_limpieza': "5_s_orden_limpieza",
                    firma_tejedor: "firma_tejedor",
                    obs: "obs",
                };

                // ======= FUNCIONES ===========

                function getInputValue(name) {
                    let id = mapeoInputs[name];
                    let el = document.getElementById(id);
                    if (!el) return "";
                    if (el.type === "radio") {
                        return el.checked ? el.value : "";
                    } else if (el.tagName === "SELECT") {
                        return el.value;
                    } else {
                        return el.value;
                    }
                }

                function setInputValue(name, value) {
                    let id = mapeoInputs[name];
                    let el = document.getElementById(id);
                    if (!el) return;

                    // Si es un campo de hora
                    if (id === 'hora_paro' || id === 'hora_arranque') {
                        // Solo toma HH:mm
                        if (value && value.length >= 5) {
                            // Si viene HH:mm:ss, cortamos a HH:mm
                            value = value.substring(0, 5);
                        }
                        el.value = value ?? '';
                        return;
                    }

                    if (el.type === "radio") {
                        el.checked = value ? true : false;
                    } else if (el.tagName === "SELECT") {
                        el.value = value ?? "";
                    } else {
                        el.value = value ?? "";
                    }
                }


                function recolectarDatos() {
                    let data = {};
                    campos.forEach(name => data[name] = getInputValue(name));
                    return data;
                }

                function validarCompleto() {
                    const obligatorios = [
                        "estatus_atado", "fecha_atado", "turno", "clave_atador", "no_julio", "orden", "tipo",
                        "metros", "telar", "proveedor", "merma_kg", "hora_paro", "hora_arranque",
                        "calidad_atado", "5_s_orden_limpieza", "firma_tejedor"
                    ];
                    let llenos = obligatorios.every(name => {
                        let valor = getInputValue(name);
                        return valor !== null && valor !== undefined && valor !== "";
                    });
                    document.getElementById("btnFinalizar").disabled = !llenos;
                }

                function guardarEnServidor() {
                    let data = recolectarDatos();
                    fetch("{{ route('atadores.save') }}", {
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(r => r.json())
                        .then(resp => {
                            if (resp.success) {
                                // Guardado ok!
                            }
                        });
                }

                // ========= SELECCIÓN DE FILAS Y ABRIR MODAL =========

                filas.forEach(fila => {
                    fila.classList.add("fila-hover");
                    fila.addEventListener("click", function() {
                        filas.forEach(f => f.classList.remove("fila-seleccionada"));
                        this.classList.add("fila-seleccionada");
                        filaSeleccionada = this;
                    });
                });

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
                    const orden = celdas[6]?.innerText?.trim() || '';
                    const metros = celdas[5]?.innerText?.trim() || '';
                    const tipo = celdas[3]?.innerText?.trim() || '';
                    const telar = celdas[2]?.innerText?.trim() || '';
                    const no_julio = celdas[4]?.innerText?.trim() || '';
                    const fechaTexto = celdas[0]?.innerText?.trim() || '';
                    const turno = celdas[1]?.innerText?.trim() || '';

                    // Prellenar campos base desde la fila seleccionada
                    setInputValue("orden", orden);
                    setInputValue("metros", metros);
                    setInputValue("tipo", tipo);
                    setInputValue("telar", telar);
                    setInputValue("no_julio", no_julio);
                    setInputValue("fecha_atado", fechaTexto);
                    setInputValue("turno", turno);

                    // Buscar el proveedor localmente en el listado JS (atadoresData)
                    let proveedor = '';
                    if (typeof atadoresData !== 'undefined' && Array.isArray(atadoresData)) {
                        const resultado = atadoresData.find(item => item.orden_prod == orden);
                        if (resultado) proveedor = resultado.proveedor || '';
                    }
                    setInputValue("proveedor", proveedor);

                    // Ahora, consulta al backend por si ya existe el registro y sobreescribe TODO
                    abrirModalAtador(orden, turno);

                    // Mostrar modal
                    modal.classList.remove("hidden");
                });

                cerrarModalBtn.addEventListener("click", function() {
                    modal.classList.add("hidden");

                    // Limpiar todos los campos del modal
                    campos.forEach(name => {
                        const el = document.getElementById(name);
                        if (!el) return;
                        if (el.tagName === "SELECT") {
                            el.selectedIndex = 0; // primer opción
                        } else if (el.type === "checkbox" || el.type === "radio") {
                            el.checked = false;
                        } else {
                            el.value = "";
                        }
                        // Si es un campo bloqueado, vuelve a deshabilitarlo por seguridad
                        if (["calidad_atado", "5_s_orden_limpieza", "firma_tejedor", "obs"].includes(
                                name)) {
                            el.disabled = true;
                        }
                    });
                });


                // =========== AUTOGUARDADO =============

                Object.entries(mapeoInputs).forEach(([name, id]) => {
                    let el = document.getElementById(id);
                    if (el) {
                        el.addEventListener("change", function() {
                            guardarEnServidor();
                            validarCompleto();
                        });
                        el.addEventListener("input", function() {
                            guardarEnServidor();
                            validarCompleto();
                        });
                    }
                });

                // ========== SHOW: CARGA DESDE BACKEND =========

                window.abrirModalAtador = function(orden, turno) {
                    fetch(`{{ route('atadores.show') }}?orden=${orden}&turno=${turno}`)
                        .then(r => r.json())
                        .then(data => {
                            // data puede ser null, {}, o un objeto lleno
                            // Considera null o objeto vacío como "sin registro"
                            if (data && Object.keys(data).length > 0) {
                                campos.forEach(name => setInputValue(name, data[name] ?? ""));
                            }
                            validarCompleto();
                        });
                };



                // ======= FINALIZAR ========
                document.getElementById("btnFinalizar").addEventListener("click", function() {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Finalizado!',
                        text: 'El registro se guardó correctamente.',
                        confirmButtonColor: '#3085d6'
                    });
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
