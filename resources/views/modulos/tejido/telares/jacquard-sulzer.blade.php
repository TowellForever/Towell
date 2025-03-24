@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-black font-bold text-2xl mb-4">
        {{ str_replace('-', ' ', 'JACQUARD SULZER') }} - {{ $telar }}
    </h1>

    <table class="table border border-gray-800">
        <thead class="bg-cyan-500 text-white text-center">
            <tr>
                <th colspan="5">EN PROCESO</th>
            </tr>
        </thead>
        <tbody class="bg-white text-black">
            @foreach($datos as $dato)
                <tr>
                    <td class="border p-2">     
                        <b>Orden:</b> {{ $dato->Orden_Prod }} 
                        <br><b>Cuenta Rizo:</b> {{ $dato->Cuenta }}
                        <br><b>Trama 4:</b> {{ '$dato->' }}
                        <br><b>Artículo:</b> {{ '$dato->' }}
                        <br><b>Pedido:</b> {{ $dato->Tipo_Ped }}
                        <br><b>Fin:</b> {{ $dato->Fin_Tejido }}
                    </td>
                    <td class="border p-2">
                            <b>No Flog:</b> {{ $dato->Id_Flog }} 
                        <br><b>Cuenta Pie:</b> {{ $dato->Calibre_Pie }}
                        <br><b>Trama 5:</b> {{ '$dato->' }}
                        <br><b>Producido:</b> {{ '$dato->' }}
                        <br><b>Fecha de Compromiso Tejido:</b> {{ $dato->Fecha_Compromiso }}
                    </td>
                    <td class="border p-2">
                            <b>Trama 1:</b> {{ '$dato->' }} 
                        <br><b>Trama 6:</b> {{ '$dato->' }}
                        <br><b>Número de Tiras:</b> {{ $dato->Tiras }}
                        <br><b>Producción (KG)/Día:</b> {{ '$dato->Prod_(KG)Día ACENTO' }}
                        <br><b>Fecha de Compromiso Cliente:</b> {{ $dato->Fecha_Compromiso1}}

                    </td>
                    <td class="border p-2">
                            <b>Cliente:</b> {{ '$dato->' }} 
                        <br><b>Trama 2:</b> {{ '$dato->' }}
                        <br><b>Trama 7:</b> {{ '$dato->' }}
                        <br><b>STD/Día:</b> {{ '$dato->Std/Dia Undefined property' }}

                    </td>
                    <td class="border p-2">
                            <b>Trama 3:</b> {{ '$dato->' }} 
                        <br><b>Trama 8:</b> {{ '$dato->' }}
                        <br><b>Inicio:</b> {{ $dato->Inicio_Tejido }}
                        <br><b>Entrega:</b> {{ $dato->Entrega }}

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table">
        <thead class="bg-cyan-500 text-white">
            <tr>
                <th class="text-center">REQUERIMIENTO</th>
            </tr>
        </thead>
        <tbody class="bg-white text-black">
            <tr>
                <td class="border p-2">
                    <div class="flex">
                        <div class="flex">
                            <div class="mr-4">
                                <b>Tipo: </b><b> {{ 'RIZO o PIE' }} </b>
                                <br><b>Cuenta:</b> {{ $dato->Cuenta }}
                            </div>
                            <div class="mr-4" >
                                <b>Fecha:</b> {{ '$dato->Fecha' }}
                                <br><b>Turno:</b> {{ $dato->Tipo_Ped }}
                                <br><b>Metros:</b> <p class="ml-20 mb-3"><b>7000 mts</b> <br><b>2500 mts</b></p>
                            </div>
                        </div>                        
                
                        <!-- Tabla a la derecha -->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">Fecha: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                         <!-- Tabla a la derecha -->
                         <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">Fecha: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                         <!-- Tabla a la derecha -->
                         <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">Fecha: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox"> </label><br>
                                            <label><input type="checkbox"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">JULIO RESERVADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                    </td>                           
                                </tr>
                                <tr>
                                    <td class="border text-center">
                                    </td>                             
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </td>
            </tr>
        </tbody>
    </table>
 <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>    <!--TABLA DE ÓRDENES PROGRAMADAS (3 cuerpos)-->
    <table class="table border-4 border-gray-300">
        <thead class="bg-cyan-500 text-white text-center">
            <tr>
                <th colspan="5">ÓRDENES PROGRAMADAS</th>
            </tr>
        </thead>
        <tbody class="bg-white text-black">
            @foreach($datos as $dato)
                <tr>
                    <td class="border p-2">     
                        <b>Orden:</b> {{ $dato->Orden_Prod }} 
                        <br><b>Cuenta Rizo:</b> {{ $dato->Cuenta }}
                        <br><b>Trama 4:</b> {{ '$dato->' }}
                        <br><b>Artículo:</b> {{ '$dato->' }}
                        <br><b>Pedido:</b> {{ $dato->Tipo_Ped }}
                        <br><b>Fin:</b> {{ $dato->Fin_Tejido }}
                    </td>
                    <td class="border p-2">
                            <b>No Flog:</b> {{ $dato->Id_Flog }} 
                        <br><b>Cuenta Pie:</b> {{ $dato->Calibre_Pie }}
                        <br><b>Trama 5:</b> {{ '$dato->' }}
                        <br><b>Producido:</b> {{ '$dato->' }}
                        <br><b>Fecha de Compromiso Tejido:</b> {{ $dato->Fecha_Compromiso }}
                    </td>
                    <td class="border p-2">
                            <b>Trama 1:</b> {{ '$dato->' }} 
                        <br><b>Trama 6:</b> {{ '$dato->' }}
                        <br><b>Número de Tiras:</b> {{ $dato->Tiras }}
                        <br><b>Producción (KG)/Día:</b> {{ '$dato->Prod_(KG)Día ACENTO' }}
                        <br><b>Fecha de Compromiso Cliente:</b> {{ $dato->Fecha_Compromiso1}}

                    </td>
                    <td class="border p-2">
                            <b>Cliente:</b> {{ '$dato->' }} 
                        <br><b>Trama 2:</b> {{ '$dato->' }}
                        <br><b>Trama 7:</b> {{ '$dato->' }}
                        <br><b>STD/Día:</b> {{ '$dato->Std/Dia Undefined property' }}

                    </td>
                    <td class="border p-2">
                            <b>Trama 3:</b> {{ '$dato->' }} 
                        <br><b>Trama 8:</b> {{ '$dato->' }}
                        <br><b>Inicio:</b> {{ $dato->Inicio_Tejido }}
                        <br><b>Entrega:</b> {{ $dato->Entrega }}

                    </td>

                </tr>
            @endforeach
        </tbody>
        <tbody class="bg-white text-black">
            @foreach($datos as $dato)
                <tr>
                    <td class="border p-2">     
                        <b>Orden:</b> {{ $dato->Orden_Prod }} 
                        <br><b>Cuenta Rizo:</b> {{ $dato->Cuenta }}
                        <br><b>Trama 4:</b> {{ '$dato->' }}
                        <br><b>Artículo:</b> {{ '$dato->' }}
                        <br><b>Pedido:</b> {{ $dato->Tipo_Ped }}
                        <br><b>Fin:</b> {{ $dato->Fin_Tejido }}
                    </td>
                    <td class="border p-2">
                            <b>No Flog:</b> {{ $dato->Id_Flog }} 
                        <br><b>Cuenta Pie:</b> {{ $dato->Calibre_Pie }}
                        <br><b>Trama 5:</b> {{ '$dato->' }}
                        <br><b>Producido:</b> {{ '$dato->' }}
                        <br><b>Fecha de Compromiso Tejido:</b> {{ $dato->Fecha_Compromiso }}
                    </td>
                    <td class="border p-2">
                            <b>Trama 1:</b> {{ '$dato->' }} 
                        <br><b>Trama 6:</b> {{ '$dato->' }}
                        <br><b>Número de Tiras:</b> {{ $dato->Tiras }}
                        <br><b>Producción (KG)/Día:</b> {{ '$dato->Prod_(KG)Día ACENTO' }}
                        <br><b>Fecha de Compromiso Cliente:</b> {{ $dato->Fecha_Compromiso1}}

                    </td>
                    <td class="border p-2">
                            <b>Cliente:</b> {{ '$dato->' }} 
                        <br><b>Trama 2:</b> {{ '$dato->' }}
                        <br><b>Trama 7:</b> {{ '$dato->' }}
                        <br><b>STD/Día:</b> {{ '$dato->Std/Dia Undefined property' }}

                    </td>
                    <td class="border p-2">
                            <b>Trama 3:</b> {{ '$dato->' }} 
                        <br><b>Trama 8:</b> {{ '$dato->' }}
                        <br><b>Inicio:</b> {{ $dato->Inicio_Tejido }}
                        <br><b>Entrega:</b> {{ $dato->Entrega }}

                    </td>

                </tr>
            @endforeach
        </tbody>
        <tbody class="bg-white text-black">
            @foreach($datos as $dato)
                <tr>         
                    <td class="border p-2">     
                        <b>Orden:</b> {{ $dato->Orden_Prod }} 
                        <br><b>Cuenta Rizo:</b> {{ $dato->Cuenta }}
                        <br><b>Trama 4:</b> {{ '$dato->' }}
                        <br><b>Artículo:</b> {{ '$dato->' }}
                        <br><b>Pedido:</b> {{ $dato->Tipo_Ped }}
                        <br><b>Fin:</b> {{ $dato->Fin_Tejido }}
                    </td>
                    <td class="border p-2">
                            <b>No Flog:</b> {{ $dato->Id_Flog }} 
                        <br><b>Cuenta Pie:</b> {{ $dato->Calibre_Pie }}
                        <br><b>Trama 5:</b> {{ '$dato->' }}
                        <br><b>Producido:</b> {{ '$dato->' }}
                        <br><b>Fecha de Compromiso Tejido:</b> {{ $dato->Fecha_Compromiso }}
                    </td>
                    <td class="border p-2">
                            <b>Trama 1:</b> {{ '$dato->' }} 
                        <br><b>Trama 6:</b> {{ '$dato->' }}
                        <br><b>Número de Tiras:</b> {{ $dato->Tiras }}
                        <br><b>Producción (KG)/Día:</b> {{ '$dato->Prod_(KG)Día ACENTO' }}
                        <br><b>Fecha de Compromiso Cliente:</b> {{ $dato->Fecha_Compromiso1}}

                    </td>
                    <td class="border p-2">
                            <b>Cliente:</b> {{ '$dato->' }} 
                        <br><b>Trama 2:</b> {{ '$dato->' }}
                        <br><b>Trama 7:</b> {{ '$dato->' }}
                        <br><b>STD/Día:</b> {{ '$dato->Std/Dia Undefined property' }}

                    </td>
                    <td class="border p-2">
                            <b>Trama 3:</b> {{ '$dato->' }} 
                        <br><b>Trama 8:</b> {{ '$dato->' }}
                        <br><b>Inicio:</b> {{ $dato->Inicio_Tejido }}
                        <br><b>Entrega:</b> {{ $dato->Entrega }}

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
