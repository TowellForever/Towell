<!-- resources/views/modelos/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-center mb-6">Lista de Modelos</h1>

    <div class="overflow-x-auto overflow-y-auto max-h-screen table-container-plane table-wrapper bg-white shadow-lg rounded-lg p-1">
        <table class="min-w-full table-auto celP plane-table border border-gray-300">
            <thead>
                <tr class="plane-thead-tr text-white">
                    @foreach ($modelos[0]->getFillable() as $field)
                        <th class=" text-left">{{ str_replace('_', ' ', $field) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($modelos as $modelo)
                    <tr>
                        @foreach ($modelo->getFillable() as $field)
                            <td class="border border-gray-300 px-2 py-1">{{ $modelo->$field }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
            {{ $modelos->links() }}

        </table>
    </div>
</div>
@endsection
