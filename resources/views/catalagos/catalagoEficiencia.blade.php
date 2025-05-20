@extends('layouts.app')

@section('content')
    <div class="container overflow-y-auto h-[600px]">
        <h1 class="mb-4 text-3xl font-bold text-center">Catálogo de Eficiencia STD</h1>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="{{ route('eficiencia.index') }}" class="mb-4">
            <div class="row p-3 rounded" style="background-color: #003366;">
                <div class="col-md-3">
                    <input type="text" name="telar" class="form-control" placeholder="Buscar por telar"
                        value="{{ request('telar') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="tipo_hilo" class="form-control" placeholder="Buscar por tipo de hilo"
                        value="{{ request('tipo_hilo') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="eficiencia" class="form-control" placeholder="Buscar por eficiencia"
                        value="{{ request('eficiencia') }}">
                </div>
                <div class="col-md-2">
                    <input type="text" name="densidad" class="form-control" placeholder="Buscar por densidad"
                        value="{{ request('densidad') }}">
                </div>
                <div class="col-md-12 mt-2 d-flex flex-wrap justify-content-between">
                    <!-- Botón Agregar Telar alineado a la izquierda -->
                    <a href="{{ route('eficiencia.create') }}" class="btn btn-success px-4 py-2 mx-1 col-12 col-md-auto">
                        Agregar Registro de Eficiencia
                    </a>
                    <!-- Contenedor para los botones Buscar y Restablecer alineados a la derecha -->
                    <div class="d-flex flex-wrap justify-content-md-end justify-content-center col-12 col-md-auto">
                        <button type="submit" class="btn btn-primary px-4 py-2 mx-1 col-12 col-md-auto">
                            Buscar
                        </button>
                        <a href="{{ route('eficiencia.index') }}"
                            class="btn btn-secondary px-4 py-2 mx-1 col-12 col-md-auto">
                            Restablecer
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <!-- Mensaje si no hay resultados -->
        @if ($noResults)
            <div class="alert alert-warning text-center" role="alert">
                No se encontraron resultados con la información proporcionada.
            </div>
        @endif

        <!-- Tabla de eficiencia -->
        <table class="table table-bordered table-sm">
            <thead class="text-center bg-light">
                <tr>
                    <th onclick="sortTable(0, this)" style="width: 15%;">Telar</th>
                    <th onclick="sortTable(1, this)" style="width: 20%;">Tipo de Hilo</th>
                    <th onclick="sortTable(2, this)" style="width: 15%;">Eficiencia</th>
                    <th onclick="sortTable(3, this)" style="width: 15%;">Densidad</th>
                    <th onclick="sortTable(3, this)" style="width: 15%;">Acciones</th>
                </tr>
            </thead>
            <tbody id="eficiencia-body">
                @foreach ($eficiencia as $item)
                    <tr class="text-center">
                        <td class="bg-white">{{ $item->telar }}</td>
                        <td class="bg-white">{{ $item->tipo_hilo }}</td>
                        <td class="bg-white">{{ $item->eficiencia }}</td>
                        <td class="bg-white">{{ $item->densidad }}</td>
                        <td class="bg-white">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Botón Editar -->
                                <a href="{{ route('eficiencia.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    ✏️
                                </a>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('eficiencia.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que quieres eliminar este registro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
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
            </div><br>
        </table>
    </div>
    <script>
        let currentSortColumn = null;
        let sortOrder = "asc";

        function sortTable(columnIndex, th) {
            let table = document.getElementById("eficiencia-body");
            let rows = Array.from(table.rows);

            let sorted = rows.sort((a, b) => {
                let aValue = a.cells[columnIndex].innerText.toLowerCase();
                let bValue = b.cells[columnIndex].innerText.toLowerCase();

                if (!isNaN(parseFloat(aValue)) && !isNaN(parseFloat(bValue))) {
                    return parseFloat(aValue) - parseFloat(bValue);
                }
                return aValue.localeCompare(bValue);
            });

            if (currentSortColumn === columnIndex && sortOrder === "asc") {
                sorted.reverse();
                sortOrder = "desc";
            } else {
                sortOrder = "asc";
            }

            currentSortColumn = columnIndex;
            table.innerHTML = "";
            sorted.forEach(row => table.appendChild(row));

            updateHeaderStyles(th);
        }

        function updateHeaderStyles(th) {
            document.querySelectorAll("th").forEach(header => {
                header.style.backgroundColor = "";
                header.innerHTML = header.innerHTML.replace(" 🔼", "").replace(" 🔽", ""); // Limpia flechas
            });

            th.style.backgroundColor = "#ffdd57"; // Amarillo suave para resaltar
            th.innerHTML += sortOrder === "asc" ? " 🔼" : " 🔽";
        }
    </script>
@endsection
