@extends('layouts.app')

@section('title', 'Calendarios - Planeación')

@section('content')
    <div class="container mx-auto p-2">
        <h1 class="text-3xl font-bold text-center mb-6">CALENDARIOS</h1>

        <div class="">
            <table class="min-w-full bg-white border border-gray-300">
                <!-- Primer Encabezado -->
                <thead>
                    <tr class="bg-blue-500 text-white text-center">
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
                            ['3', 'Calendario Tej3', '', '', 'bg-transparent'],
                        ];
                    @endphp

                    @foreach ($filas as [$id, $nombre, $valor1, $valor2, $fondo])
                        <tr class="{{ $fondo }} text-center font-semibold">
                            <td class="px-2 py-1 {{ $fondo === 'bg-transparent' ? 'border-0' : 'border border-gray-300' }}">
                                {{ $id }}</td>
                            <td class="px-2 py-1 {{ $fondo === 'bg-transparent' ? 'border-0' : 'border border-gray-300' }}">
                                {{ $nombre }}</td>
                            <td class="px-2 py-1 {{ $fondo === 'bg-transparent' ? 'border-0' : 'border border-gray-300' }}">
                                {{ $valor1 }}</td>
                            <td class="px-2 py-1 {{ $fondo === 'bg-transparent' ? 'border-0' : 'border border-gray-300' }}">
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
                        <tbody>
                            @foreach ($calendariot1 as $cal)
                                <tr class="text-center">
                                    <td class="border border-gray-300 px-2 py-1">{{ $cal->horas }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $cal->dia }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $cal->inicio }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $cal->fin }}</td>
                                    <td class="border border-gray-300 px-2 py-1">{{ $cal->dias_acum }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tabla = document.querySelector("#fechaYHoras");
            if (!tabla) return;

            tabla.querySelectorAll("tbody td").forEach((td, colIndex) => {
                td.addEventListener("click", function() {
                    if (td.querySelector("input")) return;

                    const fila = td.parentElement;
                    const calId = fila.dataset.calId;

                    let originalContent = td.innerText.trim();
                    let input = document.createElement("input");
                    input.type = "text";
                    input.value = originalContent;
                    input.classList.add("w-full", "border", "p-1");

                    input.addEventListener("blur", function() {
                        const nuevoValor = this.value.trim() || originalContent;
                        td.innerText = nuevoValor;

                        const celdas = fila.querySelectorAll("td");
                        const fecha_inicio = celdas[1].innerText.trim();
                        const fecha_fin = celdas[2].innerText.trim();
                        const total_horas = celdas[3].innerText.trim();

                        fetch("{{ route('calendarios.update.inline') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    cal_id: calId,
                                    fecha_inicio: fecha_inicio,
                                    fecha_fin: fecha_fin,
                                    total_horas: total_horas
                                })
                            })
                            .then(res => res.json())
                            .then(data => {
                                console.log("Guardado:", data);

                                const fila = td.parentElement;
                                const totalHorasTd = fila.children[3];
                                totalHorasTd.innerText = data.total_horas;

                                if (data.success) {
                                    mostrarEstado(td, "✔️", "green");
                                } else {
                                    mostrarEstado(td, "❌", "red");
                                }
                            });
                    });

                    input.addEventListener("keydown", function(e) {
                        if (e.key === "Enter") this.blur();
                        if (e.key === "Escape") td.innerText = originalContent;
                    });

                    td.innerText = "";
                    td.appendChild(input);
                    input.focus();
                });
            });

            function mostrarEstado(td, simbolo, color) {
                const feedback = document.createElement("span");
                feedback.innerText = simbolo;
                feedback.style.color = color;
                feedback.style.marginLeft = "5px";
                feedback.style.fontSize = "1.2em";
                td.appendChild(feedback);

                setTimeout(() => {
                    if (feedback && feedback.parentElement === td) {
                        feedback.remove();
                    }
                }, 1500);
            }
        });
    </script>



@endsection
