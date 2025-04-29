<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ORDEN DE URDIDO Y ENGOMADO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

</head>
<body class="bg-white impresion-UE">
    <div class="border border-black p-1 ">
        <div class="flex justify-between items-center mb-1">
            <div>
                <img src="{{ asset('images/fondosTowell/logo_towell2.png') }}" alt="Logo Towell" style="width: 2cm;">
                
            </div>
            <p class="font-bold text-lg text-sm">ORDEN DE URDIDO Y ENGOMADO</p>
            <div class="text-right mr-2">
                <p class="text-sm">No. FOLIO: <span class="font-bold text-red-600">{{ $folio }}</span></p>
            </div>
        </div>
    
        <div class="grid grid-cols-4 gap-4 mb-0.5 text-left">
            <div>
                <p><strong>PARADA:</strong> _____________</p>
                <p><strong>FECHA:</strong> _____________</p>
            </div>
            <div>
                <p><strong>CUENTA:</strong> {{ $orden->cuenta ?? ''}}</p>
                
                
                <p class="flex items-center space-x-6">
                    <strong class="mr-2">TIPO:</strong>
                    <label class="inline-flex items-center space-x-1">
                        <input type="checkbox" class="w-5 h-5 border-black" 
                               style="background-color: blue;" 
                               {{ $orden->tipo === 'Rizo' ? 'checked' : '' }} disabled>
                        <span>RIZO</span>
                    </label>
                
                    <label class="inline-flex items-center space-x-1">
                        <input type="checkbox" class="w-5 h-5 border-black" 
                               style="color: blue;" 
                              {{ $orden->tipo === 'Pie' ? 'checked' : '' }} disabled>
                        <span>PIE</span>
                    </label>
                </p>  
                
                
            </div>
            <div>
                <p><strong>ORDENADO POR:</strong>_____________</p>
                <p><strong>DESTINO:</strong> {{ $orden->destino ?? '' }}</p>
            </div>
            <div>
                <p><strong>COLOR: _____________</strong> {{ $orden->color ?? ''}}</p>
            </div>
        </div>

        <div style="display: flex;" class="mb-2 ">
            <div class=" border border-black p-1 w-1/2 grid grid-cols-3 gap-3 justify-between">
                <div>
                    <p><strong>URDIDO:</strong> {{ $orden->urdido ?? ''}}</p>
                    <p><strong>CALIBRE:</strong> _____________</p>
                </div>
                <div>
                    <p><strong>PROVEEDOR:</strong> {{ $orden->proveedor ?? '' }}</p>
                    <p><strong>METROS:</strong> {{ rtrim(rtrim(number_format($orden->metros, 1, '.', ''), '0'), '.') ?? ' '}}</p>
                </div>
                <div>
                  <p><strong>LOTE:</strong> _____________</p>
                </div>
            </div>

            <div class="ml-2 border border-black p-1 w-1/2">
                <p><strong>CONSTRUCCIÓN:</strong>
                    @if ($julios->count())
                        @foreach ($julios as $index => $jul)
                            {{ $jul->no_julios }} {{ $jul->no_julios == 1 ? 'JULIO' : 'JULIOS' }} DE {{ $jul->hilos }} HILOS{{ $index + 1 < $julios->count() ? ', ' : '' }}
                        @endforeach
                    @else
                        No hay información de julios
                    @endif
                </p>                
                
            </div>
        </div>
        <!-- Tabla principal -->
        <div class="w-full overflow-x-auto">
          <table class="border border-collapse border-black mb-1 text-center w-full">
            <thead class="leading-none">
                <tr>
                    <th colspan="11"></th>
                    <th class="border border-black p-[1px] bg-gray-50" colspan="4">ROTURAS</th>
                </tr>
                <tr class="bg-gray-200">
                    @php
                        $headers = [
                            'FECHA', 'OFICIAL', 'TURNO', 'H. INIC.', 'H. FIN.', 'No. JULIO', 'HILOS', 
                            'Kg. BRUTO', 'TARA', 'Kg. NETO', 'METROS', 'HILAT.', 'MAQ.', 'OPERAC.', 'TRANSF.'
                        ];
                    @endphp
                    @foreach ($headers as $index => $header)
                    <th class="border border-black p-[1px] whitespace-nowrap 
                    {{ $index === 0 ? 'w-20' : '' }}
                    {{ $index === 1 ? 'w-20' : '' }}  
                    {{ $index === 2 ? 'w-5' : '' }}
                    {{ $index === 3 ? 'w-15' : '' }}
                    {{ $index === 4 ? 'w-15' : '' }}
                    {{ $index === 5 ? 'w-8' : '' }}
                    {{ $index === 7 ? 'w-10' : '' }}
                    {{ $index === 8 ? 'w-16' : '' }}
                    {{ $index === 9 ? 'w-10' : '' }}
                    {{ $index === 11 ? 'w-5' : '' }}
                    {{ $index === 12 ? 'w-5' : '' }}
                    {{ $index === 13 ? 'w-5' : '' }}
                    {{ $index === 14 ? 'w-5' : '' }}
                     ">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="leading-none">
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        @for ($j = 0; $j < 15; $j++)
                            <td class="border border-black p-[5px] whitespace-nowrap 
                            {{ $j === 0 ? 'w-32' : '' }}
                            {{ $j === 2 ? 'w-5' : '' }}
                            {{ $j === 5 ? 'w-5' : '' }}
                            {{ $j === 7 ? 'w-10' : '' }}
                            {{ $j === 9 ? 'w-10' : '' }}
                            {{ $j === 11 ? 'w-5' : '' }}
                             ">&nbsp;</td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
            
          </table>
      </div>
        @php
            $campos = [
                'COCINERO:',
                'TURNO:',
                'OLLAS:',
                'VOL. INICIAL:',
                'ALMIDÓN:',
                'RESINA:',
                'VOL. FINAL:',
                'FÓRMULA:',
                '% SÓLIDOS:',
                'PRODUCCIÓN:',
            ];
        @endphp

        <table class="w-full table-fixed border-collapse border border-black impresion-UE-2">
            <tbody>
                @foreach ($campos as $campo)
                    <tr>
                        <td class="border border-black whitespace-nowrap font-bold">{{ $campo }}</td>
                        @for ($i = 0; $i < 7; $i++)
                            <td class="border border-black whitespace-nowrap"></td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class=" grid grid-cols-6 gap-6 justify-between text-left">
            <div>
                <p><strong>NÚCLEO:</strong> {{ $orden->nucleo }}</p>
                <p><strong>NO. TELAS:</strong> {{ $orden->no_telas }}</p>
            </div>
            <div>
                <p><strong>ANCHO BALONAS:</strong> {{ $orden->balonas }}</p>
                <p><strong>METRAJE DE TELAS:</strong> {{ $orden->metros_tela }}</p>
            </div>
            <div>
                <p><strong>CUENDEADOS MÍNIMO:</strong>{{ $orden->cuendados_mini }}</p>
            </div>
            <div class="col-span-3">
                <p class="max-w-xl line-clamp-2">
                    <strong>OBSERVACIONES:</strong> Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae aliquid vel dolores pariatur exercitationem, illum nihil ex excepturi debitis suscipit praesentium repellendus labore ea inventore recusandae atque voluptatem, quisquam repellat.
                </p>
            </div>
        </div>
    </div>
    <!--SEGUNDA IMPRESION DE LA ORDEN URDIDO Y ENGOMADO-->
    <br>
    <div class="border border-black p-1 ">
        <div class="flex justify-between items-center mb-1">
            <div>
                <img src="{{ asset('images/fondosTowell/logo_towell2.png') }}" alt="Logo Towell" style="width: 2cm;">
                
            </div>
            <p class="font-bold text-lg text-sm">ORDEN DE URDIDO Y ENGOMADO</p>
            <div class="text-right mr-2">
                <p class="text-sm">No. FOLIO: <span class="font-bold text-red-600">{{ $folio }}</span></p>
            </div>
        </div>
    
        <div class="grid grid-cols-4 gap-4 mb-0.5 text-left">
            <div>
                <p><strong>PARADA:</strong> _____________</p>
                <p><strong>FECHA:</strong> _____________</p>
            </div>
            <div>
                <p><strong>CUENTA:</strong> {{ $orden->cuenta ?? ''}}</p>
                
                
                <p class="flex items-center space-x-6">
                    <strong class="mr-2">TIPO:</strong>
                    <label class="inline-flex items-center space-x-1">
                        <input type="checkbox" class="w-5 h-5 border-black" 
                               style="background-color: blue;" 
                               {{ $orden->tipo === 'Rizo' ? 'checked' : '' }} disabled>
                        <span>RIZO</span>
                    </label>
                
                    <label class="inline-flex items-center space-x-1">
                        <input type="checkbox" class="w-5 h-5 border-black" 
                               style="color: blue;" 
                              {{ $orden->tipo === 'Pie' ? 'checked' : '' }} disabled>
                        <span>PIE</span>
                    </label>
                </p>  
                
                
            </div>
            <div>
                <p><strong>ORDENADO POR:</strong>_____________</p>
                <p><strong>DESTINO:</strong> {{ $orden->destino ?? '' }}</p>
            </div>
            <div>
                <p><strong>COLOR: _____________</strong> {{ $orden->color ?? ''}}</p>
            </div>
        </div>

        <div style="display: flex;" class="mb-2 ">
            <div class=" border border-black p-1 w-1/2 grid grid-cols-3 gap-3 justify-between">
                <div>
                    <p><strong>URDIDO:</strong> {{ $orden->urdido ?? ''}}</p>
                    <p><strong>CALIBRE:</strong> _____________</p>
                </div>
                <div>
                    <p><strong>PROVEEDOR:</strong> {{ $orden->proveedor ?? '' }}</p>
                    <p><strong>METROS:</strong> {{ rtrim(rtrim(number_format($orden->metros, 1, '.', ''), '0'), '.') ?? ' '}}</p>
                </div>
                <div>
                  <p><strong>LOTE:</strong> _____________</p>
                </div>
            </div>

            <div class="ml-2 border border-black p-1 w-1/2">
                <p><strong>CONSTRUCCIÓN:</strong>
                    @if ($julios->count())
                        @foreach ($julios as $index => $jul)
                            {{ $jul->no_julios }} {{ $jul->no_julios == 1 ? 'JULIO' : 'JULIOS' }} DE {{ $jul->hilos }} HILOS{{ $index + 1 < $julios->count() ? ', ' : '' }}
                        @endforeach
                    @else
                        No hay información de julios
                    @endif
                </p>                
                
            </div>
        </div>
        <!-- Tabla principal -->
        <div class="w-full overflow-x-auto">
          <table class="border border-collapse border-black mb-1 text-center w-full">
            <thead class="leading-none">
                <tr>
                    <th colspan="11"></th>
                    <th class="border border-black p-[1px] bg-gray-50" colspan="4">ROTURAS</th>
                </tr>
                <tr class="bg-gray-200">
                    @php
                        $headers = [
                            'FECHA', 'OFICIAL', 'TURNO', 'H. INIC.', 'H. FIN.', 'No. JULIO', 'HILOS', 
                            'Kg. BRUTO', 'TARA', 'Kg. NETO', 'METROS', 'HILAT.', 'MAQ.', 'OPERAC.', 'TRANSF.'
                        ];
                    @endphp
                    @foreach ($headers as $index => $header)
                    <th class="border border-black p-[1px] whitespace-nowrap 
                    {{ $index === 0 ? 'w-20' : '' }}
                    {{ $index === 1 ? 'w-20' : '' }}  
                    {{ $index === 2 ? 'w-5' : '' }}
                    {{ $index === 3 ? 'w-15' : '' }}
                    {{ $index === 4 ? 'w-15' : '' }}
                    {{ $index === 5 ? 'w-8' : '' }}
                    {{ $index === 7 ? 'w-10' : '' }}
                    {{ $index === 8 ? 'w-16' : '' }}
                    {{ $index === 9 ? 'w-10' : '' }}
                    {{ $index === 11 ? 'w-5' : '' }}
                    {{ $index === 12 ? 'w-5' : '' }}
                    {{ $index === 13 ? 'w-5' : '' }}
                    {{ $index === 14 ? 'w-5' : '' }}
                     ">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="leading-none">
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        @for ($j = 0; $j < 15; $j++)
                            <td class="border border-black p-[5px] whitespace-nowrap 
                            {{ $j === 0 ? 'w-32' : '' }}
                            {{ $j === 2 ? 'w-5' : '' }}
                            {{ $j === 5 ? 'w-5' : '' }}
                            {{ $j === 7 ? 'w-10' : '' }}
                            {{ $j === 9 ? 'w-10' : '' }}
                            {{ $j === 11 ? 'w-5' : '' }}
                             ">&nbsp;</td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
            
          </table>
      </div>
        @php
            $campos = [
                'COCINERO:',
                'TURNO:',
                'OLLAS:',
                'VOL. INICIAL:',
                'ALMIDÓN:',
                'RESINA:',
                'VOL. FINAL:',
                'FÓRMULA:',
                '% SÓLIDOS:',
                'PRODUCCIÓN:',
            ];
        @endphp

        <table class="w-full table-fixed border-collapse border border-black impresion-UE-2">
            <tbody>
                @foreach ($campos as $campo)
                    <tr>
                        <td class="border border-black whitespace-nowrap font-bold">{{ $campo }}</td>
                        @for ($i = 0; $i < 7; $i++)
                            <td class="border border-black whitespace-nowrap"></td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class=" grid grid-cols-6 gap-6 justify-between text-left">
            <div>
                <p><strong>NÚCLEO:</strong> {{ $orden->nucleo }}</p>
                <p><strong>NO. TELAS:</strong> {{ $orden->no_telas }}</p>
            </div>
            <div>
                <p><strong>ANCHO BALONAS:</strong> {{ $orden->balonas }}</p>
                <p><strong>METRAJE DE TELAS:</strong> {{ $orden->metros_tela }}</p>
            </div>
            <div>
                <p><strong>CUENDEADOS MÍNIMO:</strong>{{ $orden->cuendados_mini }}</p>
            </div>
            <div class="col-span-3">
                <p class="max-w-xl line-clamp-2">
                    <strong>OBSERVACIONES:</strong> Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quae aliquid vel dolores pariatur exercitationem, illum nihil ex excepturi debitis suscipit praesentium repellendus labore ea inventore recusandae atque voluptatem, quisquam repellat.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
