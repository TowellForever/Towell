@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-10 rounded-2xl shadow-2xl text-center max-w-xl w-full">
        <h1 class="text-5xl font-extrabold text-gray-800 mb-6 tracking-wide">
            Folio generado
        </h1>

        <div class="bg-gray-50 border border-gray-300 rounded-xl p-6 mb-8">
            <p class="text-4xl font-mono text-green-700 select-all">
                {{ $folio }}
            </p>
        </div>

        <p class="text-lg text-gray-600 mb-6">
            Presione el botón para continuar
        </p>

        <a href="{{ route('ReturningBackProRequerimientos') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-full transition duration-200 shadow-md">
            Continuar
        </a>
    </div>
</div>

<!-- Script para evitar que el usuario regrese usando el botón de retroceso -->
<script>
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };

    // Script para abrir automáticamente nueva pestaña
    window.onload = function() {
        let folio = @json($folio); // pasa el folio de PHP a JS seguro
        let url = "{{ url('/imprimir-folio') }}/" + folio;
        window.open(url, '_blank');
    };
</script>
@endsection
