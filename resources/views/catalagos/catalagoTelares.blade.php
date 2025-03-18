@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-3xl font-bold text-center">Catálogo de Telares</h1>
    
    <!-- Tabla de telares -->
    <table class="table table-bordered table-sm">
        <thead class="text-center bg-light">
            <tr>
                <th style="width: 15%;">Salon</th>
                <th style="width: 15%;">Telar</th>
                <th style="width: 20%;">Nombre</th>
                <th style="width: 15%;">Cuenta</th>
                <th style="width: 15%;">Piel</th>
                <th style="width: 15%;">Ancho</th>
            </tr>
        </thead>
        <tbody>
            @foreach($telares as $telar)
                <tr class="text-center">
                    <td class="bg-white">{{ $telar->salon }}</td>
                    <td class="bg-white">{{ $telar->telar }}</td>
                    <td class="bg-white">{{ $telar->nombre }}</td>
                    <td class="bg-white">{{ $telar->cuenta }}</td>
                    <td class="bg-white">{{ $telar->pie }}</td>
                    <td class="bg-white">{{ $telar->ancho }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
