<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #00b4d8, #0096c7, #0077b6, #023e8a, #03045e);
            background-size: 500% 500%;
            animation: gradientAnimation 8s ease-in-out infinite;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            25% {
                background-position: 50% 100%;
            }
            50% {
                background-position: 100% 50%;
            }
            75% {
                background-position: 50% 0%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="fondoLog">
    <div class="login-container">
        <div class="login-box">
            <h2>Iniciar sesión</h2>

            <!-- Formulario de login -->
            <form id="loginForm" method="POST" action="{{ url('/login') }}">
                @csrf

                <!-- Campo para Foto de perfil -->
                <div class="input-group">
                    <label for="photo">Foto de Perfil</label>
                
                    <!-- Cuadro donde se podrá visualizar la foto en el futuro -->
                    <div id="photo-preview" class="photo-preview" style="display: none;">
                        <img src="#" alt="Vista previa" id="photo-image"/>
                    </div>
                </div>                         

                <!-- Campo para Área -->
                <div class="input-group">
                    <label for="area">Área</label>
                    <select name="area" id="area" required>
                        <option value="" disabled selected>Selecciona tu área</option>
                        <option value="Almacen">Almacén</option>
                        <option value="Urdido">Urdido</option>
                        <option value="Engomado">Engomado</option>
                        <option value="Tejido">Tejido</option>
                        <option value="Atadores">Atadores</option>
                        <option value="Tejedores">Tejedores</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                    </select>
                </div>
                
                <!-- Campo para Número de Empleado -->
                <div class="input-group">
                    <label for="noEmpleado">Número de Empleado</label>
                    <select name="numero_empleado" id="noEmpleado" required>
                        <option value="" disabled selected>Selecciona tu número de empleado</option>
                        <option value="1">Porfavor selecciona el área a la que correspondes</option>
                    </select>
                </div>

                <!-- Campo para Nombre -->
                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="name" id="name" placeholder="Tu nombre" required>
                </div>

                <!-- Campo para Contraseña -->
                <div class="input-group">
                    <label for="password">Contraseña</label>

                    <!-- Mensaje de error justo encima del campo de contraseña -->
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="password-container">
                        <input type="password" name="contrasenia" id="password" placeholder="Tu contraseña" required>
                        <span id="togglePassword" class="eye-icon">👁️</span>
                    </div>
                </div>
                
                <!-- Botón para enviar formulario -->
                <button type="submit" id="btnLogin">Iniciar sesión</button>
                <!-- Botón de Acceso por QR -->
                <div class="qr-option">
                    <button type="button" id="qr-button">Accesar por QR</button>
                </div>

                <video id="qr-video" style="display:none;"></video>

            </form>

            <!-- Modal de recuperación de contraseña -->
            <div id="forgot-password-modal" class="modal">
                <div class="modal-content">
                    <h2>Recuperar Contraseña</h2>
                    <form id="forgot-password-form">
                        <label for="numero_empleado">Número de empleado:</label>
                        <input type="text" id="numero_empleado" name="numero_empleado" required>
                        <button type="submit">Enviar solicitud</button>
                    </form>
                    <button id="close-modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.min.js"></script>

    <script>
        document.getElementById('area').addEventListener('change', function() {
            const areaSeleccionada = this.value;
            const noEmpleadoSelect = document.getElementById('noEmpleado');
        
            // Limpiar opciones previas
            noEmpleadoSelect.innerHTML = '<option value="" disabled selected>Selecciona tu número de empleado</option>';
            document.getElementById('name').value = ""; // Limpiar nombre
            document.getElementById('photo-preview').style.display = 'none'; // Limpiar foto previa
        
            if (areaSeleccionada) {
                fetch(`/obtener-empleados/${areaSeleccionada}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(empleado => {
                            let option = document.createElement('option');
                            option.value = empleado.numero_empleado;
                            option.textContent = empleado.numero_empleado;
                            noEmpleadoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Error al obtener empleados:", error));
            }
        });
    
        document.getElementById('noEmpleado').addEventListener('change', function() {
        const noEmpleado = this.value;

        if (noEmpleado) {
            fetch(`/obtener-nombre/${noEmpleado}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.nombre || "";
                    const fotoUrl = data.foto ? `/storage/${data.foto}` : ''; // Ruta de la foto, asegurándose de que sea válida
                    const photoPreview = document.getElementById('photo-preview');
                    const photoImage = document.getElementById('photo-image');
                    
                    // Si hay foto, mostrarla
                    if (fotoUrl) {
                        photoPreview.style.display = 'block'; // Hacer visible la imagen
                        photoImage.src = fotoUrl; // Actualizar la imagen
                    } else {
                        photoPreview.style.display = 'none'; // Si no hay foto, ocultar el área de la vista previa
                    }
                })
                .catch(error => console.error("Error al obtener el nombre:", error));
        }
    });
    </script>

    <script>
        document.getElementById('photo').addEventListener('change', function(event) {
            var reader = new FileReader();

            // Cuando se carga la imagen
            reader.onload = function() {
                var photoPreview = document.getElementById('photo-image');
                photoPreview.style.display = 'block';  // Hacer visible la imagen
                photoPreview.src = reader.result;  // Establecer la imagen seleccionada como fuente
            }

            // Leer la imagen seleccionada como una URL
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            let passwordField = document.getElementById('password');
            let fieldType = passwordField.getAttribute('type');
            passwordField.setAttribute('type', fieldType === 'password' ? 'text' : 'password');
        });
    </script>

    
    <script>
        const qrButton = document.getElementById('qr-button');
        const qrVideo = document.getElementById('qr-video');

        qrButton.addEventListener('click', function() {
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                .then(function(stream) {
                    qrVideo.srcObject = stream;
                    qrVideo.style.display = 'block';
                    qrVideo.play();

                    const interval = setInterval(() => {
                        if (qrVideo.readyState === qrVideo.HAVE_ENOUGH_DATA) {
                            const canvas = document.createElement('canvas');
                            canvas.width = qrVideo.videoWidth;
                            canvas.height = qrVideo.videoHeight;
                            const context = canvas.getContext('2d');
                            context.drawImage(qrVideo, 0, 0, canvas.width, canvas.height);

                            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                            const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

                            if (qrCode) {
                                clearInterval(interval);

                                // Enviar el número de empleado al backend para autenticación
                                fetch('/login-qr', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({ numero_empleado: qrCode.data })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.href = '/produccionProceso';
                                    } else {
                                        alert('Error: ' + data.message);
                                    }
                                })
                                .catch(error => console.error('Error en la autenticación QR:', error));
                            }
                        }
                    }, 100);
                })
                .catch(error => {
                    console.log('Error al acceder a la cámara: ', error);
                });
        });
    </script>
</body>
</html>
