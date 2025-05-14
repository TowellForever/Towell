@extends('layouts.app')

@section('content')
    <div class="formato-print bg-white p-2 mx-2  print:w-[99%] print:relative print:top-0 print:mt-0 print:pt-0">
        <h1 class="text-center text-2xl font-bold">BUENAS PRÁCTICAS DE MANUFACTURA</h1>

        <div class="d-flex justify-content-between items-center">
            <div>RECIBE: <strong>{{ $usuario->nombre }}</strong></div>
            <div>
                ENTREGA:
                <select name="entrega" id="entrega" class="form-control d-inline-block w-auto" style="font-weight: bold;">
                    <option value="jesus.alvarez"><strong>José Luis Patricio</strong></option>
                    <option value="karla.mendez"><strong>Beatriz Torres</strong></option>
                    <option value="ricardo.lopez"><strong>Ricardo López</strong></option>
                    <option value="andrea.soto"><strong>Andrea Soto</strong></option>
                    <option value="fernando.ramos"><strong>Fernando Ramos</strong></option>
                </select>
            </div>
        </div>
        <!-- Fecha y Telar -->
        <div class="flex items-center justify-between mb-1">
            <div class="text-sm font-semibold">Fecha: <span
                    class="border-b border-black px-4">{{ now()->format('d/m/Y') }}</span></div>
        </div>


        <!-- Tabla -->
        <!-- Tabla centrada y más pequeña -->
        <div class="overflow-x-auto h-1/2 mx-auto">
            <table class="table-auto w-full border border-black text-xs text-center">
                <thead>
                    <tr>
                        <th rowspan="2" class="w-1/4 border border-black px-1 py-1">Número de Tejedor</th>
                        <span rowspan="2" class="absolute top-[140px] left-[280px] z-10 text-xs font-bold">Telar:</span>
                        @foreach ($usuario->telares as $telar)
                            <th colspan="3" class="border border-black border-2 px-1 py-1">{{ $telar->telar }}</th>
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
                            'FIRMA SUPERVISOR: ',
                        ];
                    @endphp

                    @foreach ($criterios as $i => $criterio)
                        <tr class="{{ in_array($i, [3, 9]) ? 'bg-red-500 text-white font-semibold' : '' }}">
                            <td class="border border-black text-left px-1 py-1">{{ $i + 1 }}.- {{ $criterio }}
                            </td>
                            @for ($j = 0; $j < $usuario->telares->count() * 3; $j++)
                                <!-- 5 * 3 - 5 es el numero de telares, 3 son los turnos c:-->
                                <td class="border border-black py-1">
                                    <button type="button"
                                        class="estado-check px-1 py-0.5 text-xs border border-gray-400 rounded-sm"
                                        data-estado="0" data-criterio="{{ $i }}"
                                        data-turno="{{ $j }}">
                                        ⬜
                                    </button>
                                </td>
                            @endfor
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <!-- Firma Supervisor -->
        <div class="mt-4 flex justify-between text-sm">
            <div class="text-right text-gray-500">Versión 0 - F-PR-58 - <span
                    class="">{{ now()->format('d/m/Y') }}</span></div>
        </div>
        <div class="flex justify-end mb-4">
            <a href="/produccionProceso"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition duration-300 ease-in-out">
                GUARDAR
            </a>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.estado-check').forEach(btn => {
                btn.addEventListener('click', function() {
                    let estado = parseInt(this.dataset.estado);
                    estado = (estado + 1) % 3;

                    if (estado === 0) {
                        this.innerHTML = '⬜'; // Vacío
                    } else if (estado === 1) {
                        this.innerHTML = '✅';
                    } else {
                        this.innerHTML = '❌';
                    }

                    this.dataset.estado = estado;
                });
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
            }
        </style>
    @endpush
@endsection
