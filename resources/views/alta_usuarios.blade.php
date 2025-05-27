@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Registrar Nuevo Usuario</h1>

        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-2xl p-6">
            <form action="{{ route('usuarios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Área -->
                <div class="mb-4">
                    <label for="area" class="block font-semibold">Área</label>
                    <select name="area" id="area" class="w-full p-2 border rounded-lg" required>
                        <option value="" disabled selected>Selecciona el área</option>
                        <option value="Almacen">Almacén</option>
                        <option value="Urdido">Urdido</option>
                        <option value="Engomado">Engomado</option>
                        <option value="Tejido">Tejido</option>
                        <option value="Atadores">Atadores</option>
                        <option value="Tejedores">Tejedores</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                    </select>
                </div>

                <!-- Número de Empleado -->
                <div class="mb-4">
                    <label for="numero_empleado" class="block font-semibold">Número de Empleado</label>
                    <input type="text" name="numero_empleado" id="numero_empleado" class="w-full p-2 border rounded-lg"
                        required>
                </div>

                <!-- Nombre -->
                <div class="mb-4">
                    <label for="nombre" class="block font-semibold">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="w-full p-2 border rounded-lg" required>
                </div>

                <!-- Campo para Contraseña -->
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <div class="password-container">
                        <input type="password" name="contrasenia" id="password" placeholder="Tu contraseña" required>

                    </div>
                </div>

                <!-- Foto (Opcional) -->
                <div class="mb-4">
                    <label for="foto" class="block font-semibold">Foto de Perfil (Opcional)</label>
                    <input type="file" name="foto" id="foto" class="w-full p-2 border rounded-lg"
                        accept="image/*" onchange="previewImage(event)">
                    <div id="photo-preview" class="mt-2 hidden">
                        <img id="photo-image" class="w-32 h-32 object-cover rounded-full border">
                    </div>
                </div>

                <!-- Permisos por Módulos (Checkbox) -->
                <div class="mb-4">
                    <label class="block font-semibold">Módulos</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label><input type="checkbox" name="almacen"> Almacén</label>
                        <label><input type="checkbox" name="urdido"> Urdido</label>
                        <label><input type="checkbox" name="engomado"> Engomado</label>
                        <label><input type="checkbox" name="tejido"> Tejido</label>
                        <label><input type="checkbox" name="atadores"> Atadores</label>
                        <label><input type="checkbox" name="tejedores"> Tejedores</label>
                        <label><input type="checkbox" name="mantenimiento"> Mantenimiento</label>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div class="mt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                        Registrar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script para Previsualizar Imagen -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            let passwordField = document.getElementById('password');
            let fieldType = passwordField.getAttribute('type');
            let button = document.getElementById('togglePassword');

            if (fieldType === 'password') {
                passwordField.setAttribute('type', 'text');
                button.textContent = 'Ocultar Contraseña'; // Cambiar el texto al hacer clic
            } else {
                passwordField.setAttribute('type', 'password');
                button.textContent = 'Mostrar Contraseña'; // Volver al texto original
            }
        });
    </script>
@endsection
