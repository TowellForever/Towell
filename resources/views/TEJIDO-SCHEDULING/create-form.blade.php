@extends('layouts.app')

@section('content')
<div class="mx-auto p-3 bg-white shadow rounded-lg mt-6">
    <h1 class="text-xl font-bold mb-4 text-gray-800 text-center">NUEVO REGISTRO TEJIDO SCHEDULING</h1>
    <form action="{{ route('planeacion.store') }}" method="POST" class="grid grid-cols-4 gap-x-8 gap-y-4 fs-11">
        @csrf

        <div class="flex items-center">
            <label for="no_flog" class="w-20 font-medium text-gray-700">No. FLOG:</label>
            <input type="text" name="no_flog" id="no_flog" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="telar" class="w-20 font-medium text-gray-700">TELAR:</label>
            <input type="text" name="telar" id="telar" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="modelo" class="w-32 font-medium text-gray-700">CLAVE MODELO:</label>
            <select name="modelo" id="modelo" class="border border-gray-300 rounded px-2 py-1 w-full text-sm" required>
                <option value="">-- Selecciona --</option>
                <option value="1023">1023</option>
                <option value="2845">2845</option>
                <option value="3917">3917</option>
                <option value="4768">4768</option>
                <option value="5592">5592</option>
            </select>
        </div>        

        <div class="flex items-center">
            <label for="modelo" class="w-24 font-medium text-gray-700">NOMBRE:</label>
            <select name="modelo" id="modelo" class="border border-gray-300 rounded px-2 py-1 w-full text-sm" required>
                <option value="">-- Selecciona --</option>
                <option value="ALFA">ALFA</option>
                <option value="BETA">BETA</option>
                <option value="GAMMA">GAMMA</option>
                <option value="OMEGA">OMEGA</option>
                <option value="DELTA">DELTA</option>
            </select>
        </div>
        

        <div class="flex items-center">
            <label for="tamano" class="w-20 font-medium text-gray-700">TAMAÑO:</label>
            <input type="text" name="tamano" id="tamano" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="cantidad" class="w-20 font-medium text-gray-700">CANTIDAD:</label>
            <input type="number" name="cantidad" id="cantidad" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="fecha_scheduling" class="w-20 font-medium text-gray-700">FECHA SCHEDULING:</label>
            <input type="date" name="fecha_scheduling" id="fecha_scheduling" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="fecha_inv" class="w-20 font-medium text-gray-700">FECHA INV:</label>
            <input type="date" name="fecha_inv" id="fecha_inv" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="fecha_compromiso_tejido" class="w-20 font-medium text-gray-700">COMPROMISO TEJIDO:</label>
            <input type="date" name="fecha_compromiso_tejido" id="fecha_compromiso_tejido" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="flex items-center">
            <label for="fecha_cliente" class="w-20 font-medium text-gray-700">FECHA CLIENTE:</label>
            <input type="date" name="fecha_cliente" id="fecha_cliente" class=" border border-gray-300 rounded px-2 py-1" required>
        </div>

        <div class="col-span-4 text-right mt-4 ">
            <button type="submit" class="w-1/6 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">
                GUARDAR
            </button>
        </div>
    </form>
</div>
<BR></BR><BR></BR><BR></BR>
@endsection
