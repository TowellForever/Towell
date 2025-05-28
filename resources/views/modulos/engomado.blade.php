@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-2 bg-white shadow-lg rounded-lg mt-1 overflow-y-auto md:h-[650px]">
        <div id="finalizadoOverlay">FINALIZADO CORRECTAMENTE</div>
        <h1 class="text-3xl font-bold text-center mb-2">Proceso de Producción de Engomado</h1>
        <!-- Formulario -->
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
            <!-- Primera columna -->
            <div class="text-sm">
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Orden de Trabajo:</label>
                    <input id="folio" name="folio" type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $requerimiento->orden_prod ?? '' }}" readonly />
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Cuenta:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $engomadoUrd->cuenta ?? '' }}" readonly />
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Urdido:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $engomadoUrd->urdido ?? '' }}" readonly />
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Destino:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $engomadoUrd->destino . ' ' . $requerimiento->telar ?? '' }}" readonly />
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Proveedor:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $engomadoUrd->proveedor ?? '' }}"readonly>
                </div>
            </div>

            <div class="text-sm">
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Engomado:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" name="engomado"
                        value="{{ $engomadoUrd->engomado ?? '' }}" required>
                </div>
                <label class="w-1/4 text-sm">Tipo:</label>
                <label class="text-sm text-black font-bold"><input type="radio" name="tipo" value="Rizo"
                        {{ $engomadoUrd->tipo === 'Rizo' ? 'checked' : '' }} disabled> Rizo</label>
                <label class="text-sm text-black font-bold ml-4"><input type="radio" name="tipo" value="Pie"
                        {{ $engomadoUrd->tipo === 'Pie' ? 'checked' : '' }} disabled> Pie</label>
                <div class="flex items-center mb-1 mt-2">
                    <label class="w-1/4 text-sm">Núcleo:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $engomadoUrd->nucleo ?? '' }}"readonly />
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">No. De Telas:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $engomadoUrd->no_telas ?? '' }}"readonly>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Ancho Balonas:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $engomadoUrd->balonas ?? '' }}"readonly>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Mts. De Telas:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ floor($engomadoUrd->metros_tela) == $engomadoUrd->metros_tela ? intval($engomadoUrd->metros_tela) : $engomadoUrd->metros_tela }}
"readonly><!--Si es entero, lo convierte a entero con intval() (quita el .0), y si no es entero, lo deja como está (mantiene decimales como .5, .25, etc.).-->
                </div>
            </div>
            <div class="text-sm">
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Cuendeados Mín.:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold"
                        value="{{ $engomadoUrd->cuendados_mini ?? '' }}" />
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Observaciones:</label>
                    <textarea class="w-2/6 border rounded p-1 text-xs h-20 font-bold" name="observaciones">{{ $engomadoUrd->observaciones ?? '' }}</textarea>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Color:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" name="color"
                        value="{{ $engomadoUrd->color ?? '' }}" required>
                </div>
                <div class="flex items-center mb-1">
                    <label class="w-1/4 text-sm">Sólidos:</label>
                    <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" name="solidos"
                        value="{{ $engomadoUrd->solidos ?? '' }}" required>
                </div>
            </div>
        </form>

        <!-- Tabla de Datos -->
        <h2 class="text-sm font-bold mt-2">Registro de Producción</h2>
        <table class="w-full border-collapse border border-gray-300 mt-2">
            <thead>
                <tr class="bg-gray-200 text-xs">
                    <th class="border p-1">Fecha</th>
                    <th class="border p-1">Oficial</th>
                    <th class="border p-1">Turno</th>
                    <th class="border p-1">H. Inic.</th>
                    <th class="border p-1">H. Final</th>
                    <th class="border p-1">Tiempo</th>
                    <th class="border p-1">N° Julio</th>
                    <th class="border p-1">Kg. Bruto</th>
                    <th class="border p-1">Tara</th>
                    <th class="border p-1">Kg. Neto</th>
                    <th class="border p-1">Metros</th>
                    <th class="border p-1">Temp Canoa 1</th>
                    <th class="border p-1">Temp Canoa 2</th>
                    <th class="border p-1">Temp Canoa 3</th>
                    <th class="border p-1">Humedad</th>
                    <th class="border p-1">Roturas</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $registroIndex = 0;
                @endphp
                @for ($i = 0; $i < $engomadoUrd->no_telas; $i++)
                    @php
                        $orden = $engomado[$registroIndex] ?? null;
                        $registroIndex++;
                    @endphp
                    <tr class="text-xs">
                        <input type="hidden" name="datos[{{ $registroIndex }}][id2]" value="{{ $registroIndex }}">
                        <input type="hidden" name="datos[{{ $registroIndex }}][folio]"
                            value="{{ $requerimiento->orden_prod ?? '' }}">
                        <td class="border p-1">
                            <input class="w-24 p-1" type="date" name="datos[{{ $registroIndex }}][fecha]"
                                value="{{ $orden && $orden->fecha ? \Carbon\Carbon::parse($orden->fecha)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </td>

                        <td class="border p-1 w-30">
                            <select class="w-24 border rounded p-1 text-xs" name="datos[{{ $registroIndex }}][oficial]"
                                id="oficial_{{ $registroIndex }}" onchange="updateOficialTipo({{ $registroIndex }})">
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

                        <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                name="datos[{{ $registroIndex }}][tiempo]" class="w-10 border rounded p-1 text-xs"
                                value="{{ $orden->tiempo ?? '' }}"></td>

                        <td class="border p-1 w-30">
                            <select class="w-24 border rounded p-1 text-xs" name="datos[{{ $registroIndex }}][no_julio]"
                                id="no_julio_{{ $registroIndex }}" onchange="updateValues({{ $registroIndex }})">
                                <option value="">Seleccionar</option>
                                @foreach ($julios as $julio)
                                    <option value="{{ $julio->no_julio }}" data-tara="{{ $julio->tara }}"
                                        data-tipo="{{ $julio->tipo }}" @if (!is_null($orden) && $julio->no_julio == $orden->no_julio) selected @endif>
                                        {{ $julio->no_julio }}
                                    </option>
                                @endforeach
                            </select>
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
                            <input class="w-14 p-1 text-xs" type="text" name="datos[{{ $registroIndex }}][peso_neto]"
                                id="peso_neto_{{ $registroIndex }}" value="{{ $orden->peso_neto ?? '' }}" readonly>
                        </td>

                        <td class="border p-1">
                            {{ floor($engomadoUrd->metros_tela) == $engomadoUrd->metros_tela ? intval($engomadoUrd->metros_tela) : $engomadoUrd->metros_tela }}
                            <input type="hidden" name="datos[{{ $registroIndex }}][metros]"
                                value="{{ floor($engomadoUrd->metros_tela) == $engomadoUrd->metros_tela ? intval($engomadoUrd->metros_tela) : $engomadoUrd->metros_tela }}">
                        </td>

                        <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                name="datos[{{ $registroIndex }}][temp_canoa_1]" class="w-10 border rounded p-1 text-xs"
                                value="{{ $orden->temp_canoa_1 ?? '' }}"></td>
                        <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                name="datos[{{ $registroIndex }}][temp_canoa_2]" class="w-10 border rounded p-1 text-xs"
                                value="{{ $orden->temp_canoa_2 ?? '' }}"></td>
                        <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                name="datos[{{ $registroIndex }}][temp_canoa_3]" class="w-10 border rounded p-1 text-xs"
                                value="{{ $orden->temp_canoa_3 ?? '' }}"></td>
                        <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                name="datos[{{ $registroIndex }}][humedad]" class="w-10 border rounded p-1 text-xs"
                                value="{{ $orden->humedad ?? '' }}"></td>
                        <td class="border p-1"><input type="text" inputmode="numeric" pattern="[0-9]*"
                                name="datos[{{ $registroIndex }}][roturas]" class="w-10 border rounded p-1 text-xs"
                                value="{{ $orden->roturas ?? '' }}"></td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <div class="mt-4 text-right">
            @if ($engomadoUrd->estatus_engomado == 'en_proceso')
                <button class="btn bg-blue-600 text-white w-20 h-9 hover:bg-blue-400" id="guardarYFinalizar">Guardar y
                    Finalizar</button>
            @endif
        </div>
    </div>

    <script>
        document.getElementById("guardarYFinalizar").addEventListener("click", function() {
            // Validar folio
            const folio = document.querySelector('input[name="folio"]').value;
            if (!folio) {
                alert("No se encontró el folio.");
                return;
            }

            if (!confirm("¿Está seguro de guardar y finalizar este urdido?")) return;

            // Obtener todos los datos de los inputs
            const inputs = document.querySelectorAll('input[name^="datos"], select[name^="datos"]');
            let formData = {};
            let camposGenerales = {
                color: document.querySelector('input[name="color"]').value,
                solidos: document.querySelector('input[name="solidos"]').value,
                observaciones: document.querySelector('textarea[name="observaciones"]').value,
                folio: folio,
                engomado: document.querySelector('input[name="engomado"]').value
            };

            inputs.forEach(input => {
                const match = input.name.match(/datos\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    const index = match[1];
                    const key = match[2];

                    if (!formData[index]) {
                        formData[index] = {};
                    }

                    formData[index][key] = input.tagName.toLowerCase() === "select" ?
                        input.options[input.selectedIndex].value :
                        input.value;
                }
            });

            // Enviar al backend combinado
            fetch("{{ route('ordenEngomado.guardarYFinalizar') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                            "content")
                    },
                    body: JSON.stringify({
                        registros: Object.values(formData),
                        generales: camposGenerales
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || "Registros guardados y engomado finalizado.");
                    document.getElementById('guardarYFinalizar').disabled = true;
                    document.getElementById('guardarYFinalizar').innerText = 'Finalizado';
                    //Antes de cerrar el proceso de finalizado, muestro el overlay
                    const overlay = document.getElementById('finalizadoOverlay');
                    overlay.classList.add('active');

                    setTimeout(() => {
                        overlay.classList.remove('active');
                    }, 4000);
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Ocurrió un error al guardar y finalizar.");
                });
        });
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
