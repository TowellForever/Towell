@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-black font-bold text-2xl mb-4">
        ÓRDENES PROGRAMADAS
    </h1>

    <table class="table border-4 border-gray-300">
        <thead class="bg-cyan-500 text-white text-center">
            <tr>
                <th colspan="5">ÓRDENES PROGRAMADAS</th>
            </tr>
        </thead>
        <tbody class="bg-white text-black">
            @foreach($ordenes as $dato) <!-- Cambié $datos a $ordenes -->
                <tr>
                    <td class="border p-2">
                        <b>Orden:</b> {{ $dato->Orden_Prod }} 
                        <br><b>Cuenta Rizo:</b> {{ $dato->Cuenta }}
                        <br><b>Trama 4:</b> {{ $dato->Trama_4 }} <!-- Corregido -->
                        <br><b>Artículo:</b> {{ $dato->Articulo }} <!-- Corregido -->
                        <br><b>Pedido:</b> {{ $dato->Tipo_Ped }}
                        <br><b>Fin:</b> {{ $dato->Fin_Tejido }}
                    </td>
                    <td class="border p-2">
                        <b>No Flog:</b> {{ $dato->Id_Flog }} 
                        <br><b>Cuenta Pie:</b> {{ $dato->Calibre_Pie }}
                        <br><b>Trama 5:</b> {{ $dato->Trama_5 }} <!-- Corregido -->
                        <br><b>Producido:</b> {{ $dato->Producido }} <!-- Corregido -->
                        <br><b>Fecha de Compromiso Tejido:</b> {{ $dato->Fecha_Compromiso }}
                    </td>
                    <td class="border p-2">
                        <b>Trama 1:</b> {{ $dato->Trama_1 }} <!-- Corregido -->
                        <br><b>Trama 6:</b> {{ $dato->Trama_6 }} <!-- Corregido -->
                        <br><b>Número de Tiras:</b> {{ $dato->Tiras }}
                        <br><b>Producción (KG)/Día:</b> {{ $dato->Prod_KG_Dia }} <!-- Corregido -->
                        <br><b>Fecha de Compromiso Cliente:</b> {{ $dato->Fecha_Compromiso1 }}
                    </td>
                    <td class="border p-2">
                        <b>Cliente:</b> {{ $dato->Cliente }} <!-- Corregido -->
                        <br><b>Trama 2:</b> {{ $dato->Trama_2 }} <!-- Corregido -->
                        <br><b>Trama 7:</b> {{ $dato->Trama_7 }} <!-- Corregido -->
                        <br><b>STD/Día:</b> {{ $dato->Std_Dia }} <!-- Corregido -->
                    </td>
                    <td class="border p-2">
                        <b>Trama 3:</b> {{ $dato->Trama_3 }} <!-- Corregido -->
                        <br><b>Trama 8:</b> {{ $dato->Trama_8 }} <!-- Corregido -->
                        <br><b>Inicio:</b> {{ $dato->Inicio_Tejido }}
                        <br><b>Entrega:</b> {{ $dato->Entrega }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
