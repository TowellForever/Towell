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
        <div class="flex items-start gap-4">
            {{-- Botones laterales (si necesitas pasar ids del paso 1) --}}
            <div class="shrink-0 w-56 space-y-4">
                <form method="POST" action="{{ route('reservar.inventario') }}">
                    @csrf
                    @foreach ($requerimientos as $i => $req)
                        <input type="hidden" name="ids[]" value="{{ $req->id }}">
                    @endforeach
                    <button class="w-full border px-4 py-3 rounded bg-white hover:bg-slate-50 font-semibold">
                        Reservar Inventario
                    </button>
                </form>

                <form method="POST" action="{{ route('orden.produccion.store') }}">
                    @csrf
                    @foreach ($requerimientos as $i => $req)
                        <input type="hidden" name="ids[]" value="{{ $req->id }}">
                    @endforeach
                    <button class="w-full border px-4 py-3 rounded bg-white hover:bg-slate-50 font-semibold">
                        Crear Órdenes
                    </button>
                </form>
            </div>
        </div>

        {{-- ===================== SEGUNDAS PÁGINA (AGRUPADOS) ===================== --}}
        <table class="w-full text-xs border-separate border-spacing-0 border border-gray-300 mb-2">
            <thead class="h-10">
                <tr class="bg-gray-200 text-left text-slate-900">
                    <th class="border px-1 py-0.5 w-28">Telar</th>
                    <th class="border px-1 py-0.5 w-20">Fec Req</th>
                    <th class="border px-1 py-0.5 w-16">Cuenta</th>
                    <th class="border px-1 py-0.5 w-16">Calibre</th>
                    <th class="border px-1 py-0.5 w-12">Hilo</th>
                    <th class="border px-1 py-0.5 w-24">Urdido</th>
                    <th class="border px-1 py-0.5 w-12">Tipo</th>
                    <th class="border px-1 py-0.5 w-24">Destino</th>
                    <th class="border px-1 py-0.5 w-14">Metros</th>
                    <th class="border px-1 py-0.5 w-14">L.Mat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agrupados as $i => $g)
                    @php
                        $rowClass = $rowPalette[$i % count($rowPalette)];
                    @endphp
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
                        <td class="border px-1 py-0.5 text-right">{{ number_format($g->metros, 0) }}</td>
                        <td class="border px-1 py-0.5 text-center">—</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ====== Bloques inferiores ====== --}}
        <div class="flex space-x-1">
            <div class="w-1/6 p-1">
                <h2 class="text-sm font-bold">Construcción Urdido</h2>
                <div class="flex">
                    <table class="w-full text-xs border-collapse border border-gray-300 mb-4">
                        <thead class="h-10">
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
                <h2 class="text-sm font-bold">Datos Engomado</h2>
                <br class="block md:hidden">

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
                class="px-4 py-2 rounded border font-semibold bg-white hover:bg-slate-50">Volver</a>
            <button class="px-4 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700">
                Guardar datos de Engomado
            </button>
        </div>
    </div>
@endsection
