@extends('layouts.app')

@section('content')
<!-- Vista del formulario para registrar datos de URDIDO y ENGOMADO, además Construcción JULIOS -->
<div class="mt-3 mb-20 p-1">
    {{-- Mostrar errores de validación --}}
    <form action="{{ route('orden.produccion.store') }}" method="POST">
        @csrf
                {{-- Mostrar errores de validación --}}
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Lo sentimos, ocurrió un problema:</strong>
                        <ul class="list-disc pl-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Mostrar mensaje de error personalizado --}}
                @if (session('error'))
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Advertencia:</strong> {{ session('error') }}
                    </div>
                @endif

                {{-- Mostrar mensaje de éxito --}}
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">¡Operación exitosa!</strong> {{ session('success') }}
                    </div>
                @endif
        <h2 class="text-sm font-bold mb-1">Datos Urdido</h2>
        <table class="w-full text-xs border-collapse border border-gray-300 mb-4 ">
            <thead class="h-10">
                <tr class="bg-gray-200 text-left">
                    <th class="border px-1 py-0.5 w-12">Telar</th>
                    <th class="border px-1 py-0.5 w-12">Cuenta</th>
                    <th class="border px-1 py-0.5 w-24">Urdido</th>
                    <th class="border px-1 py-0.5 w-32">Proveedor</th>
                    <th class="border px-1 py-0.5 w-12">Tipo</th>
                    <th class="border px-1 py-0.5 w-32">Destino</th>
                    <th class="border px-1 py-0.5 w-24">Metros</th>
                </tr>
            </thead>
            <tbody class="h-24">
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
                        <input type="text" name="telar" value=" {{$requerimiento->telar ?? ''}}" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded">
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="cuenta" value="{{ $cuenta }}" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded">
                    </td>
                    <td class="border px-1 py-0.5">
                        <select name="urdido" class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded" required>
                            <option value="" disabled selected></option>
                            <option value="Mc Coy 1">Mc Coy 1</option>
                            <option value="Mc Coy 2">Mc Coy 2</option>
                            <option value="Mc Coy 3">Mc Coy 3</option>
                        </select>
                    </td>
                    <td class="border px-1 py-0.5">
                        <select name="proveedor" class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded" required>
                            <option value="" disabled selected></option>
                            <option value="Jiutepec">Jiutepec</option>
                            <option value="Verstappen">Verstappen</option>
                            <option value="Perez">Perez</option>
                        </select>
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="tipo" value="{{ $tipo }}" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded" readonly>
                    </td>
                    <td class="border px-1 py-0.5">
                        <input type="text" name="destino" value="{{ $datos->salon ?? '' }}" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded" readonly>
                    </td>
                    <td class="border px-1 py-0.5">
                        <select name="metros" class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded" required>
                            <option value="" disabled selected></option>
                            <option value="4000">4000</option>
                            <option value="5000">5000</option>
                            <option value="6000">6000</option>
                            <option value="7000">7000</option>
                        </select>
                    </td>
                </tr>                
            </tbody>
        </table>
        
        <div class="flex space-x-1">
            <!-- Columna 1: Datos de JULIOS, tablita con 2 columnas -->
            <div class="w-1/6 p-1">
                <h2 class="text-sm font-bold">Construcción Urdido</h2>
                <div class="flex">
                    <table class="w-full text-xs border-collapse border border-gray-300 mb-4">
                        <thead class="h-10">
                            <tr class="bg-gray-200 text-center">
                                <th class="border px-1 py-0.5 ">No. Julios</th>
                                <th class="border px-1 py-0.5 ">Hilos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < 4; $i++)
                                <tr>
                                    <td class="border px-1 py-0.5">
                                        <input type="text" inputmode="numeric" pattern="[0-9]*" name="no_julios[]" class="form-input px-1 py-0.5 text-[10px] border border-gray-300 rounded w-full">
                                    </td>
                                    <td class="border px-1 py-0.5">
                                        <input type="text" inputmode="numeric" pattern="[0-9]*" name="hilos[]" class="form-input px-1 py-0.5 text-[10px] border border-gray-300 rounded w-full">
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Columna 2: Datos Engomado -->
            <div class="w-5/6 p-1">
                <h2 class="text-sm font-bold">Datos Engomado</h2><br class="block md:hidden "><!-- Solo se muestra en pantallas pequeñas -->
                
                <table class="w-full text-xs border-collapse border border-gray-300 mb-1">
                    <thead class="h-10">
                        <tr class="bg-gray-200 text-left">
                            <th class="border px-1 py-0.5">Núcleo</th>
                            <th class="border px-1 py-0.5">No. de Telas</th>
                            <th class="border px-1 py-0.5">Ancho Balonas</th>
                            <th class="border px-1 py-0.5">Metraje de Telas</th>
                            <th class="border px-1 py-0.5">Cuendeados Mínimo</th>
                            <th class="border px-1 py-0.5 w-1/4">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody class="h-24">
                        <tr>
                            <td class="border px-1 py-0.5">
                                <input type="text" name="nucleo" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded">
                            </td>
                            <td class="border px-1 py-0.5">
                                <input type="text" inputmode="numeric" pattern="[0-9]*" name="no_telas" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded">
                            </td>
                            <td class="border px-1 py-0.5">
                                <input type="text" name="balonas" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded">
                            </td>
                            <td class="border px-1 py-0.5">
                                <input type="text" name="metros_tela" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded">
                            </td>
                            <td class="border px-1 py-0.5">
                                <input type="text" name="cuendados_mini" class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded">
                            </td>
                            <td class="border px-1 py-0.5">
                                <textarea name="observaciones" class="form-textarea w-full px-1 py-1 text-xs border border-gray-300 rounded h-16"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

         <!-- Botón discreto para enviar -->
         <div class="-mt-4">
            <button type="submit" onclick="this.disabled=true; this.form.submit();" class="w-1/5 bg-green-500 text-black px-4 py-2 rounded">
                GUARDAR
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

    {{-- También mostrar alertas como pop-up en pantalla --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if(session('error'))
                alert("⚠️ {{ session('error') }}");
            @endif

            @if(session('success'))
                alert("✅ {{ session('success') }}");
            @endif

            @if ($errors->any())
                alert("⚠️ Por favor, revisa los errores del formulario.");
            @endif
        });
    </script>

@endsection
