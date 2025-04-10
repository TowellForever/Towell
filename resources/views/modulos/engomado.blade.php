@extends('layouts.app')

@section('content')
<div class="container mx-auto p-2 bg-white shadow-lg rounded-lg mt-1">
    <h1 class="text-3xl font-bold text-center mb-2">Proceso de Producción de Engomado</h1>
    
    <!-- Formulario -->
    <form class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
        <!-- Primera columna -->
        <div class="text-sm">
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Orden de Trabajo:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ $urdido->folio ?? '' }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Cuenta:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ $urdido->cuenta ?? '' }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Urdido:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ $urdido->urdido ?? '' }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Núcleo:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ $urdido->nucleo ?? '' }}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Cuendeados Mínimo:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ $urdido->cuendados_mini ?? ''}}" />
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Destino:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ $urdido->destino ?? '' }}" />
            </div>
        </div>
        
        <div class="text-sm">
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Engomado:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <label class="w-1/4 text-sm">Tipo:</label>
                <label class="text-sm text-black font-semibold"><input type="radio" name="tipo" value="Rizo" {{ $urdido->tipo === 'Rizo' ? 'checked' : '' }} disabled> Rizo</label>
                <label class="text-sm text-black font-semibold ml-4"><input type="radio" name="tipo" value="Pie" {{ $urdido->tipo === 'Pie' ? 'checked' : '' }} disabled> Pie</label>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Ancho Balonas:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ $urdido->balonas ?? ''}}">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Sólidos:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Observaciones:</label>
                <textarea class="w-2/6 border rounded p-1 text-xs h-20" aria-valuetext="{{$urdido->observaciones ?? ''}}"></textarea>
            </div>
        </div>
        
        <div class="text-sm">
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Fecha:</label>
                <input type="date" class="w-2/6 border rounded p-1 text-xs">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Metraje de la Tela:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{$urdido->metros_tela ?? ''}}">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Proveedor:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{ $urdido->proveedor ?? ''}}">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Número de Telas:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs" value="{{$urdido->no_telas ?? ''}}">
            </div>
        
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">Color:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs">
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
                @for($i = 0; $i < $urdido->no_telas; $i++)
                    @php
                        $orden = $ordenEngomado[$registroIndex] ?? null;
                        $registroIndex++;
                    @endphp
                    <tr class="text-xs">
                        <input type="hidden" name="datos[{{$registroIndex}}][id2]" value="{{ $registroIndex }}">
                        <input type="hidden" name="datos[{{$registroIndex}}][folio]" value="{{ $urdido->folio ?? '' }}">
                        <td class="border p-1">
                            <input class="w-24 p-1" type="date" name="datos[{{$registroIndex}}][fecha]" value="{{ $orden ? \Carbon\Carbon::parse($orden->fecha)->format('Y-m-d') : '' }}">
                        </td>          
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][oficial]" value="{{ $orden->oficial ?? ''}}" class="w-14 border rounded p-1 text-xs"></td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][turno]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->turno ?? '' }}"></td>
                        <td class="border p-1">
                            <input type="time" name="datos[{{$registroIndex}}][hora_inicio]" class="w-24 border rounded p-1 text-xs" 
                                value="{{ isset($orden->hora_inicio) ? \Illuminate\Support\Str::limit($orden->hora_inicio, 5, '') : '' }}" step="60">
                        </td>
                        <td class="border p-1">
                            <input type="time" name="datos[{{$registroIndex}}][hora_fin]" class="w-24 border rounded p-1 text-xs" 
                                value="{{ isset($orden->hora_fin) ? \Illuminate\Support\Str::limit($orden->hora_fin, 5, '') : '' }}" step="60">
                        </td> 

                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][tiempo]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->tiempo ?? '' }}"></td>

                        <td class="border p-1 w-30">
                            <select class="w-24 border rounded p-1 text-xs" name="datos[{{$registroIndex}}][no_julio]" id="no_julio_{{$registroIndex}}" onchange="updateValues({{$registroIndex}})">
                                <option value="">Seleccionar</option>
                                @foreach($julios as $julio)
                                    <option value="{{ $julio->no_julio }}" 
                                        data-tara="{{ $julio->tara }}" 
                                        data-tipo="{{ $julio->tipo }}"
                                        @if($julio->no_julio == $urdido->no_julio) selected @endif>
                                        {{ $julio->no_julio }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        
                        <td class="border p-1">
                            <input class="w-10 border rounded p-1 text-xs" type="text" name="datos[{{$registroIndex}}][peso_bruto]" value="{{ $orden->peso_bruto ?? '' }}" id="peso_bruto_{{$registroIndex}}" onchange="updatePesoNeto({{$registroIndex}})">
                        </td>
                        
                        <td class="border p-1">
                            <input class="w-14 p-1 text-xs" type="text" name="datos[{{$registroIndex}}][tara]" id="tara_{{$registroIndex}}" value="{{ $orden->tara ?? '' }}" readonly>
                        </td>
                        <td class="border p-1">
                            <input class="w-14 p-1 text-xs" type="text" name="datos[{{$registroIndex}}][peso_neto]" id="peso_neto_{{$registroIndex}}" value="{{ $orden->peso_neto ?? ''}}" readonly>
                        </td>

                        <td class="border p-1">{{ rtrim(rtrim($urdido->metros ?? '', '0'), '.') }}
                            <input type="hidden" name="datos[{{$registroIndex}}][metros]" value="{{ rtrim(rtrim($urdido->metros ?? '', '0'), '.') }}">
                        </td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][temp_canoa_1]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->temp_canoa_1 ?? '' }}"></td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][temp_canoa_2]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->temp_canoa_2 ?? '' }}"></td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][temp_canoa_3]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->temp_canoa_3 ?? '' }}"></td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][humedad]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->humedad ?? '' }}"></td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][roturas]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->roturas ?? '' }}"></td>
                    </tr>
                @endfor
        </tbody>
    </table>
    <div class="mt-4 text-right">
      <button id="guardarTodo" class="btn bg-blue-600 text-white w-20 h-9 hover:bg-blue-400">Guardar Todo</button>
    </div>
</div>

    <script>
        document.getElementById("guardarTodo").addEventListener("click", function () {
            // Obtener todos los inputs de tipo name="datos[..]"
            const inputs = document.querySelectorAll('input[name^="datos"], select[name^="datos"]');
            let formData = {};

            // Agrupar inputs por índice
            inputs.forEach(input => {
                const match = input.name.match(/datos\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    const index = match[1];
                    const key = match[2];

                    if (!formData[index]) {
                        formData[index] = {};
                    }

                    // Verificar si es un select para agregar el valor seleccionado
                    if (input.tagName.toLowerCase() === "select") {
                        formData[index][key] = input.options[input.selectedIndex].value; // Valor de la opción seleccionada
                    } else {
                        formData[index][key] = input.value;
                    }
                }
            });

            // Enviar los datos al servidor
            fetch("{{ route('ordenEngomado.guardar') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: JSON.stringify({ registros: Object.values(formData) })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message || "Todos sus registros han sido guardados correctamente.");
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Error al guardar los registros.");
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
@endsection
