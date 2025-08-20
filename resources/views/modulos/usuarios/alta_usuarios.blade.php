@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto pr-2 pl-2">
        {{-- SweetAlert de éxito --}}
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'success',
                        title: '¡ÉXITO!',
                        text: @json(session('success')),
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'Entendido'
                    }).then(() => {

                        // ==== Opción A: Recargar la página ====
                        location.reload(); // recarga simple
                        window.location.href =
                            "{{ route('usuarios.create') }}"; // recarga "limpia" por si hay querystring
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ocurrió un problema',
                        text: @json(session('error')),
                        confirmButtonColor: '#2563eb'
                    });
                });
            </script>
        @endif

        @if ($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const errs = @json($errors->all());
                    const list = '<ul style="text-align:left;margin-left:0.5rem;">' +
                        errs.map(e => `<li>• ${e}</li>`).join('') +
                        '</ul>';
                    Swal.fire({
                        icon: 'error',
                        title: 'Revisa los campos',
                        html: list,
                        confirmButtonColor: '#2563eb'
                    });
                });
            </script>
        @endif
        <!-- Wrapper con scroll vertical si es necesario -->
        <div class="bg-gradient-to-br from-blue-50 via-blue-50 to-blue-100 rounded-2xl shadow-sm border border-blue-200/60">
            <!-- Encabezado -->
            <div class="px-3 py-2 border-b border-blue-200/70 bg-gradient-to-r from-blue-600 to-blue-700 rounded-t-2xl">
                <h1 class="text-white text-xl font-semibold tracking-tight">REGISTRAR NUEVO USUARIO</h1>
            </div>

            <!-- Contenido scrolleable -->
            <div class="px-2 py-2 max-h-[calc(100vh-100px)] overflow-y-auto bigScroll">
                <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-1">
                    @csrf

                    <!-- Bloque: Datos generales -->
                    <div class="rounded-xl border border-blue-200/60 bg-white/90 shadow-xs">
                        <div class="px-1 border-b border-blue-100/80 flex items-center gap-2">
                            <h2 class="text-[13px] font-semibold text-blue-800 tracking-tight">Datos generales</h2>
                        </div>

                        <div class="p-2">
                            <!-- 2 columnas: (label + input) | (label + input) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-0.5 gap-y-1">

                                <!-- Col 1: Área -->
                                <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                    <label for="area"
                                        class="text-[12px] font-semibold text-blue-900 text-right ">Área</label>
                                    <select id="area" name="area"
                                        class=" w-full text-[12px] rounded-lg border border-blue-200/80 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                                        required>
                                        <option value="" disabled {{ old('area') ? '' : 'selected' }}>Selecciona el
                                            área</option>
                                        @foreach ([
            'Almacén' => 'Almacen',
            'Urdido' => 'Urdido',
            'Engomado' => 'Engomado',
            'Tejido' => 'Tejido',
            'Atadores' => 'Atadores',
            'Tejedores' => 'Tejedores',
            'Mantenimiento' => 'Mantenimiento',
        ] as $label => $val)
                                            <option value="{{ $val }}"
                                                {{ old('area') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Col 2: Número de Empleado -->
                                <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                    <label for="numero_empleado"
                                        class="text-[12px] font-semibold text-blue-900 text-right leading-tight">
                                        Núm. Empleado
                                    </label>
                                    <input id="numero_empleado" name="numero_empleado" type="number" inputmode="numeric"
                                        pattern="[0-9]*" value="{{ old('numero_empleado') }}"
                                        class="h-7 w-full text-[12px] px-2 rounded-lg border border-blue-200/80 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                                        placeholder="Ej. 01234" required>
                                </div>

                                <!-- Col 1: Nombre -->
                                <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                    <label for="nombre"
                                        class="text-[12px] font-semibold text-blue-900 text-right leading-tight">Nombre</label>
                                    <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}"
                                        class="h-7 w-full text-[12px] px-2 rounded-lg border border-blue-200/80 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                                        placeholder="Nombre completo" required>
                                </div>

                                <!-- Col 2: Contraseña -->
                                <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                    <label for="password"
                                        class="text-[12px] font-semibold text-blue-900 text-right leading-tight">Contraseña</label>
                                    <div class="relative">
                                        <input id="password" name="contrasenia" type="password" autocomplete="new-password"
                                            class="h-7 w-1/2 text-[12px] pl-2 pr-16 rounded-lg border border-blue-200/80 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                                            placeholder="Mínimo 8 caracteres" required>
                                        <button type="button" id="togglePassword"
                                            class="w-1/3 absolute inset-y-0 right-0 my-auto mr-1 h-5 px-2 text-[10px] rounded-md border border-blue-300 bg-blue-50 hover:bg-blue-100 text-blue-700">
                                            Mostrar
                                        </button>
                                    </div>
                                </div>
                                <!-- Col : telefono -->
                                <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                    <label for="telefono"
                                        class="text-[12px] font-semibold text-blue-900 text-right leading-tight">
                                        Teléfono
                                    </label>
                                    <input id="telefono" name="telefono" type="tel" inputmode="numeric"
                                        autocomplete="tel" value="{{ old('telefono') }}" placeholder="10 dígitos" required
                                        minlength="10" maxlength="10" pattern="^\d{10}$"
                                        oninput="this.value=this.value.replace(/\D/g,'').slice(0,10)"
                                        class="h-7 w-full text-[12px] px-2 rounded-lg border border-blue-200/80 bg-white
         focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400
         invalid:border-red-400 invalid:focus:ring-red-400" />

                                </div>
                                <!-- Col : turno -->
                                <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                    <label for="turno"
                                        class="text-[12px] font-semibold text-blue-900 text-right leading-tight">
                                        Turno
                                    </label>
                                    <select id="turno" name="turno" required
                                        class="h-7 w-full text-[12px] pl-2 pr-7 rounded-lg border border-blue-200/80 bg-white
               focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                                        <option value="" disabled {{ old('turno') ? '' : 'selected' }}>Selecciona el
                                            turno
                                        </option>
                                        <option value="1" {{ old('turno') == '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ old('turno') == '2' ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ old('turno') == '3' ? 'selected' : '' }}>3</option>
                                    </select>
                                </div>
                                <!-- Col : enviar mensaje SI o NO -->
                                <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                    <label for="enviarMensaje"
                                        class="text-[12px] font-semibold text-blue-900 text-right leading-tight">
                                        ¿Enviar mensaje?
                                    </label>

                                    <div class="flex items-center ml-2 gap-1.5">
                                        <input id="enviarMensaje" name="enviarMensaje" type="checkbox" value="1"
                                            class="h-5 w-5 rounded border-blue-300 text-blue-600 focus:ring-blue-400"
                                            {{ old('enviarMensaje') ? 'checked' : '' }}>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <!-- Bloque: Foto -->
                    <div class="rounded-xl border border-blue-200/60 bg-white/90 shadow-xs">
                        <div class="px-3 py-2 border-b border-blue-100/80 flex items-center gap-2">
                            <div class="w-1.5 h-4 bg-blue-600 rounded-full"></div>
                            <h2 class="text-[13px] font-semibold text-blue-800 tracking-tight">Foto de perfil (opcional)
                            </h2>
                        </div>

                        <div class="p-2 space-y-1">
                            <!-- Archivo -->
                            <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                <label for="foto"
                                    class="text-[12px] font-semibold text-blue-900 text-right">Archivo</label>
                                <div>
                                    <input id="foto" name="foto" type="file" accept="image/*"
                                        class="w-full text-[13px] p-1.5 rounded-lg border border-blue-200/80 bg-white focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                                        onchange="previewImage(event)">
                                    <p class="text-[11px] text-blue-600/90 mt-0.5">Formatos: JPG, PNG. Tamaño sugerido
                                        512×512.</p>
                                </div>
                            </div>

                            <!-- Preview -->
                            <div class="grid grid-cols-[120px_1fr] items-center gap-x-2 gap-y-0.5">
                                <span class="text-[12px] font-semibold text-blue-900 text-right">Vista previa</span>
                                <div id="photo-preview" class="hidden">
                                    <img id="photo-image"
                                        class="w-20 h-20 object-cover rounded-full border border-blue-300 shadow-xs"
                                        alt="Vista previa">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bloque: Permisos por módulos -->
                    <div class="rounded-xl border border-blue-200/60 bg-white/90 shadow-xs">
                        <div class="px-3 py-2 border-b border-blue-100/80 flex items-center gap-2">
                            <div class="w-1.5 h-4 bg-blue-600 rounded-full"></div>
                            <h2 class="text-[13px] font-semibold text-blue-800 tracking-tight">Permisos por módulos</h2>
                        </div>

                        <div class="p-2">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-y-0.5 gap-x-2">
                                @php
                                    $mods = [
                                        'almacen' => 'Almacén',
                                        'urdido' => 'Urdido',
                                        'engomado' => 'Engomado',
                                        'tejido' => 'Tejido',
                                        'atadores' => 'Atadores',
                                        'tejedores' => 'Tejedores',
                                        'mantenimiento' => 'Mantenimiento',
                                        'planeacion' => 'Planeación',
                                        'configuracion' => 'Configuracion',
                                        'UrdidoEngomado' => 'Urdido y Engomado',
                                    ];
                                @endphp

                                @foreach ($mods as $name => $label)
                                    <label class="flex items-center gap-1.5 text-[13px] text-blue-900">
                                        <input type="checkbox" name="{{ $name }}" value="1"
                                            class="h-3.5 w-3.5 rounded border-blue-300 text-blue-600 focus:ring-blue-400"
                                            {{ old($name) ? 'checked' : '' }}>
                                        <span>{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="pt-1">
                        <button type="submit"
                            class="w-1/3 text-[14px] font-semibold py-2 rounded-xl
                                   bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800
                                   text-white shadow-md hover:from-blue-700 hover:via-blue-800 hover:to-blue-900
                                   border border-blue-900/10">
                            Registrar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Mostrar / ocultar contraseña
        (function() {
            const btn = document.getElementById('togglePassword');
            const input = document.getElementById('password');
            if (btn && input) {
                btn.addEventListener('click', () => {
                    const isHidden = input.type === 'password';
                    input.type = isHidden ? 'text' : 'password';
                    btn.textContent = isHidden ? 'Ocultar' : 'Mostrar';
                    input.focus();
                });
            }
        })();

        // Previsualización de imagen
        function previewImage(evt) {
            const file = evt.target.files && evt.target.files[0];
            const preview = document.getElementById('photo-preview');
            const img = document.getElementById('photo-image');

            if (!file) {
                if (preview) preview.classList.add('hidden');
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                if (img) img.src = e.target.result;
                if (preview) preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    </script>
@endsection
