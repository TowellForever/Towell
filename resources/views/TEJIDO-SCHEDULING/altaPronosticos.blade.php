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
            consultarPronosticosAjax();
            // Restablece select para que puedan elegir otro sin borrar manualmente
            selectMes.value = "";
        });

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

        function consultarPronosticosAjax() {
            if (mesesSeleccionados.length === 0) {
                renderTablaPronosticos([]);
                return;
            }
            fetch('{{ route('pronosticos.ajax') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        meses: mesesSeleccionados
                    })
                })
                .then(r => r.json())
                .then(data => renderTablaPronosticos(data.datos))
                .catch(() => renderTablaPronosticos([], true));
        }

        function renderTablaPronosticos(datos, error = false) {
            const tbody = document.querySelector('#tabla-pronosticos tbody');
            if (error) {
                tbody.innerHTML =
                    `<tr><td colspan="12" class="text-center text-red-400 py-3">Error al obtener datos.</td></tr>`;
                return;
            }
            if (!datos || datos.length === 0) {
                tbody.innerHTML =
                    `<tr><td colspan="12" class="text-center text-gray-400 py-3">No hay registros para estos meses.</td></tr>`;
                return;
            }
            tbody.innerHTML = '';
            datos.forEach(dato => {
                tbody.innerHTML += `
            <tr class="hover:bg-blue-100 transition-all"
    data-idflog="${dato.IDFLOG ?? ''}"
    data-custname="${dato.CUSTNAME ?? ''}"
    data-itemid="${dato.ITEMID ?? ''}"
    data-itemname="${dato.ITEMNAME ?? ''}"
    data-inventsizeid="${dato.INVENTSIZEID ?? ''}"
    data-porentregar="${dato.PORENTREGAR ?? ''}"
    data-rasuradocrudo="${dato.RASURADOCRUDO ?? ''}"
    data-tipohilo="${dato.TIPOHILOID ?? ''}"
    data-valoragregado="${dato.VALORAGREGADO ?? ''}"
    data-ancho="${dato.ANCHO ?? ''}"
    data-porentregar="${dato.PORENTREGAR ?? ''}"
    data-tipoarticulo="${dato.TIPOARTICULO ?? ''}"
    data-codigobarras="${dato.CODIGOBARRAS ?? ''}"

>
    <td class="px-2 py-1">${dato.IDFLOG ?? '-'}</td>
    <td class="px-2 py-1">${dato.CUSTNAME ?? '-'}</td>
    <td class="px-2 py-1">${dato.ITEMID ?? '-'}</td>
    <td class="px-2 py-1">${dato.ITEMNAME ?? '-'}</td>
    <td class="px-2 py-1">${dato.TIPOHILOID ?? '-'}</td>
    <td class="px-2 py-1">${dato.INVENTSIZEID ?? '-'}</td>
    <td class="px-2 py-1">${dato.RASURADOCRUDO ?? '-'}</td>
    <td class="px-2 py-1">${dato.VALORAGREGADO ?? '-'}</td>
    <td class="px-2 py-1">${mostrarDecimalBonito(dato.ANCHO)}</td>
    <td class="px-2 py-1">${mostrarDecimalBonito(dato.PORENTREGAR)}</td>
    <td class="px-2 py-1">${dato.TIPOARTICULO ?? '-'}</td>
    <td class="px-2 py-1">${dato.CODIGOBARRAS ?? '-'}</td>
    <td class="text-center align-middle border">
        <input type="radio" name="fila-seleccionada" 
            class="form-radio text-blue-500 w-5 h-5" />
    </td>

</tr>
        `;
            });
        }

        function mostrarDecimalBonito(valor) {
            if (valor === null || valor === undefined || valor === '') return '-';
            const num = Number(valor);
            if (isNaN(num)) return valor;
            // Si es entero, muéstralo sin decimales. Si tiene decimales, muéstralo con máximo 2, pero sin ceros extra.
            return num % 1 === 0 ? num : num.toLocaleString('en-US', {
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

        async function consultarPronosticosAjax() {
            if (mesesSeleccionados.length === 0) {
                renderTablaPronosticos([]);
                return;
            }

            // Cancelar petición previa (si aún vive)
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
                renderTablaPronosticos(data.datos);
            } catch (err) {
                if (err.name === 'AbortError') {
                    // petición cancelada: no hacemos nada
                    return;
                }
                console.error(err);
                renderTablaPronosticos([], true);
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
