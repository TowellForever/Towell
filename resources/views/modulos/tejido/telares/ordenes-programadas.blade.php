@extends('layouts.app')

@section('content')
    <div class="container container mx-auto overflow-y-auto" style="max-height: calc(100vh - 120px);">
        <h1 class="text-center text-black font-bold text-2xl mb-4">
            ÓRDENES PROGRAMADAS (Telar: {{ $telar }})
        </h1>

        <table class="table border-4 border-gray-300 w-full">
            <thead class="bg-cyan-500 text-white text-center">
                <tr>
                    <th colspan="5">ÓRDENES PROGRAMADAS</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @foreach ($ordenes as $dato)
                    <tr>
                        <td class="border p-2">
                            <b>Orden:</b> {{ $dato->Orden_Prod }}
                            <br><b>Cuenta Rizo:</b> {{ $dato->Cuenta }}
                            <br><b>Trama 4:</b> {{ number_format($dato->CALIBRE_C3, 2) }}
                            <br><b>Artículo:</b> {{ $dato->Articulo }}
                            <br><b>Pedido:</b> {{ $dato->Tipo_Ped }}
                            <br><b>Fin:</b> {{ \Carbon\Carbon::parse($dato->Fin_Tejido)->format('d/m/Y') }}
                        </td>
                        <td class="border p-2">
                            <b>No Flog:</b> {{ $dato->Id_Flog }}
                            <br><b>Cuenta Pie:</b> {{ $dato->Calibre_Pie }}
                            <br><b>Trama 5:</b> {{ number_format($dato->CALIBRE_C4, 2) }}
                            <br><b>Producido:</b> {{ $dato->Producido }}
                            <br><b>Fecha de Compromiso Tejido:</b>
                            {{ \Carbon\Carbon::parse($dato->Fecha_Compromiso)->format('d/m/Y') }}
                        </td>
                        <td class="border p-2">
                            <b>Trama 1:</b> {{ number_format($dato->CALIBRE_TRA, 2) }}
                            <br><b>Trama 6:</b> {{ number_format($dato->CALIBRE_C5, 2) }}
                            <br><b>Número de Tiras:</b> {{ $dato->Tiras }}
                            <br><b>Producción (KG)/Día:</b> {{ $dato->Prod_KG_Dia }}
                            <br><b>Fecha de Compromiso Cliente:</b>
                            {{ \Carbon\Carbon::parse($dato->Fecha_Compromiso1)->format('d/m/Y') }}
                        </td>
                        <td class="border p-2">
                            <b>Cliente:</b> {{ $dato->Cliente }}
                            <br><b>Trama 2:</b> {{ number_format($dato->CALIBRE_C1, 2) }}
                            <br><b>Trama 7:</b> {{ $dato->Trama_7 }}
                            <br><b>STD/Día:</b> {{ $dato->Std_Dia }}
                        </td>
                        <td class="border p-2">
                            <b>Trama 3:</b> {{ $dato->Trama_3 }}
                            <br><b>Trama 8:</b> {{ $dato->Trama_8 }}
                            <br><b>Inicio:</b> {{ \Carbon\Carbon::parse($dato->Inicio_Tejido)->format('d/m/Y') }}
                            <br><b>Entrega:</b> {{ \Carbon\Carbon::parse($dato->Entrega)->format('d/m/Y') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
