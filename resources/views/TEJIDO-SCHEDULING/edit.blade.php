<?php
$datos = [
    // ... tus datos ...
    'en_proceso' => 'Sí',
    'Cuenta' => '2222',
    // ... etc ...
    'id' => 55,
];

// Define aquí las secciones y los campos de cada una:
$secciones = [
    'Datos Generales' => ['en_proceso', 'Cuenta', 'Salon', 'Telar', 'Ultimo', 'Cambios_Hilo', 'Maquina', 'Ancho', 'Eficiencia_Std', 'Velocidad_STD', 'Hilo'],
    'Características y Colores' => ['Calibre_Rizo', 'Calibre_Pie', 'Calendario', 'Clave_AX', 'Tamano_AX', 'Estilo_Alternativo', 'Nombre_Producto', 'ancho_por_toalla', 'COLOR_TRAMA', 'CALIBRE_C1', 'Clave_Color_C1', 'COLOR_C1', 'CALIBRE_C2', 'Clave_Color_C2', 'COLOR_C2', 'CALIBRE_C3', 'Clave_Color_C3', 'COLOR_C3', 'CALIBRE_C4', 'Clave_Color_C4', 'COLOR_C4', 'CALIBRE_C5', 'Clave_Color_C5', 'COLOR_C5', 'Plano', 'Cuenta_Pie', 'Clave_Color_Pie', 'Color_Pie', 'Peso_gr_m2'],
    'Fechas y Producción' => ['cantidad', 'Saldos', 'Fecha_Captura', 'Orden_Prod', 'Fecha_Liberacion', 'Id_Flog', 'Descrip', 'Aplic', 'Obs', 'Tipo_Ped', 'Tiras', 'Peine', 'Largo_Crudo', 'Peso_Crudo', 'Luchaje', 'CALIBRE_TRA', 'Dobladillo', 'PASADAS_TRAMA', 'PASADAS_C1', 'PASADAS_C2', 'PASADAS_C3', 'PASADAS_C4', 'PASADAS_C5', 'Dias_Ef', 'Prod_Kg_Dia', 'Std_Dia', 'Prod_Kg_Dia1', 'Std_Toa_Hr_100', 'Dias_jornada_completa', 'Horas', 'Std_Hr_efectivo', 'Inicio_Tejido', 'Calc4', 'Calc5', 'Calc6', 'Fin_Tejido', 'Fecha_Compromiso', 'Fecha_Compromiso1', 'Entrega', 'Dif_vs_Compromiso'],
    'Identificador' => ['id'],
];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Edición de Registro</title>
    <style>
        body {
            background: linear-gradient(135deg, #099ff6, #c2e7ff, #0857be);
            background-size: 300% 300%;
            animation: gradientAnimation 5s ease infinite;
            position: relative;
            overflow: hidden;
            /* Para que los círculos no se salgan del body */
        }

        /* Animación del fondo */
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

        .form-container {
            max-width: 1400px;
            margin: 32px auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            padding: 2px 2px 2px 2px;
        }

        .form-title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 2px;
            color: #222e3a;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-section {
            border-top: 2px solid #e5e7eb;
            padding-top: 2px;
        }

        .section-title {
            font-size: 1.15rem;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 2px;
        }

        .section-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2px 4px;
        }

        .form-group {
            display: flex;
            align-items: center;
        }

        .form-label {
            min-width: 80px;
            font-size: 0.97rem;
            font-weight: 600;
            color: #374151;
            margin-right: 2px;
            text-align: right;
        }

        .form-input {
            flex: 1;
            padding: 4px 7px;
            border: 1.5px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            border-color: #1717ff;
            outline: none;
        }

        .form-submit {
            margin-top: 10px;
            display: flex;
            justify-content: center;
        }

        .submit-btn {
            background: #2563eb;
            color: #fff;
            font-weight: bold;
            font-size: 1.2rem;
            padding: 12px 8px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.10);
            transition: background 0.15s;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        @media (max-width: 900px) {
            .section-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 650px) {
            .section-grid {
                grid-template-columns: 1fr;
            }

            .form-label {
                min-width: 50px;
                font-size: 10pz;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-title">EDICIÓN DE REGISTRO</div>
        <form action="tu-accion.php" method="POST">
            <?php foreach ($secciones as $section => $fields): ?>
            <section class="form-section">
                <div class="section-title"><?= htmlspecialchars($section) ?></div>
                <div class="section-grid">
                    <?php foreach ($fields as $campo): ?>
                    <div class="form-group">
                        <label for="<?= $campo ?>" class="form-label">
                            <?= ucwords(str_replace('_', ' ', $campo)) ?>
                        </label>
                        <input
                            type="<?= stripos($campo, 'fecha') !== false || stripos($campo, 'Fecha') !== false ? 'date' : (is_numeric($datos[$campo] ?? null) && !in_array($campo, ['Cuenta', 'Id_Flog', 'Clave_AX', 'Tamano_AX']) ? 'number' : 'text') ?>"
                            id="<?= $campo ?>" name="<?= $campo ?>" class="form-input"
                            value="<?= htmlspecialchars($datos[$campo] ?? '') ?>" autocomplete="off">
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endforeach; ?>
            <div class="form-submit">
                <button type="submit" class="submit-btn">Guardar Registro</button>
            </div>
        </form>
    </div>
</body>

</html>
