@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-2 overflow-y-auto md:h-[600px]">
        <h1 class="text-3xl font-bold text-center mb-2">PRODUCCIÓN DE URDIDO</h1>
        <div id="finalizadoOverlay">FINALIZADO CORRECTAMENTE</div>

        <!-- Formulario -->
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
            <!-- Primera columna -->
            <div class="text-sm">
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">FOLIO:</label>
                    <input id="folio" type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ explode('-', $requerimiento->orden_prod)[0] ?? '' }}" readonly>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">CUENTA:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $urdido->cuenta ?? '' }}" readonly>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">URDIDO:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $urdido->urdido ?? '' }}" readonly>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">PROVEEDOR:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $urdido->proveedor ?? '' }}" readonly>
                </div>

            </div>

            <!-- Segunda columna -->
            <div class="text-sm">
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">TIPO:</label>
                    <div class="flex items-center">
                        <label class="text-sm text-black font-semibold">
                            <input type="radio" name="tipo" value="Rizo"
                                {{ $urdido->tipo === 'Rizo' ? 'checked' : '' }} disabled> Rizo
                        </label>
                        <label class="text-sm text-black font-semibold ml-4">
                            <input type="radio" name="tipo" value="Pie"
                                {{ $urdido->tipo === 'Pie' ? 'checked' : '' }} disabled> Pie
                        </label>
                    </div>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm ">METROS:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ rtrim(rtrim($urdido->metros, '0'), '.') }}" readonly>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm ">DESTINO:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $urdido->destino . ' ' . $requerimiento->telar ?? '' }}" readonly>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">ORDENADO POR:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" value="pending">
                </div>
            </div>

            <!-- Tercera columna -->
            <div>
                <!-- Tabla de Construcción -->
                <h2 class="text font-semibold">CONSTRUCCIÓN: </h2>
                <table class="w-full border-collapse border border-gray-300  font-bold">
                    <thead>
                        <tr class="bg-gray-200 text-xs">
                            <th class="border p-1 w-1/5 text-center font-bold">No. JULIO</th>
                            <th class="border p-1 w-1/5 text-center font-bold">HILOS</th>
                            <th class="border p-1 text-center font-bold">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mostrar datos de 'construccion' -->
                        @foreach ($construccion as $registroConstruccion)
                            <tr class="text-xs">
                                <td class="border p-0.5 text-center">{{ $registroConstruccion->no_julios ?? '' }}</td>
                                <td class="border p-0.5 text-center">{{ $registroConstruccion->hilos ?? '' }}</td>
                                <td class="border p-0.5 text-center">{{ $registroConstruccion->observaciones ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Tabla de Datos -->
        <h2 class="text-sm font-bold mt-2">Registro de Producción</h2>
        <table class="w-full border-collapse border border-gray-300 mt-2 text-center">
            <thead>
                <tr class="bg-gray-200 text-xs">
                    <th class="border p-0.5" colspan="11"></th>
                    <th class="p-0.5 text-center border-2 border-black" colspan="4">ROTURAS</th>
                </tr>
                <tr class="bg-gray-200 text-xs">
                    <th class="border p-1">FECHA</th>
                    <th class="border p-1">OFICIAL</th>
                    <th class="border p-1">TURNO</th>
                    <th class="border p-1">H. INIC.</th>
                    <th class="border p-1">H. FIN</th>
                    <th class="border p-1">No. JULIO</th>
                    <th class="border p-1">HILOS</th>
                    <th class="border p-1">Kg. BRUTO</th>
                    <th class="border p-1">TARA</th>
                    <th class="border p-1 W-30">Kg. NETO</th>
                    <th class="border p-1">METROS</th>
                    <th class="border p-1">HILAT.</th>
                    <th class="border p-1">MÁQ.</th>
                    <th class="border p-1">OPERAC.</th>
                    <th class="border p-1">TRANSF.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $registroIndex = 0;
                @endphp
                @foreach ($construccion as $registroConstruccion)
                    @for ($i = 0; $i < $registroConstruccion->no_julios; $i++)
                        @php
                            $orden = $ordenUrdido[$registroIndex] ?? null;
                            $oficial = $oficiales[$registroIndex] ?? null;
                            $registroIndex++;
                        @endphp
                        <tr class="text-xs">
                            <input type="hidden" name="datos[{{ $registroIndex }}][id2]" value="{{ $registroIndex }}">
                            <input type="hidden" name="datos[{{ $registroIndex }}][folio]"
                                value="{{ $registroConstruccion->folio ?? '' }}">
                            <td class="border p-1">
                                <input class="w-24 p-1" type="date" name="datos[{{ $registroIndex }}][fecha]"
                                    value="{{ $orden && $orden->fecha ? \Carbon\Carbon::parse($orden->fecha)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </td>
                            <!--OFICIAL, select dinámico-->
                            <td class="border p-1 w-30">
                                <select class="w-24 border rounded p-1 text-xs"
                                    name="datos[{{ $registroIndex }}][oficial]" id="oficial_{{ $registroIndex }}"
                                    onchange="updateOficialTipo({{ $registroIndex }})">
                                    <option value="{{ Auth::user()->nombre }}">{{ Auth::user()->nombre }}</option>
                                    @foreach ($oficiales as $of)
                                        <option value="{{ $of->oficial }}" data-tipo="{{ $of->tipo }}"
                                            @if (!empty($orden) && $of->oficial == $orden->oficial) selected @endif>
                                            {{ $of->oficial }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                    name="datos[{{ $registroIndex }}][turno]" class="w-10 border rounded p-1 text-xs"
                                    value="{{ $orden->turno ?? '' }}"></td>
                            <td class="border p-1">
                                <input type="time" name="datos[{{ $registroIndex }}][hora_inicio]"
                                    class="w-24 border rounded p-1 text-xs"
                                    value="{{ isset($orden->hora_inicio) ? \Illuminate\Support\Str::limit($orden->hora_inicio, 5, '') : '' }}"
                                    step="60">
                            </td>
                            <td class="border p-1">
                                <input type="time" name="datos[{{ $registroIndex }}][hora_fin]"
                                    class="w-24 border rounded p-1 text-xs"
                                    value="{{ isset($orden->hora_fin) ? \Illuminate\Support\Str::limit($orden->hora_fin, 5, '') : '' }}"
                                    step="60">
                            </td>

                            <td class="border p-1 w-30">
                                <select class="w-24 border rounded p-1 text-xs"
                                    name="datos[{{ $registroIndex }}][no_julio]" id="no_julio_{{ $registroIndex }}"
                                    onchange="updateValues({{ $registroIndex }})">
                                    <option value="">Seleccionar</option>
                                    @foreach ($julios as $julio)
                                        <option value="{{ $julio->no_julio }}" data-tara="{{ $julio->tara }}"
                                            data-tipo="{{ $julio->tipo }}"
                                            @if (!is_null($orden) && $julio->no_julio == $orden->no_julio) selected @endif>
                                            {{ $julio->no_julio }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td class="border p-1">{{ $registroConstruccion->hilos ?? '' }}
                                <input type="hidden" name="datos[{{ $registroIndex }}][hilos]"
                                    value="{{ $registroConstruccion->hilos ?? '' }}">
                            </td>

                            <td class="border p-1">
                                <input class="w-10 border rounded p-1 text-xs" type="text" inputmode="numeric"
                                    pattern="[0-9]*" name="datos[{{ $registroIndex }}][peso_bruto]"
                                    value="{{ $orden->peso_bruto ?? '' }}" id="peso_bruto_{{ $registroIndex }}"
                                    onchange="updatePesoNeto({{ $registroIndex }})">
                            </td>

                            <td class="border p-1">
                                <input class="w-14 p-1 text-xs" type="text" name="datos[{{ $registroIndex }}][tara]"
                                    id="tara_{{ $registroIndex }}" value="{{ $orden->tara ?? '' }}" readonly>
                            </td>
                            <td class="border p-1">
                                <input class="w-14 p-1 text-xs" type="text"
                                    name="datos[{{ $registroIndex }}][peso_neto]" id="peso_neto_{{ $registroIndex }}"
                                    value="{{ $orden->peso_neto ?? '' }}" readonly>
                            </td>

                            <td class="border p-1">{{ rtrim(rtrim($urdido->metros ?? '', '0'), '.') }}
                                <input type="hidden" name="datos[{{ $registroIndex }}][metros]"
                                    value="{{ rtrim(rtrim($urdido->metros ?? '', '0'), '.') }}">
                            </td>
                            <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                    name="datos[{{ $registroIndex }}][hilatura]" class="w-10 border rounded p-1 text-xs"
                                    value="{{ $orden->hilatura ?? '' }}"></td>
                            <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                    name="datos[{{ $registroIndex }}][maquina]" class="w-10 border rounded p-1 text-xs"
                                    value="{{ $orden->maquina ?? '' }}"></td>
                            <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                    name="datos[{{ $registroIndex }}][operacion]" class="w-10 border rounded p-1 text-xs"
                                    value="{{ $orden->operacion ?? '' }}"></td>
                            <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                    name="datos[{{ $registroIndex }}][transferencia]"
                                    class="w-10 border rounded p-1 text-xs" value="{{ $orden->transferencia ?? '' }}">
                            </td>
                        </tr>
                    @endfor
                @endforeach
            </tbody>
        </table>
        <div class="mt-4 text-right">
            @if ($urdido->estatus_urdido == 'en_proceso')
                <button id="guardarYFinalizar"
                    class="ml-10 btn bg-blue-600 text-white w-40 h-12 hover:bg-blue-400">Guardar
                    y Finalizar</button>
            @endif
            @if ($urdido->estatus_urdido == 'finalizado')
                <button onclick="reimprimir()" class="w-1/5 px-4 py-2 bg-green-600 text-white rounded">
                    🔁 Reimprimir
                </button>
            @endif
        </div>
    </div>

    <!-- Modal de error -->
    <div id="modalErrores" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-96 p-6">
            <h2 class="text-lg font-semibold mb-4 text-red-600">Campos faltantes</h2>
            <div id="contenidoErrores" class="text-sm text-gray-700 whitespace-pre-line"></div>
            <div class="mt-6 text-right">
                <button onclick="cerrarModalErrores()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Aceptar
                </button>
            </div>
        </div>
    </div>


    <script>
        function updateOficialTipo(index) {
            const select = document.getElementById('oficial_' + index);
            const tipo = select.options[select.selectedIndex].getAttribute('data-tipo');

            // Si quieres llenar otro input con ese tipo, podrías hacer algo como:
            const tipoInput = document.getElementById('tipo_oficial_' + index);
            if (tipoInput) {
                tipoInput.value = tipo;
            }
        }
    </script>

    <script>
        document.getElementById("guardarYFinalizar").addEventListener("click", function() {
            const inputs = document.querySelectorAll(
                'input[name^="datos"], select[name^="datos"]'
            ); //Recoger todos los datos de entradas (input y select) con nombres que empiecen con datos
            let formData = {};
            let erroresPorFila = {}; //almacenará campos faltantes para mostrar un resumen amigable si hay errores.
            let folio = document.getElementById("folio").value;

            if (!folio) {
                alert("No se encontró el folio.");
                return;
            }

            Swal.fire({
                title: 'CONFIRME ESTA ACCIÓN',
                text: '¿Desea guardar y finalizar este urdido?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then(result => {
                if (!result.isConfirmed) return;

                // Aquí continúa tu lógica solo si confirmó



                // Agrupar datos por fila
                inputs.forEach(input => {
                    const match = input.name.match(/datos\[(\d+)\]\[(\w+)\]/);
                    if (match) {
                        const index = match[1];
                        const key = match[2];

                        if (!formData[index]) {
                            formData[index] = {};
                        }

                        let value = input.tagName.toLowerCase() === "select" ?
                            input.options[input.selectedIndex].value :
                            input.value.trim();

                        formData[index][key] = value;

                        // Validar campos obligatorios
                        const camposOpcionales = ['tara', 'peso_neto', 'hilatura', 'maquina',
                            'operacion',
                            'transferencia',
                        ];
                        if (!value && !camposOpcionales.includes(key)) {
                            if (!erroresPorFila[index]) {
                                erroresPorFila[index] = [];
                            }
                            erroresPorFila[index].push(key);
                        }
                    }
                });

                // Mostrar errores si los hay
                if (Object.keys(erroresPorFila).length > 0) {
                    let mensaje = "Por favor completa los campos faltantes en las siguientes filas:\n\n";
                    for (const index in erroresPorFila) {
                        mensaje += `● Fila ${parseInt(index)}: ${erroresPorFila[index].join(', ')}\n`;
                    }

                    alert(mensaje);
                    return;
                }

                // Enviar petición al backend
                fetch("{{ route('urdido.guardarFinalizar') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute(
                                    "content")
                        },
                        body: JSON.stringify({
                            folio: folio,
                            registros: Object.values(formData)
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Mostrar mensaje de finalizado
                        const overlay = document.getElementById('finalizadoOverlay');
                        overlay.classList.add('active');

                        setTimeout(() => {
                            overlay.classList.remove('active');
                        }, 3000);

                        // Desactivar botón
                        const btn = document.getElementById("guardarYFinalizar");
                        btn.disabled = true;
                        btn.innerText = "Finalizado";

                        // 👉 ABRIR la nueva pestaña con la impresión después de 3 segundos
                        setTimeout(() => {
                            const url = "{{ url('/imprimir-orden-llena-urd') }}/" + folio;
                            const papeletas = "{{ url('/imprimir-papeletas-pequenias') }}/" +
                                folio;
                            window.open(url, '_blank');
                            window.open(papeletas, '_blank');

                        }, 3000); // 3000 ms = 3 segundos


                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Ocurrió un error al guardar y finalizar.");
                    });
            });
        });
    </script>


    <script>
        function mostrarModalErrores(mensaje) {
            document.getElementById("contenidoErrores").innerHTML = mensaje;
            document.getElementById("modalErrores").classList.remove("hidden");
        }

        function cerrarModalErrores() {
            document.getElementById("modalErrores").classList.add("hidden");
        }
    </script>

    <!--script para actualizar datos en tiempo real en 2 campos de la 2da tabla (tara y peso neto)-->
    <script>
        function updateValues(registroIndex) {
            // Obtener el select y la opción seleccionada
            let select = document.getElementById('no_julio_' + registroIndex);
            let selectedOption = select.options[select.selectedIndex];

            // Obtener la tara de los atributos data-tara
            let tara = selectedOption.getAttribute('data-tara');

            // Asignar la tara al input correspondiente
            document.getElementById('tara_' + registroIndex).value = tara;

            // Llamar a la función para actualizar el peso neto
            updatePesoNeto(registroIndex);
        }

        function updatePesoNeto(registroIndex) {
            // Obtener el valor del peso bruto y la tara
            let pesoBruto = parseFloat(document.getElementById('peso_bruto_' + registroIndex).value) || 0;
            let tara = parseFloat(document.getElementById('tara_' + registroIndex).value) || 0;

            // Calcular el peso neto
            let pesoNeto = pesoBruto - tara;

            // Asignar el valor calculado al input de peso neto
            document.getElementById('peso_neto_' + registroIndex).value = pesoNeto.toFixed(2); // Mostrar con 2 decimales
        }
    </script>

    <script>
        function reimprimir() {
            const folio = document.getElementById('folio').value;
            const url = "{{ url('/imprimir-orden-llena-urd') }}/" + folio;
            const papeletas = "{{ url('/imprimir-papeletas-pequenias') }}/" + folio;
            window.open(url, '_blank');
            window.open(papeletas, '_blank');
        }
    </script>

    @push('styles')
        <style>
            #finalizadoOverlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.8);
                color: white;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 4rem;
                font-weight: bold;
                z-index: 9999;
                opacity: 0;
                transition: opacity 0.5s ease;
                pointer-events: none;
            }

            #finalizadoOverlay.active {
                opacity: 1;
                pointer-events: auto;
            }
        </style>
    @endpush

@endsection
