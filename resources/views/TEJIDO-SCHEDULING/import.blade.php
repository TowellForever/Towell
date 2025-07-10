@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-2xl shadow-xl">
        <h2 class="text-2xl font-bold mb-6 text-blue-700 text-center">IMPORTACIÓN DE REGISTROS DESDE ARCHIVO EXCEL</h2>

        <form action="{{ route('tejido.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="file" name="archivo" required class="block w-full border p-2 rounded">
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">Subir e
                Importar</button>
        </form>
    </div>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection
