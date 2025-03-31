@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold text-center mb-6">Reportar Falla del Telar</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <form action="{{ route('reportar.falla') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="telefono">Número de Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
            <label for="mensaje">Mensaje</label>
            <textarea class="form-control" id="mensaje" name="mensaje" required maxlength="160"></textarea>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Enviar Reporte</button>
    </form>
</div>
@endsection