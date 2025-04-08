@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-2">
    <h1 class="text-3xl font-bold text-center mb-2">ORDEN DE URDIDO</h1>

    <!-- Formulario -->
    <form class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
        <!-- Primera columna -->
        <div class="text-sm">
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">FOLIO:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" value="{{ $requerimiento->orden_prod ?? '' }}" readonly>
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">CUENTA:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" value="{{ $urdido->cuenta ?? '' }}" readonly>
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">URDIDO:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" value="{{ $urdido->urdido ?? '' }}" readonly>
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">PROVEEDOR:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" value="{{ $urdido->proveedor ?? '' }}" readonly>
            </div>

        </div>
        

        <!-- Segunda columna -->
        <div class="text-sm">
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm">TIPO:</label>
                <div class="flex items-center">
                    <label class="text-sm text-black font-semibold">
                        <input type="radio" name="tipo" value="Rizo" {{ $urdido->tipo === 'Rizo' ? 'checked' : '' }} disabled> Rizo
                    </label>
                    <label class="text-sm text-black font-semibold ml-4">
                        <input type="radio" name="tipo" value="Pie" {{ $urdido->tipo === 'Pie' ? 'checked' : '' }} disabled> Pie
                    </label>
                </div>                
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm ">METROS:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" value="{{ rtrim(rtrim($urdido->metros, '0'), '.') }}" readonly>
            </div>
            <div class="flex items-center mb-1">
                <label class="w-1/4 text-sm ">DESTINO:</label>
                <input type="text" class="w-2/6 border rounded p-1 text-xs font-bold" value="{{ $urdido->destino.' '.$requerimiento->telar?? '' }}" readonly>
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
                    @foreach($construccion as $registroConstruccion)
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
            @foreach($construccion as $registroConstruccion)
                @for($i = 0; $i < $registroConstruccion->no_julios; $i++)
                    @php
                        $orden = $ordenUrdido[$registroIndex] ?? null;
                        $registroIndex++;
                    @endphp
                    <tr class="text-xs">
                        <input type="hidden" name="datos[{{$registroIndex}}][id]" value="{{ $registroIndex }}">
                        <input type="hidden" name="datos[{{$registroIndex}}][folio]" value="{{ $registroConstruccion->folio ?? '' }}">
                        
                        <td class="border p-1">
                            <input class="w-24 p-1" type="date" name="datos[{{$registroIndex}}][fecha]" value="{{ $orden->fecha ? \Carbon\Carbon::parse($orden->fecha)->format('Y-m-d') : '' }}">
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
                        <td class="border p-1 w-30">
                            <input class="w-10 border rounded p-1 text-xs" type="text" name="datos[{{$registroIndex}}][no_julio]" value="{{ $registroConstruccion->no_julios ?? '' }}">
                        </td>
                        <td class="border p-1">{{ $registroConstruccion->hilos ?? '' }}
                            <input type="hidden" name="datos[{{$registroIndex}}][hilos]" value="{{ $registroConstruccion->hilos ?? '' }}">
                        </td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][peso_bruto]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->peso_bruto ?? '' }}"></td>
                        <td class="border p-1">AUTO<input type="hidden" name="datos[{{$registroIndex}}][tara]" value="AUTO"></td>
                        <td class="border p-1">AUTO<input type="hidden" name="datos[{{$registroIndex}}][peso_neto]" value="AUTO"></td>
                        <td class="border p-1">{{ rtrim(rtrim($urdido->metros ?? '', '0'), '.') }}
                            <input type="hidden" name="datos[{{$registroIndex}}][metros]" value="{{ rtrim(rtrim($urdido->metros ?? '', '0'), '.') }}">
                        </td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][hilatura]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->hilatura ?? '' }}"></td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][maquina]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->maquina ?? '' }}"></td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][operacion]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->operacion ?? '' }}"></td>
                        <td class="border p-1"><input type="text" name="datos[{{$registroIndex}}][transferencia]" class="w-10 border rounded p-1 text-xs" value="{{ $orden->transferencia ?? '' }}"></td>
                    </tr>
                @endfor
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-4 text-right">
        <button id="guardarTodo" class="btn bg-blue-600 text-white w-20 h-9 hover:bg-blue-400">Guardar Todo</button>
    </div>
</div>

    <script>
        document.getElementById("guardarTodo").addEventListener("click", function () {
            // Obtener todos los inputs de tipo name="datos[..]"
            const inputs = document.querySelectorAll('input[name^="datos"]');
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
                    formData[index][key] = input.value;
                }
            });

            fetch("{{ route('ordenUrdido.guardar') }}", {
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


@endsection
