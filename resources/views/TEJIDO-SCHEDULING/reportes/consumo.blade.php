@extends('layouts.app')

@section('menu-planeacion')
@endsection

@section('content')
    @php
        $head = 'px-1.5 py-px text-left text-[9px] font-bold uppercase tracking-tight whitespace-nowrap';
        $cell = 'px-1.5 py-px text-[10px] leading-[1] whitespace-nowrap';
        $altoTabla = 'max-h-[260px]'; // cambia el alto visible si quieres
    @endphp

    <div class="max-w-7xl mx-auto">
        {{-- Wrapper que permite scroll vertical de TODAS las tarjetas de tablas --}}
        <div class="h-[calc(100vh-50px)] overflow-y-auto thin-scroll bigScroll pr-1 pl-1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-1.5">

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
                                            <td class="{{ $cell }} text-center">
                                                {{ number_format($t, 0, '.', ',') }}
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
                                    @foreach ($comb1Data as $calibre => $filas)
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
                                        @foreach ($comb1Totales as $t)
                                            <td class="{{ $cell }} text-center">
                                                {{ number_format($t, 0, '.', ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- =============== TABLA 3 =============== --}}
                <div class="rounded-xl shadow-sm border border-blue-200 bg-white">
                    <div class="px-2 pt-0.5 pb-0.5">
                        <h2 class="text-blue-800 font-extrabold text-[15px] leading-tight">CONSUMO COMBINACIÓN 2</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="{{ $altoTabla }} overflow-y-auto thin-scroll">
                            <table class="min-w-full text-gray-800 tbl-compact">
                                <thead class="bg-blue-100 border-y border-blue-200 sticky top-0 z-20">
                                    <tr class="text-[9px]">
                                        <th class="{{ $head }} w-28">CALIBRE</th>
                                        <th class="{{ $head }} w-52">COLOR C2</th>
                                        @foreach ($semanas as $s)
                                            <th class="{{ $head }} text-center w-16">{{ $s }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comb2Data as $calibre => $filas)
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
                                        @foreach ($comb2Totales as $t)
                                            <td class="{{ $cell }} text-center">
                                                {{ number_format($t, 0, '.', ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- =============== TABLA 4 =============== --}}
                <div class="rounded-xl shadow-sm border border-blue-200 bg-white">
                    <div class="px-2 pt-0.5 pb-0.5">
                        <h2 class="text-blue-800 font-extrabold text-[15px] leading-tight">CONSUMO COMBINACIÓN 3</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="{{ $altoTabla }} overflow-y-auto thin-scroll">
                            <table class="min-w-full text-gray-800 tbl-compact">
                                <thead class="bg-blue-100 border-y border-blue-200 sticky top-0 z-20">
                                    <tr class="text-[9px]">
                                        <th class="{{ $head }} w-28">CALIBRE</th>
                                        <th class="{{ $head }} w-52">COLOR C3</th>
                                        @foreach ($semanas as $s)
                                            <th class="{{ $head }} text-center w-16">{{ $s }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comb3Data as $calibre => $filas)
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
                                        @foreach ($comb3Totales as $t)
                                            <td class="{{ $cell }} text-center">
                                                {{ number_format($t, 0, '.', ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- =============== TABLA 5 =============== --}}
                <div class="rounded-xl shadow-sm border border-blue-200 bg-white">
                    <div class="px-2 pt-0.5 pb-0.5">
                        <h2 class="text-blue-800 font-extrabold text-[15px] leading-tight">CONSUMO COMBINACIÓN 4</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="{{ $altoTabla }} overflow-y-auto thin-scroll">
                            <table class="min-w-full text-gray-800 tbl-compact">
                                <thead class="bg-blue-100 border-y border-blue-200 sticky top-0 z-20">
                                    <tr class="text-[9px]">
                                        <th class="{{ $head }} w-28">CALIBRE</th>
                                        <th class="{{ $head }} w-52">COLOR C4</th>
                                        @foreach ($semanas as $s)
                                            <th class="{{ $head }} text-center w-16">{{ $s }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- vacía por ahora --}}
                                </tbody>
                                <tfoot class="bg-blue-50 border-t border-blue-200">
                                    <tr class="font-bold">
                                        <td class="{{ $cell }}">Total general</td>
                                        <td class="{{ $cell }}"></td>
                                        @foreach ($comb4Totales as $t)
                                            <td class="{{ $cell }} text-center">
                                                {{ number_format($t, 0, '.', ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- =============== TABLA 6 =============== --}}
                <div class="rounded-xl shadow-sm border border-blue-200 bg-white">
                    <div class="px-2 pt-0.5 pb-0.5">
                        <h2 class="text-blue-800 font-extrabold text-[15px] leading-tight">CONSUMO PIE</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="{{ $altoTabla }} overflow-y-auto thin-scroll">
                            <table class="min-w-full text-gray-800 tbl-compact">
                                <thead class="bg-blue-100 border-y border-blue-200 sticky top-0 z-20">
                                    <tr class="text-[9px]">
                                        <th class="{{ $head }} w-28">Calibre P</th>
                                        <th class="{{ $head }} w-52">Color Pie</th>
                                        @foreach ($semanas as $s)
                                            <th class="{{ $head }} text-center w-16">{{ $s }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pieData as $calibre => $filas)
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
                                        @foreach ($pieTotales as $t)
                                            <td class="{{ $cell }} text-center">
                                                {{ number_format($t, 0, '.', ',') }}
                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- =============== TABLA 7 =============== --}}
                <div class="rounded-xl shadow-sm border border-blue-200 bg-white">
                    <div class="px-2 pt-0.5 pb-0.5">
                        <h2 class="text-blue-800 font-extrabold text-[15px] leading-tight">CONSUMO RIZO</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="{{ $altoTabla }} overflow-y-auto thin-scroll">
                            <table class="min-w-full text-gray-800 tbl-compact">
                                <thead class="bg-blue-100 border-y border-blue-200 sticky top-0 z-20">
                                    <tr class="text-[9px]">
                                        <th class="{{ $head }} w-28">&nbsp;</th> {{-- sin título, como en Excel --}}
                                        <th class="{{ $head }} w-52">Hilo</th>
                                        @foreach ($semanas as $s)
                                            <th class="{{ $head }} text-center w-16">{{ $s }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rizoData as $grupo => $filas)
                                        <tr class="bg-gray-50">
                                            <td class="{{ $cell }} font-semibold">+ {{ $grupo }}</td>
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
                                        @foreach ($rizoTotales as $t)
                                            <td class="{{ $cell }} text-center">
                                                {{ number_format($t, 0, '.', ',') }}</td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
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

        .thin-scroll {
            scrollbar-width: thin;
            scrollbar-color: #a9c9f5 transparent;
        }

        .thin-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

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
    </style>
@endsection
