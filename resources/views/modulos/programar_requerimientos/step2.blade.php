@extends('layouts.app')

@section('content')
    <div class="space-y-4">
        <h1 class="text-lg font-bold text-slate-800">Segundas Página</h1>

        @php
            // Paleta PRO, más viva y corporativa
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

        {{-- ====== RESUMEN DE REGISTROS (igual a tu imagen de arriba) ====== --}}
        <div class="flex items-start gap-4">
            <div class="grow">
                <table class="w-full text-xs border-separate border-spacing-0 border border-gray-300 mb-2">
                    <thead class="h-10">
                        <tr class="bg-gray-200 text-left text-slate-900">
                            <th class="border px-1 py-0.5 w-20">Telar</th>
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
                        @foreach ($requerimientos as $i => $req)
                            @php
                                $idx = crc32((string) ($req->id ?? $i)) % count($rowPalette);
                                $rowClass = $rowPalette[$idx];

                                $tipo = ($req->rizo ?? 0) == 1 ? 'Rizo' : (($req->pie ?? 0) == 1 ? 'Pie' : '');
                                $cuenta = $tipo === 'Rizo' ? $req->cuenta_rizo ?? '' : $req->cuenta_pie ?? '';
                                $calibre = $tipo === 'Rizo' ? $req->calibre_rizo ?? '' : $req->calibre_pie ?? '';
                                $metros = $tipo === 'Rizo' ? $req->metros ?? 0 : $req->metros_pie ?? 0;

                                // Persistir ids del paso 1 en el siguiente form:

                            @endphp
                            <tr
                                class="{{ $rowClass }} text-slate-900 transition
                                   hover:[&>td]:bg-white/70 hover:[&>td]:ring-1 hover:[&>td]:ring-slate-400 hover:[&>td]:ring-inset
                                   focus-within:[&>td]:ring-2 focus-within:[&>td]:ring-sky-500">
                                <td class="border px-1 py-0.5">{{ $req->telar ?? '-' }}</td>
                                <td class="border px-1 py-0.5">
                                    {{ $req->fecha_requerida ? \Carbon\Carbon::parse($req->fecha_requerida)->format('d/m/Y') : '' }}
                                </td>
                                <td class="border px-1 py-0.5">{{ $cuenta }}</td>
                                <td class="border px-1 py-0.5">{{ $calibre }}</td>
                                <td class="border px-1 py-0.5">{{ $req->hilo ?? 'H' }}</td>
                                <td class="border px-1 py-0.5">{{ $req->urdido ?? '' }}</td>
                                <td class="border px-1 py-0.5">{{ $tipo }}</td>
                                <td class="border px-1 py-0.5">{{ $req->valor ?? '' }}</td>
                                <td class="border px-1 py-0.5 text-right">{{ number_format($metros, 0) }}</td>
                                <td class="border px-1 py-0.5 text-center">—</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Botones laterales como en tu screenshot --}}
            <div class="shrink-0 w-56 space-y-4">
                <form method="POST" action="{{ route('reservar.inventario') }}">
                    @csrf
                    {{-- pasa ids si hace falta --}}
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
                        Crear Ordenes
                    </button>
                </form>
            </div>
        </div>

        {{-- ====== LISTA DE MATERIALES: Urdido ====== --}}
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
                            class="form-select w-full px-1 py-1 text-xs border border-gray-300 rounded" required>
                            <option value="" disabled {{ old('lmaturdido') ? '' : 'selected' }}>Selecciona un BOM
                            </option>
                            @foreach ($boms as $bom)
                                <option value="{{ $bom->id }}" {{ old('lmaturdido') == $bom->id ? 'selected' : '' }}>
                                    {{ $bom->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- ====== Bloques inferiores: Construcción Urdido + Datos Engomado ====== --}}
        <div class="flex space-x-1">
            {{-- Columna 1: Construcción Urdido (tabla 2xN) --}}
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

            {{-- Columna 2: Datos Engomado --}}
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
                                    <option value="Itema" {{ old('nucleo') == 'Itema' ? 'selected' : '' }}>Itema</option>
                                    <option value="Smit" {{ old('nucleo') == 'Smit' ? 'selected' : '' }}>Smit</option>
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

        {{-- Navegación / acciones inferiores (opcional) --}}
        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ url()->previous() }}"
                class="px-4 py-2 rounded border font-semibold bg-white hover:bg-slate-50">Volver</a>
            <button class="px-4 py-2 rounded bg-blue-600 text-white font-semibold hover:bg-blue-700">
                Guardar datos de Engomado
            </button>
        </div>
    </div>
@endsection
