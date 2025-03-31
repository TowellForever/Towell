@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold text-center mb-4">Enviar Mensaje de Falla</h1>
    <form action="/send-whatsapp" method="POST">
        @csrf
        <div class="mb-4">
            <label for="message" class="block text-gray-700">Mensaje:</label>
            <textarea name="message" id="message" rows="4" class="w-full p-2 border border-gray-300 rounded" required></textarea>
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Enviar Mensaje</button>
    </form>
</div>
@endsection
