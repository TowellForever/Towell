@extends('layouts.app')

@section('content')
<div class="container mx-auto -mt-3"> 
    <!-- Tabla 1: Requerimiento desde Dynamics AX -->
    <div class="bg-white shadow-md rounded-lg p-2 custom-scroll">
        <h2 class="text-lg font-bold bg-yellow-200 text-center py-2">Programación de Requerimientos</h2>
        <div class="overflow-y-auto max-h-60 "> <!-- Contenedor con scroll -->
            <table class="w-full text-xs border-collapse border border-gray-300">
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
                        <tr>
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
                            <td class="border px-1 py-0.5">{{ $req->orden_prod }}</td>
                            <td class="border text-center"><input type="checkbox"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end mt-2">
            <button class="px-3 w-1/6 py-1 text-xs bg-green-500 text-white rounded shadow hover:bg-green-600">Reservar</button>
        </div>
    </div>
    

    <!-- Espacio entre tablas -->
    <div class="my-2"></div>

    <!-- Tabla 2: Inventario Disponible -->
    <div class="bg-white shadow-md rounded-lg p-2">
        <h2 class="text-lg font-bold bg-yellow-200 text-center py-2">Inventario Disponible</h2>
        <table class="w-full text-xs border-collapse border border-gray-300">
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
                    <tr>
                        <td class="border px-1 py-0.5">{{$inv->ITEMID}}</td>
                        <td class="border px-1 py-0.5">{{$inv->}}</td>
                        <td class="border px-1 py-0.5">{{$inv->POSTEDQTY}}</td>

                        <td class="border px-1 py-0.5">{{$inv->CONFIGID}}</td>
                        <td class="border px-1 py-0.5">{{$inv->INVENTSIZEID}}</td>
                        <td class="border px-1 py-0.5">{{$inv->INVENTCOLORID}}</td>
                        <td class="border px-1 py-0.5">{{$inv->INVENTLOCATIONID}}</td>
                        <td class="border px-1 py-0.5">{{$inv->INVENTBATCHID}}</td>
                        <td class="border px-1 py-0.5">{{$inv->WMSLOCATIONID}}</td>
                        <td class="border px-1 py-0.5">{{$inv->INVENTSERIALID}}</td>

                        <td class="border px-1 py-0.5">{{$inv->}}</td>
                        <td class="border px-1 py-0.5">{{$inv->}}</td>
                        <td class="border px-1 py-0.5">{{$inv->}}</td>
                        <td class="border px-1 py-0.5 text-center"><input type="checkbox"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-end mt-2">
            <button class="px-3 w-1/6 py-1 text-xs bg-green-500 text-white rounded shadow hover:bg-green-600">Reservar</button>
        </div>
    </div>

</div>

<!--
SELECT 
    INVENTSUM.ITEMID,
    INVENTSUM.POSTEDQTY,
    INVENTDIM.CONFIGID,
    INVENTDIM.INVENTSIZEID,
    INVENTDIM.INVENTCOLORID,
    INVENTDIM.INVENTLOCATIONID,
    INVENTDIM.INVENTBATCHID,
    INVENTDIM.WMSLOCATIONID,
    INVENTDIM.INVENTSERIALID,
    PRODTABLE.MTS,
    PRODTABLE.REALDATE
FROM 
    TI_PRO.dbo.INVENTSUM AS INVENTSUM
JOIN 
    TI_PRO.dbo.INVENTDIM AS INVENTDIM 
    ON INVENTSUM.INVENTDIMID = INVENTDIM.INVENTDIMID
JOIN 
    TI_PRO.dbo.PRODTABLE AS PRODTABLE 
    ON PRODTABLE.INVENTDIMID = INVENTDIM.INVENTDIMID 
    AND PRODTABLE.PRODSTATUS = 7
    AND PRODTABLE.DATAAREAID = 'PRO'
JOIN 
    TI_PRO.dbo.INVENTDIM AS INVENTDIM1 
    ON INVENTDIM.INVENTBATCHID = INVENTDIM1.INVENTBATCHID 
    AND INVENTDIM.INVENTSERIALID = INVENTDIM1.INVENTSERIALID
WHERE 
    INVENTSUM.POSTEDQTY > 0
    AND INVENTSUM.DATAAREAID = 'PRO'
    AND INVENTDIM.INVENTLOCATIONID = 'A-JUL/TELA'







SELECT
    INVENTSUM.ITEMID,
    INVENTSUM.POSTEDQTY,
    INVENTDIM.CONFIGID,
    INVENTDIM.INVENTSIZEID,
    INVENTDIM.INVENTCOLORID,
    INVENTDIM.INVENTLOCATIONID,
    INVENTDIM.INVENTBATCHID,
    INVENTDIM.WMSLOCATIONID,
    INVENTDIM.INVENTSERIALID
FROM 
    TI_PRO.dbo.INVENTSUM AS INVENTSUM
JOIN 
    TI_PRO.dbo.INVENTDIM AS INVENTDIM 
    ON INVENTSUM.INVENTDIMID = INVENTDIM.INVENTDIMID
WHERE 
    INVENTSUM.POSTEDQTY > 0
    AND INVENTSUM.DATAAREAID = 'PRO'
    AND INVENTDIM.INVENTLOCATIONID = 'A-JUL/TELA'

    
SELECT TOP 1 * FROM TI_PRO.dbo.PRODTABLE JOIN INVENTDIM  ON PRODTABLE.INVENTDIMID = INVENTDIM.INVENTDIMID
WHERE PRODTABLE.ITEMID = 'JU-ENG-PI-C' AND INVENTDIM.INVENTBATCHID = '2611' AND INVENTDIM.INVENTSERIALID = 'S359' 



-->

@endsection
