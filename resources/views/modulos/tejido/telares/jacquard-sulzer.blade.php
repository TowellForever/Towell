@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-black font-bold text-2xl mb-4">
        {{ str_replace('-', ' ', 'JACQUARD SULZER') }} - {{ $telar }}
    </h1>

    <table class="table border-0">
        <thead class="bg-cyan-500 text-white text-center">
            <tr>
                <th colspan="5">EN PROCESO</th>
            </tr>
        </thead>
        <tbody class="bg-white text-black">
            @foreach($datos as $dato)
                <tr>
                    <td class=" p-2">     
                        <b>Orden:</b> {{ $dato->Orden_Prod }} 
                        <br><b>Cuenta Rizo:</b> {{ $dato->Cuenta }}
                        <br><b>Trama 4:</b> {{ number_format($dato->CALIBRE_C3, 2) }}
                        <br><b>Artículo:</b> {{ $dato->Nombre_Producto }}
                        <br><b>Pedido:</b> {{ $dato->Tipo_Ped }}
                        <br><b>Fin:</b> {{ \Carbon\Carbon::parse($dato->Fin_Tejido)->format('d/m/Y') }}
                    </td>
                    <td class=" p-2">
                            <b>No Flog:</b> {{ $dato->Id_Flog }} 
                        <br><b>Cuenta Pie:</b> {{ $dato->Calibre_Pie }}
                        <br><b>Trama 5:</b> {{ number_format($dato->CALIBRE_C4, 2) }}
                        <br>
                        <br><b>Producido:</b> {{ '---' }}
                        <br><b>Fecha de Compromiso Tejido:</b> {{ \Carbon\Carbon::parse($dato->Fecha_Compromiso)->format('d/m/Y') }}
                    </td>
                    <td class=" p-2">
                        <br>
                        <b>Trama 1:</b> {{ number_format($dato->CALIBRE_TRA, 2) }}
                        <br><b>Trama 6:</b> {{ number_format($dato->CALIBRE_C5 , 2) }}
                        <br><b>Número de Tiras:</b> {{ $dato->Tiras }}
                        <br><b>Producción (KG)/Día:</b> {{ '$dato->' }}
                        <br><b>Fecha de Compromiso Cliente:</b> {{ \Carbon\Carbon::parse($dato->Fecha_Compromiso1)->format('d/m/Y') }}
                    </td>
                    <td class=" p-2">
                            <b>Cliente:</b> {{ '$dato->' }} 
                        <br><b>Trama 2:</b> {{ number_format($dato->CALIBRE_C1 , 2) }}
                        <br><b>Trama 7:</b> {{ '-' }}
                        <br>
                        <br><b>STD/Día:</b> {{ '$dato->Std/Dia ' }}

                    </td>
                    <td class=" p-2">
                            <br>
                            <b>Trama 3:</b> {{ number_format($dato->CALIBRE_C2 , 2) }}
                        <br><b>Trama 8:</b> {{ '-' }}
                        <br>
                        <br><b>Inicio:</b> {{ \Carbon\Carbon::parse($dato->Inicio_Tejido)->format('d/m/Y') }}
                        <br><b>Entrega:</b> {{ \Carbon\Carbon::parse($dato->Entrega)->format('d/m/Y') }}

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
                                <b>Tipo: </b> {{ 'RIZO o PIE' }} 
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
                        <div class="ml-20 mt-6 flex-col space-y-2">
                            <a href="#"><button class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">GUARDAR</button></a>
                            <a href="#"><button href class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700 mt-1">PROGRAMAR</button></a>
                        </div>
                           
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="flex justify-center mt-6 w-80">
        <a href=""><button class="bg-blue-800 text-white font-bold py-2 px-6 rounded hover:bg-blue-900">
            Órdenes Programadas
        </button></a>
    </div>

</div>
@endsection
