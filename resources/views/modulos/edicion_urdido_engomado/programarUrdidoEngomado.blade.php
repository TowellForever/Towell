@extends('layouts.app')

@section('content')
    <!--define una variable PHP para logica de edicion segun estatus-->
    @php

        $urdido = $ordenCompleta->estatus_urdido; // finalizado ó en_proceso
        $engomado = $ordenCompleta->estatus_engomado;

        $modo = 'editar';

        if ($urdido === 'finalizado' && $engomado === 'finalizado') {
            $modo = 'solo_lectura';
        } elseif ($urdido === 'finalizado' && $engomado === 'en_proceso') {
            $modo = 'solo_engomado';
        } elseif ($urdido === 'en_proceso' && $engomado === 'finalizado') {
            $modo = 'solo_urdido';
        }
    @endphp


    <!-- Vista del formulario para registrar datos de URDIDO y ENGOMADO, además Construcción JULIOS -->
    <div class="mt-3 mb-20 p-1 overflow-y-auto lg:max-h-[400px] ">

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
                            <input type="text" name="telar" value=" {{ $requerimiento->telar ?? '' }}"
                                class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                @if ($modo == 'solo_lectura' || $modo == 'solo_engomado') disabled @endif>
                        </td>
                        <td class="border px-1 py-0.5">
                            <input type="text" name="cuenta" value="{{ $cuenta }}"
                                class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                @if ($modo == 'solo_lectura' || $modo == 'solo_engomado') disabled @endif>
                        </td>
                        <td class="border px-1 py-0.5">
                            <select name="urdido"
                                class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded" required
                                @if ($modo == 'solo_lectura' || $modo == 'solo_engomado') disabled @endif>
                                <option value="{{ $ordenCompleta->urdido }}">{{ $ordenCompleta->urdido }}</option>
                                <option value="Mc Coy 1">Mc Coy 1</option>
                                <option value="Mc Coy 2">Mc Coy 2</option>
                                <option value="Mc Coy 3">Mc Coy 3</option>
                            </select>
                        </td>
                        <td class="border px-1 py-0.5">
                            <select name="proveedor"
                                class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                @if ($modo == 'solo_lectura' || $modo == 'solo_engomado') disabled @endif required>
                                <option value="{{ $ordenCompleta->proveedor }}">{{ $ordenCompleta->proveedor }}</option>
                                <option value="Max">Max Verstappen – Red Bull</option>
                                <option value="Sergio">Sergio Pérez – Red Bull</option>
                                <option value="Lewis">Lewis Hamilton – Ferrari</option>
                                <option value="Charles">Charles Leclerc – Ferrari</option>
                                <option value="Lando">Lando Norris – McLaren</option>

                            </select>
                        </td>
                        <td class="border px-1 py-0.5">
                            <input type="text" name="tipo" value="{{ $tipo }}"
                                class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                @if ($modo == 'solo_lectura' || $modo == 'solo_engomado') disabled @endif required>
                        </td>
                        <td class="border px-1 py-0.5">
                            <input type="text" name="destino" value="{{ $ordenCompleta->destino ?? '' }}"
                                class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                @if ($modo == 'solo_lectura' || $modo == 'solo_engomado') disabled @endif required>
                        </td>
                        <td class="border px-1 py-0.5">
                            <select name="metros"
                                class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                @if ($modo == 'solo_lectura' || $modo == 'solo_engomado') disabled @endif required>
                                <option value="{{ $ordenCompleta->metros }}">{{ $ordenCompleta->metros }}</option>
                                @for ($i = 1000; $i <= 10000; $i += 1000)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- LISTA DE MATERIALES Urdido-->
            <table class="w-1/2 text-xs border-collapse border border-gray-300 mb-4">
                <thead class="h-10">
                    <tr class="bg-gray-200 text-left">
                        <th class="border px-1 py-0.5 w-12">L. Mat. Urdido</th>
                    </tr>
                </thead>
                <tbody class="h-10">
                    <tr>
                        <td class="border px-1 py-0.5">
                            <select id="bomSelect" name="lmaturdido"
                                class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                @if ($modo == 'solo_lectura' || $modo == 'solo_engomado') disabled @endif required>
                                <option value="{{ $ordenCompleta->lmaturdido }}">{{ $ordenCompleta->lmaturdido }}</option>
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
                                    <th class="border px-1 py-0.5 ">No. Julios</th> <!--PENDING-->
                                    <th class="border px-1 py-0.5 ">Hilos</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                                @for ($i = 0; $i < 4; $i++)
                                    @php
                                        $julio = $julios[$i] ?? null;
                                    @endphp
                                    <tr>
                                        <td class="border px-1 py-0.5">
                                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="no_julios[]"
                                                value="{{ $julio->no_julios ?? '' }}"
                                                class="form-input px-1 py-0.5 text-[10px] border border-gray-300 rounded w-full">
                                        </td>
                                        <td class="border px-1 py-0.5">
                                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="hilos[]"
                                                value="{{ $julio->hilos ?? '' }}"
                                                class="form-input px-1 py-0.5 text-[10px] border border-gray-300 rounded w-full">
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>

                            </tbody>

                        </table>
                    </div>
                </div>

                <!-- Columna 2: Datos Engomado -->
                <div class="w-5/6 p-1">
                    <h2 class="text-sm font-bold">Datos Engomado</h2><br
                        class="block md:hidden "><!-- Solo se muestra en pantallas pequeñas -->

                    <table class="w-full text-xs border-collapse border border-gray-300 mb-1">
                        <thead class="h-10">
                            <tr class="bg-gray-200 text-left">
                                <th class="border px-1 py-0.5">Núcleo</th>
                                <th class="border px-1 py-0.5">No. de Telas</th>
                                <th class="border px-1 py-0.5">Ancho Balonas</th>
                                <th class="border px-1 py-0.5">Metraje de Telas</th>
                                <th class="border px-1 py-0.5">Cuendeados Mínimos por Tela</th>
                                <th class="border px-1 py-0.5 w-1/4">Observaciones</th>
                            </tr>
                        </thead>
                        <tbody class="h-24">
                            <tr>
                                <td class="border px-1 py-0.5">
                                    <select name="nucleo"
                                        class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                        @if ($modo == 'solo_lectura' || $modo == 'solo_urdido') disabled @endif>
                                        <option value="{{ $ordenCompleta->nucleo }}">{{ $ordenCompleta->nucleo }}
                                        </option>
                                        <option value="Itema">Itema</option>
                                        <option value="Smit">Smit</option>
                                        <option value="Jacquard">Jacquard</option>
                                    </select>
                                </td>
                                <td class="border px-1 py-0.5">
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="no_telas"
                                        class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                        @if ($modo == 'solo_lectura' || $modo == 'solo_urdido') disabled @endif
                                        value="{{ $ordenCompleta->no_telas }}">
                                </td>
                                <td class="border px-1 py-0.5">
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="balonas"
                                        class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                        @if ($modo == 'solo_lectura' || $modo == 'solo_urdido') disabled @endif
                                        value="{{ $ordenCompleta->balonas }}">
                                </td>
                                <td class="border px-1 py-0.5">
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="metros_tela"
                                        class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                        @if ($modo == 'solo_lectura' || $modo == 'solo_urdido') disabled @endif
                                        value="{{ $ordenCompleta->metros_tela }}">
                                </td>
                                <td class="border px-1 py-0.5">
                                    <input type="text" inputmode="numeric" pattern="[0-9]*" name="cuendados_mini"
                                        class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                        @if ($modo == 'solo_lectura' || $modo == 'solo_urdido') disabled @endif
                                        value="{{ $ordenCompleta->cuendados_mini }}">
                                </td>
                                <td class="border px-1 py-0.5">
                                    <textarea name="observaciones" class="form-textarea w-full px-1 py-1 text-xs border border-gray-300 rounded h-16"
                                        @if ($modo == 'solo_lectura' || $modo == 'solo_urdido') disabled @endif>{{ $ordenCompleta->observaciones }}</textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- LISTA DE MATERIALES Urdido-->
                    <table
                        class="w-full
                                        text-xs border-collapse border border-gray-300 mb-4">
                        <thead class="h-10">
                            <tr class="bg-gray-200 text-left">
                                <th class="border px-1 py-0.5 w-12">Engomado</th>
                                <th class="border px-1 py-0.5 w-12">L. Mat. Engomado</th>
                            </tr>
                        </thead>
                        <tbody class="h-10">
                            <tr>
                                <td class="border px-1 py-0.5">
                                    <select name="maquinaEngomado"
                                        class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                        @if ($modo == 'solo_lectura' || $modo == 'solo_urdido') disabled @endif required>
                                        <option value="{{ $ordenCompleta->maquinaEngomado }}">
                                            {{ $ordenCompleta->maquinaEngomado }}</option>
                                        <option value="Hilo Algodón 20/1">West Point 1</option>
                                        <option value="Hilo Algodón 30/1">West Point 2</option>
                                        <option value="Hilo Poliéster 150D">West Point 3</option>
                                    </select>
                                </td>
                                <td class="border px-1 py-0.5">
                                    <select id="bomSelect2" name="lmatengomado"
                                        class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                        @if ($modo == 'solo_lectura' || $modo == 'solo_urdido') disabled @endif required>
                                        <option value="{{ $ordenCompleta->lmatengomado }}">
                                            {{ $ordenCompleta->lmatengomado }}
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botón discreto para enviar -->
            <div class="-mt-4">
                <button type="submit" onclick="this.disabled=true; this.form.submit();"
                    class="w-1/5 bg-green-500 text-black px-4 py-2 rounded">
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
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('error'))
                alert("⚠️ {{ session('error') }}");
            @endif

            @if (session('success'))
                alert("✅ {{ session('success') }}");
            @endif

            @if ($errors->any())
                alert("⚠️ Por favor, revisa los errores del formulario.");
            @endif
        });
    </script>
    <!--busca BOMIDs para select2 de URDIDO-->
    <script>
        $('#bomSelect').select2({
            placeholder: "Buscar BOM...",
            ajax: {
                url: '{{ route('bomids.api') }}',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: data.map(item => ({
                            id: item.BOMID,
                            text: item.BOMID
                        }))
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            width: 'resolve'
        });
    </script>

    <!--busca BOMIDs para select2 de ENGOMADO-->
    <script>
        $(document).ready(function() {
            $('#bomSelect2').select2({
                placeholder: "Buscar lista...",
                ajax: {
                    url: '{{ route('bomids.api2') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // texto del buscador
                            tipo: '{{ $tipo }}' // aquí se envía "Pie" o "Rizo" desde Blade
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(item => ({
                                id: item.BOMID,
                                text: item.BOMID
                            }))
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                width: 'resolve'
            });
        });
    </script>



@endsection
