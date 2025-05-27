<!-- resources/views/modelos/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Lista de Modelos</h1>

        <div class="d-flex justify-content-center mt-4">
            @php
                $totalPages = ceil($total / $perPage);
                $startPage = max(1, $currentPage - 5);
                $endPage = min($totalPages, $currentPage + 5);
            @endphp

            <nav>
                <ul class="pagination">
                    {{-- Botón Anterior --}}
                    @if ($currentPage > 1)
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}">Anterior</a>
                        </li>
                    @endif

                    {{-- Botones de página visibles --}}
                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    {{-- Botón Siguiente --}}
                    @if ($currentPage < $totalPages)
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">Siguiente</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

        <!--FILTROS DE BÚSQUEDA ***************************************************************************************************************-->
        <div class="flex justify-center sm:mt-4 mb-1 w-1/5">
            <!-- Botón de búsqueda (lupa) -->
            <button id="search-toggle" class="p-1 w-16 rounded-full bg-blue-500 text-white hover:bg-blue-600 mr-5">
                <i class="fas fa-search text-3xl"></i>
            </button>

            <!-- Botón de restablecer (cruz o refresh) -->
            <div class="w-auto text-left">
                <button id="reset-search" class="p-2 rounded-full bg-red-500 text-white hover:bg-red-600 mt-2 text-xs">
                    Restablecer búsqueda
                </button>
            </div>
        </div>

        <!-- Modal -->
        <div id="search-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
                <h2 class="text-xl font-bold mb-4">Búsqueda Avanzada</h2>

                <form action="{{ route('modelos.index') }}" method="GET" class="flex flex-col gap-4">
                    <!-- Select para escoger la primera columna -->
                    <div class="flex gap-4 items-center">
                        <select name="column[]"
                            class="form-control p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Selecciona una columna</option>
                            @foreach ($fillableFields as $field)
                                <option value="{{ $field }}"> {{ str_replace('_', ' ', $field) }} </option>
                            @endforeach
                        </select>
                        <input type="text" name="value[]"
                            class="form-control p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Valor a buscar">
                    </div>

                    <!-- Contenedor para filtros adicionales -->
                    <div id="additional-filters" class="max-h-60 overflow-y-auto p-2 border border-gray-300 rounded-lg">
                    </div>


                    <!-- Botón para agregar más filtros -->
                    <!-- Botón para agregar más filtros -->
                    <button type="button" id="add-filter"
                        class="w-1/3 block mx-auto bg-gray-700 text-white px-3 py-1.5 rounded-md hover:bg-gray-800 transition duration-300 text-sm shadow">
                        Agregar Otro Filtro
                    </button>

                    <!-- Botón de buscar -->
                    <button type="submit"
                        class="block mx-auto w-1/5  bg-blue-600 text-white px-3 py-1.5 rounded-md hover:bg-blue-700 transition duration-300 shadow">
                        Buscar
                    </button>
                </form>

                <!-- Botón para cerrar el modal -->
                <button id="close-modal"
                    class="block mx-auto w-1/5 mt-4 px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600">Cerrar</button>
            </div>
        </div>

        <!--FIN DE FILTROS DE BÚSQUEDA ***************************************************************************************************************-->
        <!--inicia tabla MODULOS-->
        <div class="overflow-x-auto overflow-y-auto table-container-plane table-wrapper bg-white shadow-lg rounded-lg p-1"
            style="max-height: calc(100vh - 200px);">
            <table class="min-w-full celP plane-table border border-gray-300 text-center">
                <thead>
                    <tr class="plane-thead-tr text-white text-xs">
                        @foreach ($modelos[0]->getFillable() as $field)
                            <th class="sticky top-0 z-10">{{ str_replace('_', ' ', $field) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="text-xs">
                    @foreach ($modelos as $modelo)
                        <tr>
                            @foreach ($modelo->getFillable() as $field)
                                @php
                                    $value = $modelo->$field;

                                    // Campos que necesitan quitar ".0"
                                    $fieldsSinDecimal = ['RASEMA', 'Telar_Actual', 'Clave_Modelo', 'CUENTA', 'PASADAS'];

                                    // Campos de fecha
                                    $fieldsFecha = ['Fecha_Orden', 'Fecha_Cumplimiento'];

                                    // Campos que requieren 2 decimales
                                    $fieldsDosDecimales = [
                                        'Rizo',
                                        'No#_De_Marbetes',
                                        'C11',
                                        'C21',
                                        'Hilo5',
                                        'Hilo6',
                                        'KG_x_Dia',
                                        'Densidad',
                                        'Pzas_Dia__pasadas',
                                        'Pzas_Día_formula',
                                        'DIF',
                                        'EFIC#',
                                        'Rev',
                                        'TIRAS1',
                                        'PASADAS5',
                                        'A',
                                        'B',
                                        'C',
                                        'COMPROBAR modelos duplicados',
                                    ];

                                    // Campo que requiere 3 decimales
                                    $fieldsTresDecimales = ['Hilo4'];

                                    // Formatear según el campo
                                    if (in_array($field, $fieldsSinDecimal)) {
                                        $value = is_numeric($value) ? intval($value) : $value;
                                    } elseif (in_array($field, $fieldsFecha)) {
                                        $value = \Carbon\Carbon::parse($value)->format('d-m-y');
                                    } elseif (in_array($field, $fieldsDosDecimales)) {
                                        $value = is_numeric($value) ? number_format($value, 2) : $value;
                                    } elseif (in_array($field, $fieldsTresDecimales)) {
                                        $value = is_numeric($value) ? number_format($value, 3) : $value;
                                    }
                                @endphp
                                <td class="border border-gray-300 px-2 py-1">{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Mostrar modal
        document.getElementById('search-toggle').addEventListener('click', function() {
            document.getElementById('search-modal').classList.remove('hidden');
        });

        // Cerrar modal
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('search-modal').classList.add('hidden');
        });

        // Agregar más filtros
        document.getElementById('add-filter').addEventListener('click', function() {
            const newFilter = `
            <div class="flex gap-4 items-center mt-4 bg-gray-100 p-3 rounded-lg shadow-md">
                <select name="column[]" class="form-control p-2 border border-gray-400 rounded-md text-gray-800 focus:ring-2 focus:ring-blue-400">
                    <option value="">Selecciona una columna</option>
                        @foreach ($fillableFields as $field)
                            <option value="{{ $field }}">        {{ str_replace('_', ' ', $field) }}      </option>
                        @endforeach
                </select>

                <input type="text" name="value[]" class="form-control p-2 border border-gray-400 rounded-md text-gray-800 focus:ring-2 focus:ring-blue-400" placeholder="Ingrese el valor">

                <button type="button" class="w-1/5 remove-filter bg-gray-700 text-white px-3 py-1.5 rounded-md hover:bg-red-600 transition" onclick="removeFilter(this)">
                    X
                </button>
            </div>
        `;
            document.getElementById('additional-filters').insertAdjacentHTML('beforeend', newFilter);
        });

        // Eliminar filtro
        function removeFilter(button) {
            button.parentElement.remove();
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("reset-search").addEventListener("click", function() {
                window.location.href =
                    "{{ route('modelos.index') }}"; // Redirige a la ruta planificacion.index
            });
        });
    </script>
@endsection
