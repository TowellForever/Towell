@extends('layouts.app')

@section('content')
    <div class="bg-white container mx-auto overflow-y-auto" style="max-height: calc(100vh - 100px);">
        <h1 class="text-center text-2xl font-bold">BUENAS PRÁCTICAS DE MANUFACTURA</h1>

        <form method="POST" action="{{ route('manufactura.guardar') }}">

            <div class="d-flex justify-content-between items-center">
                <div>RECIBE: <strong>{{ $usuario->nombre }}</strong></div>
                <input type="hidden" name="recibe" value="{{ $usuario->nombre }}">
                <div>
                    ENTREGA:
                    <select name="entrega" id="entrega" class="form-control d-inline-block w-auto font-bold">
                        <option value="juan.de.jesus" {{ $usuarioPorDefecto == 'jesus.alvarez' ? 'selected' : '' }}>Juan de
                            Jesus</option>
                        <option value="beatriz.torres" {{ $usuarioPorDefecto == 'karla.mendez' ? 'selected' : '' }}>Beatriz
                            Torres
                        </option>
                        <option value="ricardo.lopez" {{ $usuarioPorDefecto == 'ricardo.lopez' ? 'selected' : '' }}>Ricardo
                            López
                        </option>
                        <option value="andrea.soto" {{ $usuarioPorDefecto == 'andrea.soto' ? 'selected' : '' }}>Andrea Soto
                        </option>
                        <option value="fernando.ramos" {{ $usuarioPorDefecto == 'fernando.ramos' ? 'selected' : '' }}>
                            Fernando
                            Ramos</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between mb-1">
                <div class="text-sm font-semibold">Fecha: <span
                        class="border-b border-black px-4">{{ now()->format('d/m/Y') }}</span> <input type="hidden"
                        name="fecha" value="{{ now() }}"></div>
            </div>

            @csrf
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
                                'FIRMA SUPERVISOR: ',
                            ];
                        @endphp

                        @foreach ($criterios as $i => $criterio)
                            <tr class="{{ in_array($i, [3, 9]) ? 'bg-red-500 text-white font-semibold' : '' }}">
                                <td class="border border-black text-left px-1 py-1">{{ $i + 1 }}.-
                                    {{ $criterio }}</td>
                                @for ($j = 0; $j < $usuario->telares->count() * 3; $j++)
                                    @php
                                        $inputName = "criterios[{$i}][{$j}]";
                                    @endphp
                                    <td class="border border-black py-1">
                                        <input type="hidden" name="{{ $inputName }}" value="0">
                                        <button type="button"
                                            class="estado-check px-1 py-0.5 text-xs border border-gray-400 rounded-sm"
                                            data-target="{{ $inputName }}" data-estado="0">
                                            ⬜
                                        </button>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-between text-sm">
                <div class="text-right text-gray-500">Versión 0 - F-PR-58 - <span>{{ now()->format('d/m/Y') }}</span></div>
            </div>

            <div class="flex justify-end mb-4">
                <button type="submit"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md transition duration-300 ease-in-out">
                    GUARDAR
                </button>
            </div>
        </form>
    </div>

    <!-- Script para cambiar estado del botón y su valor correspondiente -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const estados = ['⬜', '✅', '❌'];
            const valores = [0, 1, 2];

            document.querySelectorAll('.estado-check').forEach(button => {
                button.addEventListener('click', () => {
                    let estadoActual = parseInt(button.getAttribute('data-estado')) || 0;
                    let nuevoEstado = (estadoActual + 1) % 3;

                    button.setAttribute('data-estado', nuevoEstado);
                    button.innerText = estados[nuevoEstado];

                    let inputName = button.getAttribute('data-target');
                    let inputHidden = document.querySelector(`input[name="${inputName}"]`);
                    if (inputHidden) {
                        inputHidden.value = valores[nuevoEstado];
                    }
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
