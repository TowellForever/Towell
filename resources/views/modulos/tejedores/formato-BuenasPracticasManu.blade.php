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
        // Establece la zona horaria explícitamente (asegúrate de que coincida con tu ubicación)
        $ahora = \Carbon\Carbon::now('America/Mexico_City');

        $hora = (int) $ahora->format('H');
        $minuto = (int) $ahora->format('i');
        $totalMinutos = $hora * 60 + $minuto;

        if ($totalMinutos >= 390 && $totalMinutos <= 869) {
            // 06:30 - 14:29
            $turnoActual = 1;
        } elseif ($totalMinutos >= 870 && $totalMinutos <= 1349) {
            // 14:30 - 22:29
            $turnoActual = 2;
        } else {
            // 22:30 - 06:29
            $turnoActual = 3;
        }
    @endphp



    <div class="bg-white container mx-auto overflow-y-auto" style="max-height: calc(100vh - 100px);">
        <div class="text-sm font-semibold m-0 p-0 leading-none opacity-70">
            FECHA: <strong>{{ now()->format('Y-m-d H:i') }}</strong>
        </div>

        <h1 class="text-center text-2xl font-bold">BUENAS PRÁCTICAS DE MANUFACTURA</h1>

        <form method="POST" action="{{ route('manufactura.guardar') }}">
            @csrf

            <input type="hidden" name="recibe" value="{{ $usuario->nombre }}">
            <input type="hidden" name="fecha" value="{{ now() }}">
            <input type="hidden" name="turno_actual" value="{{ $turnoActual }}">

            <div class="d-flex justify-content-between items-center mb-2">
                <div>RECIBE: <strong>{{ $usuario->nombre }}</strong></div>
                <div class="text-sm font-semibold mt-2">TURNO ACTUAL: <strong>{{ $turnoActual }}</strong></div>
                <div>
                    ENTREGA:
                    @php
                        $usuarios = [
                            'jesus.alvarez' => 'Juan de Jesus',
                            'karla.mendez' => 'Karla Mendez',
                            'ricardo.lopez' => 'Ricardo López',
                            'andrea.soto' => 'Andrea Soto',
                            'fernando.ramos' => 'Fernando Ramos',
                        ];
                    @endphp

                    <select name="entrega" id="entrega" class="form-control d-inline-block w-auto font-bold">
                        @foreach ($usuarios as $clave => $nombre)
                            <option value="{{ $clave }}" {{ $usuarioPorDefecto == $clave ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="overflow-x-auto h-1/2 mx-auto">
                <table class="table-auto w-full border border-black text-xs text-center">
                    <thead>
                        <tr>
                            <th rowspan="2" class="w-1/4 border border-black px-1 py-1">Número de Tejedor</th>
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
                        @php
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
                        @endphp

                        @foreach ($criterios as $i => $criterio)
                            <tr class="{{ in_array($i, [3, 9]) ? 'bg-red-500 text-white font-semibold' : '' }}">
                                <td class="border border-black text-left px-1 py-1">{{ $i + 1 }}.-
                                    {{ $criterio }}</td>
                                @for ($j = 0; $j < $usuario->telares->count() * 3; $j++)
                                    @php
                                        $turno = ($j % 3) + 1;
                                        $inputName = "criterios[{$i}][{$j}]";
                                        $editable = $turno === $turnoActual;
                                    @endphp
                                    <td class="border border-black py-1">
                                        <input type="hidden" name="{{ $inputName }}" value="0">
                                        <button type="button"
                                            class="estado-check px-1 py-0.5 text-xs border border-gray-400 rounded-sm"
                                            data-target="{{ $inputName }}" data-estado="0"
                                            {{ !$editable ? 'disabled style=opacity:0.4' : '' }}>
                                            ⬜
                                        </button>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                        <td class="border border-black text-left px-1 py-1">11.- FIRMA DEL SUPERVISOR:</td>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition duration-300 ease-in-out">
                    GUARDAR
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
                    /* Tailwind's bg-gray-200 */
                }

                .text-white {
                    color: #000 !important;
                }

                .estado-check[disabled] {
                    background-color: #e5e7eb;
                    /* gris claro */
                    color: #9ca3af;
                    /* texto gris */
                    border-color: #d1d5db;
                }
            }
        </style>
    @endpush
@endsection

<!----SELECT * FROM Produccion.dbo.usuarios

SELECT * FROM Produccion.dbo.catalago_telares

SELECT * FROM Produccion.dbo.telares_usuario

use Produccion.dbo.Produccion


INSERT INTO Produccion.dbo.telares_usuario (usuario_id,telar_id)
VALUES
(10000, 11),
(10000, 12),
(10000, 13),
(10000, 14),
(10000, 15);


UPDATE usuarios
SET remember_token = 1
WHERE id = 2;


EXEC sp_help 'Produccion.dbo.telares_usuario'
>
