@extends('layouts.app')

@section('content')
    @php
        $step1 = collect(session('urdido.step1', [])); // id => { destino, metros, urdido, ... }

        // Paleta
        $rowPalette = [
            'bg-[#93C5FD]', // blue-300
            'bg-[#7DD3FC]', // sky-300
            'bg-[#5EEAD4]', // teal-300
            'bg-[#6EE7B7]', // emerald-300
            'bg-[#FCD34D]', // amber-300
            'bg-[#FDA4AF]', // rose-300
            'bg-[#C4B5FD]', // violet-300
            'bg-[#A5B4FC]', // indigo-300
        ];
    @endphp

    <div class="space-y-4">

        {{-- ===================== SEGUNDA PÁGINA (AGRUPADOS) ===================== --}}
        <table class="w-full text-xs border-separate border-spacing-0 border border-gray-300 mb-2">
            <thead class="h-8">
                <tr class="bg-gray-200 text-left text-slate-900">{{-- ESPACIOS WIDHT POR PIXELES 1900 --}}
                    <th class="border px-1 py-0.5 w-20">Telar</th>
                    <th class="border px-1 py-0.5 w-14">Fec Req</th>
                    <th class="border px-1 py-0.5 w-12">Cuenta</th>
                    <th class="border px-1 py-0.5 w-8">Calibre</th>
                    <th class="border px-1 py-0.5 w-12">Hilo</th>
                    <th class="border px-1 py-0.5 w-20">Urdido</th>
                    <th class="border px-1 py-0.5 w-6">Tipo</th>
                    <th class="border px-1 py-0.5 w-8">Destino</th>
                    <th class="border px-1 py-0.5 w-14">Metros</th>
                    <th class="border px-1 py-0.5 w-30">L.Mat Urdido</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agrupados as $i => $g)
                    @php $rowClass = $rowPalette[$i % count($rowPalette)]; @endphp
                    <tr class="{{ $rowClass }}">
                        <td class="border px-1 py-0.5">{{ $g->telar_str }}</td>
                        <td class="border px-1 py-0.5">
                            {{ $g->fecha_requerida ? \Carbon\Carbon::parse($g->fecha_requerida)->format('d/m/Y') : '' }}
                        </td>
                        <td class="border px-1 py-0.5">{{ decimales($g->cuenta) }}</td>
                        <td class="border px-1 py-0.5">{{ $g->calibre }}</td>
                        <td class="border px-1 py-0.5">{{ $g->hilo }}</td>
                        <td class="border px-1 py-0.5">{{ $g->urdido }}</td>
                        <td class="border px-1 py-0.5">{{ $g->tipo }}</td>
                        <td class="border px-1 py-0.5">{{ $g->destino }}</td>
                        <td class="border px-1 py-0.5 text-right">{{ decimales($g->metros) }}</td>
                        <td class="border px-1 py-0.5">
                            {{-- IMPORTANTE: usa clase y nombre indexado --}}
                            @php
                                // Lo que tengas guardado (id y texto). Si solo tienes id, usamos el mismo id como texto.
                                $preId = old("agrupados.$i.lmaturdido", $g->lmaturdido_id ?? null);
                                $preText = old("agrupados.$i.lmaturdido_text", $g->lmaturdido_text ?? null) ?? $preId;
                            @endphp

                            <select name="agrupados[{{ $i }}][lmaturdido]"
                                class="js-bom-select form-select w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                data-selected-id="{{ $preId ?? '' }}" data-selected-text="{{ $preText ?? '' }}">
                                {{-- opción vacía para placeholder --}}
                                <option value=""></option>

                                {{-- si ya hay valor previo, imprimimos la opción seleccionada con texto --}}
                                @if ($preId)
                                    <option value="{{ $preId }}" selected>{{ $preText }}</option>
                                @endif
                            </select>

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
        <div class="flex items-start gap-4">
            {{-- ... tabla y BOTONES del lado izquierdo... --}}

            {{-- Botones laterales compactos y bonitos --}}
            <aside class="ml-auto w-56  top-4">
                <div class="rounded-xl border border-slate-200 bg-white/90 shadow-sm p-2 space-y-2">

                    <form method="POST" action="{{ route('reservar.inventario') }}">
                        @csrf
                        @foreach ($requerimientos as $req)
                            <input type="hidden" name="ids[]" value="{{ $req->id }}">
                        @endforeach

                        <button
                            class="w-full px-3 py-2 rounded-lg text-sm font-semibold
                           bg-emerald-600 text-white hover:bg-emerald-700
                           focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-1">
                            Reservar inventario
                        </button>
                    </form>

                    <form method="POST" action="{{ route('orden.produccion.store') }}">
                        @csrf
                        @foreach ($requerimientos as $req)
                            <input type="hidden" name="ids[]" value="{{ $req->id }}">
                        @endforeach

                        <button
                            class="w-full px-3 py-2 rounded-lg text-sm font-semibold
                           bg-blue-600 text-white hover:bg-blue-700
                           focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1">
                            Crear órdenes
                        </button>
                    </form>

                </div>
            </aside>
        </div>


        {{-- ====== Bloques inferiores  CONS URDIDO Y ENGOMADO ====== --}}
        <div class="flex space-x-1">
            <div class="w-1/6 p-1">

                <div class="flex">
                    <table class="w-full text-xs border-collapse border border-gray-300 mb-4">
                        <thead class="h-10">
                            <tr class="bg-gray-200 text-center">
                                <th colspan="2">CONTRUCCIÓN URDIDO</th>
                            </tr>
                            <tr class="bg-gray-200 text-center">
                                <th class="border px-1 py-0.5">No. Julios</th>
                                <th class="border px-1 py-0.5">Hilos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 4; $i++)
                                <tr>
                                    <td class="border px-1 py-0.5">
                                        <input type="text" inputmode="numeric" pattern="[0-9]*" name="no_julios[]"
                                            class="form-input px-1 py-0.5 text-[10px] border border-gray-300 rounded w-full"
                                            value="{{ old('no_julios.' . $i) }}">
                                    </td>
                                    <td class="border px-1 py-0.5">
                                        <input type="text" inputmode="numeric" pattern="[0-9]*" name="hilos[]"
                                            class="form-input px-1 py-0.5 text-[10px] border border-gray-300 rounded w-full"
                                            value="{{ old('hilos.' . $i) }}">
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="w-5/6 p-1">
                <table class="w-full text-xs border-collapse border border-gray-300">
                    <thead class="h-4">
                        <tr class="bg-gray-200 text-center">
                            <th colspan="7">DATOS DE ENGOMADO</th>
                        </tr>
                        <tr class="bg-gray-200 text-left">
                            <th class="border px-1">Núcleo</th>
                            <th class="border px-1">No. de Telas</th>
                            <th class="border px-1">Ancho Balonas</th>
                            <th class="border px-1">Metraje de Telas</th>
                            <th class="border px-1">Cuendeados Mín. por Tela</th>
                            <th class="border px-1">L Mat Engomado</th>
                            <th class="border px-1 w-1/4">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody class="h-24">
                        <tr>
                            <td class="border px-1 py-0.5">
                                <select name="nucleo"
                                    class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded">
                                    <option value="" disabled {{ old('nucleo') ? '' : 'selected' }}></option>
                                    <option value="Itema" {{ old('nucleo') == 'Itema' ? 'selected' : '' }}>Itema
                                    </option>
                                    <option value="Smit" {{ old('nucleo') == 'Smit' ? 'selected' : '' }}>Smit
                                    </option>
                                    <option value="Jacquard" {{ old('nucleo') == 'Jacquard' ? 'selected' : '' }}>Jacquard
                                    </option>
                                </select>
                            </td>
                            <td class="border px-1 py-0.5">
                                <input type="text" inputmode="numeric" pattern="[0-9]*" name="no_telas"
                                    class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                    value="{{ old('no_telas') }}">
                            </td>
                            <td class="border px-1 py-0.5">
                                <input type="text" inputmode="numeric" pattern="[0-9]*" name="balonas"
                                    class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                    value="{{ old('balonas') }}">
                            </td>
                            <td class="border px-1 py-0.5">
                                <input type="text" inputmode="numeric" pattern="[0-9]*" name="metros_tela"
                                    class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                    value="{{ old('metros_tela') }}">
                            </td>
                            <td class="border px-1 py-0.5">
                                <input type="text" inputmode="numeric" pattern="[0-9]*" name="cuendados_mini"
                                    class="form-input w-full px-1 py-1 text-xs border border-gray-300 rounded"
                                    value="{{ old('cuendados_mini') }}">
                            </td>
                            <td class="border px-1 py-0.5">
                                <select id="bomSelect2" name="lmatengomado"
                                    class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded" required>
                                    <option value="" disabled selected>Selecciona una lista</option>
                                </select>
                            </td>
                            <td class="border px-1 py-0.5">
                                <textarea name="observaciones" class="form-textarea w-full px-1 py-1 text-xs border border-gray-300 rounded h-16">{{ old('observaciones') }}</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Navegación inferior --}}
        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ url()->previous() }}"
                class="px-4 py-1 rounded border font-semibold bg-white hover:bg-slate-50 ">VOLVER</a>
            <button class="w-[200px] px-4 py-1 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700">
                GUARDAR DATOS DE ENGOMADO
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlBoms = @json(route('bomids.api'));

            $('.js-bom-select').each(function() {
                const $el = $(this);

                // Si trae data-selected-id pero no existe un <option selected> con texto,
                // podríamos cargarlo por AJAX (opcional). Si no tienes endpoint por id, omite este bloque.
                const selId = $el.data('selected-id');
                const selText = $el.data('selected-text');

                if (selId && !$el.find('option[value="' + selId + '"]').length) {
                    const opt = new Option(selText || selId, selId, true, true);
                    $el.append(opt);
                }

                $el.select2({
                    placeholder: 'Buscar BOM...',
                    allowClear: false,
                    ajax: {
                        url: urlBoms,
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            q: params.term
                        }),
                        processResults: data => ({
                            results: data.map(item => ({
                                id: item.BOMID,
                                text: item.BOMID
                            })) // usa item.DESCRIPCION si la tienes
                        }),
                        cache: true
                    },
                    minimumInputLength: 1,
                    dropdownParent: $el.parent(), // estable dentro de celdas/scroll
                    width: 'style',
                    // Si por cualquier motivo viene sin "text", mostramos el id
                    templateSelection: function(data, container) {
                        if (!data.id) return 'Buscar BOM...';
                        return data.text || data.id;
                    }
                });
            });
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
                            tipo: '{{ $g->tipo }}' // aquí se envía "Pie" o "Rizo" desde Blade
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
