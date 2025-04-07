@extends('layouts.app')

@section('content')
<!--Vista del formulario para registrar datos de URDIDO y ENGOMADO, ademas Construccion JULIOS-->
<div class="container mx-auto p-4">
    <form action="{{ route('orden.produccion.store') }}" method="POST">
        @csrf
        <!-- Tabla 1: Datos del Requerimiento -->
        <h2 class="text-lg font-semibold mb-2">Datos Urdido</h2>
        <table class="w-full text-xs border-collapse border border-gray-300 mb-4">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border px-1 py-0.5">Telar</th>
                    <th class="border px-1 py-0.5">Cuenta</th>
                    <th class="border px-1 py-0.5">Urdido</th>
                    <th class="border px-1 py-0.5">Proveedor</th>
                    <th class="border px-1 py-0.5">Tipo</th>
                    <th class="border px-1 py-0.5">Destino</th>
                    <th class="border px-1 py-0.5">Metros</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $tipo = '';
                    $cuenta = '';

                    if (($requerimiento->rizo ?? null) == 1) {
                        $tipo = 'Rizo';
                        $cuenta = $requerimiento->cuenta_rizo ?? '';
                    } elseif (($requerimiento->pie ?? null) == 1) {
                        $tipo = 'Pie';
                        $cuenta = $requerimiento->cuenta_pie ?? '';
                    }
                @endphp

                <tr>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="telar" value=" {{$requerimiento->telar ?? ''}}" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="cuenta" value="{{ $cuenta }}" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <!-- Select para 'urdido' -->
                    <td class="border px-1 py-0.5">
                        <select name="urdido" class="form-select w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm" required>
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Mc Coy 1">Mc Coy 1</option>
                            <option value="Mc Coy 2">Mc Coy 2</option>
                            <option value="Mc Coy 3">Mc Coy 3</option>
                        </select>
                    </td>

                    <!-- Select para 'proveedor' -->
                    <td class="border px-1 py-0.5">
                        <select name="proveedor" class="form-select w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm" required>
                            <option value="" disabled selected>Selecciona un proveedor</option>
                            <option value="Jiutepec">Jiutepec</option>
                            <option value="Verstappen">Verstappen</option>
                            <option value="Perez">Perez</option>
                        </select>
                    </td>

                    <td class="border px-1 py-0.5">
                        <input type="text" name="tipo" value="{{ $tipo }}" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm" readonly>
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="destino" value="{{ $datos->salon ?? '' }}" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm" readonly>
                    </td>
                    <!-- Select para 'metros' -->
                    <td class="border px-1 py-0.5">
                        <select name="metros" class="form-select w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm" required>
                            <option value="" disabled selected>Selecciona los metros</option>
                            <option value="4000">4000</option>
                            <option value="5000">5000</option>
                            <option value="6000">6000</option>
                            <option value="7000">7000</option>
                        </select>
                    </td>
                </tr>                
            </tbody>
        </table>
        <!-- Tabla 2: Construcción Urdido -->
        <h2 class="text-lg font-semibold mb-2">Construcción Urdido</h2>
        <table class="w-full text-xs border-collapse border border-gray-300 mb-4">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border px-1 py-0.5">No. de Julios</th>
                    <th class="border px-1 py-0.5">Hilos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="no_julios[]" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="hilos[]" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                </tr>
                <tr>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="no_julios[]" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="hilos[]" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                </tr>
                <tr>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="no_julios[]" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="hilos[]" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                </tr>
                <tr>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="no_julios[]" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="hilos[]" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                </tr>
            </tbody>
        </table>

        

        <!-- Tabla 3: Datos de Engomado -->
        <h2 class="text-lg font-semibold mb-2">Datos Engomado</h2>
        <table class="w-full text-xs border-collapse border border-gray-300 mb-4">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border px-1 py-0.5">Núcleo</th>
                    <th class="border px-1 py-0.5">No. de Telas</th>
                    <th class="border px-1 py-0.5">Ancho Balonas</th>
                    <th class="border px-1 py-0.5">Metraje de Telas</th>
                    <th class="border px-1 py-0.5">Cuendeados Mínimo</th>
                    <th class="border px-1 py-0.5">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="nucleo" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="no_telas" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="balonas" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="metros_tela" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="cuendados_mini" class="form-input w-full h-10 px-2 py-2 border border-gray-300 rounded text-sm">
                    </td>
                    <td class="border px-1 py-0.5">
                        <textarea name="observaciones" class="form-textarea w-full px-2 py-2 border border-gray-300 rounded text-sm h-20"></textarea>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Botón discreto para enviar -->
        <div class="mt-4">
            <button type="submit" onclick="this.disabled=true; this.form.submit();" class="w-1/5 bg-green-500 text-black px-4 py-2 rounded">
                Orden Producción
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector('form[action="{{ route('orden.produccion.store') }}"]');

        form.addEventListener('submit', function(e) {
            // Opcional: evitar envío para probar
             e.preventDefault();

            const formData = new FormData(form);
            const data = {};

            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }

            console.log("Datos enviados:", data);
        });
    });
</script>

@endsection
