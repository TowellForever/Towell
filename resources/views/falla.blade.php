@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold text-center mb-4">Reportar Falla de Telar</h1>
    <form id="whatsappForm" class="bg-white shadow-lg rounded-lg p-6">
        <div class="mb-4">
            <label class="block text-gray-700">Número de Telar:</label>
            <input type="text" id="telar" class="w-full p-2 border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Descripción de la Falla:</label>
            <textarea id="descripcion" class="w-full p-2 border border-gray-300 rounded"></textarea>
        </div>
        <button type="button" onclick="enviarWhatsApp()" class="bg-green-500 text-white px-4 py-2 rounded">Enviar a WhatsApp</button>
    </form>
</div>

<script>
function enviarWhatsApp() {
    let telar = document.getElementById("telar").value;
    let descripcion = document.getElementById("descripcion").value;
    let numeroWhatsApp = "522214125380"; // Cambia por el número real

    if (!telar || !descripcion) {
        alert("Por favor, llena todos los campos.");
        return;
    }

    let mensaje = `Hola, se reporta una falla en el telar ${telar}:\n"${descripcion}"`;
    let url = `https://api.whatsapp.com/send?phone=${numeroWhatsApp}&text=${encodeURIComponent(mensaje)}`;

    window.open(url, "_blank"); // Abre WhatsApp en otra pestaña
}
</script>
@endsection
