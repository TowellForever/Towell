@extends('layouts.app', ['ocultarBotones' => true])

@section('content')
    @if (session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'ATENCIÓN',
                    text: @json(session('warning')),
                    timer: 4000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    backdrop: true,
                    customClass: {
                        popup: 'text-xl'
                    }
                });
            });
        </script>
    @endif

    <div class=" container mx-auto overflow-y-auto" style="max-height: calc(100vh - 120px);">
        @php
            // Detectar si estás en la ruta especial
            $esJacquardSulzer = request()->is('tejido/jacquard-sulzer/*'); //tejido/jacquard-sulzer/ ESTA ES LA URL GLOBAL DE LA VISTA DINÁMICA, NUNCA CAMBIARÁ ESTA PARTE
        @endphp

        @if ($esJacquardSulzer)
            <div class="flex gap-4 justify-center items-center z-5 botonesApp">
                <a href="/modulo-tejido" class="absolute top-1 right-48 z-1 btn btn-warning text-sm">SALIR </a>
                <!-- Botón Atrás -->
                <button onclick="cambiarTelar(-1)"
                    class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    ⬅️
                </button>

                <!-- Botón Adelante -->
                <button onclick="cambiarTelar(1)"
                    class="bg-white text-blue-500 font-bold py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 transition duration-300 flex items-center gap-2">
                    ➡️
                </button>
            </div>

            <script>
                function cambiarTelar(direccion) {
                    const path = window.location.pathname; // Ej: /tejido/jacquard-sulzer/208
                    const partes = path.split('/');
                    let telarActual = parseInt(partes.at(-1));

                    if (isNaN(telarActual)) return;

                    // 🧩 Definir los rangos válidos
                    const rangoJacquardSulzer = [207, 208, 209, 210, 211];
                    const rangoJacquardSmith = [201, 202, 203, 204, 205, 206, 213, 214, 215];
                    const rangoSmith = [305, 306, 307, 308, 309, 310, 311, 312, 313, 314, 315, 316];
                    const rangoItemaViejo = [303, 304, 317, 318];
                    const rangoItemaNuevo = [299, 300, 301, 302, 319, 320];

                    let rangoActivo = [];

                    if (rangoJacquardSulzer.includes(telarActual)) {
                        rangoActivo = rangoJacquardSulzer;
                    } else if (rangoJacquardSmith.includes(telarActual)) {
                        rangoActivo = rangoJacquardSmith;
                    } else if (rangoSmith.includes(telarActual)) {
                        rangoActivo = rangoSmith;
                    } else if (rangoItemaViejo.includes(telarActual)) {
                        rangoActivo = rangoItemaViejo;
                    } else if (rangoItemaNuevo.includes(telarActual)) {
                        rangoActivo = rangoItemaNuevo;
                    } else {
                        return; // 🚫 Número de telar no permitido
                    }

                    const indiceActual = rangoActivo.indexOf(telarActual);
                    const nuevoIndice = indiceActual + direccion;

                    if (nuevoIndice < 0 || nuevoIndice >= rangoActivo.length) {
                        Swal.fire({
                            icon: 'info',
                            title: 'LÍMITE ALCANZADO',
                            text: 'No puedes avanzar más allá de este telar. Has alcanzado el rango permitido.',
                            timer: 2000,
                            timerProgressBar: true,
                            showConfirmButton: false,
                            background: '#f9fafb',
                            color: '#1e3a8a',
                            iconColor: '#2563eb'
                        });

                        return; // fuera de rango
                    }

                    const siguienteTelar = rangoActivo[nuevoIndice];

                    // 🧭 Redirigir
                    partes[partes.length - 1] = siguienteTelar;
                    const nuevaUrl = partes.join('/');
                    window.location.href = nuevaUrl;
                }
            </script>
        @endif
        <table class="table border-0 sm:mt-[20px] md:-mt-2">
            <thead class="bg-cyan-500 text-white text-center">
                <tr>
                    <th colspan="5">EN PROCESO JACQUARD SULZER {{ $telar }}</th>
                </tr>
            </thead>
            <tbody class="bg-white text-black">
                @foreach ($datos as $dato)
                    <tr class="text-sm">
                        <td class=" p-2">
                            <b>Orden:</b> {{ rtrim(rtrim(number_format($dato->Orden_Prod, 2, '.', ''), '0'), '.') }}
                            <br><b>Cuenta Rizo:</b> {{ rtrim(rtrim(number_format($dato->Cuenta, 2, '.', ''), '0'), '.') }}
                            <br><b>Trama 4:</b>
                            {{ $dato->CALIBRE_C3 == 0 ? '0' : rtrim(rtrim(number_format($dato->CALIBRE_C3, 2, '.', ''), '0'), '.') }}
                            <br><b>Artículo:</b> {{ $dato->Nombre_Producto }}
                            <br><b>Pedido:</b>
                            {{ $dato->Saldos == 0 ? '0' : rtrim(rtrim(number_format($dato->Saldos, 2, '.', ''), '0'), '.') }}
                            <br><b>Fin:</b> {{ \Carbon\Carbon::parse($dato->Fin_Tejido)->format('d/m/Y') }}
                        </td>
                        <td class=" p-2">
                            <b>No. Flog:</b> {{ $dato->Id_Flog }}
                            <br><b>Cuenta Pie:</b>
                            {{ rtrim(rtrim(number_format($dato->Cuenta_Pie, 2, '.', ''), '0'), '.') }}
                            <br><b>Trama 5:</b>
                            {{ $dato->CALIBRE_C4 == 0 ? '0' : rtrim(rtrim(number_format($dato->CALIBRE_C4, 2, '.', ''), '0'), '.') }}
                            <br><b>Producido:</b> {{ '' }}
                            <br>
                            <br><b>Fecha de Compromiso Tejido:</b>
                            {{ \Carbon\Carbon::parse($dato->Fecha_Compromiso)->format('d/m/Y') }}
                        </td>
                        <td class=" p-2">
                            <b>Trama 1:</b> {{ number_format($dato->CALIBRE_TRA, 2) }}
                            <br><b>Trama 6:</b>
                            {{ $dato->CALIBRE_C5 == 0 ? '0' : rtrim(rtrim(number_format($dato->CALIBRE_C5, 2, '.', ''), '0'), '.') }}
                            <br><b>Número de Tiras:</b>
                            {{ $dato->Tiras == 0 ? '0' : rtrim(rtrim(number_format($dato->Tiras, 2, '.', ''), '0'), '.') }}
                            <br><b>Producción (KG)/Día:</b>
                            {{ $dato->Prod_Kg_Dia == 0 ? '0' : rtrim(rtrim(number_format($dato->Prod_Kg_Dia, 2, '.', ''), '0'), '.') }}
                            <br>
                            <br><b>Fecha de Compromiso Cliente:</b>
                            {{ \Carbon\Carbon::parse($dato->Fecha_Compromiso1)->format('d/m/Y') }}
                        </td>
                        <td class=" p-2">
                            <b>Cliente:</b> {{ '' }}
                            <br><b>Trama 2:</b>
                            {{ $dato->CALIBRE_C1 == 0 ? '0' : rtrim(rtrim(number_format($dato->CALIBRE_C1, 2, '.', ''), '0'), '.') }}
                            <br><b>Trama 7:</b> {{ '-' }}
                            <br>
                            <br>
                            <br><b>STD/Día:</b> {{ rtrim(rtrim(number_format($dato->Std_Dia, 2, '.', ''), '0'), '.') }}


                        </td>
                        <td class=" p-2">
                            <br>
                            <b>Trama 3:</b>
                            {{ $dato->CALIBRE_C2 == 0 ? '0' : rtrim(rtrim(number_format($dato->CALIBRE_C2, 2, '.', ''), '0'), '.') }}
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
        <div class="overflow-x-auto sm:max-w-[620px] md:max-w-full">
            <table class="table w-full">
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
                                    <div class="mr-4 mt-[32px]">
                                        <b>Cuentas:
                                        </b><br>
                                        <b>RIZO </b><label id="cuenta-rizo">
                                        </label> <br>
                                        <b>PIE</b> <label id="cuenta-pie">
                                        </label>
                                    </div>
                                    <div class="mr-4">
                                        <b id="fecha"></b>
                                        <!--<br><b>Turno:</b> {{ '' }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <br><b>Metros:</b> <br><input type="text" id="metros" class="border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <br><input type="text" id="metros_pie" class="border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">-->
                                    </div>
                                </div>

                                <!-- Tabla a la derecha 1-->
                                <table class="ml-4 border-2">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center border fecha-tabla">
                                                {{ \Carbon\Carbon::now()->format('d-m-Y') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-center">
                                                <div class=" font-bold">1</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo1" class="t1rizo w-5 h-5"
                                                            value="rizo1"> </label><br>
                                                    <label><input type="checkbox" name="pie1" class="t1pie w-5 h-5"
                                                            value="pie1"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">2</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo2" class="t1rizo w-5 h-5"
                                                            value="rizo2"> </label><br>
                                                    <label><input type="checkbox" name="pie2" class="t1pie w-5 h-5"
                                                            value="pie2"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">3</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo3" class="t1rizo w-5 h-5"
                                                            value="rizo3"> </label><br>
                                                    <label><input type="checkbox" name="pie3" class="t1pie w-5 h-5"
                                                            value="pie3"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Tabla a la derecha 2-->
                                <table class="ml-4 border-2">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center border fecha-tabla">
                                                {{ \Carbon\Carbon::tomorrow()->format('d-m-Y') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-center">
                                                <div class=" font-bold">1</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo1" class="t2rizo w-5 h-5"
                                                            value="rizo1"> </label><br>
                                                    <label><input type="checkbox" name="pie1" class="t2pie w-5 h-5"
                                                            value="pie1"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">2</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo2" class="t2rizo w-5 h-5"
                                                            value="rizo2"> </label><br>
                                                    <label><input type="checkbox" name="pie2" class="t2pie w-5 h-5"
                                                            value="pie2"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">3</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo3" class="t2rizo w-5 h-5"
                                                            value="rizo3"> </label><br>
                                                    <label><input type="checkbox" name="pie3" class="t2pie w-5 h-5"
                                                            value="pie3"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Tabla a la derecha 3-->
                                <table class="ml-4 border-2">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center border fecha-tabla">
                                                {{ \Carbon\Carbon::now()->addDays(2)->format('d-m-Y') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-center">
                                                <div class=" font-bold">1</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo1" class="t3rizo w-5 h-5 "
                                                            value="rizo1"> </label><br>
                                                    <label><input type="checkbox" name="pie1" class="t3pie w-5 h-5"
                                                            value="pie1"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">2</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo2" class="t3rizo w-5 h-5"
                                                            value="rizo2"> </label><br>
                                                    <label><input type="checkbox" name="pie2" class="t3pie w-5 h-5"
                                                            value="pie2"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">3</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo3" class="t3rizo w-5 h-5"
                                                            value="rizo3"> </label><br>
                                                    <label><input type="checkbox" name="pie3" class="t3pie w-5 h-5"
                                                            value="pie3"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Tabla a la derecha 4-->
                                <table class="ml-4 border-2">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center border fecha-tabla">
                                                {{ \Carbon\Carbon::now()->addDays(3)->format('d-m-Y') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-center">
                                                <div class=" font-bold">1</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo1" class="t4rizo w-5 h-5"
                                                            value="rizo1"> </label><br>
                                                    <label><input type="checkbox" name="pie1" class="t4pie w-5 h-5"
                                                            value="pie1"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">2</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo2" class="t4rizo w-5 h-5"
                                                            value="rizo2"> </label><br>
                                                    <label><input type="checkbox" name="pie2" class="t4pie w-5 h-5"
                                                            value="pie2"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">3</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo3" class="t4rizo w-5 h-5"
                                                            value="rizo3"> </label><br>
                                                    <label><input type="checkbox" name="pie3" class="t4pie w-5 h-5"
                                                            value="pie3"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Tabla a la derecha 5-->
                                <table class="ml-4 border-2">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center border fecha-tabla">
                                                {{ \Carbon\Carbon::now()->addDays(4)->format('d-m-Y') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-center">
                                                <div class=" font-bold">1</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo1" class="t5rizo w-5 h-5"
                                                            value="rizo1"> </label><br>
                                                    <label><input type="checkbox" name="pie1" class="t5pie w-5 h-5"
                                                            value="pie1"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">2</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo2" class="t5rizo w-5 h-5"
                                                            value="rizo2"> </label><br>
                                                    <label><input type="checkbox" name="pie2" class="t5pie w-5 h-5"
                                                            value="pie2"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">3</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo3" class="t5rizo w-5 h-5"
                                                            value="rizo3"> </label><br>
                                                    <label><input type="checkbox" name="pie3" class="t5pie w-5 h-5"
                                                            value="pie3"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Tabla a la derecha 6-->
                                <table class="ml-4 border-2">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center border fecha-tabla">
                                                {{ \Carbon\Carbon::now()->addDays(5)->format('d-m-Y') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-center">
                                                <div class=" font-bold">1</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo1" class="t6rizo w-5 h-5"
                                                            value="rizo1"> </label><br>
                                                    <label><input type="checkbox" name="pie1" class="t6pie w-5 h-5"
                                                            value="pie1"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">2</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo2" class="t6rizo w-5 h-5"
                                                            value="rizo2"> </label><br>
                                                    <label><input type="checkbox" name="pie2" class="t6pie w-5 h-5"
                                                            value="pie2"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">3</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo3" class="t6rizo w-5 h-5"
                                                            value="rizo3"> </label><br>
                                                    <label><input type="checkbox" name="pie3" class="t6pie w-5 h-5"
                                                            value="pie3"> </label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Tabla a la derecha 7-->
                                <table class="ml-4 border-2">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center border fecha-tabla">
                                                {{ \Carbon\Carbon::now()->addDays(6)->format('d-m-Y') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border text-center">
                                                <div class=" font-bold">1</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo1" class="t7rizo w-5 h-5"
                                                            value="rizo1"> </label><br>
                                                    <label><input type="checkbox" name="pie1" class="t7pie w-5 h-5"
                                                            value="pie1"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">2</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo2" class="t7rizo w-5 h-5"
                                                            value="rizo2"> </label><br>
                                                    <label><input type="checkbox" name="pie2" class="t7pie w-5 h-5"
                                                            value="pie2"> </label>
                                                </div>
                                            </td>
                                            <td class="border text-center">
                                                <div class=" font-bold">3</div>
                                                <div class="mt-2">
                                                    <label><input type="checkbox" name="rizo3" class="t7rizo w-5 h-5"
                                                            value="rizo3"> </label><br>
                                                    <label><input type="checkbox" name="pie3" class="t7pie w-5 h-5"
                                                            value="pie3"> </label>
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
        </div>
        <div class="flex justify-center mt-6 w-80">
            <a href="{{ route('ordenes.programadas', ['telar' => $telar]) }}"
                class="inline-block bg-blue-800 text-white font-bold py-2 px-6 rounded hover:bg-blue-900">
                Órdenes Programadas
            </a>

        </div>
    </div>

    <script>
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                let fila = this.closest('tr'); // Obtener la fila actual
                let fecha = fila.closest('table').querySelector('th').innerText.replace('Fecha: ', '');
                //let metros = document.getElementById('metros').value;
                //let julioR = String(document.getElementById('julio_reserv').value);
                //let metros_pie = document.getElementById('metros_pie').value;
                //let julioR_pie = String(document.getElementById('julio_reserv_pie').value);
                let valorCheckbox = this.value;
                let rizo = 0,
                    pie = 0;

                let datos = @json($datos);
                let cuentaRizo = datos[0].Cuenta;
                let cuentaPie = datos[0].Cuenta_Pie;
                let ordenProd = '';
                let telar = @json($telar);

                // 🔹 Detectar si es Rizo o Pie
                if (valorCheckbox.startsWith('rizo')) {
                    rizo = 1;
                    // 🔹 Desmarcar todos los checkboxes de tipo "rizo" antes de marcar el nuevo
                    document.querySelectorAll('input[type="checkbox"][value^="rizo"]').forEach(cb => cb
                        .checked = false);
                } else if (valorCheckbox.startsWith('pie')) {
                    pie = 1;
                    // 🔹 Desmarcar todos los checkboxes de tipo "pie" antes de marcar el nuevo
                    document.querySelectorAll('input[type="checkbox"][value^="pie"]').forEach(cb => cb
                        .checked = false);
                }

                // 🔹 Marcar solo el checkbox seleccionado
                this.checked = true;

                axios.post('/guardar-requerimiento', {
                        cuenta_rizo: cuentaRizo,
                        cuenta_pie: cuentaPie,
                        fecha: fecha,
                        //metros: metros,
                        //julio_reserv: julioR,
                        //metros_pie: metros_pie,
                        //julio_reserv_pie: julioR_pie,
                        orden_prod: ordenProd,
                        valor: valorCheckbox,
                        rizo,
                        pie,
                        telar
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => {
                        console.log(response.data.message);

                        Swal.fire({
                            icon: 'success',
                            title: 'Datos actualizados correctamente',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            position: 'bottom-end',
                            toast: true
                        });

                    })
                    .catch(error => {
                        console.error('Error:', error.response ? error.response.data : error.message);
                    });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el número de telar de la vista
            let telar =
                @json($telar); // Asegúrate de que esta variable sea el número de telar correcto en la vista

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
                            document.getElementById('cuenta-rizo').innerText = parseInt(req
                                .cuenta_rizo);
                        }
                        if (req.cuenta_pie) {
                            document.getElementById('cuenta-pie').innerText = parseInt(req.cuenta_pie);
                        }
                        if (req.fecha_hora_creacion) {
                            let fecha = req.fecha_hora_creacion.split(' ')[
                                0]; // Solo la fecha (sin hora)
                            fechaServidor = req.fecha;
                        }
                        /*if (req.metros) {
                            document.getElementById('metros').value = req.metros;
                        }*/
                        /*if (req.julio_reserv) {
                            document.getElementById('julio_reserv').value = req.julio_reserv;
                        }*/
                        /*if (req.metros_pie) {
                            document.getElementById('metros_pie').value = req.metros_pie;
                        }*/
                        /*if (req.julio_reserv_pie) {
                            document.getElementById('julio_reserv_pie').value = req.julio_reserv_pie;
                        }*/

                        // Convertir los valores de `req.valor` en un Set para mejor búsqueda
                        let valoresReq = new Set(req.valor ? req.valor.split(',').map(v => v.trim()) :
                        []);
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
                    console.error('Error al obtener requerimientos activos:', error.response ? error.response
                        .data : error.message);
                });
        });
    </script>
@endsection
