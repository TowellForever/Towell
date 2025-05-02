@extends('layouts.app')

@section('content')
<div class="mx-auto p-3 bg-white shadow rounded-lg mt-6 overflow-y-auto max-h-[600px]">
    <h1 class="text-xl font-bold mb-4 text-gray-800 text-center">NUEVO REGISTRO TEJIDO SCHEDULING</h1>
    <form id="form-planeacion" action="{{ route('planeacion.store') }}" method="POST" class="grid grid-cols-4 gap-x-8 gap-y-4 fs-11">
        @csrf

        <div class="col-span-1 grid grid-cols-1 items-center">
            <label for="no_flog" class="w-20 font-medium text-gray-700">No FLOG:</label>
            <select id="no_flog" name="no_flog" class=" border border-gray-300 rounded px-2 py-1 select2-flog">
                <option value="">-- SELECCIONA --</option>
            </select>
        </div>
        
        <div class="flex items-center">
            <label for="descrip" class="w-20 font-medium text-gray-700">DESCRIPCIÓN:</label>
            <input type="text" name="descripcion" id="descrip" class=" border border-gray-300 rounded px-2 py-1" readonly>
        </div>        

        <div class="flex items-center">
            <label for="telar" class="w-20 font-medium text-gray-700">TELAR:</label>
            <select name="telar" id="telar" class="border border-gray-300 rounded px-2 py-1 text-sm" required>
                <option value="">-- SELECCIONA --</option>
                @foreach($telares as $telar)
                    <option value="{{ $telar->telar }}"> {{ $telar->telar }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center mb-4">
            <label for="clave_ax" class="w-20 font-medium text-gray-700">CLAVE AX:</label>
            <select id="clave_ax" name="clave_ax" class="w-34 border border-gray-300 rounded px-2 py-1 select2-modelos" ><option value="">-- ................................... --</option></select>
        </div>
        <div class="flex items-center">
            <label for="nombre_modelo" class="w-20 font-medium text-gray-700">NOMBRE MODELO:</label>
            <input type="text" id="nombre_modelo" name="nombre_modelo" class=" border border-gray-300 rounded px-2 py-1" readonly>
        </div>
        
        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">TAMAÑO:</label>
            <input type="text" name="tamano" id="tamano" class="border rounded px-2 py-1" required>
        </div>
        <div class="flex items-center">
            <label for="cuenta_rizo" class="w-20 font-medium text-gray-700">CUENTA RIZO:</label>
            <input type="text" name="cuenta_rizo" id="cuenta_rizo" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>
        <div class="flex items-center">
            <label for="calibre_rizo" class="w-20 font-medium text-gray-700">CALIBRE RIZO:</label>
            <input type="text" name="calibre_rizo" id="calibre_rizo" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="cuenta_pie" class="w-20 font-medium text-gray-700">CUENTA PIE:</label>
            <input type="text" name="cuenta_pie" id="cuenta_pie" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>
        <div class="flex items-center">
            <label for="calibre_pie" class="w-20 font-medium text-gray-700">CALIBRE PIE:</label>
            <input type="text" name="calibre_pie" id="calibre_pie" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="trama_0" class="w-20 font-medium text-gray-700">TRAMA:</label>
            <input type="text" name="trama_0" id="trama_0" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_0" class="w-20 font-medium text-gray-700">COLOR:</label>
            <input type="text" name="color_0" id="color_0" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_1" class="w-20 font-medium text-gray-700">TRAMA 1:</label>
            <input type="text" name="trama_1" id="calibre_1" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_1" class="w-20 font-medium text-gray-700">COLOR 1:</label>
            <input type="text" name="color_1" id="color_1" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_2" class="w-20 font-medium text-gray-700">TRAMA 2:</label>
            <input type="text" name="trama_2" id="calibre_2" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_2" class="w-20 font-medium text-gray-700">COLOR 2:</label>
            <input type="text" name="color_2" id="color_2" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_3" class="w-20 font-medium text-gray-700">TRAMA 3:</label>
            <input type="text" name="trama_3" id="calibre_3" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_3" class="w-20 font-medium text-gray-700">COLOR 3:</label>
            <input type="text" name="color_3" id="color_3" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_4" class="w-20 font-medium text-gray-700">TRAMA 4:</label>
            <input type="text" name="trama_4" id="calibre_4" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_4" class="w-20 font-medium text-gray-700">COLOR 4:</label>
            <input type="text" name="color_4" id="color_4" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="calibre_5" class="w-20 font-medium text-gray-700">TRAMA 5:</label>
            <input type="text" name="trama_5" id="calibre_5" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="color_5" class="w-20 font-medium text-gray-700">COLOR 5:</label>
            <input type="text" name="color_5" id="color_5" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="cantidad" class="w-20 font-medium text-gray-700">CANTIDAD:</label>
            <input type="number" name="cantidad" id="cantidad" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        
        <div class="flex items-center">
            <label for="saldos" class="w-20 font-medium text-gray-700">SALDOS:</label>
            <input type="text" name="saldo" id="saldo" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="fecha_scheduling" class="w-20 font-medium text-gray-700">FECHA SCHEDULING:</label>
            <input type="date" name="fecha_scheduling" id="fecha_scheduling" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="fecha_inn" class="w-20 font-medium text-gray-700">FECHA INN:</label>
            <input type="date" name="fecha_inn" id="fecha_inn" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="fecha_compromiso_tejido" class="w-20 font-medium text-gray-700">COMPROMISO TEJIDO:</label>
            <input type="date" name="fecha_compromiso_tejido" id="fecha_compromiso_tejido" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="fecha_cliente" class="w-20 font-medium text-gray-700">FECHA CLIENTE:</label>
            <input type="date" name="fecha_cliente" id="fecha_cliente" class="border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
            <label for="day_scheduling" class="w-20 font-medium text-gray-700">DAY SCHEDULING:</label>
            <input type="date" name="day_scheduling" id="day_scheduling" class=" border border-gray-300 rounded px-2 py-1" >
        </div>

        <div class="flex items-center">
          <label for="fecha_inicio" class="w-20 font-medium text-gray-700">FECHA INICIO:</label>
          <input type="date" name="fecha_inicio" id="fecha_inicio" class=" border border-gray-300 rounded px-2 py-1" >
      </div>

      <div class="flex items-center">
        <label for="fecha_fin" class="w-20 font-medium text-gray-700">FECHA FIN:</label>
        <input type="date" name="fecha_fin" id="fecha_fin" class=" border border-gray-300 rounded px-2 py-1" >
      </div>

      <div class="flex items-center">
          <label for="fecha_entrega" class="w-20 font-medium text-gray-700">FECHA ENTREGA:</label>
          <input type="date" name="fecha_entrega" id="fecha_entrega" class=" border border-gray-300 rounded px-2 py-1" >
      </div>

        <div class="col-span-4 text-right mt-4 ">
            <button type="submit" class="w-1/6 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">
                GUARDAR
            </button>
        </div>
    </form>

    <button onclick="mostrarDataTelarEnTextarea()" class="w-1/6 mt-2 px-4 py-2 bg-blue-500 text-white rounded">
      Mostrar datos del telar
    </button>

    <button onclick="mostrarDataModeloEnTextarea()" class="w-1/6 mt-2 px-4 py-2 bg-blue-500 text-white rounded">
      Mostrar datos del modelo
    </button> 

    <button onclick="mostrarDataFLOGEnTextarea()" class="w-1/6 mt-2 px-4 py-2 bg-blue-500 text-white rounded">
        Mostrar datos del modelo
      </button>
  
    <div class="mt-1">
      <label for="datos_comodin" class="block text-lg font-semibold text-gray-800 mb-2">DATOS COMODÍN:</label>
      <textarea id="datos_comodin" name="datos_comodin"
          class="w-full h-[300px] border border-gray-300 rounded-lg p-4 text-sm font-mono resize-y bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
          placeholder="Aquí aparecerán los datos extraídos...">
        </textarea>
    </div>
  
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
  let dataModelo = null;
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
                            $('#trama_0').val((data.Tra ?? '').toString().replace(/\.0$/, ''));
                            $('#color_0').val((data.OBS_R1 ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_1').val((data.Hilo_4 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_1').val((data.OBS_R2 ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_2').val((data.Hilo_5 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_2').val((data.OBS_R3 ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_3').val((data.Hilo_6 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_3').val((data.OBS_R4 ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_4').val((data.Hilo_7 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_4').val((data.OBS_R5 ?? '').toString().replace(/\.0$/, ''));
                            $('#calibre_5').val((data.Hilo_8 ?? '').toString().replace(/\.0$/, ''));
                            $('#color_5').val((data.OBS_R6 ?? '').toString().replace(/\.0$/, ''));
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


                          // Aquí guardamos todo el objeto (registro) de MODELOS encontrado
                          dataModelo = data; 
                        } else {
                            console.warn('No se encontró el modelo con esos datos');
                        }
                    })
                    .catch(error => console.error('Error al obtener detalle del modelo:', error));
            }
        });
    });

    $('#nombre_modelo').on('select2:select', function (e) {
          const valor = e.params.data.text; // o .id si tu valor está ahí
          const parteAntesDelGuion = valor.split('-')[0].trim();
          $('#tamano').val(parteAntesDelGuion);
      });
</script>

<script>
    const telaresData = @json($telares); //Paso los telares al JS como objeto
</script>
<!--Script en el que se acomodan los datos del registro de Telar enviado por el back-->
<script>
  let dataTelar = null; // variables globales, no importa si el DOM no esta cargado
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
<!-- 
Escucha cuando el usuario escribe en cantidad y actualiza saldo con el mismo valor en tiempo real.
-->
<script>
  document.addEventListener('DOMContentLoaded', function () {
      const cantidadInput = document.getElementById('cantidad');
      const saldoInput = document.getElementById('saldo');

      cantidadInput.addEventListener('input', function () {
          saldoInput.value = cantidadInput.value;
      });
  });
</script>

<script>
    let dataFlog = null; // almacena los datos encontrados de acuerdo a lo que haya seleccionado el usuario en No. FLOG
    $(document).ready(function () {
        // SELECT2 para No FLOG
        $('#no_flog').select2({
            placeholder: '-- Selecciona No FLOG --',
            ajax: {
                url: '{{ route("flog.buscar") }}', // La nueva ruta que vas a crear
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // término de búsqueda
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.IDFLOG,
                                text: `${item.IDFLOG} | ${item.TIPOPEDIDO} | ${item.NAMEPROYECT} | ${item.ESTADOFLOG} | ${item.CUSTNAME}`
                            };
                        
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 2
        });
    });

    $('#no_flog').on('select2:select', function (e) {
    const selectedData = e.params.data;

    // Extraer y mostrar NAMEPROYECT en el input #descrip
    const nameProyect = selectedData.text.split('|')[2]?.trim() || '';
    $('#descrip').val(nameProyect);

    // También puedes guardar el objeto si deseas usarlo después
    dataFlog = selectedData;
});
</script>
<!--STORE script para enviar datos al BACK, seran guardados en TEJIDO_SCHEDULING-->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-planeacion");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        axios.post("{{ route('planeacion.store') }}", formData)
            .then(response => {
                console.log(Object.fromEntries(formData.entries())); // Esto convierte FormData a objeto y lo muestra

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


<!-- scripts TEMPORALES para mostrar varibles globales, BORRAR!!!!! DESPUÉS-->
<script>
  function mostrarDataTelarEnTextarea() {
      if (dataTelar) {
          const textarea = document.getElementById('datos_comodin');
          textarea.value = JSON.stringify(dataTelar, null, 2); // Formateado bonito
      } else {
          alert('No hay datos del telar seleccionados.');
      }
  }
</script>
<script>
  function mostrarDataModeloEnTextarea() {
      if (dataModelo) {
          const textarea = document.getElementById('datos_comodin');
          textarea.value = JSON.stringify(dataModelo, null, 2); // Formateado bonito
      } else {
          alert('No hay datos del modelo seleccionados.');
      }
  }
</script>
<script>
    function mostrarDataFLOGEnTextarea() {
        if (dataFlog) {
            const textarea = document.getElementById('datos_comodin');
            textarea.value = JSON.stringify(dataFlog, null, 2); // Formateado bonito
        } else {
            alert('No hay datos del modelo seleccionados.');
        }
    }
  </script>


@endsection
