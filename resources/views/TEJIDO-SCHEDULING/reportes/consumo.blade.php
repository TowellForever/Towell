{{-- resources/views/TEJIDO-SCHEDULING/reportes/consumos-dobles.blade.php --}}
@extends('layouts.app')

@section('menu-planeacion')
@endsection

@section('content')
    @php
        $head = 'px-1.5 py-px text-left text-[9px] font-bold uppercase tracking-tight whitespace-nowrap';
        $cell = 'px-1.5 py-px text-[10px] leading-[1] whitespace-nowrap';
        $altoTabla = 'max-h-[260px]'; // <--- ajusta aquí el alto de TODAS las tablas
    @endphp

    <div class="max-w-7xl mx-auto space-y-1.5">
        {{-- 2 columnas siempre; si prefieres 1 en móvil usa: grid-cols-1 md:grid-cols-2 --}}
        <div class="grid grid-cols-2 gap-1.5">

            {{-- =============== TABLA 1 =============== --}}
            <div class="rounded-xl shadow-sm border border-blue-200 bg-white">
                <div class="px-2 pt-0.5 pb-0.5">
                    <h2 class="text-blue-800 font-extrabold text-[15px] leading-tight">CONSUMO TRAMA</h2>
                </div>

                <div class="overflow-x-auto">
                    {{-- Scroll vertical con altura máxima --}}
                    <div class="{{ $altoTabla }} overflow-y-auto thin-scroll">
                        <table class="min-w-full text-gray-800 tbl-compact">
                            <thead class="bg-blue-100 border-y border-blue-200 sticky top-0 z-20">
                                <tr class="text-[9px]">
                                    <th class="{{ $head }} w-28">CALIBRE TRAMA</th>
                                    <th class="{{ $head }} w-52">COLOR TRAMA</th>
                                    @foreach ($semanas as $s)
                                        <th class="{{ $head }} text-center w-16">{{ $s }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tramaData as $calibre => $filas)
                                    <tr class="bg-gray-50">
                                        <td class="{{ $cell }} font-semibold">+ {{ $calibre }}</td>
                                        <td class="{{ $cell }}"></td>
                                        @for ($i = 0; $i < count($semanas); $i++)
                                            <td class="{{ $cell }}"></td>
                                        @endfor
                                    </tr>
                                    @foreach ($filas as $fila)
                                        <tr class="hover:bg-blue-50">
                                            <td class="{{ $cell }}"></td>
                                            <td class="{{ $cell }} pl-1">{{ $fila['color'] }}</td>
                                            @foreach ($fila['w'] as $v)
                                                <td class="{{ $cell }} text-center">
                                                    {{ number_format($v, 0, '.', ',') }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot class="bg-blue-50 border-t border-blue-200">
                                <tr class="font-bold">
                                    <td class="{{ $cell }}">Total general</td>
                                    <td class="{{ $cell }}"></td>
                                    @foreach ($tramaTotales as $t)
                                        <td class="{{ $cell }} text-center">{{ number_format($t, 0, '.', ',') }}
                                        </td>
                                    @endforeach
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- =============== TABLA 2 =============== --}}
            <div class="rounded-xl shadow-sm border border-blue-200 bg-white">
                <div class="px-2 pt-0.5 pb-0.5">
                    <h2 class="text-blue-800 font-extrabold text-[15px] leading-tight">CONSUMO COMBINACIÓN 1</h2>
                </div>

                <div class="overflow-x-auto">
                    <div class="{{ $altoTabla }} overflow-y-auto thin-scroll">
                        <table class="min-w-full text-gray-800 tbl-compact">
                            <thead class="bg-blue-100 border-y border-blue-200 sticky top-0 z-20">
                                <tr class="text-[9px]">
                                    <th class="{{ $head }} w-28">CALIBRE C1</th>
                                    <th class="{{ $head }} w-52">COLOR C1</th>
                                    @foreach ($semanas as $s)
                                        <th class="{{ $head }} text-center w-16">{{ $s }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($combData as $calibre => $filas)
                                    <tr class="bg-gray-50">
                                        <td class="{{ $cell }} font-semibold">+ {{ $calibre }}</td>
                                        <td class="{{ $cell }}"></td>
                                        @for ($i = 0; $i < count($semanas); $i++)
                                            <td class="{{ $cell }}"></td>
                                        @endfor
                                    </tr>
                                    @foreach ($filas as $fila)
                                        <tr class="hover:bg-blue-50">
                                            <td class="{{ $cell }}"></td>
                                            <td class="{{ $cell }} pl-1">{{ $fila['color'] }}</td>
                                            @foreach ($fila['w'] as $v)
                                                <td class="{{ $cell }} text-center">
                                                    {{ number_format($v, 0, '.', ',') }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot class="bg-blue-50 border-t border-blue-200">
                                <tr class="font-bold">
                                    <td class="{{ $cell }}">Total general</td>
                                    <td class="{{ $cell }}"></td>
                                    @foreach ($combTotales as $t)
                                        <td class="{{ $cell }} text-center">{{ number_format($t, 0, '.', ',') }}
                                        </td>
                                    @endforeach
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Si luego agregas más tablas, solo mete más <div class="rounded-xl ..."> aquí y el grid las colocará:
         tabla 1 | tabla 2
         tabla 3 | tabla 4
         tabla 5 | tabla 6, etc. --}}
        </div>
    </div>

    <style>
        /* ====== Tabla ultra compacta tipo Excel ====== */
        .tbl-compact {
            border-collapse: collapse;
        }

        .tbl-compact thead th {
            font-size: 9px;
            line-height: 1;
        }

        .tbl-compact td,
        .tbl-compact th {
            padding: 1px 4px !important;
            line-height: 1 !important;
            white-space: nowrap;
        }

        .tbl-compact tbody td,
        .tbl-compact tfoot td {
            border-right: 0.5px solid #e5eef7;
        }

        .tbl-compact tbody tr:hover {
            transition: background 120ms;
            background: #f5f9ff;
        }

        /* ====== Header/foot sticky (por si no usas utilidades Tailwind) ====== */
        .sticky-head thead {
            position: sticky;
            top: 0;
            z-index: 20;
            background: #eaf2ff;
        }

        .sticky-foot tfoot {
            position: sticky;
            bottom: 0;
            z-index: 20;
            background: #eef6ff;
        }

        /* ====== Scrollbar delgada (WebKit + Firefox) ====== */
        .thin-scroll {
            scrollbar-width: thin;
            scrollbar-color: #a9c9f5 transparent;
        }

        /* Firefox */
        .thin-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        /* Chrome/Edge */
        .thin-scroll::-webkit-scrollbar-thumb {
            background: #c9dff7;
            border-radius: 8px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        .thin-scroll::-webkit-scrollbar-thumb:hover {
            background: #a9c9f5;
            background-clip: content-box;
        }

        .thin-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        /* ====== Ajustes menores del card ====== */
        .rounded-xl>.px-2 {
            padding-top: 2px !important;
            padding-bottom: 2px !important;
        }
    </style>
@endsection
