@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold text-center mb-4">Enviar Mensaje de Falla</h1>
    <form action="/send-whatsapp" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Número de Telar:</label>
            <input type="text" name="telar" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Número de Falla:</label>
            <input type="text" name="falla_numero" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Descripción de la Falla:</label>
            <input type="text" name="falla" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Usuario:</label>
            <input type="text" name="usuario" class="w-full p-2 border border-gray-300 rounded" required>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Enviar Mensaje</button>
    </form>
</div>
@endsection
