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
        <form id="form-filtrar-mes" class="mb-4">
            <div class="flex items-center gap-2">
                <select id="select-mes"
                    class="w-56 rounded-xl border-2 border-blue-300 bg-blue-50 text-blue-800 px-4 py-1 shadow focus:border-blue-500 focus:ring focus:ring-blue-100 transition-all text-md font-bold appearance-none">
                    <option value="">{{ $textoMesActual }}</option>
                    <option value="2025-01">ENERO</option>
                    <option value="2025-02">FEBRERO</option>
                    <option value="2025-03">MARZO</option>
                    <option value="2025-04">ABRIL</option>
                    <option value="2025-05">MAYO</option>
                    <option value="2025-06">JUNIO</option>
                    <option value="2025-07">JULIO</option>
                    <option value="2025-08">AGOSTO</option>
                    <option value="2025-09">SEPTIEMBRE</option>
                    <option value="2025-10">OCTUBRE</option>
                    <option value="2025-11">NOVIEMBRE</option>
                    <option value="2025-12">DICIEMBRE</option>
                </select>
                <!-- Chips de meses seleccionados -->
                <div id="meses-seleccionados"
                    class="flex flex-wrap gap-2 min-h-[32px] items-center max-w-full overflow-x-auto"></div>
            </div>
        </form>


        <div class="overflow-x-auto rounded-2xl shadow-lg border border-blue-200 bg-white"
            style="max-height: 400px; overflow-y: auto;">
            <table id="tabla-pronosticos" class="min-w-full text-xs text-center">
                <thead class="bg-blue-400 text-white font-bold leading-tight">
                    <tr>
                        <th class="px-2 py-1">ID FLOG</th>
                        <th class="px-2 py-1">NOMBRE DEL CLIENTE</th>
                        <th class="px-2 py-1">CÓDIGO DEL ARTÍCULO</th>
                        <th class="px-2 py-1">NOMBRE DEL ARTÍCULO</th>
                        <th class="px-2 py-1">TIPO DE HILO</th>
                        <th class="px-2 py-1">TAMAÑO</th>
                        <th class="px-2 py-1">RASURADO</th>
                        <th class="px-2 py-1">VALOR AGREGADO</th>
                        <th class="px-2 py-1">ANCHO</th>
                        <th class="px-2 py-1">CANTIDAD</th>
                        <th class="px-2 py-1">TIPO DE ARTÍCULO</th>
                        <th class="px-2 py-1">CÓDIGO DE BARRAS</th>
                        <th class="">
                            <button id="enviarSeleccionados"
                                class="w-full h-full font-bold text-sm bg-black text-yellow-400 rounded-full hover:bg-yellow-400 hover:text-white transition shadow px-2 py-2 border-none"
                                style="border-radius: 50px;">
                                PROGRAMAR
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-blue-50">

                </tbody>
            </table>
        </div>
        <!-- Overlay de carga -->
        <div id="ajax-loader"
            class="fixed inset-0 z-[9999] hidden items-center justify-center bg-white/70 backdrop-blur-sm">
            <div class="flex flex-col items-center gap-3">
                <!-- Spinner -->
                <div class="w-12 h-12 rounded-full border-4 border-gray-300 border-t-gray-700 animate-spin"></div>
                <div class="text-sm font-semibold text-gray-700">Cargando datos…</div>
            </div>
        </div>
    </div>


    <script>
        const selectMes = document.getElementById('select-mes');
        const barraMeses = document.getElementById('meses-seleccionados');
        let mesesSeleccionados = [];

        selectMes.addEventListener('change', function() {
            const value = selectMes.value;
            // Evita agregar vacíos o duplicados
            if (!value || mesesSeleccionados.includes(value)) return;
            mesesSeleccionados.push(value);
            renderBarraMeses();
            consultarPronosticosAjax(); //peticion al servidor, toda la logica esta en el back
            // Restablece select para que puedan elegir otro sin borrar manualmente
            selectMes.value = "";
        });

        //con la siguiente FUNCION pintamos los CHIPs de MESES en la cabecera
        function renderBarraMeses() {
            barraMeses.innerHTML = "";
            mesesSeleccionados.forEach(val => {
                // Muestra el texto bonito del mes:
                const texto = selectMes.querySelector(`option[value="${val}"]`).textContent;
                const chip = document.createElement('div');
                chip.className =
                    "bg-blue-100 border border-blue-300 text-blue-900 rounded-xl px-3 py-1 flex items-center gap-1 font-bold text-sm shadow whitespace-nowrap";
                chip.innerHTML = `
            <span>${texto}</span>
            <button type="button" class="ml-2 text-blue-600 hover:text-red-600 font-bold focus:outline-none" data-value="${val}" title="Quitar mes">&times;</button>
        `;
                chip.querySelector('button').onclick = e => {
                    mesesSeleccionados = mesesSeleccionados.filter(v => v !== val);
                    renderBarraMeses();
                    consultarPronosticosAjax();
                };
                barraMeses.appendChild(chip);
            });
        }

        function renderTablaPronosticos(batas = [], otros = [], error = false) {
            const tbody = document.querySelector('#tabla-pronosticos tbody');

            if (error) {
                tbody.innerHTML =
                    `<tr><td colspan="12" class="text-center text-red-400 py-3">ERROR AL CARGAR DATOS, POR FAVOR RECARGA LA PÀGINA.</td></tr>`;
                return;
            }
            if ((!batas || batas.length === 0) && (!otros || otros.length === 0)) {
                tbody.innerHTML =
                    `<tr><td colspan="12" class="text-center text-gray-400 py-3">NO SE HAN ENCONTRADO REGISTROS PARA ESTOS MESES.</td></tr>`;
                return;
            }

            tbody.innerHTML = '';

            // --- OTROS ---
            otros.forEach(o => {
                const tipo = o.TIPOARTICULO ?? o.ITEMTYPEID ?? '-'; // 👈 fallback
                tbody.innerHTML += `
        <tr class="hover:bg-orange-200 transition-all"
            data-idflog="${o.IDFLOG ?? ''}"
            data-custname="${o.CUSTNAME ?? ''}"
            data-itemid="${o.ITEMID ?? ''}"
            data-itemname="${o.ITEMNAME ?? ''}"
            data-inventsizeid="${o.INVENTSIZEID ?? ''}"
            data-porentregar="${o.PORENTREGAR ?? ''}"
            data-rasuradocrudo="${o.RASURADOCRUDO ?? ''}"
            data-tipohilo="${o.TIPOHILOID ?? ''}"
            data-valoragregado="${o.VALORAGREGADO ?? ''}"
            data-ancho="${o.ANCHO ?? ''}"
            data-tipoarticulo="${tipo}"
            data-codigobarras="${o.CODIGOBARRAS ?? ''}">
            <td class="px-2 py-1">${o.IDFLOG ?? '-'}</td>
            <td class="px-2 py-1">${o.CUSTNAME ?? '-'}</td>
            <td class="px-2 py-1">${o.ITEMID ?? '-'}</td>
            <td class="px-2 py-1">${o.ITEMNAME ?? '-'}</td>
            <td class="px-2 py-1">${o.TIPOHILOID ?? '-'}</td>
            <td class="px-2 py-1">${o.INVENTSIZEID ?? '-'}</td>
            <td class="px-2 py-1">${o.RASURADOCRUDO ?? '-'}</td>
            <td class="px-2 py-1">${o.VALORAGREGADO ?? '-'}</td>
            <td class="px-2 py-1">${mostrarDecimalBonito(o.ANCHO)}</td>
            <td class="px-2 py-1">${mostrarDecimalBonito(o.PORENTREGAR)}</td>
            <td class="px-2 py-1">${tipo}</td>
            <td class="px-2 py-1">${o.CODIGOBARRAS ?? '-'}</td>
            <td class="text-center align-middle border">
                <input type="radio" name="fila-seleccionada" class="form-radio text-blue-500 w-5 h-5" />
            </td>
        </tr>`;
            });

            // --- BATAS ---
            batas.forEach(b => {
                const tipo = b.TIPOARTICULO ?? b.ITEMTYPEID ?? '-'; // 👈 fallback
                tbody.innerHTML += `
        <tr class="hover:bg-blue-200 bg-blue-100 transition-all"
            data-idflog="${b.IDFLOG ?? ''}"
            data-custname="${b.CUSTNAME ?? ''}"
            data-itemid="${b.ITEMID ?? ''}"
            data-itemname="${b.ITEMNAME ?? ''}"
            data-inventsizeid="${b.INVENTSIZEID ?? ''}"
            data-porentregar="${b.PORENTREGAR ?? ''}"
            data-rasuradocrudo="${b.RASURADOCRUDO ?? ''}"
            data-tipohilo="${b.TIPOHILOID ?? ''}"
            data-valoragregado="${b.VALORAGREGADO ?? ''}"
            data-ancho="${b.ANCHO ?? ''}"
            data-tipoarticulo="${tipo}"
            data-codigobarras="${b.CODIGOBARRAS ?? ''}">
            <td class="px-2 py-1">${b.IDFLOG ?? '-'}</td>
            <td class="px-2 py-1">${b.CUSTNAME ?? '-'}</td>
            <td class="px-2 py-1">${b.ITEMID ?? '-'}</td>
            <td class="px-2 py-1">${b.ITEMNAME ?? '-'}</td>
            <td class="px-2 py-1">${b.TIPOHILOID ?? '-'}</td>
            <td class="px-2 py-1">${b.INVENTSIZEID ?? '-'}</td>
            <td class="px-2 py-1">${b.RASURADOCRUDO ?? '-'}</td>
            <td class="px-2 py-1">${b.VALORAGREGADO ?? '-'}</td>
            <td class="px-2 py-1">${mostrarDecimalBonito(b.ANCHO)}</td>
            <td class="px-2 py-1">${mostrarDecimalBonito(b.PORENTREGAR)}</td>
            <td class="px-2 py-1">${tipo}</td>
            <td class="px-2 py-1">${b.CODIGOBARRAS ?? '-'}</td>
            <td class="text-center align-middle border">
                <input type="radio" name="fila-seleccionada" class="form-radio text-blue-500 w-5 h-5" />
            </td>
        </tr>`;
            });
        }

        function mostrarDecimalBonito(valor) {
            if (valor === null || valor === undefined || valor === '') return '-';
            const num = Number(valor);
            if (isNaN(num)) return valor;
            // Si es entero, mostrar con separador de miles
            if (num % 1 === 0) {
                return num.toLocaleString('en-US', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                });
            }
            // Si tiene decimales, máximo 2 decimales, con separador de miles
            return num.toLocaleString('en-US', {
                maximumFractionDigits: 2,
                minimumFractionDigits: 0
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Si tienes el mes actual desde Blade:
            const mesActual = "{{ $mesActual }}";
            if (mesActual) {
                mesesSeleccionados = [mesActual];
                renderBarraMeses();
                consultarPronosticosAjax();
            }
        });

        //AQUI comienza todo lo relacionado con el LOADER y BLOQUE TEMPORAL mientras trabaja AJAX
        const overlay = document.getElementById('ajax-loader');
        const btnProgramar = document.getElementById('enviarSeleccionados'); // puede ser null si no existe aún
        const controlsToDisable = [selectMes, btnProgramar].filter(Boolean);

        function showLoader() {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex'); // centra el spinner
            document.body.classList.add('overflow-hidden', 'cursor-wait');
            controlsToDisable.forEach(el => el.disabled = true);
        }

        function hideLoader() {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            document.body.classList.remove('overflow-hidden', 'cursor-wait');
            controlsToDisable.forEach(el => el.disabled = false);
        }

        let lastController = null;

        //FUNCION que conecta con la API o BACKEND para TRAER DATOS
        async function consultarPronosticosAjax() {
            const tbody = document.querySelector('#tabla-pronosticos tbody');
            if (mesesSeleccionados.length === 0) {
                renderTablaPronosticos([], []);
                return;
            }

            // Cancelar petición previa
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

                // 👈🏻 AQUÍ ESTABA EL ERROR: usa las 2 colecciones correctas
                renderTablaPronosticos(data.batas || [], data.otros || []);
            } catch (err) {
                if (err.name !== 'AbortError') {
                    console.error(err);
                    renderTablaPronosticos([], [], true);
                }
            } finally {
                hideLoader();
            }
        }

        const appRoot = document.querySelector('.max-w-7xl.mx-auto'); // tu contenedor
        function showLoader() {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
            document.body.classList.add('overflow-hidden', 'cursor-wait');
            appRoot?.setAttribute('inert', ''); // bloquea foco/teclas
            controlsToDisable.forEach(el => el.disabled = true);
        }

        function hideLoader() {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
            document.body.classList.remove('overflow-hidden', 'cursor-wait');
            appRoot?.removeAttribute('inert');
            controlsToDisable.forEach(el => el.disabled = false);
        }
    </script>

    <!--script para el funcionamiento del boton PROGRAMAR, envia datos al form-create-->
    <script>
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
                    // Si necesitas FECHACANCE o algo más, agrégalo aquí y en el <tr>
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

            // Solo tomamos el primero si vamos a redirigir con GET
            const primero = seleccionados[0];

            const queryParams = new URLSearchParams(primero).toString();
            const url = "{{ route('planeacion.create') }}" + "?" + queryParams;

            window.location.href = url;
        });
    </script>

    <!--Script para evitar que el USER seleccione MAS de 1 CHECKBOX-->
    <script>
        const tbody = document.querySelector('#tabla-pronosticos tbody');

        tbody.addEventListener('change', (e) => {
            const cb = e.target;
            if (!cb.classList.contains('form-radio')) return;

            if (cb.checked) {
                // Desmarcar todos los demás checkboxes del tbody
                tbody.querySelectorAll('.form-radio').forEach(other => {
                    if (other !== cb) other.checked = false;
                });

                // Log de la fila seleccionada
                const fila = cb.closest('tr');
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
                console.log(datos);
            }
        });
    </script>
@endsection
