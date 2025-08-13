@extends('layouts.app')

@section('content')
    @php
        $meses = [
            '01' => 'ENERO',
            '02' => 'FEBRERO',
            '03' => 'MARZO',
            '04' => 'ABRIL',
            '05' => 'MAYO',
            '06' => 'JUNIO',
            '07' => 'JULIO',
            '08' => 'AGOSTO',
            '09' => 'SEPTIEMBRE',
            '10' => 'OCTUBRE',
            '11' => 'NOVIEMBRE',
            '12' => 'DICIEMBRE',
        ];
        $anioActual = substr($mesActual, 0, 4); // '2025'
        $mesNum = substr($mesActual, 5, 2); // '08'
        $textoMesActual = ($meses[$mesNum] ?? '') . " $anioActual";
    @endphp

    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-blue-800 text-center tracking-tight drop-shadow -mt-2">
            ALTA DE PRONÓSTICOS
        </h1>

        <form id="form-filtrar-mes" class="mb-3">
            <div class="flex flex-wrap items-center gap-2">
                <select id="select-mes"
                    class="w-56 rounded-xl border-2 border-blue-300 bg-blue-50 text-blue-800 px-4 py-1 shadow focus:border-blue-500 focus:ring focus:ring-blue-100 transition-all text-md font-bold appearance-none">
                    <option value="">{{ $textoMesActual }}</option>
                    @foreach (range(1, 12) as $m)
                        @php($val = '2025-' . str_pad($m, 2, '0', STR_PAD_LEFT))
                        <option value="{{ $val }}">{{ $meses[str_pad($m, 2, '0', STR_PAD_LEFT)] }}</option>
                    @endforeach
                </select>

                <!-- Chips de meses seleccionados -->
                <div id="meses-seleccionados"
                    class="flex flex-wrap gap-2 min-h-[32px] items-center max-w-full overflow-x-auto"></div>

                <!-- Botones de acciones -->
                <div class="ml-auto flex items-center gap-2">
                    <button id="btn-filtros" type="button"
                        class="rounded-xl bg-blue-600 text-white font-bold px-4 py-1 shadow hover:bg-blue-700 transition">
                        FILTRAR
                    </button>
                    <button id="btn-reset-filtros" type="button"
                        class="rounded-xl bg-gray-200 text-gray-800 font-bold px-4 py-1 shadow hover:bg-gray-300 transition">
                        Limpiar filtros
                    </button>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto rounded-2xl shadow-lg border border-blue-200 bg-white"
            style="max-height: 420px; overflow-y: auto;">
            <table id="tabla-pronosticos" class="min-w-full text-xs text-center">
                <thead class="bg-blue-400 text-white font-bold leading-tight sticky top-0 z-10">
                    <tr>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="IDFLOG">ID FLOG</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="CUSTNAME">NOMBRE DEL CLIENTE</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="ITEMID">CÓDIGO DEL ARTÍCULO</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="ITEMNAME">NOMBRE DEL ARTÍCULO</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="TIPOHILOID">TIPO DE HILO</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="INVENTSIZEID">TAMAÑO</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="RASURADOCRUDO">RASURADO</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="VALORAGREGADO">VALOR AGREGADO</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="ANCHO">ANCHO</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="CANTIDAD">CANTIDAD</th>
                        <th class="px-2 py-1 sticky top-0 z-10 sortable" data-key="TIPOARTICULO">TIPO DE ARTÍCULO</th>
                        <th class="px-2 py-1">
                            <button id="enviarSeleccionados"
                                class="w-full h-full font-bold text-sm bg-black text-yellow-400 rounded-full hover:bg-yellow-400 hover:text-white transition shadow px-2 py-2">
                                PROGRAMAR
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class=""></tbody>
            </table>
        </div>

        <!-- Overlay de carga -->
        <div id="ajax-loader"
            class="fixed inset-0 z-[9999] hidden items-center justify-center bg-white/70 backdrop-blur-sm">
            <div class="flex flex-col items-center gap-3">
                <div class="w-12 h-12 rounded-full border-4 border-gray-300 border-t-gray-700 animate-spin"></div>
                <div class="text-sm font-semibold text-gray-700">Cargando datos…</div>
            </div>
        </div>
    </div>

    <!-- MODAL FILTROS -->
    <div id="modal-filtros" class="fixed inset-0 z-[9998] hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative bg-white rounded-2xl shadow-xl w-[850px] max-w-[95vw] p-5">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xl font-extrabold text-blue-800">Filtros por columna</h3>
                <button id="cerrar-modal" class="text-gray-500 hover:text-gray-800 font-bold text-xl">&times;</button>
            </div>

            <div class="grid grid-cols-3 gap-3 text-sm">
                <div>
                    <label class="font-semibold text-gray-700">Cliente</label>
                    <input id="f_CUSTNAME" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Artículo (código)</label>
                    <input id="f_ITEMID" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Artículo (nombre)</label>
                    <input id="f_ITEMNAME" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Tipo de hilo</label>
                    <input id="f_TIPOHILOID" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Tamaño</label>
                    <input id="f_INVENTSIZEID" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Rasurado</label>
                    <input id="f_RASURADOCRUDO" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Valor agregado</label>
                    <input id="f_VALORAGREGADO" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Ancho (mín)</label>
                    <input id="f_ANCHO_MIN" type="number" step="0.01" class="w-full border rounded px-2 py-1" />
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Ancho (máx)</label>
                    <input id="f_ANCHO_MAX" type="number" step="0.01" class="w-full border rounded px-2 py-1" />
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Cantidad (mín)</label>
                    <input id="f_CANTIDAD_MIN" type="number" step="0.01" class="w-full border rounded px-2 py-1" />
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Cantidad (máx)</label>
                    <input id="f_CANTIDAD_MAX" type="number" step="0.01" class="w-full border rounded px-2 py-1" />
                </div>
                <div>
                    <label class="font-semibold text-gray-700">Tipo de artículo</label>
                    <input id="f_TIPOARTICULO" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>

                <div class="col-span-3">
                    <label class="font-semibold text-gray-700">Código de barras</label>
                    <input id="f_CODIGOBARRAS" class="w-full border rounded px-2 py-1" placeholder="Contiene…" />
                </div>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button id="aplicar-filtros"
                    class="rounded-xl bg-blue-600 text-white font-bold px-4 py-1 shadow hover:bg-blue-700 transition">Aplicar</button>
                <button id="limpiar-filtros"
                    class="rounded-xl bg-gray-200 text-gray-800 font-bold px-4 py-1 shadow hover:bg-gray-300 transition"
                    type="button">Limpiar</button>
            </div>
        </div>
    </div>

    <style>
        /* Indicador de sort en TH */
        th.sortable {
            cursor: pointer;
            position: relative;
            user-select: none;
        }

        th.sortable::after {
            content: attr(data-sort-icon);
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 900;
            font-size: 10px;
        }
    </style>

    <script>
        // --------- ESTADO GLOBAL ---------
        const selectMes = document.getElementById('select-mes');
        const barraMeses = document.getElementById('meses-seleccionados');
        const overlay = document.getElementById('ajax-loader');
        const table = document.getElementById('tabla-pronosticos');
        const tbody = table.querySelector('tbody');
        const appRoot = document.querySelector('.max-w-7xl.mx-auto');

        const btnFiltros = document.getElementById('btn-filtros');
        const modal = document.getElementById('modal-filtros');
        const cerrarModal = document.getElementById('cerrar-modal');
        const btnAplicarFiltros = document.getElementById('aplicar-filtros');
        const btnLimpiarFiltros = document.getElementById('limpiar-filtros');
        const btnResetFiltros = document.getElementById('btn-reset-filtros');

        const btnProgramar = document.getElementById('enviarSeleccionados');
        const controlsToDisable = [selectMes, btnProgramar, btnFiltros].filter(Boolean);

        let mesesSeleccionados = [];
        let lastData = {
            batas: [],
            otros: []
        };

        // sort por defecto: NOMBRE DEL CLIENTE ASC
        let currentSort = {
            key: 'CUSTNAME',
            dir: 'asc'
        };

        // filtros
        let filters = {
            CUSTNAME: '',
            ITEMID: '',
            ITEMNAME: '',
            TIPOHILOID: '',
            INVENTSIZEID: '',
            RASURADOCRUDO: '',
            VALORAGREGADO: '',
            TIPOARTICULO: '',
            CODIGOBARRAS: '',
            ANCHO_MIN: null,
            ANCHO_MAX: null,
            CANTIDAD_MIN: null,
            CANTIDAD_MAX: null
        };

        // --------- UTILIDADES ---------
        function showLoader() {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            document.body.classList.add('overflow-hidden', 'cursor-wait');
            appRoot?.setAttribute('inert', '');
            controlsToDisable.forEach(el => el.disabled = true);
        }

        function hideLoader() {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            document.body.classList.remove('overflow-hidden', 'cursor-wait');
            appRoot?.removeAttribute('inert');
            controlsToDisable.forEach(el => el.disabled = false);
        }

        function mostrarDecimalBonito(valor) {
            if (valor === null || valor === undefined || valor === '') return '-';
            const num = Number(valor);
            if (isNaN(num)) return valor;
            if (num % 1 === 0) return num.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
            return num.toLocaleString('en-US', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 0
            });
        }

        // Normaliza en una sola lista para aplicar filtros/orden
        function normalizar(batas = [], otros = []) {
            const A = (otros || []).map(o => ({
                SECCION: 'OTROS',
                IDFLOG: o.IDFLOG ?? '',
                CUSTNAME: o.CUSTNAME ?? '',
                ITEMID: o.ITEMID ?? '',
                ITEMNAME: o.ITEMNAME ?? '',
                TIPOHILOID: o.TIPOHILOID ?? '',
                INVENTSIZEID: o.INVENTSIZEID ?? '',
                RASURADOCRUDO: o.RASURADOCRUDO ?? '',
                VALORAGREGADO: o.VALORAGREGADO ?? '',
                ANCHO: o.ANCHO ?? null,
                CANTIDAD: o.PORENTREGAR ?? 0, // otros: PORENTREGAR
                TIPOARTICULO: o.TIPOARTICULO ?? o.ITEMTYPEID ?? '',
                RAW: o
            }));
            const B = (batas || []).map(b => ({
                SECCION: 'BATAS',
                IDFLOG: b.IDFLOG ?? '', // de la query CTE (il.IDFLOG) o tu etiqueta si así lo decides
                CUSTNAME: b.CUSTNAME ?? '',
                ITEMID: b.ITEMID ?? '',
                ITEMNAME: b.ITEMNAME ?? '',
                TIPOHILOID: b.TIPOHILOID ?? '',
                INVENTSIZEID: b.INVENTSIZEID ?? '',
                RASURADOCRUDO: b.RASURADOCRUDO ?? '',
                VALORAGREGADO: b.VALORAGREGADO ?? '',
                ANCHO: b.ANCHO ?? null,
                CANTIDAD: b.TOTAL_RESULTADO ?? 0, // batas: TOTALAZO (Σ INVENTQTY * BOMQTY)
                TIPOARTICULO: b.TIPOARTICULO ?? b.ITEMTYPEID ?? '',
                RAW: b
            }));
            return [...A, ...B];
        }

        function aplicaFiltros(rows) {
            return rows.filter(r => {
                // textos (contains)
                if (filters.CUSTNAME && !String(r.CUSTNAME).toUpperCase().includes(filters.CUSTNAME.toUpperCase()))
                    return false;
                if (filters.ITEMID && !String(r.ITEMID).toUpperCase().includes(filters.ITEMID.toUpperCase()))
                    return false;
                if (filters.ITEMNAME && !String(r.ITEMNAME).toUpperCase().includes(filters.ITEMNAME.toUpperCase()))
                    return false;
                if (filters.TIPOHILOID && !String(r.TIPOHILOID).toUpperCase().includes(filters.TIPOHILOID
                        .toUpperCase())) return false;
                if (filters.INVENTSIZEID && !String(r.INVENTSIZEID).toUpperCase().includes(filters.INVENTSIZEID
                        .toUpperCase())) return false;
                if (filters.RASURADOCRUDO && !String(r.RASURADOCRUDO).toUpperCase().includes(filters.RASURADOCRUDO
                        .toUpperCase())) return false;
                if (filters.VALORAGREGADO && !String(r.VALORAGREGADO).toUpperCase().includes(filters.VALORAGREGADO
                        .toUpperCase())) return false;
                if (filters.TIPOARTICULO && !String(r.TIPOARTICULO).toUpperCase().includes(filters.TIPOARTICULO
                        .toUpperCase())) return false;
                if (filters.CODIGOBARRAS && !String(r.CODIGOBARRAS).toUpperCase().includes(filters.CODIGOBARRAS
                        .toUpperCase())) return false;

                // numéricos
                const ancho = Number(r.ANCHO ?? 0);
                const cant = Number(r.CANTIDAD ?? 0);
                if (filters.ANCHO_MIN !== null && filters.ANCHO_MIN !== '' && !isNaN(filters.ANCHO_MIN) && !(
                        ancho >= Number(filters.ANCHO_MIN))) return false;
                if (filters.ANCHO_MAX !== null && filters.ANCHO_MAX !== '' && !isNaN(filters.ANCHO_MAX) && !(
                        ancho <= Number(filters.ANCHO_MAX))) return false;
                if (filters.CANTIDAD_MIN !== null && filters.CANTIDAD_MIN !== '' && !isNaN(filters.CANTIDAD_MIN) &&
                    !(cant >= Number(filters.CANTIDAD_MIN))) return false;
                if (filters.CANTIDAD_MAX !== null && filters.CANTIDAD_MAX !== '' && !isNaN(filters.CANTIDAD_MAX) &&
                    !(cant <= Number(filters.CANTIDAD_MAX))) return false;

                return true;
            });
        }

        function ordenar(rows, key, dir = 'asc') {
            const mult = dir === 'desc' ? -1 : 1;
            return rows.sort((a, b) => {
                const va = a[key];
                const vb = b[key];
                const na = Number(va);
                const nb = Number(vb);
                // si ambos son numéricos reales, compara como número
                if (!isNaN(na) && !isNaN(nb) && String(va).trim() !== '' && String(vb).trim() !== '') {
                    if (na < nb) return -1 * mult;
                    if (na > nb) return 1 * mult;
                    return 0;
                }
                // sino, compara como texto (case-insensitive)
                return String(va ?? '').toUpperCase().localeCompare(String(vb ?? '').toUpperCase()) * mult;
            });
        }

        function renderRows(rows) {
            if (!rows || rows.length === 0) {
                tbody.innerHTML =
                    `<tr><td colspan="13" class="text-center text-gray-400 py-3">NO SE HAN ENCONTRADO REGISTROS PARA ESTOS MESES.</td></tr>`;
                return;
            }
            tbody.innerHTML = rows.map(r => {
                const tipo = r.TIPOARTICULO ?? '-';
                const rowCls = r.SECCION === 'BATAS' ? 'hover:bg-blue-200 bg-blue-100' : 'hover:bg-orange-200';
                const cantidad = mostrarDecimalBonito(r.CANTIDAD);
                const ancho = mostrarDecimalBonito(r.ANCHO);

                return `
                    <tr class="${rowCls} transition-all"
                        data-idflog="${r.IDFLOG ?? ''}"
                        data-custname="${r.CUSTNAME ?? ''}"
                        data-itemid="${r.ITEMID ?? ''}"
                        data-itemname="${r.ITEMNAME ?? ''}"
                        data-inventsizeid="${r.INVENTSIZEID ?? ''}"
                        data-porentregar="${r.CANTIDAD ?? ''}"
                        data-rasuradocrudo="${r.RASURADOCRUDO ?? ''}"
                        data-tipohilo="${r.TIPOHILOID ?? ''}"
                        data-valoragregado="${r.VALORAGREGADO ?? ''}"
                        data-ancho="${r.ANCHO ?? ''}"
                        data-tipoarticulo="${tipo}">
                        <td class="px-2 py-1">${r.IDFLOG ?? '-'}</td>
                        <td class="px-2 py-1">${r.CUSTNAME ?? '-'}</td>
                        <td class="px-2 py-1">${r.ITEMID ?? '-'}</td>
                        <td class="px-2 py-1">${r.ITEMNAME ?? '-'}</td>
                        <td class="px-2 py-1">${r.TIPOHILOID ?? '-'}</td>
                        <td class="px-2 py-1">${r.INVENTSIZEID ?? '-'}</td>
                        <td class="px-2 py-1">${r.RASURADOCRUDO ?? '-'}</td>
                        <td class="px-2 py-1">${r.VALORAGREGADO ?? '-'}</td>
                        <td class="px-2 py-1">${ancho}</td>
                        <td class="px-2 py-1">${cantidad}</td>
                        <td class="px-2 py-1">${tipo}</td>

                        <td class="text-center align-middle border">
                            <input type="radio" name="fila-seleccionada" class="form-radio text-blue-500 w-5 h-5" />
                        </td>
                    </tr>`;
            }).join('');
        }

        function refresh() {
            // 1) Normalizar
            const rows = normalizar(lastData.batas, lastData.otros);
            // 2) Filtrar
            const filtrados = aplicaFiltros(rows);
            // 3) Ordenar según estado
            const ordenados = ordenar(filtrados, currentSort.key, currentSort.dir);
            // 4) Pintar
            renderRows(ordenados);
            // 5) Actualiza iconos de sort
            document.querySelectorAll('th.sortable').forEach(th => {
                const key = th.dataset.key;
                th.dataset.sortIcon = (key === currentSort.key) ? (currentSort.dir === 'asc' ? '▲' : '▼') : '';
            });
        }

        // --------- MESES / AJAX ---------
        let lastController = null;

        selectMes.addEventListener('change', function() {
            const value = selectMes.value;
            if (!value || mesesSeleccionados.includes(value)) return;
            mesesSeleccionados.push(value);
            renderBarraMeses();
            consultarPronosticosAjax();
            selectMes.value = "";
        });

        function renderBarraMeses() {
            barraMeses.innerHTML = "";
            mesesSeleccionados.forEach(val => {
                const texto = selectMes.querySelector(`option[value="${val}"]`)?.textContent || val;
                const chip = document.createElement('div');
                chip.className =
                    "bg-blue-100 border border-blue-300 text-blue-900 rounded-xl px-3 py-1 flex items-center gap-1 font-bold text-sm shadow whitespace-nowrap";
                chip.innerHTML = `
                    <span>${texto}</span>
                    <button type="button" class="ml-2 text-blue-600 hover:text-red-600 font-bold" data-value="${val}" title="Quitar mes">&times;</button>
                `;
                chip.querySelector('button').onclick = () => {
                    mesesSeleccionados = mesesSeleccionados.filter(v => v !== val);
                    renderBarraMeses();
                    consultarPronosticosAjax();
                };
                barraMeses.appendChild(chip);
            });
        }

        async function consultarPronosticosAjax() {
            if (mesesSeleccionados.length === 0) {
                lastData = {
                    batas: [],
                    otros: []
                };
                refresh();
                return;
            }
            if (lastController) lastController.abort();
            lastController = new AbortController();
            showLoader();

            try {
                const r = await fetch('{{ route('pronosticos.ajax') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        meses: mesesSeleccionados
                    }),
                    signal: lastController.signal
                });
                if (!r.ok) throw new Error('Respuesta no OK');
                const data = await r.json();
                // Guarda datasets crudos
                lastData = {
                    batas: data.batas || [],
                    otros: data.otros || []
                };
                // Orden por defecto: CUSTNAME asc
                currentSort = {
                    key: 'CUSTNAME',
                    dir: 'asc'
                };
                refresh();
            } catch (err) {
                if (err.name !== 'AbortError') {
                    console.error(err);
                    tbody.innerHTML =
                        `<tr><td colspan="13" class="text-center text-red-400 py-3">ERROR AL CARGAR DATOS, POR FAVOR RECARGA LA PÁGINA.</td></tr>`;
                }
            } finally {
                hideLoader();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // arranque con el mes actual si viene de Blade:
            const mesActual = "{{ $mesActual }}";
            if (mesActual) {
                mesesSeleccionados = [mesActual];
                renderBarraMeses();
                consultarPronosticosAjax();
            } else {
                refresh(); // vacío
            }
        });

        // --------- SORT POR CABECERA ---------
        document.querySelectorAll('th.sortable').forEach(th => {
            th.addEventListener('click', () => {
                const key = th.dataset.key;
                if (!key) return;
                if (currentSort.key === key) {
                    currentSort.dir = (currentSort.dir === 'asc') ? 'desc' : 'asc';
                } else {
                    currentSort = {
                        key,
                        dir: 'asc'
                    }; // nuevo campo: inicia asc
                }
                refresh();
            });
        });

        // --------- MODAL FILTROS ---------
        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        btnFiltros?.addEventListener('click', () => {
            // precarga valores actuales
            document.getElementById('f_CUSTNAME').value = filters.CUSTNAME || '';
            document.getElementById('f_ITEMID').value = filters.ITEMID || '';
            document.getElementById('f_ITEMNAME').value = filters.ITEMNAME || '';
            document.getElementById('f_TIPOHILOID').value = filters.TIPOHILOID || '';
            document.getElementById('f_INVENTSIZEID').value = filters.INVENTSIZEID || '';
            document.getElementById('f_RASURADOCRUDO').value = filters.RASURADOCRUDO || '';
            document.getElementById('f_VALORAGREGADO').value = filters.VALORAGREGADO || '';
            document.getElementById('f_TIPOARTICULO').value = filters.TIPOARTICULO || '';
            document.getElementById('f_CODIGOBARRAS').value = filters.CODIGOBARRAS || '';
            document.getElementById('f_ANCHO_MIN').value = filters.ANCHO_MIN ?? '';
            document.getElementById('f_ANCHO_MAX').value = filters.ANCHO_MAX ?? '';
            document.getElementById('f_CANTIDAD_MIN').value = filters.CANTIDAD_MIN ?? '';
            document.getElementById('f_CANTIDAD_MAX').value = filters.CANTIDAD_MAX ?? '';
            openModal();
        });
        cerrarModal?.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        btnAplicarFiltros?.addEventListener('click', () => {
            filters = {
                CUSTNAME: document.getElementById('f_CUSTNAME').value.trim(),
                ITEMID: document.getElementById('f_ITEMID').value.trim(),
                ITEMNAME: document.getElementById('f_ITEMNAME').value.trim(),
                TIPOHILOID: document.getElementById('f_TIPOHILOID').value.trim(),
                INVENTSIZEID: document.getElementById('f_INVENTSIZEID').value.trim(),
                RASURADOCRUDO: document.getElementById('f_RASURADOCRUDO').value.trim(),
                VALORAGREGADO: document.getElementById('f_VALORAGREGADO').value.trim(),
                TIPOARTICULO: document.getElementById('f_TIPOARTICULO').value.trim(),
                CODIGOBARRAS: document.getElementById('f_CODIGOBARRAS').value.trim(),
                ANCHO_MIN: document.getElementById('f_ANCHO_MIN').value,
                ANCHO_MAX: document.getElementById('f_ANCHO_MAX').value,
                CANTIDAD_MIN: document.getElementById('f_CANTIDAD_MIN').value,
                CANTIDAD_MAX: document.getElementById('f_CANTIDAD_MAX').value,
            };
            closeModal();
            refresh();
        });

        btnLimpiarFiltros?.addEventListener('click', () => {
            filters = {
                CUSTNAME: '',
                ITEMID: '',
                ITEMNAME: '',
                TIPOHILOID: '',
                INVENTSIZEID: '',
                RASURADOCRUDO: '',
                VALORAGREGADO: '',
                TIPOARTICULO: '',
                CODIGOBARRAS: '',
                ANCHO_MIN: null,
                ANCHO_MAX: null,
                CANTIDAD_MIN: null,
                CANTIDAD_MAX: null
            };
            // limpia inputs del modal
            modal.querySelectorAll('input').forEach(i => i.value = '');
        });

        btnResetFiltros?.addEventListener('click', () => {
            filters = {
                CUSTNAME: '',
                ITEMID: '',
                ITEMNAME: '',
                TIPOHILOID: '',
                INVENTSIZEID: '',
                RASURADOCRUDO: '',
                VALORAGREGADO: '',
                TIPOARTICULO: '',
                CODIGOBARRAS: '',
                ANCHO_MIN: null,
                ANCHO_MAX: null,
                CANTIDAD_MIN: null,
                CANTIDAD_MAX: null
            };
            refresh();
        });

        // --------- PROGRAMAR (igual que el tuyo) ---------
        document.getElementById('enviarSeleccionados').addEventListener('click', function() {
            const seleccionados = [];
            document.querySelectorAll('.form-radio:checked').forEach(checkbox => {
                const fila = checkbox.closest('tr');
                const datos = {
                    IDFLOG: fila.dataset.idflog,
                    CUSTNAME: fila.dataset.custname,
                    ITEMID: fila.dataset.itemid,
                    ITEMNAME: fila.dataset.itemname,
                    INVENTSIZEID: fila.dataset.inventsizeid,
                    CANTIDAD: fila.dataset.porentregar,
                    RASURADOCRUDO: fila.dataset.rasuradocrudo,
                    TIPOHILO: fila.dataset.tipohilo,
                    APLICACION: fila.dataset.valoragregado,
                    ANCHO: fila.dataset.ancho,
                    TIPOARTICULO: fila.dataset.tipoarticulo,
                    CODIGOBARRAS: fila.dataset.codigobarras
                };
                seleccionados.push(datos);
            });

            if (seleccionados.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'ATENCIÓN!',
                    text: 'Marca la casilla de al menos una fila.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            const primero = seleccionados[0];
            const queryParams = new URLSearchParams(primero).toString();
            const url = "{{ route('planeacion.create') }}" + "?" + queryParams;
            window.location.href = url;
        });

        // evitar seleccionar más de uno
        tbody.addEventListener('change', (e) => {
            const cb = e.target;
            if (!cb.classList.contains('form-radio')) return;
            if (cb.checked) {
                tbody.querySelectorAll('.form-radio').forEach(other => {
                    if (other !== cb) other.checked = false;
                });
            }
        });
    </script>
@endsection
