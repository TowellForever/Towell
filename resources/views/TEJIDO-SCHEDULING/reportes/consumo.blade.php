@extends('layouts.app')

@section('menu-planeacion')
@endsection

@section('content')
    @php
        $head = 'px-1.5 py-px text-left text-[9px] font-bold uppercase tracking-tight whitespace-nowrap';
        $cell = 'px-1.5 py-px text-[10px] leading-[1] whitespace-nowrap';
        $altoTabla = 'max-h-[260px]'; // alto visible por tabla
        $altoGrafica = 'h-[420px]'; // alto de la gráfica
    @endphp

    <div class="max-w-7xl mx-auto">

        {{-- ====== BARRA DE FILTRO (rango de fechas) ====== --}}
        <form method="GET" action="{{ route('reportes.consumo') }}"
            class=" top-0 z-30 mb-1 bg-white/90 backdrop-blur rounded-xl border border-blue-200 p-0.5">
            <div class="flex flex-wrap items-end gap-2 items-center ml-[4px]">
                <div>
                    <label class=" text-[11px] font-semibold text-gray-700 mb-0.5">Inicio</label>
                    <input type="date" name="inicio" value="{{ optional($inicio)->toDateString() }}"
                        class="border rounded px-2 py-1 text-[12px]" required>
                </div>
                <div>
                    <label class=" text-[11px] font-semibold text-gray-700 mb-0.5">Fin</label>
                    <input type="date" name="fin" value="{{ optional($fin)->toDateString() }}"
                        class="border rounded px-2 py-1 text-[12px]" required>
                </div>

                <button type="submit"
                    class="w-20 ml-1 inline-flex items-center gap-1 rounded bg-blue-600 text-white text-[12px] font-semibold px-3 py-1">
                    APLICAR
                </button>

                {{-- Rápidos --}}
                <div class="ml-auto flex items-center gap-1">
                    <button type="button" class="text-[11px] font-bold rounded border bg-blue-600 text-white"
                        onclick="setQuickRange('4w')">Últimas 4
                        semanas</button>
                    <button type="button" class="text-[11px] px-2 py-1 font-bold rounded border bg-blue-600 text-white"
                        onclick="setQuickRange('mes')">Este
                        mes</button>
                    <button type="button" class="text-[11px] px-2 py-1 font-bold rounded border bg-blue-600 text-white"
                        onclick="setQuickRange('hoy')">Esta
                        semana</button>
                </div>
            </div>
        </form>

        {{-- ====== CONTENEDOR SCROLLEABLE DE TODAS LAS TARJETAS ====== --}}
        <div class="h-[calc(100vh-160px)] overflow-y-auto thin-scroll pr-1 pl-1">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-1.5">

                {{-- =============== TABLA 1 =============== --}}
                <div class="rounded-xl shadow-sm border border-blue-200 bg-white">
                    <div class="px-2 pt-0.5 pb-0.5">
                        <h2 class="text-blue-800 font-extrabold text-[15px] leading-tight">CONSUMO TRAMA</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <div class="{{ $altoTabla }} overflow-y-auto thin-scroll">
                            <table class="min-w-full text-gray-800 tbl-compact">
                                <thead class="bg-blue-100 border-y border-blue-200 sticky top-0 z-20">
                                    <tr class="text-[9px]">
                                        <th class="{{ $head }} w-28">CALIBRE TRAMA</th>
                                        <th class="{{ $head }} w-52">COLOR TRAMA</th>
                                        @foreach ($semanas as $s)
                                            <th class="{{ $head }} text-center w-20">{{ $s }}</th>
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
                                                {{ number_format($t, 0, '.', ',') }}</td>
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
                                            <th class="{{ $head }} text-center w-20">{{ $s }}</th>
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
                                                {{ number_format($t, 0, '.', ',') }}</td>
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
                                            <th class="{{ $head }} text-center w-20">{{ $s }}</th>
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
                                                {{ number_format($t, 0, '.', ',') }}</td>
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
                                            <th class="{{ $head }} text-center w-20">{{ $s }}</th>
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
                                                {{ number_format($t, 0, '.', ',') }}</td>
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
                                            <th class="{{ $head }} text-center w-20">{{ $s }}</th>
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
                                                {{ number_format($t, 0, '.', ',') }}</td>
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
                                            <th class="{{ $head }} text-center w-20">{{ $s }}</th>
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
                                                {{ number_format($t, 0, '.', ',') }}</td>
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
                                        <th class="{{ $head }} w-28">&nbsp;</th>
                                        <th class="{{ $head }} w-52">Hilo</th>
                                        @foreach ($semanas as $s)
                                            <th class="{{ $head }} text-center w-20">{{ $s }}</th>
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

                {{-- =============== GRÁFICO KG RIZO =============== --}}
                <div class="rounded-2xl shadow border border-blue-200 bg-white p-3 md:col-span-2">
                    <h2 class="text-xl font-extrabold text-center text-gray-800 mb-2">KG RIZO</h2>
                    <div class="{{ $altoGrafica }}">
                        <canvas id="kgRizoChart"></canvas>
                    </div>
                    <div class="text-center mt-1 text-[11px] text-gray-500">
                        Rango actual: {{ $etiquetasX[0] ?? '' }} → {{ $etiquetasX[count($etiquetasX) - 1] ?? '' }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Chart.js (CDN) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script>
        // Rápidos para el rango (JS simple)
        function setQuickRange(tipo) {
            const i = document.querySelector('input[name="inicio"]');
            const f = document.querySelector('input[name="fin"]');
            const today = new Date();
            const end = new Date(today); // hoy

            let start;
            if (tipo === '4w') {
                start = new Date(today);
                start.setDate(start.getDate() - 7 * 3 - (start.getDay() + 6) % 7); // hace 4 semanas aprox
            } else if (tipo === 'mes') {
                start = new Date(today.getFullYear(), today.getMonth(), 1);
                // fin a último día del mes
                end.setMonth(end.getMonth() + 1, 0);
            } else { // 'hoy' = esta semana (Lun-Dom)
                start = new Date(today);
                const dow = (today.getDay() + 6) % 7; // 0=Lunes
                start.setDate(today.getDate() - dow);
                end.setDate(start.getDate() + 6);
            }

            i.value = start.toISOString().slice(0, 10);
            f.value = end.toISOString().slice(0, 10);
        }

        (function() {
            const labels = @json($etiquetasX);
            const seriesObj = @json($series);
            const totales = @json($totales);

            const colorMap = {
                "O16": "#f2c200",
                "Fil 370 (secual)/A12": "#7f8c4a",
                "Fil (reciclado-secual)": "#7b4b3a",
                "HR": "#ff9e47",
                "Fil600 (virgen)/A12": "#2f86eb",
                "A20": "#ff7a3d",
                "H": "#16a34a",
                "A12": "#e11d48"
            };

            const barDatasets = Object.keys(seriesObj).map((name) => ({
                type: 'bar',
                label: name,
                data: seriesObj[name],
                backgroundColor: colorMap[name] || '#89a',
                borderColor: colorMap[name] || '#89a',
                borderWidth: 1,
                stack: 'kg'
            }));

            const lineDataset = {
                type: 'line',
                label: 'Total general',
                data: totales,
                borderColor: '#111',
                backgroundColor: '#111',
                pointRadius: 3,
                pointHoverRadius: 4,
                tension: 0.25,
                yAxisID: 'y',
            };

            const ctx = document.getElementById('kgRizoChart').getContext('2d');
            const nf = new Intl.NumberFormat('es-MX');

            new Chart(ctx, {
                data: {
                    labels,
                    datasets: [...barDatasets, lineDataset]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'right'
                        },
                        tooltip: {
                            callbacks: {
                                label: (c) => `${c.dataset.label}: ${nf.format(c.parsed.y || 0)}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true,
                            ticks: {
                                maxRotation: 0,
                                autoSkip: true
                            }
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            ticks: {
                                callback: (v) => nf.format(v)
                            }
                        }
                    }
                }
            });
        })();
    </script>

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
            background: #61abf9;
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
