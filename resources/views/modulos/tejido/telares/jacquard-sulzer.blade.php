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
                        <br><b>Producido:</b> {{ '---' }}
                        <br>
                        <br><b>Fecha de Compromiso Tejido:</b> {{ \Carbon\Carbon::parse($dato->Fecha_Compromiso)->format('d/m/Y') }}
                    </td>
                    <td class=" p-2">
                        <b>Trama 1:</b> {{ number_format($dato->CALIBRE_TRA, 2) }}
                        <br><b>Trama 6:</b> {{ number_format($dato->CALIBRE_C5 , 2) }}
                        <br><b>Número de Tiras:</b> {{ $dato->Tiras }}
                        <br><b>Producción (KG)/Día:</b> {{ '$dato->' }}
                        <br>
                        <br><b>Fecha de Compromiso Cliente:</b> {{ \Carbon\Carbon::parse($dato->Fecha_Compromiso1)->format('d/m/Y') }}
                    </td>
                    <td class=" p-2">
                            <b>Cliente:</b> {{ '$dato->' }} 
                        <br><b>Trama 2:</b> {{ number_format($dato->CALIBRE_C1 , 2) }}
                        <br><b>Trama 7:</b> {{ '-' }}
                        <br>
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
                                <b><br><br>Tipo: &nbsp;&nbsp;&nbsp;
                                </b> 
                                <b>Cuenta:</b>
                                <br><b>RIZO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b><label id="cuenta-rizo"> {{ $dato->Cuenta }}</label>  
                                <br><b>PIE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b> <label id="cuenta-pie" >{{ $dato->Calibre_Pie }}</label>                                                      
                            </div>
                            <div class="mr-4" >
                                <b id="fecha">Fecha:</b> 
                                <br><b>Turno:</b> {{ '' }}
                                <br><b>Metros:</b> <br><input type="text" id="metros" class="border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <br><input type="text" id="metros_pie" class="border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>                        
                
                        <!-- Tabla a la derecha 1-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border fecha-tabla">{{ \Carbon\Carbon::now()->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo1" class="t1rizo" value="rizo1"> </label><br>
                                            <label><input type="checkbox" name="pie1" class="t1pie" value="pie1"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo2" class="t1rizo" value="rizo2"> </label><br>
                                            <label><input type="checkbox" name="pie2" class="t1pie" value="pie2"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo3" class="t1rizo" value="rizo3"> </label><br>
                                            <label><input type="checkbox" name="pie3" class="t1pie" value="pie3"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                         <!-- Tabla a la derecha 2-->
                         <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border fecha-tabla">{{ \Carbon\Carbon::tomorrow()->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo1" class="t2rizo" value="rizo1"> </label><br>
                                            <label><input type="checkbox" name="pie1" class="t2pie" value="pie1"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo2" class="t2rizo" value="rizo2"> </label><br>
                                            <label><input type="checkbox" name="pie2" class="t2pie" value="pie2"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo3" class="t2rizo" value="rizo3"> </label><br>
                                            <label><input type="checkbox" name="pie3" class="t2pie" value="pie3"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                         <!-- Tabla a la derecha 3-->
                         <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border fecha-tabla">{{ \Carbon\Carbon::now()->addDays(2)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo1" class="t3rizo" value="rizo1"> </label><br>
                                            <label><input type="checkbox" name="pie1" class="t3pie" value="pie1"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo2" class="t3rizo" value="rizo2"> </label><br>
                                            <label><input type="checkbox" name="pie2" class="t3pie" value="pie2"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo3" class="t3rizo" value="rizo3"> </label><br>
                                            <label><input type="checkbox" name="pie3" class="t3pie" value="pie3"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tabla a la derecha 4-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border fecha-tabla">{{ \Carbon\Carbon::now()->addDays(3)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center"> 
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo1" class="t4rizo" value="rizo1"> </label><br>
                                            <label><input type="checkbox" name="pie1" class="t4pie" value="pie1" > </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo2" class="t4rizo" value="rizo2"> </label><br>
                                            <label><input type="checkbox" name="pie2" class="t4pie" value="pie2"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo3" class="t4rizo" value="rizo3"> </label><br>
                                            <label><input type="checkbox" name="pie3" class="t4pie" value="pie3"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tabla a la derecha 5-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border fecha-tabla">{{ \Carbon\Carbon::now()->addDays(4)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo1" class="t5rizo" value="rizo1"> </label><br>
                                            <label><input type="checkbox" name="pie1" class="t5pie" value="pie1"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo2" class="t5rizo" value="rizo2"> </label><br>
                                            <label><input type="checkbox" name="pie2" class="t5pie" value="pie2"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo3" class="t5rizo" value="rizo3"> </label><br>
                                            <label><input type="checkbox" name="pie3" class="t5pie" value="pie3"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tabla a la derecha 6-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border fecha-tabla">{{ \Carbon\Carbon::now()->addDays(5)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo1" class="t6rizo" value="rizo1"> </label><br>
                                            <label><input type="checkbox" name="pie1" class="t6pie" value="pie1"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo2" class="t6rizo" value="rizo2"> </label><br>
                                            <label><input type="checkbox" name="pie2" class="t6pie" value="pie2"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo3" class="t6rizo" value="rizo3"> </label><br>
                                            <label><input type="checkbox" name="pie3" class="t6pie" value="pie3"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>

                        <!-- Tabla a la derecha 7-->
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="3" class="text-center border fecha-tabla">{{ \Carbon\Carbon::now()->addDays(6)->format('d-m-Y') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center">
                                        <div class=" font-bold">1</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo1" class="t7rizo" value="rizo1"> </label><br>
                                            <label><input type="checkbox" name="pie1" class="t7pie" value="pie1"> </label>
                                        </div>
                                    </td>                                    
                                    <td class="border text-center">
                                        <div class=" font-bold">2</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo2" class="t7rizo" value="rizo2"> </label><br>
                                            <label><input type="checkbox" name="pie2" class="t7pie" value="pie2"> </label>
                                        </div>
                                    </td>  
                                    <td class="border text-center">
                                        <div class=" font-bold">3</div>
                                        <div class="mt-2">
                                            <label><input type="checkbox" name="rizo3" class="t7rizo" value="rizo3"> </label><br>
                                            <label><input type="checkbox" name="pie3" class="t7pie" value="pie3"> </label>
                                        </div>
                                    </td>  
                                </tr>
                            </tbody>
                        </table>
                        <table class="ml-4 border-2">
                            <thead>
                                <tr>
                                    <th colspan="1" class="text-center border">JULIO RESERVADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border text-center w-40">
                                        <br><input type="text" id="julio_reserv" class="border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <input type="text" id="julio_reserv_pie" class="border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            let fila = this.closest('tr');
            let fecha = fila.closest('table').querySelector('th').innerText.replace('Fecha: ', '');
            let valorCheckbox = this.value; // Captura el valor del checkbox
            let metros = document.getElementById('metros').value;
            let julioR = String(document.getElementById('julio_reserv').value);
            let metros_pie = document.getElementById('metros_pie').value;
            let julioR_pie = String(document.getElementById('julio_reserv_pie').value);
            let valorCheckbox2 = this.value; // Captura el valor del checkbox
            let rizo = 0; // Inicializamos la variable rizo
            let pie = 0;  // Inicializamos la variable pie

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
                             let telar = @json($telar);

            //detectamos que fue marcado, RIZO o PIE
            // Condicional para incrementar rizo o pie dependiendo del valor del checkbox
            if (valorCheckbox2.startsWith('rizo')) {
                rizo = 1; // Si el valor comienza con 'rizo', se suma 1 a rizo
            } else if (valorCheckbox2.startsWith('pie')) {
                pie = 1; // Si el valor comienza con 'pie', se suma 1 a pie
            }

            axios.post('/guardar-requerimiento', {
                cuenta_rizo: cuentaRizo,
                cuenta_pie: cuentaPie,
                fecha: fecha,
                metros: metros,
                julio_reserv: julioR,
                metros_pie: metros_pie,
                julio_reserv_pie: julioR_pie,
                orden_prod: ordenProd,
                valor: valorCheckbox, // Enviamos el valor del checkbox al backend
                rizo,
                pie,
                telar
            }, {
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
            })
            .then(response => {
                console.log(response.data.message);
                location.reload(); // Recargar la página automáticamente
                // Desmarcar checkboxes anteriores
                document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
                    if (cb !== checkbox) cb.checked = false;
                });

            })
            .catch(error => {
                console.error('Error:', error.response ? error.response.data : error.message);
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Obtener el número de telar de la vista
        let telar = @json($telar); // Asegúrate de que esta variable sea el número de telar correcto en la vista
        
        axios.get('/ultimos-requerimientos')
            .then(response => {
                let requerimientos = response.data;
                let fechasTablas = document.querySelectorAll('th.fecha-tabla');
                let fechaServidor = '';
    
                // Limpiar todos los checkboxes antes de marcar los correctos
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false;
                });
    
                // Procesar los requerimientos
                requerimientos.forEach(req => {
                    // Filtramos por telar
                    if (req.telar !== telar) {
                        return; // Si el telar no coincide, lo ignoramos
                    }
    
                    // Si el requerimiento coincide con el telar, se procesan los datos
                    if (req.cuenta_rizo) {
                        document.getElementById('cuenta-rizo').innerText = req.cuenta_rizo;
                    }
                    if (req.cuenta_pie) {
                        document.getElementById('cuenta-pie').innerText = req.cuenta_pie;
                    }
                    if (req.fecha_hora_creacion) {
                        let fecha = req.fecha_hora_creacion.split(' ')[0]; // Solo la fecha (sin hora)
                        fechaServidor = req.fecha;
                    }
                    if (req.metros) {
                        document.getElementById('metros').value = req.metros;
                    }
                    if (req.julio_reserv) {
                        document.getElementById('julio_reserv').value = req.julio_reserv;
                    }
                    if (req.metros_pie) {
                        document.getElementById('metros_pie').value = req.metros_pie;
                    }
                    if (req.julio_reserv_pie) {
                        document.getElementById('julio_reserv_pie').value = req.julio_reserv_pie;
                    }
    
                    // Convertir los valores de `req.valor` en un Set para mejor búsqueda
                    let valoresReq = new Set(req.valor ? req.valor.split(',').map(v => v.trim()) : []);
                    console.log('Valores requerimientos:', [...valoresReq]);
    
                    // Buscar si hay una coincidencia con las fechas de la tabla
                    let fechaTablaEncontrada = Array.from(fechasTablas).find(th => {
                        let fechaTabla = th.innerText.replace('Fecha: ', '').trim();
                        return fechaServidor === fechaTabla;
                    });
    
                    // Si no se encontró una fecha coincidente, no se marcan checkboxes
                    if (!fechaTablaEncontrada) return;
    
                    console.log('Fecha coincidente encontrada:', fechaServidor);
    
                    // Marcar solo los checkboxes dentro de la tabla que tiene la fecha correcta
                    let table = fechaTablaEncontrada.closest('table');
                    if (table) {
                        table.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                            let checkboxValue = checkbox.value.trim();
                            if (valoresReq.has(checkboxValue)) {
                                checkbox.checked = true;
                                console.log('✔ Checkbox marcado:', checkboxValue);
                            }
                        });
                    }
                });
            })
            .catch(error => {
                console.error('Error al obtener requerimientos activos:', error.response ? error.response.data : error.message);
            });
    });
    </script>
    
@endsection
