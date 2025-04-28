<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Urdido y Engomado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body class="bg-white p-1">
    <div class="border border-black p-1 impresion-UE">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h1 class="font-bold text-2xl">Towell</h1>
            </div>
                <p class="font-bold text-lg text-sm">ORDEN DE URDIDO Y ENGOMADO</p>
            <div class="text-right">
                <p class="text-sm">No. FOLIO: <span class="font-bold text-red-600">A020</span></p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3 mb-2 ">
            <div>
                <p><strong>PARADA:</strong></p>
                <p><strong>FECHA:</strong> 10/09/2024</p>
                <p><strong>CUENTA:</strong> 3036</p>
            </div>
            
            <div>
                <p><strong>Tipo</strong> RIZO <input type="checkbox">   PIE <input type="checkbox"></p>
                
            </div>
            <div>
                <p><strong>ORDENADO POR:</strong> Salvador Z</p>
                <p><strong>DESTINO:</strong> Japones</p>
                <p><strong>COLOR:</strong> 1000</p>
            </div>
        </div>

        <div style="display: flex;" class="mb-2 ">
            <div class=" border border-black p-1 w-2/5 grid grid-cols-2 gap-2 justify-between" >
              <div>
                <p><strong>URDIDO:</strong> MCT</p>
                <p><strong>CALIBRE:</strong> 12/</p>
                <p><strong>PROVEEDOR:</strong> JUTEPEC</p>
              </div>
              <div>
                <p><strong>METROS:</strong> 12</p>
                <p><strong>LOTE:</strong> JUTEPEC</p>
              </div>
            </div>

            <div class="ml-2 border border-black p-1 w-3/5">
                <p><strong>CONSTRUCCIÓN:</strong> HILO DE 506 HILOS</p>
            </div>
        </div>
        <!-- Tabla principal -->
        <div class="w-full overflow-x-auto">
        <table class=" border border-collapse border-black mb-2 text-center w-full">
          <thead class="leading-none">
              <tr>
                <th colspan="11"></th>
                  <th class="border border-black p-[1px] bg-gray-50" colspan="4">ROTURAS</th>
              </tr>
              <tr class="bg-gray-200">
                  <th class="border border-black p-[1px] whitespace-nowrap">FECHA</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">OFICIAL</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">TURNO</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">H. INIC.</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">H. FIN.</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">No. JULIO</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">HILOS</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">Kg. BRUTO</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">TARA</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">Kg. NETO</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">METROS</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">HILAT.</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">MAQ.</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">OPERAC.</th>
                  <th class="border border-black p-[1px] whitespace-nowrap">TRANSF.</th>
              </tr>
          </thead>
          <tbody class="leading-none">
              <tr>
                  <td class="border border-black p-[1px] whitespace-nowrap">12-09-24</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">Lemos</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">1°</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">12:45</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">1:40</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">14</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">506</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">373.3</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">143.4</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">253.9</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">10000</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">5</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">3</td>
                  <td class="border border-black p-[1px] whitespace-nowrap">3</td>
              </tr>
              <tr>
                <td class="border border-black p-[1px] whitespace-nowrap">12-09-24</td>
                <td class="border border-black p-[1px] whitespace-nowrap">Lemos</td>
                <td class="border border-black p-[1px] whitespace-nowrap">1°</td>
                <td class="border border-black p-[1px] whitespace-nowrap">12:45</td>
                <td class="border border-black p-[1px] whitespace-nowrap">1:40</td>
                <td class="border border-black p-[1px] whitespace-nowrap">14</td>
                <td class="border border-black p-[1px] whitespace-nowrap">506</td>
                <td class="border border-black p-[1px] whitespace-nowrap">373.3</td>
                <td class="border border-black p-[1px] whitespace-nowrap">143.4</td>
                <td class="border border-black p-[1px] whitespace-nowrap">253.9</td>
                <td class="border border-black p-[1px] whitespace-nowrap">10000</td>
                <td class="border border-black p-[1px] whitespace-nowrap">5</td>
                <td class="border border-black p-[1px] whitespace-nowrap">3</td>
                <td class="border border-black p-[1px] whitespace-nowrap">3</td>
            </tr>              
            <tr>
              <td class="border border-black p-[1px] whitespace-nowrap">12-09-24</td>
              <td class="border border-black p-[1px] whitespace-nowrap">Lemos</td>
              <td class="border border-black p-[1px] whitespace-nowrap">1°</td>
              <td class="border border-black p-[1px] whitespace-nowrap">12:45</td>
              <td class="border border-black p-[1px] whitespace-nowrap">1:40</td>
              <td class="border border-black p-[1px] whitespace-nowrap">14</td>
              <td class="border border-black p-[1px] whitespace-nowrap">506</td>
              <td class="border border-black p-[1px] whitespace-nowrap">373.3</td>
              <td class="border border-black p-[1px] whitespace-nowrap">143.4</td>
              <td class="border border-black p-[1px] whitespace-nowrap">253.9</td>
              <td class="border border-black p-[1px] whitespace-nowrap">10000</td>
              <td class="border border-black p-[1px] whitespace-nowrap">5</td>
              <td class="border border-black p-[1px] whitespace-nowrap">3</td>
              <td class="border border-black p-[1px] whitespace-nowrap">3</td>
          </tr>
          <tr>
            <td class="border border-black p-[1px] whitespace-nowrap">12-09-24</td>
            <td class="border border-black p-[1px] whitespace-nowrap">Lemos</td>
            <td class="border border-black p-[1px] whitespace-nowrap">1°</td>
            <td class="border border-black p-[1px] whitespace-nowrap">12:45</td>
            <td class="border border-black p-[1px] whitespace-nowrap">1:40</td>
            <td class="border border-black p-[1px] whitespace-nowrap">14</td>
            <td class="border border-black p-[1px] whitespace-nowrap">506</td>
            <td class="border border-black p-[1px] whitespace-nowrap">373.3</td>
            <td class="border border-black p-[1px] whitespace-nowrap">143.4</td>
            <td class="border border-black p-[1px] whitespace-nowrap">253.9</td>
            <td class="border border-black p-[1px] whitespace-nowrap">10000</td>
            <td class="border border-black p-[1px] whitespace-nowrap">5</td>
            <td class="border border-black p-[1px] whitespace-nowrap">3</td>
            <td class="border border-black p-[1px] whitespace-nowrap">3</td>
        </tr>
          </tbody>
      </table>
    </div>
      
      @php
          $campos = [
              'COCINERO:', 'TURNO:', 'OLLAS:', 'VOL. INICIAL:',
              'ALMIDÓN:', 'RESINA:', 'VOL. FINAL:', 'FÓRMULA:',
              '% SÓLIDOS:', 'PRODUCCIÓN:'
          ];
      @endphp
  
      <table class="w-full table-fixed border-collapse border border-black">
          <tbody>
              @foreach ($campos as $campo)
                  <tr>
                      <td class="border border-black p-[1px] whitespace-nowrap font-bold">{{ $campo }}</td>
                      @for ($i = 0; $i < 7; $i++)
                          <td class="border border-black p-[1px] whitespace-nowrap"></td>
                      @endfor
                  </tr>
              @endforeach
          </tbody>
      </table>

      <div class=" p-1 grid grid-cols-3 gap-3 justify-between text-center">
        <div>
          <p><strong>NÚCLEO:</strong> Japones</p>
          <p><strong>NO. TELAS:</strong> DOS</p>
        </div>
        <div>
          <p><strong>ANCHO BALONAS:</strong> 273 cm</p>
          <p><strong>METRAJE DE TELAS:</strong> 50000</p>
        </div>
        <div>
          <p><strong>CUENDEADOS MÍNIMO:</strong> 2 x tela</p>
        </div>
      </div>
    </div>

</body>
</html>
