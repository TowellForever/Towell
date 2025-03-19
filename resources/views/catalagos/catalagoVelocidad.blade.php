@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-3xl font-bold text-center">Catálogo de Velocidad STD</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('velocidad.index') }}" class="mb-4">
        <div class="row p-3 rounded" style="background-color: #003366;">
            <div class="col-md-3">
                <input type="text" name="telar" class="form-control" placeholder="Buscar por telar" value="{{ request('telar') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="salon" class="form-control" placeholder="Buscar por salón" value="{{ request('salon') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="tipo_hilo" class="form-control" placeholder="Buscar por tipo de hilo" value="{{ request('tipo_hilo') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="velocidad" class="form-control" placeholder="Buscar por velocidad" value="{{ request('velocidad') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="densidad" class="form-control" placeholder="Buscar por densidad" value="{{ request('densidad') }}">
            </div>
            <div class="col-md-12 mt-2 d-flex flex-wrap justify-content-between">
                <!-- Botón Agregar Telar alineado a la izquierda -->
                <a href="{{ route('velocidad.create') }}" class="btn btn-success px-4 py-2 mx-1 col-12 col-md-auto">
                    Agregar Registro de Velocidad
                </a>
                <!-- Contenedor para los botones Buscar y Restablecer alineados a la derecha -->
                <div class="d-flex flex-wrap justify-content-md-end justify-content-center col-12 col-md-auto">
                    <button type="submit" class="btn btn-primary px-4 py-2 mx-1 col-12 col-md-auto">
                        Buscar
                    </button>
                    <a href="{{ route('velocidad.index') }}" class="btn btn-secondary px-4 py-2 mx-1 col-12 col-md-auto">
                        Restablecer
                    </a>
                </div>
            </div>
        </div>
    </form>

    <!-- Mensaje si no hay resultados -->
    @if($noResults)
        <div class="alert alert-warning text-center" role="alert">
            No se encontraron resultados con la información proporcionada.
        </div>
    @endif

    <!-- Tabla de velocidad -->
    <table class="table table-bordered table-sm">
        <thead class="text-center bg-light">
            <tr>
                <th onclick="sortTable(0, this)" style="width: 15%;">Telar</th>
                <th onclick="sortTable(1, this)" style="width: 15%;">Salón</th>
                <th onclick="sortTable(2, this)" style="width: 20%;">Tipo de Hilo</th>
                <th onclick="sortTable(3, this)" style="width: 15%;">Velocidad</th>
                <th onclick="sortTable(4, this)" style="width: 15%;">Densidad</th>
            </tr>
        </thead>
        <tbody id="velocidad-body">
            @foreach($velocidad as $item)
                <tr class="text-center">
                    <td class="bg-white">{{ $item->telar }}</td>
                    <td class="bg-white">{{ $item->salon }}</td>
                    <td class="bg-white">{{ $item->tipo_hilo }}</td>
                    <td class="bg-white">{{ $item->velocidad }}</td>
                    <td class="bg-white">{{ $item->densidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-4">
        <nav>
            <ul class="pagination">
                @php
                    $totalPages = ceil($total / $perPage);
                @endphp
    
                @if ($currentPage > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage - 1]) }}">Anterior</a>
                    </li>
                @endif
    
                @for ($i = 1; $i <= $totalPages; $i++)
                    <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                    </li>
                @endfor
    
                @if ($currentPage < $totalPages)
                    <li class="page-item">
                        <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $currentPage + 1]) }}">Siguiente</a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>

<script>
    let currentSortColumn = null;
    let sortOrder = "asc";

    function sortTable(columnIndex, th) {
        let table = document.getElementById("velocidad-body");
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
