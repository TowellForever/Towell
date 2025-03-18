@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-3xl font-bold text-center">Catálogo de Eficiencia</h1>
    
    <!-- Tabla de telares -->
    <table class="table table-bordered table-sm">
        <thead class="text-center bg-light">
            <tr>
                <th style="width: 15%;">Telar</th>
                <th style="width: 15%;">Salon</th>
                <th style="width: 20%;">Tipo de Hilo</th>
                <th style="width: 15%;">Eficiencia</th>
                <th style="width: 15%;">Densidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($eficiencia as $eficiencia)
                <tr class="text-center">
                    <td class="bg-white">{{ $eficiencia->telar }}</td>
                    <td class="bg-white">{{ $eficiencia->salon }}</td>
                    <td class="bg-white">{{ $eficiencia->tipo_hilo }}</td>
                    <td class="bg-white">{{ $eficiencia->eficiencia }}</td>
                    <td class="bg-white">{{ $eficiencia->densidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
