@extends('layouts.app')

@php
    $datosPrecargados = request()->all(); // <-- aquí captamos los datos si vienen por GET
@endphp

@section('content')
    <div class="mx-auto p-3 bg-white shadow rounded-lg overflow-y-auto max-h-[550px]">
        <div class="relative w-full flex items-center  mb-2">
            <!-- Línea horizontal -->
            <div class="w-full border-t-8 border-gray-300"></div>

            <!-- Título centrado sobre la línea -->
            <span
                class="absolute left-1/2 -translate-x-1/2 px-8 rounded-xl bg-blue-100 border-2 text-sm border-blue-300 shadow-lg font-semibold text-blue-800 tracking-wide uppercase"
                style="top: 50%; transform: translate(-50%, -50%);">
                DATOS GENERALES
            </span>
        </div>
        <form id="form-planeacion" action="{{ route('planeacion.store') }}" method="POST"
            class="grid grid-cols-5 gap-x-8 gap-y-4 fs-11">
            @csrf

            <div class="col-span-1 grid grid-cols-1 items-center -mb-1">
                <label for="no_flog" class="w-20 font-medium text-gray-700">No FLOG:</label>
                <select id="no_flog" name="no_flog"
                    class=" border border-gray-300 rounded px-1 py-0.5 select2-flog no_flog-select">
                    <option value="">-- SELECCIONA --</option>
                </select>
            </div>
            <div class="flex items-center">
                <label for="calendario" class="w-16 font-medium text-gray-700 fs-9 -mb-1">CALENDARIO:</label>
                <select name="calendario" id="calendario"
                    class="w-36 border border-gray-300 rounded px-1 py-0.5 select-alert">
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="Calendario Tej1">Calendario Tej1</option><!-- toma en cuenta TODOS los días-->
                    <option value="Calendario Tej2">Calendario Tej2 </option><!-- NO toma en cuenta domingos-->
                    <option value="Calendario Tej3">Calendario Tej3 </option>
                    <!-- No toma en cuenta domingos y sabados solo toma en cuenta hasta las 18:29-->
                </select>
            </div>
            <div class="flex items-center">
                <label for="cuenta_pie" class="w-16 font-medium text-gray-700 fs-9 -mb-1">CUENTA PIE:</label>
                <input type="number" name="cuenta_pie" id="cuenta_pie" class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="calibre_1" class="w-16 font-medium text-gray-700 fs-9 -mb-1">TRAMA 1:</label>
                <input type="number" step="0.01" name="calibre_1" id="calibre_1"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="color_3" class="w-16 font-medium text-gray-700 fs-9 -mb-1">COLOR 3:</label>
                <input type="text" name="color_3" id="color_3" class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="descripcion" class="w-16 font-medium text-gray-700 fs-9 -mb-1">DESCRIPCIÓN:</label>
                <input type="text" name="descripcion" id="descripcion"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="aplicacion" class="w-16 font-medium text-gray-700 fs-9 -mb-1">APLICACIÓN:</label>
                <select name="aplicacion" id="aplicacion"
                    class="w-36 border border-gray-300 rounded px-1 py-0.5 select-alert">
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="RZ">NO APLICA</option>
                    <option value="RZ">RZ</option>
                    <option value="RZ2">RZ2</option>
                    <option value="RZ3">RZ3</option>
                    <option value="BOR">BOR</option>
                    <option value="EST">EST</option>
                    <option value="DC">DC</option>
                </select>
            </div>
            <div class="flex items-center">
                <label for="calibre_pie" class="w-16 font-medium text-gray-700 fs-9 -mb-1">CALIRBE PIE:</label>
                <input type="number" step="0.01" name="calibre_pie" id="calibre_pie"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="color_1" class="w-16 font-medium text-gray-700 fs-9 -mb-1">COLOR 1:</label>
                <input type="text" name="color_1" id="color_1" class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="calibre_4" class="w-16 font-medium text-gray-700 fs-9 -mb-1">TRAMA 4:</label>
                <input type="number" step="0.01" name="calibre_4" id="calibre_4"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="clave_ax" class="w-16 font-medium text-gray-700 fs-9 -mb-1">CLAVE AX:</label>
                <input type="text" name="clave_ax" id="clave_ax" class="border rounded px-1 py-0.5 -mb-1" required>
            </div>
            <div class="flex items-center">
                <label for="hilo" class="w-16 font-medium text-gray-700 fs-9 -mb-1">HILO:</label>
                <select name="hilo" id="hilo"
                    class="w-36 border border-gray-300 rounded px-1 py-0.5 select-alert">
                    <option value="" disabled selected>Selecciona una opción</option>
                    <option value="H">H</option>
                    <option value="T20 PEINADO">T20 PEINADO</option>
                    <option value="A12">RZ3</option>
                    <option value="Hrpre">Hrpre</option>
                    <option value="A20">A20</option>
                    <option value="Fil600 (virgen)/A12">Fil600 (virgen)/A12</option>
                    <option value="O16">O16</option>
                    <option value="HR">HR</option>
                    <option value="Fil (reciclado-secual)">Fil (reciclado-secual)</option>
                </select>
            </div>
            <div class="flex items-center">
                <label for="calibre_2" class="w-16 font-medium text-gray-700 fs-9 -mb-1">TRAMA 2:</label>
                <input type="number" step="0.01" name="calibre_2" id="calibre_2"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="color_4" class="w-16 font-medium text-gray-700 fs-9 -mb-1">COLOR 4:</label>
                <input type="text" name="color_4" id="color_4" class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="nombre_modelo" class="w-16 font-medium text-gray-700 fs-9 -mb-1">NOMBRE MODELO:</label>
                <input type="text" id="nombre_modelo" name="nombre_modelo"
                    class=" border border-gray-300 rounded px-1 py-0.5" readonly>
            </div>
            <div class="flex items-center">
                <label for="cuenta_rizo" class="w-16 font-medium text-gray-700 fs-9 -mb-1">CUENTA RIZO:</label>
                <input type="number" name="cuenta_rizo" id="cuenta_rizo"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="trama_0" class="w-16 font-medium text-gray-700 fs-9 -mb-1">TRAMA:</label>
                <input type="number" step="0.01" name="trama_0" id="trama_0"
                    class=" border border-gray-300 roundedpx-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="color_2" class="w-16 font-medium text-gray-700 fs-9 -mb-1">COLOR 2:</label>
                <input type="text" name="color_2" id="color_2" class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="calibre_5" class="w-16 font-medium text-gray-700 fs-9 -mb-1">TRAMA 5:</label>
                <input type="number" step="0.01" name="calibre_5" id="calibre_5"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="tamano" class="w-16 font-medium text-gray-700 fs-9 -mb-1">TAMAÑO:</label>
                <input type="text" name="tamano" id="tamano" class="border rounded px-1 py-0.5 -mb-1" required>
            </div>
            <div class="flex items-center">
                <label for="calibre_rizo" class="w-16 font-medium text-gray-700 fs-9 -mb-1">CALIBRE RIZO:</label>
                <input type="number" step="0.01" name="calibre_rizo" id="calibre_rizo"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="color_0" class="w-16 font-medium text-gray-700 fs-9 -mb-1">COLOR:</label>
                <input type="text" name="color_0" id="color_0" class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="calibre_3" class="w-16 font-medium text-gray-700 fs-9 -mb-1">TRAMA 3:</label>
                <input type="number" step="0.01" name="calibre_3" id="calibre_3"
                    class=" border border-gray-300 rounded px-1 py-0.5">
            </div>
            <div class="flex items-center">
                <label for="color_5" class="w-16 font-medium text-gray-700 fs-9 -mb-1">COLOR 5:</label>
                <input type="text" name="color_5" id="color_5" class=" border border-gray-300 rounded px-1 py-0.5">
            </div>

            <!-- - - - - - - - - - - -  - - - - - - - - - - DATOS DEL TELAR  -- - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  - - - - -->
            <div class="col-span-5">
                <!-- Aquí va el divisor -->
                <div class="relative w-full flex items-center">
                    <div class="w-full border-t-8 border-gray-300"></div>
                    <span
                        class="absolute left-1/2 -translate-x-1/2 px-8 rounded-xl bg-blue-100 border-2 border-blue-300 shadow-lg text-sm font-semibold text-blue-800 tracking-wide uppercase"
                        style="top: 50%; transform: translate(-50%, -50%);">
                        DATOS DEL TELAR
                    </span>
                </div>
                <div class="overflow-x-auto rounded-lg shadow-lg bg-white p-1">
                    <!-- Botón agregar fila -->
                    <!-- Contenedor de botones -->
                    <div class="flex justify-end space-x-2">
                        <!-- Botón agregar fila -->
                        <button type="button" id="add-row-btn"
                            class="w-2 justify-center flex items-center px-3 py-1 rounded-full bg-blue-600 hover:bg-blue-700 shadow font-medium text-base transition">
                            <span>➕</span>
                        </button>
                        <!-- Botón eliminar última fila -->
                        <button type="button" id="remove-row-btn"
                            class="w-2 justify-center flex items-center px-3 py-1 rounded-full bg-red-600 hover:bg-red-700 shadow font-medium text-base transition">
                            <span>🗑️</span>
                        </button>
                    </div>
                    <table class="min-w-full text-xss">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 font-semibold text-center uppercase tracking-wide">
                                <th class="py-1 px-0.5">TELAR</th>
                                <th class="py-1 px-0.5">CANTIDAD</th>
                                <th class="py-1 px-0.5">FECHA INICIO</th>
                                <th class="py-1 px-0.5">FECHA FIN</th>
                                <th class="py-1 px-0.5">COMPROMISO TEJIDO</th>
                                <th class="py-1 px-0.5">FECHA CLIENTE</th>
                                <th class="py-1 px-0.5">FECHA ENTREGA</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-registros">
                            <tr class="border-b hover:bg-blue-50">
                                <td class="py-1 text-center">
                                    <select name="telar[]"
                                        class="border border-gray-300 rounded px-1 py-0.5 text-xs w-20 ">
                                        <option value="">Seleccionar</option>
                                        @foreach ($telares as $telar)
                                            <option value="{{ $telar->telar }}">{{ $telar->telar }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-1 text-center">
                                    <input type="number" step="0.01" name="cantidad[]"
                                        class="border border-gray-300 rounded px-1 py-0.5 w-20 cantidad-input">
                                </td>
                                <td class="py-1  text-center">
                                    <input type="datetime-local" name="fecha_inicio[]"
                                        class="border border-gray-300 rounded px-1 py-0.5 w-34" readonly>
                                </td>
                                <td class="py-1 text-center">
                                    <input type="datetime-local" name="fecha_fin[]"
                                        class="border border-gray-300 rounded px-1 py-0.5 w-34" readonly>
                                </td>
                                <td class="py-1 text-center">
                                    <input type="datetime-local" name="fecha_compromiso_tejido[]"
                                        class="border border-gray-300 rounded px-1 py-0.5 w-34" readonly>
                                </td>
                                <td class="py-1 text-center">
                                    <input type="datetime-local" name="fecha_cliente[]"
                                        class="border border-gray-300 rounded px-1 py-0.5 w-34" readonly>
                                </td>
                                <td class="py-1 text-center">
                                    <input type="datetime-local" name="fecha_entrega[]"
                                        class="border border-gray-300 rounded px-1 py-0.5 w-34" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-span-5 text-right -mt-2 -mb-2 ">
                <button type="submit" class="w-1/6 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">
                    GUARDAR
                </button>
            </div>
        </form>
    </div>

    <!--SCRIPS JS ********************************************************************************************************************************-->
    <script>
        document.addEventListener("DOMContentLoaded", function() { // esta funcion will working con AX
            const flogSelect = document.getElementById('no_flog');
            const descInput = document.getElementById('descrip');

            flogSelect.addEventListener('change', function() {
                const selected = flogSelect.options[flogSelect.selectedIndex];
                const descripcion = selected.getAttribute('data-desc');
                descInput.value = descripcion || '';
            });
        });
    </script>
    <!-- el siguiente script es para hacer selects (CLAVE AX y TAMAÑO AX): todas las opciones son de la BD de la tabla MODELOS -->

    <script>
        const telaresData = @json($telares); //Paso los telares al JS como objeto
    </script>
    <!--Script en el que se acomodan los datos del registro de Telar enviado por el back-->
    <script>
        let dataTelar = null; // variables globales, no importa si el DOM no esta cargado
        document.addEventListener('DOMContentLoaded', function() {
            const telarSelect = document.getElementById('telar');

            telarSelect.addEventListener('change', function() {
                const selectedTelar = this.value;

                const telar = telaresData.find(t => t.telar === selectedTelar);

                if (telar) {
                    document.getElementById('cuenta_rizo').value = telar.rizo ?? '';
                    document.getElementById('cuenta_pie').value = telar.pie ?? '';
                    document.getElementById('calibre_rizo').value = telar.calibre_rizo ?? '';
                    document.getElementById('calibre_pie').value = telar.calibre_pie ?? '';
                    dataTelar = telar;
                } else {
                    document.getElementById('cuenta_rizo').value = '';
                    document.getElementById('cuenta_pie').value = '';
                    document.getElementById('calibre_rizo').value = '';
                    document.getElementById('calibre_pie').value = '';
                }
            });
        });
    </script>
    <!--   Escucha cuando el usuario escribe en cantidad y actualiza saldo con el mismo valor en tiempo real.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cantidadInput = document.getElementById('cantidad');
            const saldoInput = document.getElementById('saldo');

            cantidadInput.addEventListener('input', function() {
                saldoInput.value = cantidadInput.value;
            });
        });
    </script>
    <!--FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS FLOGS-->
    <script>
        let dataFlog = null; // almacena los datos encontrados de acuerdo a lo que haya seleccionado el usuario en No. FLOG
        $(document).ready(function() {
            // SELECT2 para No FLOG
            $('#no_flog').select2({
                placeholder: '-- Ingresa un Flog --',
                ajax: {
                    url: '{{ route('flog.buscar') }}', // La nueva ruta que vas a crear
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            fingered: params.term // término de búsqueda
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.IDFLOG,
                                    ITEMNAME: item.ITEMNAME,
                                    INVENTSIZEID: item.INVENTSIZEID,
                                    text: `${item.IDFLOG} | ${item.ITEMNAME} | ${item.INVENTSIZEID}`,
                                    ITEMID: item.ITEMID,

                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2 // minimo de caracteres a ingresar para realizar la busqueda c:
            });
            // Evento al seleccionar un FLOG
            $('#no_flog').on('select2:select', function(e) {
                // El objeto seleccionado está en e.params.data
                let selected = e.params.data;

                // Guarda en la variable global
                dataFlog = {
                    IDFLOG: selected.id,
                    INVENTSIZEID: selected.INVENTSIZEID,
                    ITEMID: selected.ITEMID,
                    ITEMNAME: selected.ITEMNAME
                };
            });
            // 🧠 Cuando el usuario selecciona un FLOGSO, lanzamos la búsqueda y traemos sus datos
            $('#no_flog').on('select2:select', function(e) {
                // ... Aquí tu código para asignar dataFlog

                if (dataFlog) {
                    console.log('Buscando con:', dataFlog.ITEMID);

                    // Serializa los datos como parámetros de la URL
                    const params = new URLSearchParams({
                        inventsizeid: dataFlog.INVENTSIZEID,
                        itemid: dataFlog.ITEMID,
                    });

                    fetch(`/modelo/detalle?${params.toString()}`)
                        .then(response => response.json())
                        .then(data => {
                            if (Object.keys(data).length === 0) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'NO ENCONTRADO',
                                    text: 'Lo sentimos, no se ha encontrado el modelo con esos datos.',
                                    confirmButtonText: 'Entendido',
                                    confirmButtonColor: '#3085d6',
                                    background: '#fff',
                                    color: '#333'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                console.log('Modelo encontrado:', data);
                                // Aquí acomodo los campos como requiera, son los datos que envio el BACK como JSON (registro encontrado en modelos)
                                $('#trama_0').val(!isNaN(parseFloat(data.Tra)) ? parseFloat(data.Tra)
                                    .toFixed(2) : '');

                                $('#color_0').val((data.OBS_A_1 ?? ''));

                                $('#calibre_1').val(!isNaN(parseFloat(data.Hilo_A_1)) ? parseFloat(data
                                    .Hilo_A_1).toFixed(2) : '');

                                $('#color_1').val((data.OBS_A_2 ?? ''));

                                $('#calibre_2').val(!isNaN(parseFloat(data.Hilo_A_2)) ? parseFloat(data
                                    .Hilo_A_2).toFixed(2) : '');

                                $('#color_2').val((data.OBS_A_3 ?? ''));

                                $('#calibre_3').val(!isNaN(parseFloat(data.Hilo_A_3)) ? parseFloat(data
                                    .Hilo_A_3).toFixed(2) : '');

                                $('#color_3').val((data.OBS_A_4 ?? ''));

                                $('#calibre_4').val(!isNaN(parseFloat(data.Hilo_A_4)) ? parseFloat(data
                                    .Hilo_A_4).toFixed(2) : '');

                                $('#color_4').val((data.OBS_A_5 ?? ''));

                                $('#calibre_5').val(!isNaN(parseFloat(data.Hilo_A_5)) ? parseFloat(data
                                    .Hilo_A_5).toFixed(2) : '');
                                $('#color_5').val((data.OBS_R6 ?? ''));

                                $('#nombre_modelo').val(String(data.Modelo ?? ''));
                                $('#clave_ax').val(data.CLAVE_AX);
                                $('#tamano').val(data.Tamanio_AX);
                                $('#descripcion').val(data.Nombre_de_Formato_Logistico);

                                //Función para formatear el número
                                function mostrarBonito(num) {
                                    // Convierte a número flotante
                                    let n = parseFloat(num);
                                    // Si no es número, regresa vacío
                                    if (isNaN(n)) return '';
                                    // Si es entero (por ejemplo 5.0), muestra como entero
                                    if (Number.isInteger(n)) return n;
                                    // Si tiene decimales, muestra solo 2
                                    return n.toFixed(2);
                                }

                                $('#cuenta_rizo').val(mostrarBonito(data.CUENTA));
                                $('#calibre_rizo').val(mostrarBonito(data.Rizo));
                                $('#cuenta_pie').val(mostrarBonito(data.CUENTA1));
                                $('#calibre_pie').val(mostrarBonito(data.Pie));

                                // Fechas
                                function formatearFecha(fechaBruta) {
                                    if (fechaBruta) {
                                        const fecha = new Date(fechaBruta);
                                        const año = fecha.getFullYear();
                                        const mes = String(fecha.getMonth() + 1).padStart(2,
                                            '0'); // Mes de 2 dígitos
                                        const dia = String(fecha.getDate()).padStart(2,
                                            '0'); // Día de 2 dígitos
                                        return `${año}-${mes}-${dia}`;
                                    }
                                    return '';
                                }

                                // Aquí guardamos todo el objeto (registro) de MODELOS encontrado
                                dataModelo = data;
                            }
                        })
                        .catch(error => console.error('Error al obtener detalle del modelo:', error));
                }
            });

            /*   $('#no_flog').on('select2:select', function(e) {
                        const selectedData = e.params.data;

                        // Extraer y mostrar NAMEPROYECT en el input #descrip - DESCRIPCION DESCRIPCION DESCRIPCION DESCRIPCION DESCRIPCION DESCRIPCION DESCRIPCION DESCRIPCION 
                        const nameProyect = selectedData.text.split('|')[2]?.trim() || '';
                        $('#descripcion').val(nameProyect);

                        // También puedes guardar el objeto si deseas usarlo después
                        dataFlog = selectedData;

                    });*/

        });
    </script>
    <!--STORE script para enviar datos al BACK, seran guardados en TEJIDO_SCHEDULING-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("form-planeacion");

            form.addEventListener("submit", function(e) {
                e.preventDefault();

                const formData = new FormData(form);

                axios.post("{{ route('planeacion.store') }}", formData)
                    .then(response => {
                        console.log(Object.fromEntries(formData
                            .entries())); // Esto convierte FormData a objeto y lo muestra

                        alert('Registro guardado exitosamente');
                        // Opcional: redireccionar o limpiar campos
                        window.location.href = "{{ route('planeacion.index') }}";
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Ocurrió un error al guardar el registro');
                    });
            });
        });
    </script>
    <!-- JS para agregar filas dinámicamente -->
    <script>
        document.getElementById('add-row-btn').addEventListener('click', function() {
            let tbody = document.getElementById('tabla-registros');
            let firstRow = tbody.querySelector('tr');
            let newRow = firstRow.cloneNode(true);

            // Limpia los valores de los inputs y selects en la fila clonada
            newRow.querySelectorAll('input, select').forEach(function(el) {
                if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } else {
                    el.value = '';
                }
            });

            tbody.appendChild(newRow);
        });

        document.getElementById('remove-row-btn').addEventListener('click', function() {
            let tbody = document.getElementById('tabla-registros');
            let rows = tbody.querySelectorAll('tr');
            // Solo elimina si hay más de una fila
            if (rows.length > 1) {
                tbody.removeChild(rows[rows.length - 1]);
            }
        });
    </script>
    <!--SCRIPT para buscar la fecha del ultimo registro del telar seleccionado-->
    <script>
        let telar = null;
        $(document).ready(function() {
            // Escucha el cambio en cualquier select de telar dentro de la tabla
            $('#tabla-registros').on('change', 'select[name="telar[]"]', function() {
                const telarSeleccionado = $(this).val();
                telar = telarSeleccionado;
                const fila = $(this).closest('tr'); // Para identificar la fila específica

                if (!telarSeleccionado) return; // No hacer nada si no seleccionan

                // Hacer petición AJAX al backend
                fetch(`/Tejido-Scheduling/ultimo-por-telar?telar=${encodeURIComponent(telarSeleccionado)}`)
                    .then(resp => resp.json())
                    .then(data => {
                        if (data) {
                            // Aquí puedes llenar otros campos de la fila, por ejemplo:
                            fila.find('input[name="fecha_inicio[]"]').val(data ? data.Fin_Tejido :
                                '');
                        } else {
                            // Puedes limpiar los campos o mostrar mensaje
                            // fila.find('input[name="cantidad[]"]').val('');
                        }
                    });
            });
        });

        // Escucha cuando el usuario digita en el campo cantidad
        $('#tabla-registros').on('input', 'input[name="cantidad[]"]', function() {
            const fila = $(this).closest('tr');
            const cantidad = parseFloat($(this).val());
            const clave_ax = document.getElementById('clave_ax').value;
            const tamano = document.getElementById('tamano').value;
            const hilo = document.getElementById('hilo').value;
            const calendario = document.getElementById('calendario').value;
            const fechaInicioStr = fila.find('input[name="fecha_inicio[]"]').val();

            if (!cantidad || !fechaInicioStr) {
                fila.find('input[name="fecha_fin[]"]').val('');
                return;
            }

            // Hacer petición AJAX al backend enviando cantidad y fecha_inicio
            fetch(
                    `/Tejido-Scheduling/fechaFin?cantidad=${encodeURIComponent(cantidad)}&fecha_inicio=${encodeURIComponent(fechaInicioStr)}
                    &telar=${encodeURIComponent(telar)}
                    &clave_ax=${encodeURIComponent(clave_ax)}
                    &tamano=${encodeURIComponent(tamano)}
                    &hilo=${encodeURIComponent(hilo)}
                    &calendario=${encodeURIComponent(calendario)}`
                )
                .then(resp => resp.json())
                .then(data => {
                    if (data.error) {
                        fila.find('input[name="fecha_fin[]"]').val('');
                        Swal.fire({
                            icon: 'warning',
                            title: 'NO ENCONTRADO',
                            text: data.message,
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#3085d6',
                            background: '#fff',
                            color: '#333'
                        });
                        // Si quieres, también limpia campos aquí, etc
                    } else {
                        // Aquí puedes llenar otros campos de la fila, por ejemplo:
                        console.log('Datos de Fecha FINAL:', data);
                        fila.find('input[name="fecha_fin[]"]').val(data ? data.fecha :
                            '');
                    }
                });
        });
    </script>
    <!--Este SCIRPT es para ocultar la 2da tabla al usuario, asi evitamos que genere algun error en caso de digitar datos primero en la 2da tabla-->
    <script>
        $(document).ready(function() {
            // Por default, oculta la tabla
            $('#tabla-registros').hide();

            // Función para revisar todos los selects
            function revisarSelects() {
                var flog = $('#no_flog').val();
                var hilo = $('#hilo').val();
                var aplicacion = $('#aplicacion').val();
                var calendario = $('#calendario').val();

                // Mostrar solo si todos tienen valor
                if (flog && hilo && aplicacion && calendario) {
                    $('#tabla-registros').show();
                } else {
                    $('#tabla-registros').hide();
                }
            }

            // Eventos para cada select
            $('#no_flog').on('select2:select select2:clear', revisarSelects);
            $('#hilo, #aplicacion, #calendario').on('change', revisarSelects);

            // Opcional: revisar al cargar la página (por si ya hay valores preseleccionados)
            revisarSelects();
        });
    </script>

    <script>
        document.querySelectorAll('.select-alert').forEach(sel => {
            function revisar() {
                // Si hay un valor seleccionado (no vacío)
                if (sel.value && sel.value.trim() !== '') {
                    sel.classList.add('filled');
                } else {
                    sel.classList.remove('filled');
                }
            }

            // Revisar al cargar la página
            revisar();
            // Revisar cada vez que cambie el select
            sel.addEventListener('change', revisar);
        });
    </script>
    @push('styles')
        <style>
            #tabla-bloqueo {
                position: absolute;
                background: rgba(240, 240, 240, 0.7);
                width: 100%;
                height: 100%;
                z-index: 2;
                top: 0;
                left: 0;
                display: none;
            }

            #tabla-registros-wrapper {
                position: relative;
            }

            /* Humo rojo por default (select sin valor) */
            .select-alert {
                border: 2px solid #e53935;
                box-shadow: 0 0 5px 0 #e5393580;
                /* rojo con transparencia */
                transition: border 0.2s, box-shadow 0.2s;
                outline: none;
            }

            /* Verde cuando tiene valor */
            .select-alert.filled {
                border: 2px solid #43a047;
                box-shadow: 0 0 10px 0 #43a04780;
            }
        </style>
    @endpush
@endsection
