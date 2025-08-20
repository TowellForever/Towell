@extends('layouts.app')

@section('content')
    @php
        // Helper simple para iniciales
        function iniciales($nombre)
        {
            $partes = preg_split('/\s+/', trim($nombre));
            $ini = '';
            foreach ($partes as $p) {
                if ($p !== '') {
                    $ini .= mb_strtoupper(mb_substr($p, 0, 1));
                }
                if (mb_strlen($ini) >= 2) {
                    break;
                }
            }
            return mb_substr($ini, 0, 2);
        }
    @endphp

    <div class="max-w-full mx-auto px-2 overflow-y-auto bigScroll max-h-[550px]">
        {{-- Encabezado --}}
        <div class="rounded-xl bg-gradient-to-r from-blue-50 via-blue-100 to-blue-50 border border-blue-200 p-1 mb-1">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-extrabold text-blue-800 tracking-tight">
                    LISTA DE USUARIOS TOWELL 👨‍💼
                </h1>
                <span class="text-[11px] px-2 py-0.5 rounded-full bg-blue-200 text-blue-900 font-semibold">
                    {{ $usuarios->count() }} registros
                </span>

            </div>
        </div>

        {{-- Alertas SweetAlert si las usas en tu layout --}}
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    if (window.Swal) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: @json(session('success')),
                            confirmButtonColor: '#2563eb'
                        });
                    }
                });
            </script>
        @endif

        {{-- Lista compacta --}}
        <div class="rounded-xl border border-blue-200 bg-white overflow-hidden">
            <ul class="divide-y divide-blue-100">
                @forelse ($usuarios as $u)
                    <li class="px-2 py-1.5 hover:bg-blue-50/60 transition">
                        <div class="flex items-center gap-2">
                            {{-- Avatar / iniciales --}}
                            <div class="flex-shrink-0">
                                @if (!empty($u->foto))
                                    <img src="{{ $u->foto }}" alt="Foto"
                                        class="h-9 w-9 rounded-full object-cover ring-2 ring-blue-200">
                                @else
                                    {{-- Avatar / foto o logo --}}
                                    <div class="flex-shrink-0">
                                        @if (!empty($u->foto))
                                            <img src="{{ $u->foto }}" alt="Foto"
                                                class="h-9 w-9 rounded-full object-cover ring-2 ring-blue-200">
                                        @else
                                            <img src="{{ asset('images/fondosTowell/TOWELLIN.png') }}" alt="Towellin"
                                                class="h-9 w-9 rounded-full object-cover ring-2 ring-blue-200">
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Contenido compacto --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div class="truncate">
                                        <span class="text-[13px] font-semibold text-blue-900 truncate">
                                            {{ $u->nombre }}
                                        </span>
                                        <span
                                            class="ml-1 text-[10px] px-1 py-0.5 rounded bg-blue-100 text-blue-800 font-medium">
                                            #{{ $u->numero_empleado }}
                                        </span>
                                    </div>

                                    {{-- Botones derecha --}}
                                    <div class="flex gap-1">
                                        <a href="{{ route('usuarios.edit', $u->numero_empleado) }}"
                                            class="inline-flex items-center text-[10px] px-2 py-1 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                                            ✏️ Editar
                                        </a>

                                        <form action="{{ route('usuarios.destroy', $u->numero_empleado) }}" method="POST"
                                            onsubmit="return confirmarEliminacion(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center text-[10px] px-2 py-1 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-900 font-semibold border border-blue-300">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-0.5 grid grid-cols-2 md:grid-cols-4 gap-x-2 gap-y-0.5">
                                    <div class="text-[11px] text-blue-900/80">
                                        <span class="font-semibold">Área:</span> {{ $u->area ?? '—' }}
                                    </div>
                                    <div class="text-[11px] text-blue-900/80">
                                        <span class="font-semibold">Turno:</span> {{ $u->turno ?? '—' }}
                                    </div>
                                    <div class="text-[11px] text-blue-900/80">
                                        <span class="font-semibold">Tel:</span> {{ $u->telefono ?? '—' }}
                                    </div>
                                    <div class="text-[11px]">
                                        @if ($u->enviarMensaje)
                                            <span class="px-1.5 py-0.5 rounded bg-blue-600 text-white font-semibold">Avisos
                                                ON</span>
                                        @else
                                            <span
                                                class="px-1.5 py-0.5 rounded bg-blue-100 text-blue-700 font-semibold">Avisos
                                                OFF</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-3 py-4 text-sm text-blue-900/70">No hay usuarios para mostrar.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Confirmación de eliminación (SweetAlert si está disponible; fallback a confirm) --}}
    <script>
        function confirmarEliminacion(e) {
            if (window.Swal) {
                e.preventDefault();
                const form = e.target;
                Swal.fire({
                    title: '¿Eliminar usuario?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#2563eb',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((r) => {
                    if (r.isConfirmed) form.submit();
                });
                return false;
            } else {
                return confirm('¿Eliminar usuario? Esta acción no se puede deshacer.');
            }
        }
    </script>
@endsection
