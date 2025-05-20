@extends('layouts.app')

@section('title', 'Calendarios - Planeación')

@section('content')
    <div
        class="container mx-auto p-2 
            lg:max-h-[600px]  <!-- para pantallas grandes (PC) -->
            md:max-h-[500px]  <!-- para laptops -->
            sm:max-h-[800px]  <!-- para tablets -->
            overflow-y-auto">
        <!-- para permitir scroll si se excede -->
        <h1 class="text-3xl font-bold text-center mb-6">CALENDARIOS</h1>

        <div class="">
            <table class="min-w-full bg-white border border-gray-300" id="calendarioLista">
                <thead>
                    <tr class="bg-blue-500 text-white text-center cursor-pointer">
                        <th class="border border-gray-300 px-2 py-1 w-1/4">No. Calendario</th>
                        <th class="border border-gray-300 px-2 py-1 w-1/4">Nombre</th>
                        <th class="border border-gray-300 px-2 py-1 w-1/4">Días por Semana</th>
                        <th class="border border-gray-300 px-2 py-1 w-1/4">Horas por Semana</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $filas = [
                            ['1', 'Calendario Tej1', '', '', 'bg-gray-100'],
                            ['2', 'Calendario Tej2', '', '', 'bg-gray-100'],
                            ['3', 'Calendario Tej3', '', '', 'bg-gray-100'],
                        ];
                    @endphp

                    @foreach ($filas as [$id, $nombre, $valor1, $valor2, $fondo])
                        <tr class="text-center font-semibold calendario-fila {{ $fondo }}"
                            data-calendario-id="{{ $id }}">
                            <td class="{{ $fondo === 'bg-transparent' ? 'border-0' : 'border border-gray-300' }}">
                                {{ $id }}</td>
                            <td class="{{ $fondo === 'bg-transparent' ? 'border-0' : 'border border-gray-300' }}">
                                {{ $nombre }}</td>
                            <td class="{{ $fondo === 'bg-transparent' ? 'border-0' : 'border border-gray-300' }}">
                                {{ $valor1 }}</td>
                            <td class="{{ $fondo === 'bg-transparent' ? 'border-0' : 'border border-gray-300' }}">
                                {{ $valor2 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="w-full mt-4">
                <div class="max-h-[400px] overflow-y-auto">
                    <table id="fechaYHoras" class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr class="bg-gray-700 text-white text-center">
                                <th class="hidden">ID</th>
                                <th class="border border-gray-300 px-2 py-1">Horas</th>
                                <th class="border border-gray-300 px-2 py-1">Día</th>
                                <th class="border border-gray-300 px-2 py-1">Inicio</th>
                                <th class="border border-gray-300 px-2 py-1">Fin</th>
                                <th class="border border-gray-300 px-2 py-1">Días Acumulados</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDetalleBody">
                            {{-- Aquí se llenan dinámicamente las filas --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Pasamos los datos del backend a JS como objetos JSON
        const calendariot1 = @json($calendariot1);
        const calendariot2 = @json($calendariot2);
        const calendariot3 = @json($calendariot3);

        // Mapeamos por id para fácil acceso
        const calendariosMap = {
            1: calendariot1,
            2: calendariot2,
            3: calendariot3
        };

        // Referencias DOM
        const filasCalendario = document.querySelectorAll('.calendario-fila');
        const tbodyDetalle = document.getElementById('tablaDetalleBody');

        // Función para dibujar la tabla inferior con los datos
        function renderTablaDetalle(data) {
            tbodyDetalle.innerHTML = ''; // limpiar tabla

            if (!data || data.length === 0) {
                tbodyDetalle.innerHTML = `<tr><td colspan="5" class="text-center p-4">No hay datos disponibles</td></tr>`;
                return;
            }

            data.forEach(item => {
                // Suponiendo que el objeto tiene propiedades: horas, dia, inicio, fin, dias_acum
                const tr = document.createElement('tr');
                tr.classList.add('text-center');

                tr.innerHTML = `
            <td class="border border-gray-300 px-2 py-1">${item.horas != null ? parseFloat(item.horas).toFixed(2) : ''}</td>
            <td class="border border-gray-300 px-2 py-1">${item.dia ?? ''}</td>
            <td class="border border-gray-300 px-2 py-1">${item.inicio ? item.inicio.replace('.000', '') : ''}</td>
            <td class="border border-gray-300 px-2 py-1">${item.fin ? item.fin.replace('.000', '') : ''}</td>
            <td class="border border-gray-300 px-2 py-1">${item.dias_acum != null ? parseFloat(item.dias_acum).toFixed(2) : ''}</td>
        `;

                tbodyDetalle.appendChild(tr);
            });
        }

        // Función para limpiar selección previa y marcar fila activa
        function marcarFilaActiva(filaSeleccionada) {
            filasCalendario.forEach(fila => fila.classList.remove('bg-yellow-300', 'font-bold'));
            filaSeleccionada.classList.add('bg-yellow-300', 'font-bold');
        }

        // Inicializamos con calendario 1 seleccionado y visible
        document.addEventListener('DOMContentLoaded', () => {
            const filaInicial = document.querySelector('.calendario-fila[data-calendario-id="1"]');
            if (filaInicial) {
                marcarFilaActiva(filaInicial);
                renderTablaDetalle(calendariosMap[1]);
            }
        });

        // Asignamos evento click a cada fila del calendario
        filasCalendario.forEach(fila => {
            fila.style.cursor = 'pointer';
            fila.addEventListener('click', () => {
                const id = fila.getAttribute('data-calendario-id');
                marcarFilaActiva(fila);
                renderTablaDetalle(calendariosMap[id]);
            });
        });
    </script>


@endsection
