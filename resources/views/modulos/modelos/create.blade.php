@extends('layouts.app')

@section('content')

    <div class="mx-auto p-3 bg-white shadow rounded-lg overflow-y-auto max-h-[550px] bigScroll">
        <div class="col-span-5 mb-3">
            <!-- Aquí va el divisor -->
            <div class="relative w-full flex items-center">
                <div class="w-full border-t-8 border-gray-300"></div>
                <span
                    class="absolute left-1/2 -translate-x-1/2 px-8 rounded-xl bg-blue-100 border-2 border-blue-300 shadow-lg text-sm font-semibold text-blue-800 tracking-wide uppercase"
                    style="top: 50%; transform: translate(-50%, -50%);">
                    CREAR NUEVO MODELO
                </span>
            </div>
        </div>
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-3">
                <ul class="text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('modelos.store') }}" class="grid grid-cols-5 gap-x-8 gap-y-4 fs-11">
            @csrf
            <!-- Título centrado sobre la línea -->

            @php
                $fields = [
                    'CONCATENA',
                    'RASEMA',
                    'Fecha_Orden',
                    'Fecha_Cumplimiento',
                    'Departamento',
                    'Telar_Actual',
                    'Prioridad',
                    'Modelo',
                    'CLAVE_MODELO',
                    'CLAVE_AX',
                    'Tamanio_AX',
                    'TOLERANCIA',
                    'CODIGO_DE_DIBUJO',
                    'Fecha_Compromiso',
                    'Nombre_de_Formato_Logistico',
                    'Clave',
                    'Cantidad_a_Producir',
                    'Peine',
                    'Ancho',
                    'Largo',
                    'P_crudo',
                    'Luchaje',
                    'Tra',
                    'Hilo',
                    'OBS',
                    'Tipo_plano',
                    'Med_plano',
                    'TIPO_DE_RIZO',
                    'ALTURA_DE_RIZO',
                    'OBS_1',
                    'Veloc_Minima',
                    'Rizo',
                    'Hilo_1',
                    'CUENTA',
                    'OBS_2',
                    'Pie',
                    'Hilo_2',
                    'CUENTA1',
                    'OBS_3',
                    'C1',
                    'OBS_4',
                    'C2',
                    'OBS_5',
                    'C3',
                    'OBS_6',
                    'C4',
                    'OBS_7',
                    'Med_de_Cenefa',
                    'Med_de_inicio_de_rizo_a_cenefa',
                    'RAZURADA',
                    'TIRAS',
                    'Repeticiones_p_corte',
                    'No_De_Marbetes',
                    'Cambio_de_repaso',
                    'Vendedor',
                    'No_Orden',
                    'Observaciones',
                    'TRAMA_Ancho_Peine',
                    'LOG_DE_LUCHA_TOTAL',
                    'C1_Trama_de_Fondo',
                    'Hilo_A_1',
                    'OBS_A_1',
                    'PASADAS_1',
                    'C1_A_1',
                    'Hilo_A_2',
                    'OBS_A_2',
                    'PASADAS_C2',
                    'C2_A_2',
                    'Hilo_A_3',
                    'OBS_A_3',
                    'PASADAS_3',
                    'C3_A_3',
                    'Hilo_A_4',
                    'OBS_A_4',
                    'PASADAS_4',
                    'C4_A_4',
                    'Hilo_A_5',
                    'OBS_A_5',
                    'PASADAS_5',
                    'C5_A_5',
                    'Hilo_A_6',
                    'OBS_A_6',
                    'X',
                    'TOTAL',
                    'PASADAS_DIBUJO',
                    'Contraccion',
                    'Tramas_cm_Tejido',
                    'Contrac_Rizo',
                    'Clasificación(KG)',
                    'KG_p_dia',
                    'Densidad',
                    'Pzas_p_dia_pasadas',
                    'Pzas_p_dia_formula',
                    'DIF',
                    'EFIC',
                    'Rev',
                    'TIRAS_2',
                    'PASADAS',
                    'CU',
                    'CV',
                    'CW',
                    'COMPROBAR_modelos_duplicados',
                ];

                // Campos tipo number
                $numbers = [
                    'RASEMA',
                    'Telar_Actual',
                    'CLAVE_MODELO',
                    'Cantidad_a_Producir',
                    'Peine',
                    'Ancho',
                    'Largo',
                    'P_crudo',
                    'Luchaje',
                    'Tra',
                    'ALTURA_DE_RIZO',
                    'Veloc_Minima',
                    'Rizo',
                    'CUENTA',
                    'Pie',
                    'CUENTA1',
                    'C1',
                    'C2',
                    'C3',
                    'C4',
                    'Med_de_Cenefa',
                    'Med_de_inicio_de_rizo_a_cenefa',
                    'TIRAS',
                    'Repeticiones_p_corte',
                    'No_De_Marbetes',
                    'TRAMA_Ancho_Peine',
                    'LOG_DE_LUCHA_TOTAL',
                    'C1_Trama_de_Fondo',
                    'PASADAS_1',
                    'PASADAS_C2',
                    'PASADAS_3',
                    'PASADAS_4',
                    'PASADAS_5',
                    'X',
                    'TOTAL',
                    'KG_p_dia',
                    'Densidad',
                    'Pzas_p_dia_pasadas',
                    'Pzas_p_dia_formula',
                    'DIF',
                    'EFIC',
                    'Rev',
                    'TIRAS_2',
                    'PASADAS',
                    'CU',
                    'CV',
                    'CW',
                    'Hilo',
                    'Hilo_1',
                    'Hilo_2',
                    'Hilo_A_1',
                    'Hilo_A_2',
                    'Hilo_A_3',
                    'Hilo_A_4',
                    'Hilo_A_5',
                    'Hilo_A_6',
                ];

                // Campos tipo fecha
                $dates = ['Fecha_Orden', 'Fecha_Cumplimiento', 'Fecha_Compromiso'];
            @endphp

            @foreach ($fields as $field)
                <div class="flex items-center mb-1">
                    <label for="{{ $field }}"
                        class="w-48 font-medium text-gray-700 fs-9 -mb-1">{{ str_replace(['_', '(KG)'], [' ', ''], $field) }}:</label>
                    @if (in_array($field, $numbers))
                        <input type="number" step="0.01" name="{{ $field }}" id="{{ $field }}"
                            class="border border-gray-300 rounded px-1 py-0.5 w-full"
                            value="{{ old($field, $modelo->$field ?? '') }}">
                    @elseif(in_array($field, $dates))
                        <input type="date" name="{{ $field }}" id="{{ $field }}"
                            class="border border-gray-300 rounded px-1 py-0.5 w-full"
                            value="{{ old($field, isset($modelo) && $modelo->$field ? \Carbon\Carbon::parse($modelo->$field)->format('Y-m-d') : '') }}">
                    @else
                        <input type="text" name="{{ $field }}" id="{{ $field }}"
                            class="border border-gray-300 rounded px-1 py-0.5 w-full"
                            value="{{ old($field, $modelo->$field ?? '') }}">
                    @endif
                </div>
            @endforeach
            <div></div>
            <div></div>

            <div class="col-span-1 flex justify-center mt-4">
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded font-bold hover:bg-blue-800 transition">Guardar</button>
            </div>
        </form>
    </div>
@endsection
