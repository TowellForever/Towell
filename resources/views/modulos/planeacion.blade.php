@extends('layouts.app')

@section('content')

    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">PLANEACIÓN</h1>
        <div class="table-container relative">
            <div class="table-container-plane table-wrapper bg-white shadow-lg rounded-lg p-2">
                <table class="plane-table border border-gray-300">
                    <thead>
                        <tr class="plane-thead-tr text-white text-sm">
                            @php
                                $headers = [
                                    'Número de registro', 'Cuenta', 'Salón', 'Telar', 'Último', 'Cambios Hilo', 'Maq', 'Ancho', 'Ef Std', 'Vel', 'Hilo', 'Calibre Pie', 'Jornada', 'Clave Mod.',
                                    'Usar cuando no existe en base', 'Producto', 'Saldos', 'Day Scheduling', 'Orden Producto', 'INN', 'Descripción', 'Aplic.', 'Obs.', 'Tipo de pedido',
                                    'Tiras', 'Pei.', 'LCR', 'PCR', 'Luc', 'Calibre Tira', 'Dob', 'Pasadas Tira', 'Pasadas C1', 'Pasadas C2', 'Pasadas C3', 'Pasadas C4', 'Pasadas C5',
                                    'Ancho por Toalla', 'Color Tira', 'Plano', 'Cuenta Pie', 'Color Pie', 'Peso (gr/m²)', 'Días Efectivos', 'Prod (Kg)/Día', 'STD/Día', 'STD (Toa/HR) 100%',
                                    'Días jornada completa', 'Horas', 'Inicio', 'Fin', 'Entrega', 'Dif vs Compromiso', 'DONE'
                                ];
                            @endphp
                            
                            @foreach($headers as $index => $header)
                                <th class="plane-th border border-gray-400 p-4 relative" data-index="{{ $index }}">
                                    {{ $header }}
                                    <div class="absolute top-8 right-0 flex">
                                        <button class="toggle-column bg-red-500 text-white text-xs px-1 py-0.5" data-index="{{ $index }}">⛔</button>
                                        <button class="pin-column bg-blue-500 text-white text-xs px-1 py-0.5 ml-1" data-index="{{ $index }}">📌</button>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!--SCRIPT DE PRUEBA, crea datos ficticios para vizualizar la mega tabla-->
                        <script>
                            const tbody = document.querySelector("tbody");
                        
                            // Datos ficticios
                            const data = [];
                            for (let i = 1; i <= 10; i++) {
                                data.push([
                                    i, // Número de registro
                                    "Cta" + i, // Cuenta
                                    "Salón " + (i % 5 + 1), // Salón
                                    "T-" + (Math.floor(Math.random() * 10) + 1), // Telar
                                    Math.floor(Math.random() * 1000), // Último
                                    Math.floor(Math.random() * 5) + " cambios", // Cambios Hilo
                                    "M-" + (Math.floor(Math.random() * 10) + 1), // Maq
                                    (Math.random() * 3 + 1).toFixed(2), // Ancho
                                    (Math.random() * 100).toFixed(2) + "%", // Ef Std
                                    Math.floor(Math.random() * 20) + 50, // Vel
                                    "Hilo " + (Math.floor(Math.random() * 50) + 1), // Hilo
                                    Math.floor(Math.random() * 10) + 20, // Calibre Pie
                                    Math.floor(Math.random() * 3) + 1, // Jornada
                                    "Mod-" + (i % 5 + 1), // Clave Mod.
                                    i % 2 === 0 ? "Sí" : "No", // Usar cuando no existe en base
                                    "Prod-" + (i * 2), // Producto
                                    Math.floor(Math.random() * 100), // Saldos
                                    Math.floor(Math.random() * 30) + 1, // Day Scheduling
                                    Math.floor(Math.random() * 10000) + 1000, // Orden Producto
                                    "INN-" + (Math.floor(Math.random() * 100) + 1), // INN
                                    "Desc " + i, // Descripción
                                    "Apli " + (Math.floor(Math.random() * 10) + 1), // Aplic.
                                    "Obs " + (i % 3 === 0 ? "X" : "-"), // Obs.
                                    i % 2 === 0 ? "Normal" : "Urgente", // Tipo de pedido
                                    Math.floor(Math.random() * 5) + 1, // Tiras
                                    Math.random().toFixed(2), // Pei.
                                    Math.random().toFixed(2), // LCR
                                    Math.random().toFixed(2), // PCR
                                    Math.random().toFixed(2), // Luc
                                    Math.floor(Math.random() * 10) + 1, // Calibre Tira
                                    Math.floor(Math.random() * 10) + 1, // Dob
                                    Math.floor(Math.random() * 50) + 10, // Pasadas Tira
                                    Math.floor(Math.random() * 50) + 10, // Pasadas C1
                                    Math.floor(Math.random() * 50) + 10, // Pasadas C2
                                    Math.floor(Math.random() * 50) + 10, // Pasadas C3
                                    Math.floor(Math.random() * 50) + 10, // Pasadas C4
                                    Math.floor(Math.random() * 50) + 10, // Pasadas C5
                                    (Math.random() * 10 + 5).toFixed(2), // Ancho por Toalla
                                    "Color-" + (Math.floor(Math.random() * 10) + 1), // Color Tira
                                    "Plano " + i, // Plano
                                    "Pie-" + (Math.floor(Math.random() * 5) + 1), // Cuenta Pie
                                    "Color-" + (Math.floor(Math.random() * 10) + 1), // Color Pie
                                    Math.floor(Math.random() * 500) + 200, // Peso (gr/m²)
                                    Math.floor(Math.random() * 30) + 1, // Días Efectivos
                                    Math.floor(Math.random() * 500) + 100, // Prod (Kg)/Día
                                    Math.floor(Math.random() * 50) + 10, // STD/Día
                                    Math.floor(Math.random() * 100) + 20, // STD (Toa/HR) 100%
                                    Math.floor(Math.random() * 10) + 1, // Días jornada completa
                                    Math.floor(Math.random() * 12) + 1, // Horas
                                    "2025-03-" + (Math.floor(Math.random() * 28) + 1), // Inicio
                                    "2025-04-" + (Math.floor(Math.random() * 28) + 1), // Fin
                                    "2025-05-" + (Math.floor(Math.random() * 28) + 1), // Entrega
                                    Math.floor(Math.random() * 10) - 5, // Dif vs Compromiso
                                    i % 2 === 0 ? "✔" : "✖" // DONE
                                ]);
                            }
                        
                            // Generar filas con los datos ficticios
                            data.forEach(rowData => {
                                let row = "<tr>";
                                rowData.forEach(cellData => {
                                    row += `<td class="border border-gray-300 p-1">${cellData}</td>`;
                                });
                                row += "</tr>";
                                tbody.innerHTML += row;
                            });
                        </script>
                        
                    </tbody>
                </table>
            </div>
            <!--SEGUNDO CONTENEDOR para botones-->
            <!-- Botones alineados a la derecha -->
            <div class="button-column mb-4">
                <a href="#" class="button-plane ml-2">Catálogo Telares</a>
                <a href="#" class="button-plane ml-2">Catálogo Eficiencia STD</a>
                <a href="#" class="button-plane ml-2">Catálogo Velocidad STD</a>
                <a href="#" class="button-plane ml-2">Calendarios</a>
                <a href="#" class="button-plane ml-2">Aplicaciones</a>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-column").forEach(button => {
                button.addEventListener("click", function() {
                    let index = this.getAttribute("data-index");
                    document.querySelectorAll(`th:nth-child(${+index + 1}), td:nth-child(${+index + 1})`).forEach(el => {
                        el.classList.toggle("hidden");
                    });
                });
            });
            
            document.querySelectorAll(".pin-column").forEach(button => {
            button.addEventListener("click", function () {
                let index = parseInt(this.getAttribute("data-index")) + 1; // Ajuste por nth-child
                let columnCells = document.querySelectorAll(`th:nth-child(${index}), td:nth-child(${index})`);

                // Verificar si la columna ya está fijada
                let isPinned = columnCells[0].classList.contains("sticky");

                if (isPinned) {
                    // Si está fijada, quitar clases y restaurar
                    columnCells.forEach(el => {
                        el.classList.remove("sticky", "z-10", "shadow-md");
                        el.style.left = "";
                        el.style.backgroundColor = ""; // Restaurar fondo
                    });
                } else {
                    // Obtener el ancho acumulado de las columnas fijas previas
                    let pinnedColumns = document.querySelectorAll("th.sticky");
                    let leftOffset = 0;
                    pinnedColumns.forEach(col => {
                        leftOffset += col.offsetWidth;
                    });

                    // Fijar la columna con estilos adecuados
                    columnCells.forEach(el => {
                        el.classList.add("sticky", "z-10", "shadow-md");
                        el.style.left = `${leftOffset}px`;
                        el.style.backgroundColor = "#70bbe1"; // Mantener el fondo visible
                    });
                }
            });
        });

        });
    </script>
@endsection
