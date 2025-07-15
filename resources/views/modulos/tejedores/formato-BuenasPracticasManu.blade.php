@extends('layouts.app')

@section('content')
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'ÉXITO',
                    text: @json(session('success')),
                    timer: 3000,
                    timerProgressBar: true,
                    showConfirmButton: true,
                    backdrop: true,
                    customClass: {
                        popup: 'text-xl'
                    }
                });
            });
        </script>
    @endif

    @php
        // --- INICIO MAPEO DE DETALLES ---
        $detallesArr = [];
        if (isset($detalles) && count($detalles)) {
            foreach ($detalles as $detalle) {
                // La clave será: criterio-telar-turno
                // criterio debe ser número del 1 al 10 (si no, adapta este mapeo)
                $key = $detalle->criterio . '-' . $detalle->telar . '-' . $detalle->turno;
                $detallesArr[$key] = $detalle->valor;
            }
        }

        // Criterios (ajusta si tu DB usa otro formato)
        $criterios = [
            'Papeleta de modelo y marbetes correctos.',
            'Trama de telar correcta.',
            'Prealimentadores.',
            'Largo barba.',
            'Repaso de orillas.',
            'Tensión de Gasa de Vuelta',
            'Torre de tramas.',
            'Dibujo/Orilla Salpicado',
            'Hilos falsos.',
            'Tejido correcto (rayas - tejido abierto)',
        ];
        $usuarios = [
            'jesus.alvarez' => 'Juan de Jesus',
            'karla.mendez' => 'Karla Mendez',
            'ricardo.lopez' => 'Ricardo López',
            'andrea.soto' => 'Andrea Soto',
            'fernando.ramos' => 'Fernando Ramos',
        ];
    @endphp

    <div class="md:mt-0 sm:mt-5 bg-white container overflow-y-auto overflow-x-auto md:h-[670px] sm:h-[1200px]">
        <div class="text-sm font-semibold -mt-2 p-0 leading-none opacity-70">
            FECHA: <strong>{{ now()->format('Y-m-d H:i') }}</strong>
        </div>

        <h1 class="text-center text-2xl font-bold md:-mt-6">BUENAS PRÁCTICAS DE MANUFACTURA</h1>

        <form method="POST" action="{{ route('manufactura.guardar') }}">
            @csrf

            <input type="hidden" name="recibe" value="{{ $usuario->nombre }}">
            <input type="hidden" name="fecha" value="{{ now() }}">
            <input type="hidden" name="turno_actual" value="{{ $turnoActual }}">

            <div class="d-flex justify-content-between items-center md:-mt-4">
                <div>RECIBE: <strong>{{ $usuario->nombre }}</strong></div>
                <div class="text-sm font-semibold md:mt-2 sm:mt-10">TURNO ACTUAL: <strong>{{ $turnoActual }}</strong></div>
                <div>
                    ENTREGA:
                    <select name="entrega" id="entrega" class="form-control d-inline-block w-auto font-bold">
                        @foreach ($usuarios as $clave => $nombre)
                            <option value="{{ $clave }}" {{ $usuarioPorDefecto == $clave ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto h-1/2 md:mx-auto sm:mt-4">
                <table class="table-auto w-full border border-black text-xs text-center">
                    <thead>
                        <tr>
                            <th rowspan="2" class="w-1/4 border border-black px-1 py-1">Número de Criterio</th>
                            @foreach ($usuario->telares as $telar)
                                <th colspan="3" class="border border-black border-2 px-1 py-1">{{ $telar->telar }}</th>
                                <input type="hidden" name="telares[]" value="{{ $telar->telar }}">
                            @endforeach
                        </tr>
                        <tr>
                            @for ($i = 0; $i < $usuario->telares->count(); $i++)
                                <th class="border border-black">1°</th>
                                <th class="border border-black">2°</th>
                                <th class="border border-black">3°</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($criterios as $i => $criterio)
                            <tr class="{{ in_array($i, [3, 9]) ? 'bg-red-500 text-white font-semibold' : '' }}">
                                <td class="border border-black text-left px-1 py-1">{{ $i + 1 }}.-
                                    {{ $criterio }}</td>
                                @for ($j = 0; $j < $usuario->telares->count() * 3; $j++)
                                    @php
                                        $telarIndex = floor($j / 3); // de 0 a n_telares-1
                                        $turno = ($j % 3) + 1; // 1,2,3
                                        $nombreTelar = $usuario->telares[$telarIndex]->telar;
                                        $inputName = "criterios[{$i}][{$j}]";
                                        $editable = $turno === $turnoActual;
                                        // Aquí la clave coincide con el mapeo de la DB:
                                        $key = $i . '-' . $nombreTelar . '-' . $turno;
                                        $valorGuardado = $detallesArr[$key] ?? 0;
                                    @endphp
                                    <td class="border border-black py-1">
                                        <input type="hidden" name="{{ $inputName }}" value="{{ $valorGuardado }}">
                                        <button type="button"
                                            class="estado-check px-1 py-0.5 text-xs border border-gray-400 rounded-sm"
                                            data-target="{{ $inputName }}" data-estado="{{ $valorGuardado }}"
                                            {{ !$editable ? 'disabled style=opacity:0.4' : '' }}>
                                            @if ($valorGuardado == 1)
                                                ✅
                                            @elseif ($valorGuardado == 2)
                                                ❌
                                            @else
                                                ⬜
                                            @endif
                                        </button>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="{{ 1 + $usuario->telares->count() * 3 }}"
                                class="border border-black text-left px-1 py-1">
                                11.- FIRMA DEL SUPERVISOR:
                                <input type="text" name="firma_supervisor" class="border px-1 py-0.5 rounded ml-2"
                                    style="width: 200px;" autocomplete="off">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-2 justify-end flex gap-2">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-1 px-3 rounded-md shadow-sm transition duration-200 ease-in-out w-auto">
                    GUARDAR
                </button>
                {{-- Botón EDITAR (redirecciona a edición, puedes hacer que desbloquee el formulario) --}}
                <button id="btnEditar" type="button"
                    class="bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium py-1 px-3 rounded-md shadow-sm transition duration-200 ease-in-out w-auto">
                    EDITAR
                </button>

                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-1 px-3 rounded-md shadow-sm transition duration-200 ease-in-out w-auto">
                    AUTORIZAR
                </button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.estado-check').forEach(btn => {
            btn.addEventListener('click', () => {
                if (btn.disabled) return;

                const target = btn.dataset.target;
                const input = document.querySelector(`input[name="${target}"]`);
                let estado = parseInt(btn.dataset.estado);

                estado = (estado + 1) % 3;
                btn.dataset.estado = estado;

                if (estado === 0) {
                    btn.textContent = '⬜';
                } else if (estado === 1) {
                    btn.textContent = '✅';
                } else {
                    btn.textContent = '❌';
                }

                input.value = estado;
            });
        });
    </script>

    @push('styles')
        <style>
            @media print {
                .no-print {
                    display: none !important;
                }

                body * {
                    visibility: hidden;
                    margin: 0 !important;
                    padding: 0 !important;
                }

                html,
                body {
                    height: 100%;
                }

                .formato-print,
                .formato-print * {
                    visibility: visible;
                    margin-top: 0 !important;
                    padding-top: 0 !important;
                    top: 0 !important;
                }

                .formato-print {
                    width: 95% !important;
                    margin: 0 auto !important;
                    padding: 0 !important;
                    box-shadow: none;
                    position: relative !important;
                    left: 0 !important;
                    top: 0 !important;
                }

                @page {
                    size: letter portrait;
                    margin: 10mm;
                }

                .bg-red-500 {
                    background-color: #e5e7eb !important;
                }

                .text-white {
                    color: #000 !important;
                }

                .estado-check[disabled] {
                    background-color: #e5e7eb;
                    color: #9ca3af;
                    border-color: #d1d5db;
                }
            }
        </style>
    @endpush
@endsection
