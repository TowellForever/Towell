@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-3xl font-extrabold text-blue-800 mb-6 text-center tracking-tight drop-shadow">Pronósticos de Flogs
        </h1>

        <!-- Filtro de mes -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
            <select id="mes" name="mes"
                class="w-56 rounded-xl border-2 border-blue-300 bg-blue-50 text-blue-800 px-4 py-1 shadow focus:border-blue-500 focus:ring focus:ring-blue-100 transition-all text-md font-bold appearance-none">
                <option value="">SELECCIONA UN MES:</option>
                <option value="01">ENERO</option>
                <option value="02">FEBRERO</option>
                <option value="03">MARZO</option>
                <option value="04">ABRIL</option>
                <option value="05">MAYO</option>
                <option value="06">JUNIO</option>
                <option value="07">JULIO</option>
                <option value="08">AGOSTO</option>
                <option value="09">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>

        <!-- Tabla dinámica -->
        <div class="overflow-x-auto rounded-2xl shadow-lg border border-blue-200 bg-white">
            <table class="min-w-full text-xs text-center">
                <thead class="bg-blue-400 text-white font-bold leading-tight">
                    <tr>
                        <th class="px-2 py-1">ID FLOG</th>
                        <th class="px-2 py-1">NOMBRE DEL CLIENTE</th>
                        <th class="px-2 py-1">CÓDIGO DEL ARTÍCULO</th>
                        <th class="px-2 py-1">NOMBRE DEL ARTÍCULO</th>
                        <th class="px-2 py-1">TIPO DE HILO</th>
                        <th class="px-2 py-1">TAMAÑO</th>
                        <th class="px-2 py-1">RASURADO</th>
                        <th class="px-2 py-1">VALOR AGREGADO</th>
                        <th class="px-2 py-1">ANCHO</th>
                        <th class="px-2 py-1">CANTIDAD</th>
                        <th class="px-2 py-1">TIPO DE ARTÍCULO</th>
                        <th class="px-2 py-1">CÓDIGO DE BARRAS</th>
                    </tr>
                </thead>
                <tbody class="bg-blue-50">
                    <tr class="hover:bg-blue-100 transition-all">
                        <td class="px-2 py-1">1125</td>
                        <td class="px-2 py-1">Grupo Lala</td>
                        <td class="px-2 py-1">ART-00123</td>
                        <td class="px-2 py-1">Toalla Premium</td>
                        <td class="px-2 py-1">Algodón</td>
                        <td class="px-2 py-1">Grande</td>
                        <td class="px-2 py-1">Sí</td>
                        <td class="px-2 py-1">Bordado</td>
                        <td class="px-2 py-1">1.20</td>
                        <td class="px-2 py-1">450</td>
                        <td class="px-2 py-1">Toalla</td>
                        <td class="px-2 py-1">CB-1928374</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
