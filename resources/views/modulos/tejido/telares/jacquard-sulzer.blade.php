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

    <!--TABLA REQUERIMIENTO **********************************************************************************************************************************************-->
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
                                <b>Tipo: 
                                    <br>RIZO  {{ 'GETTING' }}
                                    <br>PIE   {{ 'GETTING' }}
                                </b> 
                                <br><b>Cuenta PIE:</b> <label id="cuenta-pie" >{{ $dato->Cuenta }}</label>
                                <br><b>Cuenta RIZO:</b> <label id="cuenta-rizo"> {{ $dato->Cuenta }}</label>                                                          
                            </div>
                            <div class="mr-4" >
                                <b>Fecha:</b> {{ 'GETTING' }}
                                <br><b>Turno:</b> {{ 'GETTING' }}
                                <br><b>Metros:</b> <input type="text" id="metros" class="border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>                        
                
                        <!-- Tabla a la derecha 1-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_A1" id="ck_A1"> </label><br>
                                            <label><input type="checkbox" name="ck_A2" id="ck_A2"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_A3" id="ck_A3"> </label><br>
                                            <label><input type="checkbox" name="ck_A4" id="ck_A4"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_A5" id="ck_A5"> </label><br>
                                            <label><input type="checkbox" name="ck_A6" id="ck_A6"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                         <!-- Tabla a la derecha 2-->
                         <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">{{ \Carbon\Carbon::tomorrow()->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_B1"> </label><br>
                                            <label><input type="checkbox" name="ck_B2"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_B3"> </label><br>
                                            <label><input type="checkbox" name="ck_B4"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_B5"> </label><br>
                                            <label><input type="checkbox" name="ck_B6"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                         <!-- Tabla a la derecha 3-->
                         <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">{{ \Carbon\Carbon::now()->addDays(2)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_C1"> </label><br>
                                            <label><input type="checkbox" name="ck_C2"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_C3"> </label><br>
                                            <label><input type="checkbox" name="ck_C4"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_C5"> </label><br>
                                            <label><input type="checkbox" name="ck_C6"> </label>
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
                                    <td class="border text-center"><input type="text" id="julio_reserv" class="border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>                           
                                </tr>
                                <tr>
                                    <td class="border text-center">
                                    </td>                             
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tabla a la derecha 4-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">{{ \Carbon\Carbon::now()->addDays(3)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center"> 
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_D1"> </label><br>
                                            <label><input type="checkbox" name="ck_D2" > </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_D3"> </label><br>
                                            <label><input type="checkbox" name="ck_D4"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_D5"> </label><br>
                                            <label><input type="checkbox" name="ck_D6"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tabla a la derecha 5-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">{{ \Carbon\Carbon::now()->addDays(4)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_E1"> </label><br>
                                            <label><input type="checkbox" name="ck_E2"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_E3"> </label><br>
                                            <label><input type="checkbox" name="ck_E4"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_E5"> </label><br>
                                            <label><input type="checkbox" name="ck_E6"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tabla a la derecha 6-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">{{ \Carbon\Carbon::now()->addDays(5)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_F1"> </label><br>
                                            <label><input type="checkbox" name="ck_F2"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_F3"> </label><br>
                                            <label><input type="checkbox" name="ck_F4"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_F5"> </label><br>
                                            <label><input type="checkbox" name="ck_F6"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tabla a la derecha 7-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border">{{ \Carbon\Carbon::now()->addDays(6)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_G1"> </label><br>
                                            <label><input type="checkbox" name="ck_G2"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_G3"> </label><br>
                                            <label><input type="checkbox" name="ck_G4"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="ck_G5"> </label><br>
                                            <label><input type="checkbox" name="ck_G6"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // Obtener la fila donde se marcó el checkbox
                    let fila = this.closest('tr');
                    let julioR = String(document.getElementById('julio_reserv').value);
                            // Asumiendo que $datos es un array de objetos y tienes múltiples valores de "Cuenta"
                            let datos1 = @json($datos); // Convertimos el objeto PHP $datos en un array de JavaScript
                            // Ejemplo: acceder a "Cuenta" de un elemento específico, por ejemplo el primero
                            let cuentaRizo = datos1[0].Cuenta; // Accede al primer objeto y luego su propiedad Orden_Prod

                            // Asumiendo que $datos es un array de objetos y tienes múltiples valores de "Calibre_Pie"
                            let datos2 = @json($datos); // Convertimos el objeto PHP $datos en un array de JavaScript
                            // Ejemplo: acceder a "Orden_Prod" de un elemento específico, por ejemplo el primero
                            let cuentaPie = datos2[0].Calibre_Pie; // Accede al primer objeto y luego su propiedad Calibre_Pie

                            // Asumiendo que $datos es un array de objetos y tienes múltiples valores de "Orden_Prod"
                            let datos = @json($datos); // Convertimos el objeto PHP $datos en un array de JavaScript
                            // Ejemplo: acceder a "Orden_Prod" de un elemento específico, por ejemplo el primero
                            let ordenProd = datos[0].Orden_Prod; // Accede al primer objeto y luego su propiedad Orden_Prod

                    // Obtener la fecha y el turno de la tabla correspondiente
                    let fecha = this.closest('table').querySelector('th').innerText.replace('Fecha: ', '');
                    let turno = this.closest('td').querySelector('.font-bold').innerText.trim();
                    
                    // Obtener el valor de los metros
                    let metros = document.getElementById('metros').value;

                    // Obtener el estado de los checkboxes
                    let ck_A1 = document.getElementsByName('ck_A1')[0]?.checked ? 1 : 0;
                    let ck_A2 = document.getElementsByName('ck_A2')[0]?.checked ? 1 : 0;
                    let ck_A3 = document.getElementsByName('ck_A3')[0]?.checked ? 1 : 0;
                    let ck_A4 = document.getElementsByName('ck_A4')[0]?.checked ? 1 : 0;
                    let ck_A5 = document.getElementsByName('ck_A5')[0]?.checked ? 1 : 0;
                    let ck_A6 = document.getElementsByName('ck_A6')[0]?.checked ? 1 : 0;
                    let ck_B1 = document.getElementsByName('ck_B1')[0]?.checked ? 1 : 0;
                    let ck_B2 = document.getElementsByName('ck_B2')[0]?.checked ? 1 : 0;
                    let ck_B3 = document.getElementsByName('ck_B3')[0]?.checked ? 1 : 0;
                    let ck_B4 = document.getElementsByName('ck_B4')[0]?.checked ? 1 : 0;
                    let ck_B5 = document.getElementsByName('ck_B5')[0]?.checked ? 1 : 0;
                    let ck_B6 = document.getElementsByName('ck_B6')[0]?.checked ? 1 : 0;
                    let ck_C1 = document.getElementsByName('ck_C1')[0]?.checked ? 1 : 0;
                    let ck_C2 = document.getElementsByName('ck_C2')[0]?.checked ? 1 : 0;
                    let ck_C3 = document.getElementsByName('ck_C3')[0]?.checked ? 1 : 0;
                    let ck_C4 = document.getElementsByName('ck_C4')[0]?.checked ? 1 : 0;
                    let ck_C5 = document.getElementsByName('ck_C5')[0]?.checked ? 1 : 0;
                    let ck_C6 = document.getElementsByName('ck_C6')[0]?.checked ? 1 : 0;
                    let ck_D1 = document.getElementsByName('ck_D1')[0]?.checked ? 1 : 0;
                    let ck_D2 = document.getElementsByName('ck_D2')[0]?.checked ? 1 : 0;
                    let ck_D3 = document.getElementsByName('ck_D3')[0]?.checked ? 1 : 0;
                    let ck_D4 = document.getElementsByName('ck_D4')[0]?.checked ? 1 : 0;
                    let ck_D5 = document.getElementsByName('ck_D5')[0]?.checked ? 1 : 0;
                    let ck_D6 = document.getElementsByName('ck_D6')[0]?.checked ? 1 : 0;
                    let ck_E1 = document.getElementsByName('ck_E1')[0]?.checked ? 1 : 0;
                    let ck_E2 = document.getElementsByName('ck_E2')[0]?.checked ? 1 : 0;
                    let ck_E3 = document.getElementsByName('ck_E3')[0]?.checked ? 1 : 0;
                    let ck_E4 = document.getElementsByName('ck_E4')[0]?.checked ? 1 : 0;
                    let ck_E5 = document.getElementsByName('ck_E5')[0]?.checked ? 1 : 0;
                    let ck_E6 = document.getElementsByName('ck_E6')[0]?.checked ? 1 : 0;
                    let ck_F1 = document.getElementsByName('ck_F1')[0]?.checked ? 1 : 0;
                    let ck_F2 = document.getElementsByName('ck_F2')[0]?.checked ? 1 : 0;
                    let ck_F3 = document.getElementsByName('ck_F3')[0]?.checked ? 1 : 0;
                    let ck_F4 = document.getElementsByName('ck_F4')[0]?.checked ? 1 : 0;
                    let ck_F5 = document.getElementsByName('ck_F5')[0]?.checked ? 1 : 0;
                    let ck_F6 = document.getElementsByName('ck_F6')[0]?.checked ? 1 : 0;
                    let ck_G1 = document.getElementsByName('ck_G1')[0]?.checked ? 1 : 0;
                    let ck_G2 = document.getElementsByName('ck_G2')[0]?.checked ? 1 : 0;
                    let ck_G3 = document.getElementsByName('ck_G3')[0]?.checked ? 1 : 0;
                    let ck_G4 = document.getElementsByName('ck_G4')[0]?.checked ? 1 : 0;
                    let ck_G5 = document.getElementsByName('ck_G5')[0]?.checked ? 1 : 0;
                    let ck_G6 = document.getElementsByName('ck_G6')[0]?.checked ? 1 : 0;
    
                    // Realizar la solicitud POST con Axios
                    axios.post('/guardar-requerimiento', {
                        cuenta_rizo: cuentaRizo,
                        cuenta_pie: cuentaPie,
                        fecha: fecha,
                        turno: turno,
                        metros: metros,
                        julio_reserv: julioR,
                        orden_prod: ordenProd, // Aquí envías el valor a tu backend
                        ck_A1,
                        ck_A2,
                        ck_A3,
                        ck_A4,
                        ck_A5,
                        ck_A6,
                        ck_B1,
                        ck_B2,
                        ck_B3,
                        ck_B4,
                        ck_B5,
                        ck_B6,
                        ck_C1,
                        ck_C2,
                        ck_C3,
                        ck_C4,
                        ck_C5,
                        ck_C6,
                        ck_D1,
                        ck_D2,
                        ck_D3,
                        ck_D4,
                        ck_D5,
                        ck_D6,
                        ck_E1,
                        ck_E2,
                        ck_E3,
                        ck_E4,
                        ck_E5,
                        ck_E6,
                        ck_F1,
                        ck_F2,
                        ck_F3,
                        ck_F4,
                        ck_F5,
                        ck_F6,
                        ck_G1,
                        ck_G2,
                        ck_G3,
                        ck_G4,
                        ck_G5,
                        ck_G6
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        console.log(response.data.message); // Puedes mostrar algún mensaje o notificación

                        // Reiniciar todos los checkboxes a 0 después de enviar los datos
                        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                            checkbox.checked = false;
                        });

                    })
                    .catch(error => {
                        console.error('Error:', error.response ? error.response.data : error.message);
                    });
                }
            });
        });
    });
</script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Definir los grupos de checkboxes por su atributo name
            const grupos = {
                grupo1: [
                    "ck_A1", "ck_A3", "ck_A5", "ck_B1", "ck_B3", "ck_B5",
                    "ck_C1", "ck_C3", "ck_C5", "ck_D1", "ck_D3", "ck_D5",
                    "ck_E1", "ck_E3", "ck_E5", "ck_F1", "ck_F3", "ck_F5",
                    "ck_G1", "ck_G3", "ck_G5"
                ],
                grupo2: [
                    "ck_A2", "ck_A4", "ck_A6", "ck_B2", "ck_B4", "ck_B6",
                    "ck_C2", "ck_C4", "ck_C6", "ck_D2", "ck_D4", "ck_D6",
                    "ck_E2", "ck_E4", "ck_E6", "ck_F2", "ck_F4", "ck_F6",
                    "ck_G2", "ck_G4", "ck_G6"
                ]
            };

            // Función para manejar la selección de checkboxes dentro de un grupo
            function manejarGrupo(grupo, checkboxSeleccionado) {
                grupo.forEach(name => {
                    const checkboxesGrupo = document.querySelectorAll(`input[name="${name}"]`);
                    checkboxesGrupo.forEach(cb => {
                        if (cb !== checkboxSeleccionado) {
                            cb.checked = false;
                        }
                    });
                });
            }

            // Obtener todos los checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function () {
                    if (this.checked) {
                        // Verificar en qué grupo está y deseleccionar los demás
                        for (const key in grupos) {
                            if (grupos[key].includes(this.name)) {
                                manejarGrupo(grupos[key], this);
                            }
                        }
                    }
                });
            });
        });
    </script>



@endsection
