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
            background: linear-gradient(135deg, #bfc2c3, #e8f0f2, #262a30);
            background-size: 300% 300%;
            animation: gradientAnimation 5s ease infinite;
            position: relative;
            /* Para que el pseudo-elemento se posicione respecto al body */
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        #qr-video-container {
            position: fixed;
            /* Se mantiene fijo en toda la pantalla */
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.8);
            /* Fondo oscuro semitransparente */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            /* Asegura que esté por encima de todo */
            display: none;
            /* Oculto por defecto */
        }

        #qr-video {
            width: 80vw;
            max-width: 400px;
            height: auto;
            border: 5px solid white;
            border-radius: 10px;
            background: black;
        }

        .eye-icon {
            cursor: pointer;
            display: inline-block;
            transition: transform 0.3s ease, color 0.3s ease;
            font-size: 24px;
            color: #555;
            user-select: none;
        }

        /* Efecto al pasar el cursor */
        .eye-icon:hover {
            color: #007BFF;
            /* azul brillante */
            transform: scale(1.3) rotate(15deg);
        }

        /* Efecto al hacer clic (cuando está activo) */
        .eye-icon:active {
            color: #0056b3;
            /* azul oscuro */
            transform: scale(1.1) rotate(-10deg);
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
                    <div id="photo-preview" class="photo-preview">
                        <img src="images/fotos_usuarios/TOWELLIN.png" alt="Previsualización" width="200"
                            id="photo-image" />
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
                    </select>
                </div>

                <!-- Campo para Nombre -->
                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="name" id="name" placeholder="Tu nombre" readonly>
                </div>

                <!-- Campo para Contraseña -->
                <div class="input-group">
                    <label for="password">Contraseña</label>

                    <!-- Mensaje de error justo encima del campo de contraseña -->
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="password-container">
                        <input type="password" name="contrasenia" id="password" placeholder="Tu contraseña" required
                            inputmode="numeric" pattern="[0-9]*">

                        <span id="togglePassword" class="eye-icon">🔒</span>
                    </div>
                </div>

                <!-- Botón para enviar formulario -->
                <button type="submit" id="btnLogin">Iniciar sesión</button>
                <!-- Botón de Acceso por QR -->
                <div class="qr-option">
                    <button type="button" id="qr-button">Accesar por QR</button>
                </div>

                <div id="qr-video-container">
                    <video id="qr-video" autoplay></video>
                    <div id="qr-overlay"
                        style="position: absolute; top: 0; left: 0; right:0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; flex-direction: column; align-items: center; justify-content: center; color: white; font-size: 1.5rem; z-index: 10;">
                        <div id="qr-message">Escanea tu código...</div>
                        <div
                            style="margin-top: 20px; border: 3px solid white; width: 200px; height: 200px; border-radius: 10px;">
                        </div>
                        <button id="cerrar-qr"
                            style="position: absolute; top: 10px; right: 10px; z-index: 11; width: auto; max-width: 150px;"
                            class="bg-green-600 text-white p-1 rounded">
                            Cerrar QR
                        </button>

                    </div>

                </div>


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
            noEmpleadoSelect.innerHTML =
                '<option value="" disabled selected>Selecciona tu número de empleado</option>';
            document.getElementById('name').value = ""; // Limpiar nombre
            document.getElementById('photo-preview').style.display = 'block'; // Limpiar foto previa
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
                        const fotoUrl = data.foto ? `/images/${data.foto}` :
                            ''; // Ruta de la foto, asegurándose de que sea válida 
                        document.getElementById('password').focus(); // Ponemos el foco en la contraseña
                        const photoPreview = document.getElementById('photo-preview');
                        const photoImage = document.getElementById('photo-image');

                        // Si hay foto, mostrarla
                        if (fotoUrl) {
                            photoPreview.style.display = 'block'; // Hacer visible la imagen
                            photoImage.src = fotoUrl; // Actualizar la imagen
                            document.getElementById('password').focus();
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
                photoPreview.style.display = 'block'; // Hacer visible la imagen
                photoPreview.src = reader.result; // Establecer la imagen seleccionada como fuente
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
    <!-- Este SCRIPT carga la función del botón de QR-->
    <script>
        const qrButton = document.getElementById('qr-button');
        const qrVideoContainer = document.getElementById('qr-video-container');
        const qrVideo = document.getElementById('qr-video');
        const cerrarQR = document.getElementById('cerrar-qr');
        let stream = null;
        let interval = null;

        function iniciarEscaneoQR() {
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                })
                .then(function(s) {
                    stream = s;
                    qrVideo.srcObject = stream;
                    qrVideoContainer.style.display = 'flex';
                    document.getElementById('qr-overlay').style.display = 'flex';
                    qrVideo.play();

                    interval = setInterval(() => {
                        if (qrVideo.readyState === qrVideo.HAVE_ENOUGH_DATA) {
                            const canvas = document.createElement('canvas');
                            canvas.width = qrVideo.videoWidth;
                            canvas.height = qrVideo.videoHeight;
                            const context = canvas.getContext('2d');
                            context.drawImage(qrVideo, 0, 0, canvas.width, canvas.height);

                            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                            const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

                            if (qrCode) {
                                detenerEscaneoQR();
                                fetch('/login-qr', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').content
                                        },
                                        body: JSON.stringify({
                                            numero_empleado: qrCode.data
                                        })
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
        }

        function detenerEscaneoQR() {
            if (interval) {
                clearInterval(interval);
                interval = null;
            }
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
            qrVideoContainer.style.display = 'none';
            document.getElementById('qr-overlay').style.display = 'none';
        }

        qrButton.addEventListener('click', iniciarEscaneoQR);
        cerrarQR.addEventListener('click', detenerEscaneoQR);

        function esDispositivoMovil() {
            return /Android|iPhone|iPad|iPod|Windows Phone|webOS/i.test(navigator.userAgent);
        }

        window.addEventListener('DOMContentLoaded', () => {
            if (esDispositivoMovil()) {
                iniciarEscaneoQR();
            }
        });
    </script>
    <!--OJO, parece que no realiza lo esperado, comprobar con el paso del tiempo si realmente recarga la pagina al presionar boton adelante-->
    <script>
        // Detecta si esta página fue accedida desde el historial (adelante o atrás)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                // Si se volvió a esta página desde el historial (adelante o atrás)
                window.location.reload(); // Fuerza recarga completa
            }
        });
    </script>


</body>

</html>
