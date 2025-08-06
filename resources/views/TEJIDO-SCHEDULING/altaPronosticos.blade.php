@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-extrabold text-blue-800 text-center tracking-tight drop-shadow -mt-2">ALTA DE PRONÓSTICOS
        </h1>

        <div class="flex items-center gap-2 mb-1 -mt-2">
            <!-- Select compacto -->
            <select id="select-mes"
                class="w-56 rounded-xl border-2 border-blue-300 bg-blue-50 text-blue-800 px-4 py-1 shadow focus:border-blue-500 focus:ring focus:ring-blue-100 transition-all text-md font-bold appearance-none">
                <option value="">SELECCIONA UN MES:</option>
                <option value="01">ENERO</option>
                <option value="02">FEBRERO</option>
                <option value="03">MARZO</option>
                <option value="04">ABRIL</option>
                <option value="05">MAYO</option>
                <option value="06">JUNIO</option>
                <option value="07">JULIO</option>
                <option value="08">AGOSTO</option>
                <option value="09">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>

            <!-- Chips a la derecha -->
            <div id="meses-seleccionados" class="flex flex-wrap gap-2 min-h-[32px] items-center max-w-full overflow-x-auto">
                <!-- Aquí van los chips -->
            </div>
        </div>
        <!-- Input hidden para backend -->
        <input type="hidden" name="meses_seleccionados" id="input-meses-seleccionados" value="">

        <!-- Tabla dinámica -->
        <div class="overflow-x-auto rounded-2xl shadow-lg border border-blue-200 bg-white">
            <table class="min-w-full text-xs text-center">
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
                <tbody class="bg-blue-50">
                    <tr class="hover:bg-blue-100 transition-all">
                        <td class="px-2 py-1">1125</td>
                        <td class="px-2 py-1">Grupo Lala</td>
                        <td class="px-2 py-1">ART-00123</td>
                        <td class="px-2 py-1">Toalla Premium</td>
                        <td class="px-2 py-1">Algodón</td>
                        <td class="px-2 py-1">Grande</td>
                        <td class="px-2 py-1">Sí</td>
                        <td class="px-2 py-1">Bordado</td>
                        <td class="px-2 py-1">1.20</td>
                        <td class="px-2 py-1">450</td>
                        <td class="px-2 py-1">Toalla</td>
                        <td class="px-2 py-1">CB-1928374</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <script>
        const selectMes = document.getElementById('select-mes');
        const barraMeses = document.getElementById('meses-seleccionados');
        const inputMeses = document.getElementById('input-meses-seleccionados');

        const mesesData = [{
                value: "01",
                text: "ENERO"
            }, {
                value: "02",
                text: "FEBRERO"
            }, {
                value: "03",
                text: "MARZO"
            },
            {
                value: "04",
                text: "ABRIL"
            }, {
                value: "05",
                text: "MAYO"
            }, {
                value: "06",
                text: "JUNIO"
            },
            {
                value: "07",
                text: "JULIO"
            }, {
                value: "08",
                text: "AGOSTO"
            }, {
                value: "09",
                text: "SEPTIEMBRE"
            },
            {
                value: "10",
                text: "OCTUBRE"
            }, {
                value: "11",
                text: "NOVIEMBRE"
            }, {
                value: "12",
                text: "DICIEMBRE"
            }
        ];

        let mesesSeleccionados = [];

        selectMes.addEventListener('change', function() {
            const value = selectMes.value;
            if (!value || mesesSeleccionados.includes(value)) return; // evitar vacíos y duplicados
            mesesSeleccionados.push(value);
            renderBarraMeses();
            selectMes.value = ""; // reset select
        });

        function renderBarraMeses() {
            barraMeses.innerHTML = "";
            mesesSeleccionados.forEach(val => {
                const mes = mesesData.find(m => m.value === val);
                const chip = document.createElement('div');
                chip.className =
                    "bg-blue-100 border border-blue-300 text-blue-900 rounded-xl px-3 py-1 flex items-center gap-1 font-bold text-sm shadow whitespace-nowrap";
                chip.innerHTML = `
                <span>${mes.text}</span>
                <button
                    class="ml-2 text-blue-600 hover:text-red-600 font-bold focus:outline-none"
                    data-value="${val}"
                    title="Quitar mes"
                    type="button"
                >×</button>
            `;
                chip.querySelector('button').onclick = e => {
                    mesesSeleccionados = mesesSeleccionados.filter(v => v !== val);
                    renderBarraMeses();
                };
                barraMeses.appendChild(chip);
            });
            // Actualiza el input hidden, separado por coma
            inputMeses.value = mesesSeleccionados.join(',');
        }
    </script>
@endsection
