@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg mt-2">
    <h1 class="text-3xl font-bold text-center mb-6">ORDEN DE URDIDO</h1>

    <!-- Formulario -->
    <form class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Primera columna -->
        <div class="text-sm">
            <label class="block font-medium">Orden de Trabajo:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="{{ $requerimiento->orden_prod ?? '' }}" readonly>
            
            <label class="block font-medium mt-1">Cuenta:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="{{ $urdido->cuenta ?? '' }}" readonly>
            
            <label class="block font-medium mt-1">Urdido:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="{{ $urdido->urdido ?? '' }}" readonly>
            
            <label class="block font-medium mt-1">Calibre:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="pending" >
            
            <label class="block font-medium mt-1">Proveedor:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="{{ $urdido->proveedor ?? '' }}" readonly>
        </div>

        <!-- Segunda columna -->
        <div class="text-sm">
            <label class="block font-medium">Fecha:</label>
            <input type="date" class="w-full border rounded p-1 text-xs" value="{{ \Carbon\Carbon::parse($requerimiento->fecha ?? null)->toDateString() }}" readonly>
            
            <label class="block font-medium mt-1">Tipo:</label>
            <div class="flex gap-2 mt-0.5">
                <label class="text-xs"><input type="radio" name="tipo" value="Rizo" {{ $urdido->tipo === 'Rizo' ? 'checked' : '' }} disabled> Rizo</label>
                <label class="text-xs"><input type="radio" name="tipo" value="Pie" {{ $urdido->tipo === 'Pie' ? 'checked' : '' }} disabled> Pie</label>
            </div>
            
            <label class="block font-medium mt-1">Metros:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="{{ rtrim(rtrim($urdido->metros, '0'), '.') }}" readonly>
            
            <label class="block font-medium mt-1">Lote:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="pending">
        </div>

        <!-- Tercera columna -->
        <div>
            <label class="block font-medium mt-1">Ordenado por:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="pending">
            <label class="block font-medium mt-1">Destino:</label>
            <input type="text" class="w-full border rounded p-1 text-xs" value="{{ $urdido->destino ?? '' }}" readonly>

            <!-- Tabla de Construcción -->
            <h2 class="text font-semibold mt-4">Construcción</h2>
            <table class="w-full border-collapse border border-gray-300 mt-2">
                <thead>
                    <tr class="bg-gray-200 text-xs">
                        <th class="border p-1 w-1/5 text-center">Número de Julio</th>
                        <th class="border p-1 w-1/5 text-center">Hilos</th>
                        <th class="border p-1 text-center">Observaciones</th>
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
    <h2 class="text-xl font-semibold mt-6">Registro de Producción</h2>
    <table class="w-full border-collapse border border-gray-300 mt-2">
        <thead>
            <tr class="bg-gray-200 text-xs">
                <th class="border p-2" colspan="12"></th>
                <th class="p-2 text-center border-2 border-black" colspan="4">Roturas</th>
            </tr>
            <tr class="bg-gray-200 text-xs">
                <th class="border p-2">Fecha</th>
                <th class="border p-2">Oficial</th>
                <th class="border p-2">Turno</th>
                <th class="border p-2">Hora Inicio</th>
                <th class="border p-2">Hora Fin</th>
                <th class="border p-2">No Julio</th>
                <th class="border p-2">Hilos</th>
                <th class="border p-2">Peso Bruto</th>
                <th class="border p-2">Tara</th>
                <th class="border p-2">Peso Neto</th>
                <th class="border p-2">Metros</th>
                <th class="border p-2">Hilatura</th>
                <th class="border p-2">Máquina</th>
                <th class="border p-2">Operación</th>
                <th class="border p-2">Transferencia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($construccion as $registroConstruccion)
            <tr class="text-xs">
                <!-- ID oculto que incrementa con cada iteración -->
                <input type="hidden" value="{{ $loop->iteration }}" id="id">
                <input type="hidden" value="{{ $registroConstruccion->folio }}" id="folio">
                <td class="border p-1" id="fecha">{{ $requerimiento->fecha ?? '' }}</td>
                <td class="border p-1" id="oficial">AUTO</td>
                <td class="border p-1"><input type="text" class="w-full border rounded p-1 text-xs" value="" id="turno"></td>
                <td class="border p-1"><input type="text" class="w-full border rounded p-1 text-xs" value="" id="hora_inicio"></td>
                <td class="border p-1"><input type="text" class="w-full border rounded p-1 text-xs" value="" id="hora_fin"></td>
                <td class="border p-1" id="no_julio">{{ $registroConstruccion->no_julios ?? '' }}</td>
                <td class="border p-1" id="hilos">{{ $registroConstruccion->hilos ?? '' }}</td>
                <td class="border p-1"><input type="text" class="w-full border rounded p-1 text-xs" value="" id="peso_bruto"></td>
                <td class="border p-1" id="tara">AUTO</td>
                <td class="border p-1" id="peso_neto">AUTO</td>
                <td class="border p-1" id="metros">{{ rtrim(rtrim($urdido->metros, '0'), '.') }}</td>
                <td class="border p-1"><input type="text" class="w-full border rounded p-1 text-xs" value="" id="hilatura"></td>
                <td class="border p-1"><input type="text" class="w-full border rounded p-1 text-xs" value="" id="maquina"></td>
                <td class="border p-1"><input type="text" class="w-full border rounded p-1 text-xs" value="" id="operacion"></td>
                <td class="border p-1"><input type="text" class="w-full border rounded p-1 text-xs" value="" id="transferencia"></td>
                <td class="border p-1">
                    <!-- Botón de guardar con data-id vacío (se llenará luego si es necesario) -->
                    <button class="btn btn-primary save-btn">Guardar</button>
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Evento para el botón de guardar
        document.querySelectorAll('.save-btn').forEach(button => {
            button.addEventListener('click', function () {
                // Obtener los datos del formulario
                let row = this.closest('tr');
                let id = row.querySelector('input#id').value;
                let folio = row.querySelector('input#folio').value;
                let fecha = row.querySelector('td#fecha').innerText;
                let oficial = row.querySelector('td#oficial').innerText;
                let turno = row.querySelector('input#turno').value;
                let hora_inicio = row.querySelector('input#hora_inicio').value;
                let hora_fin = row.querySelector('input#hora_fin').value;
                let no_julio = row.querySelector('td#no_julio').innerText;
                let hilos = row.querySelector('td#hilos').innerText;
                let peso_bruto = row.querySelector('input#peso_bruto').value;
                let tara = row.querySelector('td#tara').innerText;
                let peso_neto = row.querySelector('td#peso_neto').innerText;
                let metros = row.querySelector('td#metros').innerText;
                let hilatura = row.querySelector('input#hilatura').value;
                let maquina = row.querySelector('input#maquina').value;
                let operacion = row.querySelector('input#operacion').value;
                let transferencia = row.querySelector('input#transferencia').value;

                // Enviar los datos al servidor mediante una solicitud AJAX
                fetch("{{ route('ordenUrdido.guardar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        folio: folio,
                        id: id,
                        oficial: oficial,
                        fecha: fecha,
                        turno: turno,
                        hora_inicio: hora_inicio,
                        hora_fin: hora_fin,
                        no_julio: no_julio,
                        hilos: hilos,
                        peso_bruto: peso_bruto,
                        tara: tara,
                        peso_neto: peso_neto,
                        metros: metros,
                        hilatura: hilatura,
                        maquina: maquina,
                        operacion: operacion,
                        transferencia: transferencia
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message); // Mostrar mensaje de éxito
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al guardar el registro.');
                });
            });
        });
    });
</script>

@endsection
