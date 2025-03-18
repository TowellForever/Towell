@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-3xl font-bold text-center">Catálogo de Telares</h1>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('telares') }}" class="mb-4">
        <div class="row p-3 rounded" style="background-color: #003366;">
            <div class="col-md-2">
                <input type="text" name="salon" class="form-control" placeholder="Buscar por salón" value="{{ request('salon') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="telar" class="form-control" placeholder="Buscar por telar" value="{{ request('telar') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre" value="{{ request('nombre') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="cuenta" class="form-control" placeholder="Buscar por cuenta" value="{{ request('cuenta') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="piel" class="form-control" placeholder="Buscar por piel" value="{{ request('piel') }}">
            </div>
            <div class="col-md-2">
                <input type="text" name="ancho" class="form-control" placeholder="Buscar por ancho" value="{{ request('ancho') }}">
            </div>
            <div class="col-md-12 text-right mt-2">
                <button type="submit" class="col-md-1 btn btn-primary px-4 py-2">Buscar</button>
                <a href="{{ route('telares') }}" class="btn btn-secondary px-4 py-2">Restablecer</a>
            </div>
        </div>
    </form>

    <!-- Mensaje si no hay resultados -->
    @if($noResults)
        <div class="alert alert-warning text-center" role="alert">
            No se encontraron resultados con la información proporcionada.
        </div>
    @endif


    <!-- Tabla de telares -->
    <table class="table table-bordered table-sm">
        <thead class="text-center bg-light">
            <tr>
                <th onclick="sortTable(0, this)">Salón</th>
                <th onclick="sortTable(1, this)">Telar</th>
                <th onclick="sortTable(2, this)">Nombre</th>
                <th onclick="sortTable(3, this)">Cuenta</th>
                <th onclick="sortTable(4, this)">Piel</th>
                <th onclick="sortTable(5, this)">Ancho</th>
            </tr>
        </thead>
        <tbody id="telares-body">
            @foreach($telares as $telar)
                <tr class="text-center">
                    <td class="bg-white">{{ $telar->salon }}</td>
                    <td class="bg-white">{{ $telar->telar }}</td>
                    <td class="bg-white">{{ $telar->nombre }}</td>
                    <td class="bg-white">{{ $telar->cuenta }}</td>
                    <td class="bg-white">{{ $telar->piel }}</td>
                    <td class="bg-white">{{ $telar->ancho }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    let currentSortColumn = null;
    let sortOrder = "asc";

    function sortTable(columnIndex, th) {
        let table = document.getElementById("telares-body");
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
