<!-- resources/views/ingresar_folio.blade.php -->
@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ $errors->first() }}',
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            });
        </script>
    @endif

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 1rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.18);
            animation: fadeInUp 0.6s ease-out both;
            position: relative;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }

        .loader div {
            width: 32px;
            height: 32px;
            border: 4px solid #fff;
            border-top: 4px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .glass-card.loading form {
            opacity: 0.4;
            pointer-events: none;
        }

        .glass-card.loading .loader {
            display: block;
        }
    </style>
    <div class="flex min-h-screen h-screen from-blue-100 to-blue-300">
        <!-- Panel izquierdo: Captura de OT -->
        <div class="flex-1 flex items-center justify-center">
            <div class="glass-card w-full max-w-md p-8" id="card">
                <h1 class="text-2xl font-bold text-center mb-6 tracking-wide text-gray-800">ORDEN DE TRABAJO</h1>
                <form id="folioForm" action="{{ route('produccion.ordenTrabajo') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="folio" class="block mb-1 text-sm font-medium text-center text-gray-700">
                            Por favor ingrese su orden de trabajo
                        </label>
                        <input type="text" name="folio" id="folio"
                            class="w-full px-4 py-2 rounded-md text-black border border-gray-300 focus:ring-2 focus:ring-blue-500 text-sm"
                            required>
                    </div>
                    <button type="submit"
                        class="w-full px-4 py-2 bg-blue-600 rounded-md text-white text-sm font-semibold shadow hover:shadow-lg transition-all duration-300">
                        Cargar Información
                    </button>
                </form>
            </div>
        </div>
        <!-- Panel derecho: Lista de órdenes -->
        <div class="w-full max-w-[700px] flex flex-col p-2 h-[500px]">
            <div class="flex flex-col bg-white bg-opacity-90 rounded-2xl shadow-lg p-2 h-full">
                <h2 class="text-xl font-bold text-gray-800 text-center">ÓRDENES PENDIENTES</h2>
                <div class="flex-1 flex flex-col bg-white rounded-2xl shadow-lg p-1 min-h-0">
                    <div class="overflow-x-auto flex-1 flex flex-col min-h-0">
                        <div class="min-w-full flex-1 flex flex-col min-h-0">
                            <!-- Encabezados tipo tabla -->
                            <div class="grid grid-cols-6 bg-gray-100 rounded-t-2xl">
                                <div class="py-0.5 px-1 text-gray-700 font-bold text-sm">Folio</div>
                                <div class="py-0.5 px-1 text-gray-700 font-bold text-sm">Tipo</div>
                                <div class="py-0.5 px-1 text-gray-700 font-bold text-sm">Metros</div>
                                <div class="py-0.5 px-1 text-gray-700 font-bold text-sm col-span-2">L. Maturdido</div>
                            </div>
                            <!-- Lista tipo tabla -->
                            <ul class="divide-y divide-gray-200 flex-1 max-h-full overflow-y-auto min-h-0" id="orderList">
                                @foreach ($ordenesPendientes as $ordP)
                                    <li class="order-item grid grid-cols-6 items-center rounded-xl transition-colors cursor-pointer hover:bg-yellow-100"
                                        data-orden="{{ $ordP->folio }}">
                                        <span class="text-gray-700 font-medium">{{ $ordP->folio }}</span>
                                        <span class="text-gray-700 font-medium">{{ $ordP->tipo }}</span>
                                        <span class="text-gray-700 font-medium">
                                            {{ fmod($ordP->metros, 1) == 0 ? intval($ordP->metros) : rtrim(rtrim(number_format($ordP->metros, 2, '.', ''), '0'), '.') }}
                                        </span>
                                        <span class="text-gray-700 font-medium col-span-2">{{ $ordP->lmatengomado }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="selectedOrder" name="selectedOrder" value="">
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const orderList = document.getElementById('orderList');
                orderList.addEventListener('click', function(e) {
                    const items = orderList.querySelectorAll('li');
                    items.forEach(li => li.classList.remove('bg-yellow-200', 'ring', 'ring-yellow-300'));
                    let target = e.target;
                    while (target && target.tagName !== "LI") {
                        target = target.parentElement;
                    }
                    if (target && target.classList.contains('order-item')) {
                        target.classList.add('bg-yellow-200', 'ring', 'ring-yellow-300');

                        // Obtener el folio del data-orden
                        const folio = target.getAttribute(
                            'data-orden'
                        ); //data-orden es lo que alojó el folio, cuando se seleccionó un registro c:

                        //input para el folio:
                        document.getElementById('folio').value = folio;
                    }
                });
            });
        </script>
    @endsection
