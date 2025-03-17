@extends('layouts.app')

@section('content')

    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">PLANEACIÓN</h1>
        <div class="table-container">
            <div class="table-container-plane table-wrapper bg-white shadow-lg rounded-lg p-2">
                <table class="plane-table border border-gray-300">
                    <thead>
                        <tr class="plane-thead-tr text-white text-sm">
                            <th class="plane-th border border-gray-400 p-10">Número de registro</th>
                            <th class="plane-th border border-gray-400 p-10">Cuenta</th>
                            <th class="plane-th border border-gray-400 p-10">Salón</th>
                            <th class="plane-th border border-gray-400 p-10">Telar</th>
                            <th class="plane-th border border-gray-400 p-10">Último</th>
                            <th class="plane-th border border-gray-400 p-10">Cambios Hilo</th>
                            <th class="plane-th border border-gray-400 p-10">Maq</th>
                            <th class="plane-th border border-gray-400 p-10">Ancho</th>
                            <th class="plane-th border border-gray-400 p-10">Ef Std</th>
                            <th class="plane-th border border-gray-400 p-10">Vel</th>
                            <th class="plane-th border border-gray-400 p-10">Hilo</th>
                            <th class="plane-th border border-gray-400 p-10">Calibre Pie</th>
                            <th class="plane-th border border-gray-400 p-10">Jornada</th>
                            <th class="plane-th border border-gray-400 p-10">Clave Mod.</th>
                            <th class="plane-th border border-gray-400 p-10">Usar cuando no existe en base</th>
                            <th class="plane-th border border-gray-400 p-10">Producto</th>
                            <th class="plane-th border border-gray-400 p-10">Saldos</th>
                            <th class="plane-th border border-gray-400 p-10">Day Scheduling</th>
                            <th class="plane-th border border-gray-400 p-10">Orden Producto</th>
                            <th class="plane-th border border-gray-400 p-10">INN</th>
                            <th class="plane-th border border-gray-400 p-10">Descripción</th>
                            <th class="plane-th border border-gray-400 p-10">Aplic.</th>
                            <th class="plane-th border border-gray-400 p-10">Obs.</th>
                            <th class="plane-th border border-gray-400 p-10">Tipo de pedido</th>
                            <th class="plane-th border border-gray-400 p-10">Tiras</th>
                            <th class="plane-th border border-gray-400 p-10">Pei.</th>
                            <th class="plane-th border border-gray-400 p-10">LCR</th>
                            <th class="plane-th border border-gray-400 p-10">PCR</th>
                            <th class="plane-th border border-gray-400 p-10">Luc</th>
                            <th class="plane-th border border-gray-400 p-10">Calibre Tira</th>
                            <th class="plane-thborder border-gray-400 p-10">Dob</th>
                            <th class="plane-thborder border-gray-400 p-10">Pasadas Tira</th>
                            <th class="plane-thborder border-gray-400 p-10">Pasadas C1</th>
                            <th class="plane-thborder border-gray-400 p-10">Pasadas C2</th>
                            <th class="plane-thborder border-gray-400 p-10">Pasadas C3</th>
                            <th class="plane-thborder border-gray-400 p-10">Pasadas C4</th>
                            <th class="plane-thborder border-gray-400 p-10">Pasadas C5</th>
                            <th class="plane-thborder border-gray-400 p-10">Ancho por Toalla</th>
                            <th class="plane-thborder border-gray-400 p-10">Color Tira</th>
                            <th class="plane-thborder border-gray-400 p-10">Plano</th>
                            <th class="plane-thborder border-gray-400 p-10">Cuenta Pie</th>
                            <th class="plane-thborder border-gray-400 p-10">Color Pie</th>
                            <th class="plane-thborder border-gray-400 p-10">Peso (gr/m²)</th>
                            <th class="plane-thborder border-gray-400 p-10">Días Efectivos</th>
                            <th class="plane-thborder border-gray-400 p-10">Prod (Kg)/Día</th>
                            <th class="plane-thborder border-gray-400 p-10">STD/Día</th>
                            <th class="plane-thborder border-gray-400 p-10">STD (Toa/HR) 100%</th>
                            <th class="plane-thborder border-gray-400 p-10">Días jornada completa</th>
                            <th class="plane-thborder border-gray-400 p-10">Horas</th>
                            <th class="plane-thborder border-gray-400 p-10">Inicio</th>
                            <th class="plane-thborder border-gray-400 p-10">Fin</th>
                            <th class="plane-thborder border-gray-400 p-10">Entrega</th>
                            <th class="plane-thborder border-gray-400 p-10">Dif vs Compromiso</th>
                            <th class="plane-thborder border-gray-400 p-10">DONE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--SCRIPT DE PRUEBA, crea datos ficticios para vizualizar la mega tabla-->
                        <script>
                            const tbody = document.querySelector("tbody");
                        
                            // Datos ficticios
                            const data = [];
                            for (let i = 1; i <= 15; i++) {
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
                                    row += `<td class="border border-gray-300 p-2">${cellData}</td>`;
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
                <a href="#" class="button-plane bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Catálogo Telares</a>
                <a href="#" class="button-plane bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 ml-2">Catálogo Eficiencia STD</a>
                <a href="#" class="button-plane bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 ml-2">Catálogo Velocidad STD</a>
                <a href="#" class="button-plane bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 ml-2">Calendarios</a>
                <a href="#" class="button-plane bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700 ml-2">Aplicaciones</a>
            </div>
        </div>
    </div>
@endsection
