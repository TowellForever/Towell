@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-3xl font-bold text-center">Catálogo de Velocidad STD</h1>
    
    <!-- Tabla de telares -->
    <table class="table table-bordered table-sm">
        <thead class="text-center bg-light">
            <tr>
                <th style="width: 15%;">Telar</th>
                <th style="width: 15%;">Salón</th>
                <th style="width: 20%;">Tipo de Hilo</th>
                <th style="width: 15%;">Velocidad</th>
                <th style="width: 15%;">Densidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($velocidad as $velocidad)
                <tr class="text-center">
                    <td class="bg-white">{{ $velocidad->telar }}</td>
                    <td class="bg-white">{{ $velocidad->salon }}</td>
                    <td class="bg-white">{{ $velocidad->tipo_hilo }}</td>
                    <td class="bg-white">{{ $velocidad->velocidad }}</td>
                    <td class="bg-white">{{ $velocidad->densidad }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
