@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center text-blue-700 mb-8">REPORTES DE MANTENIMIENTO</h1>

        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white rounded-2xl shadow-lg">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-blue-50">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Telar</th>
                        <th class="px-4 py-2">Tipo</th>
                        <th class="px-4 py-2">Clave Falla</th>
                        <th class="px-4 py-2">Descripción</th>
                        <th class="px-4 py-2">Fecha</th>
                        <th class="px-4 py-2">Hora</th>
                        <th class="px-4 py-2">Operador</th>
                        <th class="px-4 py-2">Observaciones</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reportes as $reporte)
                        <tr class="border-t hover:bg-blue-50 transition">
                            <td class="px-4 py-2 text-center">{{ $reporte->id }}</td>
                            <td class="px-4 py-2 text-center">{{ $reporte->telar }}</td>
                            <td class="px-4 py-2 text-center capitalize">{{ $reporte->tipo }}</td>
                            <td class="px-4 py-2 text-center">{{ $reporte->clave_falla }}</td>
                            <td class="px-4 py-2">{{ $reporte->descripcion }}</td>
                            <td class="px-4 py-2 text-center">
                                {{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d-m-Y') }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('H:i') }}
                            </td>
                            <td class="px-4 py-2">{{ $reporte->operador }}</td>
                            <td class="px-4 py-2">{{ $reporte->observaciones }}</td>
                            <td class="px-4 py-2 flex flex-col gap-2 items-center">
                                <!-- Aquí puedes poner más acciones: Ver, Editar, Eliminar, etc. -->
                                <a href="#" class="text-blue-600 hover:underline">Ver</a>
                                <a href="#" class="text-red-600 hover:underline">Eliminar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-8 text-center text-gray-500">
                                No hay reportes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6 text-center">
            <a href="/"
                class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">Volver
                al menú principal</a>
        </div>

        <footer class="mt-10 text-center text-gray-400 text-xs">
            &copy; {{ date('Y') }} Mi Empresa. Todos los derechos reservados.
        </footer>
    </div>
@endsection
