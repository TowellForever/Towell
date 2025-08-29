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

    <div class="space-y-1">
        {{-- ===================== SEGUNDA PÁGINA (AGRUPADOS) ===================== --}}
        <div class="flex items-start gap-4">
            <!-- Columna izquierda: TABLA -->
            <div class="flex-1">
                <table class="w-full text-xs border-separate border-spacing-0 border border-gray-300 ml-1 pr-2">
                    <thead class="h-8">
                        <tr class="bg-gray-200 text-left text-slate-900">
                            <th class="border px-0.5 w-[130px]">Telar</th>
                            <th class="border px-0.5 w-[70px]">Fec Req</th>
                            <th class="border px-0.5 w-[50px]">Cuenta</th>
                            <th class="border px-0.5 w-[50px]">Calibre</th>
                            <th class="border px-0.5 w-[50px]">Hilo</th>
                            <th class="border px-0.5 w-[70px]">Urdido</th>
                            <th class="border px-0.5 w-[50px]">Tipo</th>
                            <th class="border px-0.5 w-[70px]">Destino</th>
                            <th class="border px-0.5 w-[70px]">Metros</th>
                            <th class="border px-0.5 w-[180px]">L.Mat Urdido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agrupados as $i => $g)
                            @php $rowClass = $rowPalette[$i % count($rowPalette)]; @endphp
                            <tr class="{{ $rowClass }}">
                                <td class="border px-0.5">{{ $g->telar_str }}</td>
                                <td class="border px-0.5">
                                    {{ $g->fecha_requerida ? \Carbon\Carbon::parse($g->fecha_requerida)->format('d/m/Y') : '' }}
                                </td>
                                <td class="border px-0.5">{{ decimales($g->cuenta) }}</td>
                                <td class="border px-0.5">{{ $g->calibre }}</td>
                                <td class="border px-0.5">{{ $g->hilo }}</td>
                                <td class="border px-0.5">{{ $g->urdido }}</td>
                                <td class="border px-0.5">{{ $g->tipo }}</td>
                                <td class="border px-0.5">{{ $g->destino }}</td>
                                <td class="border px-0.5 text-right">{{ decimales($g->metros) }}</td>
                                <td class="border px-0.5">
                                    @php
                                        $preId = old("agrupados.$i.lmaturdido", $g->lmaturdido_id ?? null);
                                        $preText =
                                            old("agrupados.$i.lmaturdido_text", $g->lmaturdido_text ?? null) ?? $preId;
                                    @endphp

                                    <select name="agrupados[{{ $i }}][lmaturdido]" class="js-bom-select"
                                        data-selected-id="{{ $preId ?? '' }}" data-selected-text="{{ $preText ?? '' }}">
                                        <option value=""></option>
                                        @if ($preId)
                                            <option value="{{ $preId }}" selected>{{ $preText }}</option>
                                        @endif
                                    </select>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Columna derecha: BOTONES -->
        <section class="max-w-6xl mx-auto">
            <div class="rounded-3xl bg-blue-600/90 p-1 sm:p-8 shadow-2xl">
                <div class="flex flex-wrap items-center gap-2 ">

                    <!-- VOLVER -->
                    <a href="{{ url()->previous() }}" class="btn-candy btn-gray btn-left">
                        <span class="btn-bubble" aria-hidden="true">
                            <!-- Flecha hacia la izquierda -->
                            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M15 6l-6 6 6 6" />
                            </svg>
                        </span>
                        <span class="btn-text">VOLVER</span>
                    </a>

                    <!-- Reservar inventario -->
                    <form method="POST" action="{{ route('reservar.inventario') }}">
                        @csrf
                        @foreach ($requerimientos as $req)
                            <input type="hidden" name="ids[]" value="{{ $req->id }}">
                        @endforeach
                        <button type="submit" class="btn-candy btn-teal">
                            <span class="btn-text">RESERVAR INVENTARIO</span>
                            <span class="btn-bubble" aria-hidden="true">
                                <!-- Flecha -->
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M9 6l6 6-6 6" />
                                </svg>
                            </span>
                        </button>
                    </form>

                    <!-- Crear órdenes -->
                    <form method="POST" action="{{ route('orden.produccion.store') }}">
                        @csrf
                        @foreach ($requerimientos as $req)
                            <input type="hidden" name="ids[]" value="{{ $req->id }}">
                        @endforeach
                        <button type="submit" class="btn-candy btn-blue">
                            <span class="btn-text">CREAR ÓRDENES</span>
                            <span class="btn-bubble" aria-hidden="true">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M9 6l6 6-6 6" />
                                </svg>
                            </span>
                        </button>
                    </form>

                    <!-- (Opcional) Más botones con colores de muestra similares a la imagen -->
                    {{-- 
                    <button class="btn-candy btn-red"><span class="btn-text">ACCION ROJA</span><span class="btn-bubble"
                            aria-hidden="true"><svg viewBox="0 0 24 24" width="20" height="20" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path d="M9 6l6 6-6 6" />
                            </svg></span></button>
                    <button class="btn-candy btn-yellow"><span class="btn-text">ACCION AMARILLA</span><span
                            class="btn-bubble" aria-hidden="true"><svg viewBox="0 0 24 24" width="20" height="20"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 6l6 6-6 6" />
                            </svg></span></button>
                    --}}
                </div>
            </div>
        </section>

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
                            <td class="">
                                <select id="bomSelect2" name="lmatengomado"
                                    class="form-select px-3 py-1 text-xs border border-gray-300 rounded" required>
                                    <option value="" disabled selected>Selecciona una lista</option>
                                </select>
                            </td>
                            <td class="border px-3 py-1">
                                <textarea name="observaciones" class="form-textarea w-full px-1 py-1 text-xs border border-gray-300 rounded h-16">{{ old('observaciones') }}</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                    width: '100%', // para este SELECT estamos modificando el ancho desde JS (ATENCIÓN)
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

    @push('styles')
        <style>
            /* Botón “píldora” con burbuja blanca a la derecha */
            .btn-candy {
                --from: #60a5fa;
                /* fallback */
                --to: #2563eb;
                /* fallback */
                position: relative;
                display: inline-flex;
                align-items: center;
                gap: .75rem;
                padding: .4rem 1.7rem .4rem 1rem;
                /* margen para la burbuja derecha */
                border-radius: 9999px;
                color: #fff;
                font-weight: 600;
                letter-spacing: .2px;
                background: linear-gradient(145deg, var(--from), var(--to));
                box-shadow: 0 10px 20px rgba(0, 0, 0, .18), inset 0 1px 0 rgba(255, 255, 255, .25);
                transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
                outline: none;
            }

            .btn-candy .btn-text {
                white-space: nowrap;
                text-shadow: 0 1px 0 rgba(0, 0, 0, .15);
            }

            .btn-candy .btn-bubble {
                position: absolute;
                right: .1rem;
                top: 50%;
                transform: translateY(-50%);
                width: 1.5rem;
                height: 1.5rem;
                border-radius: 9999px;
                background: #fff;

                color: #ff3d7b;
                /* tono como en ejemplo rosa/fucsia */
                display: grid;
                place-items: center;
                box-shadow: 0 8px 16px rgba(0, 0, 0, .22);
                transition: transform .18s ease;
            }

            .btn-candy:hover,
            .btn-candy:focus-visible {
                transform: translateY(-2px);
                box-shadow: 0 14px 28px rgba(0, 0, 0, .22), inset 0 1px 0 rgba(255, 255, 255, .3);
                filter: saturate(1.05);
            }

            .btn-candy:hover .btn-bubble,
            .btn-candy:focus-visible .btn-bubble {
                transform: translateY(-50%) scale(1.06);
            }

            .btn-candy .btn-bubble svg {
                transition: transform .18s ease;
            }

            .btn-candy:hover .btn-bubble svg {
                transform: translateX(2px);
            }

            /* Paletas tipo “candy” (muy similares a las de tus imágenes) */
            .btn-teal {
                --from: #2fd5d3;
                --to: #0ea5a6;
            }

            /* verde/agua */
            .btn-blue {
                --from: #4facfe;
                --to: #2563eb;
            }

            /* azul */
            .btn-red {
                --from: #ff5e62;
                --to: #d00000;
            }

            /* rojo */
            .btn-yellow {
                --from: #f6d365;
                --to: #f7b733;
            }

            /* Variante gris + burbuja a la izquierda para VOLVER */
            .btn-gray {
                --from: #e5e7eb;
                /* gris claro */
                --to: #9ca3af;
                /* gris medio */
                color: #111827;
                /* texto oscuro para mejor contraste */
            }

            .btn-gray .btn-text {
                text-shadow: none;
            }

            .btn-gray .btn-bubble {
                color: #6b7280;
            }

            /* flecha gris */

            .btn-left {
                padding: .8rem 1.2rem .8rem 3.4rem;
                /* espacio a la izquierda para la burbuja */
            }

            .btn-left .btn-bubble {
                left: .35rem;
                right: auto;
                /* mueve la burbuja a la izquierda */
            }

            .btn-left:hover .btn-bubble svg {
                transform: translateX(-2px);
            }
        </style>
    @endpush
@endsection
