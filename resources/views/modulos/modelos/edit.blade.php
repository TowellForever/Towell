@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-8 bg-white rounded-xl shadow mt-8">
        <h2 class="text-2xl font-bold mb-6 text-center">✏️ Editar Modelo</h2>
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-3">{{ session('error') }}</div>
        @endif
        <form method="POST" action="" class="grid grid-cols-2 gap-4"> <!--{{ route('modelos.update') }}-->
            @csrf
            <input type="text" name="CLAVE_AX" value="{{ $modelo->CLAVE_AX }}" readonly
                class="input input-bordered bg-gray-100">
            <input type="text" name="Tamanio_AX" value="{{ $modelo->Tamanio_AX }}" readonly
                class="input input-bordered bg-gray-100">
            <input type="text" name="Modelo" value="{{ $modelo->Modelo }}" class="input input-bordered">
            <input type="text" name="Departamento" value="{{ $modelo->Departamento }}" class="input input-bordered">
            <!-- Agrega aquí los campos que necesitas editar -->
            <div class="col-span-2 flex justify-center mt-4">
                <button type="submit"
                    class="bg-yellow-500 text-white px-5 py-2 rounded font-bold hover:bg-yellow-700 transition">Actualizar</button>
            </div>
        </form>
    </div>
@endsection
