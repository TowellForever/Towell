@extends('layouts.app', ['ocultarBotones' => true])

@section('content')
    <!-- Vista del formulario para registrar datos de URDIDO y ENGOMADO, además Construcción JULIOS -->
    <div class="mt-3 mb-20 p-1 overflow-y-auto max-h-[550px] ">

        {{-- Mostrar errores de validación --}}
        <form id="formStep1" method="POST" action="{{ route('urdido.step2') }}" method="POST"> {{-- ANTES:  action="{{ route('orden.produccion.store') }}" --}}
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

                // Paleta PRO (colores más vivos y corporativos)
                $rowPalette = [
                    'bg-[#5EEAD4]', // teal-300
                    'bg-[#FCD34D]', // amber-300
                    'bg-[#6EE7B7]', // emerald-300
                    'bg-[#FDA4AF]', // rose-300
                    'bg-[#C4B5FD]', // violet-300
                    'bg-[#A5B4FC]', // indigo-300
                    'bg-[#7DD3FC]', // sky-300
                    'bg-[#93C5FD]', // blue-300
                ];
            @endphp
            <table class="w-full text-xs border-separate border-spacing-0 border border-gray-300 mb-4">
                <thead class="h-10 bg-gray-200 text-left">
                    <tr>
                        <th class="border px-1 py-0.5 w-12">Telar</th>
                        <th class="border px-1 py-0.5 w-24">Fecha Req</th>
                        <th class="border px-1 py-0.5 w-16">Cuenta</th>
                        <th class="border px-1 py-0.5 w-16">Calibre</th>
                        <th class="border px-1 py-0.5 w-16">Hilo</th>
                        <th class="border px-1 py-0.5 w-24">Urdido</th>
                        <th class="border px-1 py-0.5 w-16">Tipo</th>
                        <th class="border px-1 py-0.5 w-24">Destino</th>
                        <th class="border px-1 py-0.5 w-24">Tipo Atado</th>
                        <th class="border px-1 py-0.5 w-16">Metros</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($requerimientos as $index => $req)
                        @php
                            $idx = crc32((string) ($req->id ?? $i)) % count($rowPalette); // color estable por id
                            $rowClass = $rowPalette[$idx];
                        @endphp
                        <tr
                            class="{{ $rowClass }} text-slate-800 transition
                            hover:[&>td]:bg-white/70
                            hover:[&>td]:ring-1 hover:[&>td]:ring-slate-400 hover:[&>td]:ring-inset
                            focus-within:[&>td]:ring-2 focus-within:[&>td]:ring-sky-500">
                            {{-- Telar --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                <input type="hidden" name="registros[{{ $index }}][id]" value="{{ $req->id }}">
                                <input type="text" name="registros[{{ $index }}][telar]"
                                    value="{{ $req->telar ?? '' }}"
                                    class="form-input w-full px-1 py-0.5 text-xs border border-gray-300 rounded">
                            </td>

                            {{-- Fecha requerida --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                <input type="date" name="registros[{{ $index }}][fecha_requerida]"
                                    value="{{ $req->fecha_requerida ? \Carbon\Carbon::parse($req->fecha_requerida)->format('Y-m-d') : '' }}"
                                    class="form-input w-full px-1 py-0.5 text-xs border border-gray-300 rounded">
                            </td>

                            {{-- Cuenta --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                <input type="text" name="registros[{{ $index }}][cuenta]"
                                    value="{{ $req->rizo == 1 ? decimales($req->cuenta_rizo) : decimales($req->cuenta_pie) }}"
                                    class="form-input w-full px-1 py-0.5 text-xs border border-gray-300 rounded">
                            </td>

                            {{-- Calibre --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                {{ $req->rizo ? $req->calibre_rizo : $req->calibre_pie }}
                            </td>

                            {{-- Hilo --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                {{ $req->hilo ?? '-' }}
                            </td>

                            {{-- Urdido (select) --}}
                            <td class="border px-1 py-0.5 first:rounded-l-md last:rounded-r-md overflow-hidden">
                                {{-- URDIDO - MC COY --}}
                                @php
                                    // Valor seleccionado: primero old(), si no existe usa $datos->salon (o '')
                                    $sel = old("registros.$index.destino", $datos->salon ?? '');
                                @endphp

                                <select name="registros[{{ $index }}][urdido]"
                                    class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded" required>
                                    <option value="" disabled {{ $sel === '' ? 'selected' : '' }}></option>
                                    <option value="Mc Coy 1" {{ $sel === 'Mc Coy 1' ? 'selected' : '' }}>Mc Coy 1</option>
                                    <option value="Mc Coy 2" {{ $sel === 'Mc Coy 2' ? 'selected' : '' }}>Mc Coy 2</option>
                                    <option value="Mc Coy 3" {{ $sel === 'Mc Coy 3' ? 'selected' : '' }}>Mc Coy 3</option>
                                </select>
                            </td>


                            {{-- Tipo --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                {{ $req->rizo ? 'Rizo' : ($req->pie ? 'Pie' : '-') }}
                            </td>

                            {{-- Destino --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                <input type="text" name="registros[{{ $index }}][destino]"
                                    value="{{ $datos->salon ?? '' }}"
                                    class="form-input w-full px-1 py-0.5 text-xs border border-gray-300 rounded">
                            </td>

                            {{-- Tipo Atado --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                <select name="registros[{{ $index }}][tipo_atado]"
                                    class="form-input w-full px-1 py-0.5 text-xs border border-gray-300 rounded" required>
                                    <option value="Normal"
                                        {{ old('registros.' . $index . '.tipo_atado') == 'Normal' ? 'selected' : '' }}>
                                        Normal</option>
                                    <option value="Especial"
                                        {{ old('registros.' . $index . '.tipo_atado') == 'Especial' ? 'selected' : '' }}>
                                        Especial</option>
                                </select>
                            </td>

                            {{-- Metros --}}
                            <td class="border px-1 py-0.5 text-center first:rounded-l-md last:rounded-r-md overflow-hidden">
                                <input type="number" name="registros[{{ $index }}][metros]"
                                    value="{{ $req->metros ?? '' }}"
                                    class="form-input w-full px-1 py-0.5 text-xs border border-gray-300 rounded"
                                    min="0" step="1" placeholder="0">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="-mt-4">
                <button type="submit" onclick="this.disabled=true; this.innerText='Enviando...'; this.form.submit();"
                    class="w-1/5 bg-green-600 text-white px-4 py-2 rounded font-semibold hover:bg-green-700">
                    SIGUIENTE
                </button>
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
                        Swal.fire({
                            icon: 'warning',
                            title: '!ATENCIÓN!',
                            text: 'Por favor, revisa los errores del formulario.',
                            confirmButtonColor: '#f59e0b', // color ámbar
                            confirmButtonText: '  Entendido  '
                        });
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
