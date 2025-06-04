<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ORDEN DE URDIDO Y ENGOMADO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <style>
        .circle {
            display: inline-block;
            border: 1.5px solid black;
            border-radius: 9999px;
            /* hace el borde completamente circular */
            padding: 4px 10px;
            margin: 2px;
            font-weight: bold;
        }
    </style>

</head>

<body class="bg-white impresion-UE">
    @for ($i = 0; $i < $totalJulios; $i++)
        <div class="border border-black p-5">
            <div class="flex justify-between items-center mb-1">
                <div>
                    <img src="{{ asset('images/fondosTowell/logo_towell2.png') }}" alt="Logo Towell" style="width: 2cm;">
                </div>
                <p class="font-bold text-lg text-sm">PAPELETA VIAJERA DE TELA ENGOMADA</p>
                <div class="text-right mr-2">
                    <p class="text-sm">No. FOLIO: <span class="font-bold text-red-600">{{ $folio }}</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-6 gap-4 mb-0.5 text-left">
                <div>
                    <p><strong>ENGOMADO:</strong> ________________</p>
                    <p><strong>URDIDO:</strong> ________________
                    </p>
                    <p><strong>ANCHO BALONAS:</strong> ________________
                </div>
                <div>
                    <p><strong>FECHA:</strong> {{ $orden->cuenta ?? '' }}</p>
                    <p><strong>URDIDOR:</strong>________________</p>
                    <p><strong>CAL.:</strong> </p>
                </div>
                <div>
                    <p><strong>TURNO::</strong>________________</p>
                    <p><strong>CUENTA:</strong> {{ $orden->destino ?? '' }}</p>
                    <p><strong>PROVEEDOR:</strong>________________</p>
                </div>
                <div>
                    <p><strong>COLOR: ___________________</strong> </p>
                    <p><strong>SÓLIDOS: ___________________</strong> </p>
                    <p><strong>TIPO: ________________</strong> </p>
                </div>
                <div>
                    <p><strong>ORDEN: ________________</strong> </p>
                    <p><strong>PAREJA: ________________</strong> </p>
                </div>
                <div class=" flex justify-end">
                    <!-- SVG donde se dibujará el código de barras -->
                    <svg id="barcode"></svg>
                </div>
            </div>

            <!-- Tabla principal -->
            <div class="w-full overflow-x-auto">
                <table border="1"
                    style="border-collapse: collapse; margin-bottom: 0.5rem; text-align: center; width: 100%;">
                    <thead style="line-height: 1;">
                        <tr>
                            <th colspan="6"></th>
                        </tr>
                        <tr style="background-color: #e5e7eb;">
                            <th style="padding: 1px; width: 5cm;">FECHA</th>
                            <th style="padding: 1px; width: 5cm;">H. INIC.</th>
                            <th style="padding: 1px; width: 1.5cm;">H. FINAL</th>
                            <th style="padding: 1px; width: 3.5cm;">METROS</th>
                            <th style="padding: 1px; width: 3.5cm;">ROTURAS</th>
                            <th style="padding: 1px; width: 2.5cm;">ENGOMADOR</th>
                            <th style="padding: 1px; width: 2.5cm;">OBSERVACIONES</th>
                        </tr>
                    </thead>
                    <tbody style="line-height: 1;">
                        <!-- Repite este bloque <tr> tantas veces como necesites -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; border: 1px solid black;"><strong></strong></td>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; width: 3.5cm; border: 1px solid black;"></td>
                            <td style="border: 1px solid black; width: 3.5cm;">
                                <div style="display: flex; width: 100%; height: 100%;">
                                    <div
                                        style="width: 50%; padding: 4px; text-align: center; border-right: 1px solid black;">
                                    </div>
                                    <div style="width: 50%; padding: 4px; text-align: center;"></div>
                                </div>
                            </td>
                            <td style="padding: 10px; width: 2.5cm; border: 1px solid black;"></td>
                            <td style="padding: 10px; width: 2.5cm; border: 1px solid black;"></td>
                        </tr>
                        <!-- Puedes copiar más filas aquí -->
                    </tbody>
                </table>

            </div>

            <!-- Tabla secundaria -->
            <div class="w-full overflow-x-auto mb-2">
                <table border="1"
                    style="border-collapse: collapse; margin-bottom: 0.25rem; text-align: center; width: 100%;">
                    <thead style="line-height: 1;">
                        <tr>
                            <th colspan="9"></th>
                        </tr>
                        <tr style="background-color: #e5e7eb;">
                            <th style="padding: 1px; width: 5cm;">N° JULIO</th>
                            <th style="padding: 1px; width: 5cm;">KG. BRUTO</th>
                            <th style="padding: 1px; width: 1.5cm;">TARA</th>
                            <th style="padding: 1px; width: 3.5cm;">KG. NETO</th>
                            <th style="padding: 1px; width: 3.5cm;">SOL. CAN.</th>
                            <th style="padding: 1px; width: 2cm;">TEMP. CANOA 1</th>
                            <th style="padding: 1px; width: 2.5cm;">TEMP. CANOA 2</th>
                            <th style="padding: 1px; width: 2.5cm;">TEMP. TAMB.</th>
                            <th style="padding: 1px; width: 2.5cm;">HUMEDAD</th>
                        </tr>
                    </thead>
                    <tbody style="line-height: 1;">
                        <!-- Repite este bloque <tr> tantas veces como necesites -->
                        <tr>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; border: 1px solid black;"><strong></strong></td>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                            <td style="padding: 10px; border: 1px solid black;"></td>
                        </tr>
                        <!-- Agrega más filas si lo deseas -->
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-4 gap-4 mb-0.5 text-left">
                <div>
                    <p><strong>FECHA DE ATADO:</strong> _____________________________</p>
                </div>
                <div>
                    <p><strong>TELAR:</strong> _____________________________</p>
                </div>
                <div>
                    <p><strong>TURNO:</strong> _____________________________</p>
                </div>
                <div>
                    <table class="table-fixed border border-black text-xss">
                        <tbody>
                            <tr>
                                <td class="border border-black text-center px-1"><strong>CLAVE ATADOR</strong></td>
                            </tr>
                            <tr>
                                <td class="border border-black py-4 text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-4 -mt-2 text-left">
                <div>
                    <p><strong>DESTINO:
                            <span class="circle">JZ</span>
                            <span class="circle">JS</span>
                            <span class="circle">S15</span>
                            <span class="circle">S </span>
                            <span class="circle">IN</span>
                            <span class="circle">IV</span>
                        </strong></p>
                </div>
                <div>
                    <table class="table-fixed border border-black text-xss">
                        <tbody>
                            <tr>
                                <td class="border border-black px-2 text-center"><strong>H. PARO</strong></td>
                                <td class="border border-black px-2 text-center"><strong>H. INICIO</strong></td>
                                <td class="border border-black px-2 text-center"><strong>H. FINAL</strong></td>
                            </tr>
                            <tr>
                                <td class="border border-black p-4 text-center"></td>
                                <td class="border border-black p-4 text-center"></td>
                                <td class="border border-black p-4 text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <p class="mt-5"><strong>MERMA:</strong> _____________________________</p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 mt-4 text-left">
                <div>
                    <p><strong>FIRMA DEL SUPERVISOR:</strong> _____________________________</p>
                </div>
                <div>
                    <p><strong>OBSERVACIONES:</strong> _____________________________</p>
                </div>
                <div>
                    <p><strong>BAJADO POR:</strong> _____________________________</p>
                </div>
            </div>
        </div>
    @endfor
    <!--SECCIÓN DE SCRIPS JS-->

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const folio = @json($folio);
            JsBarcode("#barcode", folio, {
                format: "CODE128",
                lineColor: "black",
                width: 1,
                height: 30,
                displayValue: false
            });
        });
    </script>
</body>

</html>
