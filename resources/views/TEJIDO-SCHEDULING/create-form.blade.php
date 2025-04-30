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
            <input type="text" name="telar" id="telar" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center mb-4">
            <label for="clave_modelo" class="w-32 font-medium text-gray-700">CLAVE MODELO:</label>
            <select id="clave_modelo" name="clave_modelo" class="w-full border border-gray-300 rounded px-2 py-1 select2-modelos" ></select>
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
            <label for="tamano" class="w-20 font-medium text-gray-700">CUENTA PIE:</label>
            <input type="text" name="calibre_pie" id="calibre_pie" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">TRAMA 1:</label>
            <input type="text" name="trama_1" id="trama_1" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">TRAMA 2:</label>
            <input type="text" name="trama_2" id="trama_2" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">TRAMA 3:</label>
            <input type="text" name="trama_3" id="trama_3" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">TRAMA 4:</label>
            <input type="text" name="trama_4" id="trama_4" class=" border border-gray-300 rounded px-2 py-1" >
        </div>
        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">TRAMA 5:</label>
            <input type="text" name="trama_5" id="trama_5" class=" border border-gray-300 rounded px-2 py-1" >
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
    document.addEventListener("DOMContentLoaded", function () {
        const flogSelect = document.getElementById('no_flog');
        const descInput = document.getElementById('descrip');

        flogSelect.addEventListener('change', function () {
            const selected = flogSelect.options[flogSelect.selectedIndex];
            const descripcion = selected.getAttribute('data-desc');
            descInput.value = descripcion || '';
        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#clave_modelo').select2({
            placeholder: '-- Selecciona CLAVE MODELO --',
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
            let clave = parseInt(item.CLAVE_MODELO); // Elimina .0
            return {
                id: clave,
                text: clave,
                nombre: item.Modelo
            };
        })
    };
},

                cache: true
            }
        });

        $('#clave_modelo').on('select2:select', function (e) {
            var data = e.params.data;
            $('#nombre_modelo').val(data.nombre);
        });
    });
</script>

@endsection
