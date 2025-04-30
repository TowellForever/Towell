@extends('layouts.app')

@section('content')
<div class="mx-auto p-3 bg-white shadow rounded-lg mt-6">
    <h1 class="text-xl font-bold mb-4 text-gray-800 text-center">NUEVO REGISTRO TEJIDO SCHEDULING</h1>
    <form action="{{ route('planeacion.store') }}" method="POST" class="grid grid-cols-4 gap-x-8 gap-y-4 fs-11">
        @csrf

        <div class="flex items-center">
            <label for="no_flog" class="w-20 font-medium text-gray-700">No. FLOG:</label>
            <select name="no_flog" id="no_flog" class="border border-gray-300 rounded px-2 py-1 w-full text-sm" required>
                <option value="">-- SELECCIONA --</option>
                @foreach($flogs as $flog)
                    <option value="{{ $flog->Id_Flog }}" data-desc="{{ $flog->Descrip }}">{{ $flog->Id_Flog }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center">
            <label for="descrip" class="w-20 font-medium text-gray-700">DESCRIPCIÓN:</label>
            <input type="text" name="descripcion" id="descrip" class="border border-gray-300 rounded px-2 py-1" readonly>
        </div>        

        <div class="flex items-center">
            <label for="telar" class="w-20 font-medium text-gray-700">TELAR:</label>
            <select name="telar" id="telar" class="border border-gray-300 rounded px-2 py-1 w-full text-sm" required>
                <option value="">-- SELECCIONA --</option>
                @foreach($telares as $telar)
                    <option value="{{ $telar->telar }}"> {{ $telar->telar }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center mb-4">
            <label for="clave_ax" class="w-32 font-medium text-gray-700">CLAVE AX:</label>
            <select id="clave_ax" name="clave_ax" class="w-full border border-gray-300 rounded px-2 py-1 select2-modelos" ></select>
        </div>
        <div class="flex items-center">
            <label for="nombre_modelo" class="w-24 font-medium text-gray-700">NOMBRE MODELO:</label>
            <input type="text" id="nombre_modelo" name="nombre_modelo" class="w-full border border-gray-300 rounded px-2 py-1" readonly>
        </div>
        
        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">TAMAÑO:</label>
            <input type="text" name="tamano" id="tamano" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">CUENTA RIZO:</label>
            <input type="text" name="cuenta_rizo" id="cuenta_rizo" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>
        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">CALIBRE RIZO:</label>
            <input type="text" name="calibre_pie" id="calibre_pie" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">CUENTA PIE:</label>
            <input type="text" name="cuenta_pie" id="cuenta_pie" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>
        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">CALIBRE PIE:</label>
            <input type="text" name="calibre_pie" id="calibre_pie" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="calibre_1" class="w-20 font-medium text-gray-700">CALIBRE 1:</label>
            <input type="text" name="calibre_1" id="calibre_1" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_1" class="w-20 font-medium text-gray-700">COLOR 1:</label>
            <input type="text" name="color_1" id="color_1" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_2" class="w-20 font-medium text-gray-700">CALIBRE 2:</label>
            <input type="text" name="calibre_2" id="calibre_2" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_2" class="w-20 font-medium text-gray-700">COLOR 2:</label>
            <input type="text" name="color_2" id="color_2" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_3" class="w-20 font-medium text-gray-700">CALIBRE 3:</label>
            <input type="text" name="calibre_3" id="calibre_3" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_3" class="w-20 font-medium text-gray-700">COLOR 3:</label>
            <input type="text" name="color_3" id="color_3" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_4" class="w-20 font-medium text-gray-700">CALIBRE 4:</label>
            <input type="text" name="calibre_4" id="calibre_4" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_4" class="w-20 font-medium text-gray-700">COLOR 4:</label>
            <input type="text" name="color_4" id="color_4" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_5" class="w-20 font-medium text-gray-700">CALIBRE 5:</label>
            <input type="text" name="calibre_5" id="calibre_5" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_5" class="w-20 font-medium text-gray-700">COLOR 5:</label>
            <input type="text" name="color_5" id="color_5" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="cantidad" class="w-20 font-medium text-gray-700">CANTIDAD:</label>
            <input type="number" name="cantidad" id="cantidad" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="fecha_scheduling" class="w-20 font-medium text-gray-700">FECHA SCHEDULING:</label>
            <input type="date" name="fecha_scheduling" id="fecha_scheduling" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="fecha_inv" class="w-20 font-medium text-gray-700">FECHA INV:</label>
            <input type="date" name="fecha_inv" id="fecha_inv" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="fecha_compromiso_tejido" class="w-20 font-medium text-gray-700">COMPROMISO TEJIDO:</label>
            <input type="date" name="fecha_compromiso_tejido" id="fecha_compromiso_tejido" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="fecha_cliente" class="w-20 font-medium text-gray-700">FECHA CLIENTE:</label>
            <input type="date" name="fecha_cliente" id="fecha_cliente" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="col-span-4 text-right mt-4 ">
            <button type="submit" class="w-1/6 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">
                GUARDAR
            </button>
        </div>
    </form>
</div>
<!--SCRIPS JS ********************************************************************************************************************************-->
<script>
    document.addEventListener("DOMContentLoaded", function () { // esta funcion will working con AX
        const flogSelect = document.getElementById('no_flog');
        const descInput = document.getElementById('descrip');

        flogSelect.addEventListener('change', function () {
            const selected = flogSelect.options[flogSelect.selectedIndex];
            const descripcion = selected.getAttribute('data-desc');
            descInput.value = descripcion || '';
        });
    });
</script>
<!-- el siguiente script es para hacer 2 selects (CLAVE AX y NOMBRE MODELO): todas las opciones son de la BD de la tabla MODELOS -->
<script>
    $(document).ready(function () {
        // PRIMER SELECT: CLAVE_AX
        $('#clave_ax').select2({
            placeholder: '-- Selecciona CLAVE AX --',
            ajax: {
                url: '{{ route("modelos.buscar") }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.CLAVE_AX,
                                text: item.CLAVE_AX
                            };
                        })
                    };
                },
                cache: true //Habilita el almacenamiento en caché de las respuestas para evitar solicitudes repetidas.
            }
        });

        // SEGUNDO SELECT: nombre_modelo depende del valor seleccionado en clave_ax
        $('#clave_ax').on('select2:select', function (e) {
            const claveAX = e.params.data.id;

            //Limpiar opciones previas
            $('#nombre_modelo').empty().trigger('change');

            $.ajax({
                url: '{{ route("modelos.porClave") }}',
                data: { clave_ax: claveAX },
                success: function (data) {
                    const opciones = data.map(item => ({
                        id: item.Modelo,
                        text: item.Modelo
                    }));

                    $('#nombre_modelo').select2({
                        data: opciones,
                        placeholder: '-- Selecciona un modelo --'
                    });
                }
            });
        });

        // 🧠 Cuando el usuario selecciona un modelo, lanzamos la búsqueda del detalle
        $('#nombre_modelo').on('select2:select', function (e) {
            const claveAx = $('#clave_ax').val();
            const nombreModelo = e.params.data.id;

            if (claveAx && nombreModelo) {
                console.log('Buscando con:', claveAx, nombreModelo);

                fetch(`/modelo/detalle?clave_ax=${claveAx}&nombre_modelo=${encodeURIComponent(nombreModelo)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            console.log('Modelo encontrado:', data);
                            // Aquí acomodo los campos como requiera, son los datos que envio el BACK como JSON (registro encontrado en modelos)
                            $('#calibre_1').val((data.Hilo ?? '').toString().replace(/\.0$/, ''));
                            $('#color_1').val((data.OBS ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_2').val((data.Hilo1 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_2').val((data.OBS1 ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_3').val((data.Hilo2 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_3').val((data.OBS2 ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_4').val((data.Hilo3 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_4').val((data.OBS3 ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_5').val((data.Hilo4 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_5').val((data.OBS4 ?? '').toString().replace(/\.0$/, ''));
                            // Fechas
                            function formatearFecha(fechaBruta) {
                                if (fechaBruta) {
                                    const fecha = new Date(fechaBruta);
                                    const año = fecha.getFullYear();
                                    const mes = String(fecha.getMonth() + 1).padStart(2, '0'); // Mes de 2 dígitos
                                    const dia = String(fecha.getDate()).padStart(2, '0'); // Día de 2 dígitos
                                    return `${año}-${mes}-${dia}`;
                                }
                                return '';
                            }

                            // Formatear y asignar las fechas al input
                            $('#fecha_scheduling').val(formatearFecha(data.Fecha_Compromiso));
                            $('#fecha_inv').val(formatearFecha(data.Fecha_Orden));
                            $('#fecha_cliente').val(formatearFecha(data.Fecha_Cumplimiento));

                            //$('#fecha_compromiso_tejido').val((data.X ?? '' ));
                            
                        } else {
                            console.warn('No se encontró el modelo con esos datos');
                        }
                    })
                    .catch(error => console.error('Error al obtener detalle del modelo:', error));
            }
        });
    });
</script>

<script>
    const telaresData = @json($telares); //Paso los telares al JS como objeto
</script>
<!--Script en el que se acomodan los datos del registro de Telar enviado por el back-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const telarSelect = document.getElementById('telar');

        telarSelect.addEventListener('change', function () {
            const selectedTelar = this.value;

            const telar = telaresData.find(t => t.telar === selectedTelar);

            if (telar) {
                document.getElementById('cuenta_rizo').value = telar.rizo ?? '';
                document.getElementById('cuenta_pie').value = telar.pie ?? '';
                document.getElementById('calibre_rizo').value = telar.calibre_rizo ?? '';
                document.getElementById('calibre_pie').value = telar.calibre_pie ?? '';
            } else {
                document.getElementById('cuenta_rizo').value = '';
                document.getElementById('cuenta_pie').value = '';
                document.getElementById('calibre_rizo').value = '';
                document.getElementById('calibre_pie').value = '';
            }
        });
    });
</script>

@endsection
