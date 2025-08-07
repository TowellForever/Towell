@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-blue-800 text-center tracking-tight drop-shadow -mt-2">
            ALTA DE PRONÓSTICOS
        </h1>

        <form id="form-filtrar-mes" class="mb-4">
            <div class="flex items-center gap-2">
                <select id="select-mes"
                    class="w-56 rounded-xl border-2 border-blue-300 bg-blue-50 text-blue-800 px-4 py-1 shadow focus:border-blue-500 focus:ring focus:ring-blue-100 transition-all text-md font-bold appearance-none">
                    <option value="">SELECCIONA UNO O VARIOS MESES:</option>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="12" class="text-center text-gray-400 py-3">Selecciona uno o varios meses para ver
                            registros.</td>
                    </tr>
                </tbody>
            </table>
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
            <tr class="hover:bg-blue-100 transition-all">
                <td class="px-2 py-1">${dato.IDFLOG ?? '-'}</td>
                <td class="px-2 py-1">${dato.CUSTNAME ?? '-'}</td>
                <td class="px-2 py-1">${dato.ITEMID ?? '-'}</td>
                <td class="px-2 py-1">${dato.ITEMNAME ?? '-'}</td>
                <td class="px-2 py-1">${dato.TIPOHILOID ?? '-'}</td>
                <td class="px-2 py-1">${dato.INVENTSIZEID ?? '-'}</td>
                <td class="px-2 py-1">${dato.RASURADOCRUDO ?? '-'}</td>
                <td class="px-2 py-1">${dato.VALORAGREGADO ?? '-'}</td>
                <td class="px-2 py-1">${dato.ANCHO ?? '-'}</td>
                <td class="px-2 py-1">${dato.PORENTREGAR ?? '-'}</td>
                <td class="px-2 py-1">${dato.TIPOARTICULO ?? '-'}</td>
                <td class="px-2 py-1">${dato.CODIGOBARRAS ?? '-'}</td>
            </tr>
        `;
            });
        }
    </script>
@endsection
