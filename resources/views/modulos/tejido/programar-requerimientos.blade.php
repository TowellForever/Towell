@extends('layouts.app')

@section('content')
<div class="container mx-auto -mt-3"> 
    <form id="seleccionForm" method="GET" action="{{ route('formulario.programarRequerimientos') }}">
        <!-- Inputs ocultos para enviar el telar y tipo seleccionados -->
        <input type="hidden" name="telar" id="telarInput">
        <input type="hidden" name="tipo" id="tipoInput">
        <!-- Tabla 1: Requerimiento desde Dynamics AX -->
        <div class="bg-white shadow-md rounded-lg p-2 custom-scroll">
            <h2 class="text-lg font-bold bg-yellow-200 text-center py-2">Programación de Requerimientos</h2>
            <div class="flex justify-end mt-2 mb-2">
                <button class="px-3 w-1/6 py-1 text-xs bg-green-500 text-white rounded shadow hover:bg-green-600">Programar</button>
            </div>
            <div class="overflow-y-auto max-h-60 "> <!-- Contenedor con scroll -->
                <!-- Tabla 1: Programación de Requerimientos -->
            <table class="w-full text-xs border-collapse border border-gray-300 requerimientos">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="border px-1 py-0.5">Telar</th>
                        <th class="border px-1 py-0.5">Tipo</th>
                        <th class="border px-1 py-0.5">Cuenta</th>
                        <th class="border px-1 py-0.5">Fecha Requerida</th>
                        <th class="border px-1 py-0.5">Metros</th>
                        <th class="border px-1 py-0.5">Mc Coy</th>
                        <th class="border px-1 py-0.5">Orden Urdido o Engomado</th>
                        <th class="border px-1 py-0.5">Programar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requerimientos as $req)
                    <tr class="cursor-pointer hover:bg-yellow-200 transition duration-200"
                    data-tipo="{{ $req->rizo == 1 ? 'Rizo' : ($req->pie == 1 ? 'Pie' : 'N/A') }}"
                    data-telar="{{ $req->telar }}"
                    onclick="seleccionarFila(this)">
                            <td class="border px-1 py-0.5">{{ $req->telar }}</td>
                            <td class="border px-1 py-0.5">
                                @if($req->rizo == 1)
                                    Rizo
                                @elseif($req->pie == 1)
                                    Pie
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="border px-1 py-0.5">
                                {{ $req->rizo == 1 ? $req->cuenta_rizo : ($req->pie == 1 ? $req->cuenta_pie : '-') }}
                            </td>                        
                            <td class="border px-1 py-0.5">{{ \Carbon\Carbon::parse($req->fecha)->format('d-m-Y') }}</td>
                            <td class="border px-1 py-0.5">-</td> <!-- Metros nulo -->
                            <td class="border px-1 py-0.5">-</td> <!-- Mc Coy nulo -->
                            <td class="border px-1 py-0.5"></td> <!--Aqui se insertará la orden o FOLIO que se genera en la vista que sigue al presion boton Programar-->
                            <td class="border text-center"><input type="checkbox" class="w-5 h-5"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </form>
    <!-- Espacio entre tablas -->
    <div class="my-2"></div>

    <!-- Tabla 2: Inventario Disponible -->
    <div class="bg-white shadow-md rounded-lg p-2">
        <h2 class="text-lg font-bold bg-yellow-200 text-center py-2">Inventario Disponible</h2>
        <div class="overflow-y-auto max-h-60 "> <!-- Contenedor con scroll -->
<!-- Tabla 2: Inventarios -->
<table class="w-full text-xs border-collapse border border-gray-300 inventarios">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="border px-1 py-0.5">Artículo</th>
            <th class="border px-1 py-0.5">Tipo</th>
            <th class="border px-1 py-0.5">Cantidad</th>
            <th class="border px-1 py-0.5">Hilo</th>
            <th class="border px-1 py-0.5">Cuenta</th>
            <th class="border px-1 py-0.5">Color</th>
            <th class="border px-1 py-0.5">Almacén</th>
            <th class="border px-1 py-0.5">Orden</th>
            <th class="border px-1 py-0.5">Localidad</th>
            <th class="border px-1 py-0.5">No. Julio</th>
            <th class="border px-1 py-0.5">Metros</th>
            <th class="border px-1 py-0.5">Fecha</th>
            <th class="border px-1 py-0.5">Seleccionar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inventarios as $inv)
            <tr class="cursor-pointer hover:bg-yellow-200 transition duration-200" data-tipo="{{ $inv->TIPO }}">
                <td class="border px-1 py-0.5">{{$inv->ITEMID}}</td>
                <td class="border px-1 py-0.5">{{$inv->TIPO}}</td>
                <td class="border px-1 py-0.5">{{number_format($inv->QTY,0) }}</td>
                <td class="border px-1 py-0.5">{{$inv->CONFIGID}}</td>
                <td class="border px-1 py-0.5">{{$inv->INVENTSIZEID}}</td>
                <td class="border px-1 py-0.5">{{$inv->INVENTCOLORID}}</td>
                <td class="border px-1 py-0.5">{{$inv->INVENTLOCATIONID}}</td>
                <td class="border px-1 py-0.5">{{$inv->INVENTBATCHID}}</td>
                <td class="border px-1 py-0.5">{{$inv->WMSLOCATIONID}}</td>
                <td class="border px-1 py-0.5">{{$inv->INVENTSERIALID}}</td>
                <td class="border px-1 py-0.5">{{ number_format($inv->METROS, 0) }}</td>
                <td class="border px-1 py-0.5">12/05/2025</td>
                <td class="border px-1 py-0.5 text-center"><input type="checkbox" class="w-5 h-5"></td>
            </tr>
        @endforeach
    </tbody>
</table>
        </div>
        <div class="flex justify-end mt-2">
            <button class="px-3 w-1/6 py-1 text-xs bg-green-500 text-white rounded shadow hover:bg-green-600">Reservar</button>
        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const requerimientosRows = document.querySelectorAll("tbody tr");
        const inventariosRows = document.querySelectorAll(".inventarios tbody tr");

        requerimientosRows.forEach(row => {
            row.addEventListener("click", function () {
                // Obtener el tipo del registro seleccionado
                const tipoSeleccionado = this.querySelector("td:nth-child(2)").textContent.trim();

                // Filtrar la segunda tabla según el tipo
                inventariosRows.forEach(invRow => {
                    const tipoInventario = invRow.querySelector("td:nth-child(2)").textContent.trim();

                    if (tipoInventario === tipoSeleccionado) {
                        invRow.style.display = ""; // Mostrar si coincide
                    } else {
                        invRow.style.display = "none"; // Ocultar si no coincide
                    }
                });
            });
        });
    });
</script>
<script>
    // Función para actualizar los inputs ocultos al hacer clic en la fila
    function seleccionarFila(row) {
        // Extraer los valores de los atributos data-tipo y data-telar de la fila
        const telar = row.getAttribute("data-telar");
        const tipo = row.getAttribute("data-tipo"); 

        // Actualizar los campos ocultos
        document.getElementById("telarInput").value = telar;
        document.getElementById("tipoInput").value = tipo;

        // Opcional: resaltar la fila seleccionada (por ejemplo, eliminando la clase de las demás)
        document.querySelectorAll("#seleccionForm tbody tr").forEach(r => r.classList.remove("bg-blue-200"));
        row.classList.add("bg-blue-200");
    }
</script>

@endsection
