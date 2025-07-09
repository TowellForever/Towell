@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-2xl shadow-xl">
        <h2 class="text-2xl font-bold mb-6 text-blue-700 text-center">Importar Planeación desde Excel</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 border border-green-400 rounded p-3 mb-5 text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('planeacion.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="file" name="archivo" required class="block w-full border p-2 rounded">
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700 transition">Subir e
                Importar</button>
        </form>
    </div>
@endsection
