<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportesController extends Controller
{
  //CONTROLADOR para todo lo relacionado con REPORTES c:

  public function consumo()
  {
    $semanas = ['Semana 6.', 'Semana 7.', 'Semana 8.', 'Semana 9.', 'Semana 10.'];

    // Helper para totales
    $sumTot = function (array $data) use ($semanas) {
      $t = array_fill(0, count($semanas), 0);
      foreach ($data as $filas) {
        foreach ($filas as $fila) {
          foreach ($fila['w'] as $i => $v) {
            $t[$i] += $v;
          }
        }
      }
      return $t;
    };

    // ====== 1) CONSUMO TRAMA (mock) ======
    $tramaData = [
      '12' => [
        ['color' => 'ALGODÓN', 'w' => [589, 0, 0, 0, 0]],
        ['color' => 'ALGODÓN', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'ANILLO',  'w' => [336, 0, 0, 0, 0]],
        ['color' => 'ALGODON', 'w' => [0, 0, 0, 0, 0]],
      ],
      '10' => [
        ['color' => 'ALGODON',          'w' => [351, 203, 0, 0, 0]],
        ['color' => 'ALGODÓN',          'w' => [266, 211, 40, 0, 0]],
        ['color' => 'ALGODÓN',          'w' => [569, 0, 0, 0, 0]],
        ['color' => 'POLIESTER-ALGODÓN', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'ALGODON',          'w' => [572, 34, 0, 0, 0]],
        ['color' => 'ALGODÓN CRUDO',    'w' => [0, 0, 0, 0, 0]],
        ['color' => 'TERMO',            'w' => [0, 0, 0, 0, 0]],
      ],
      '8'  => [
        ['color' => 'ALGODÓN', 'w' => [236, 0, 0, 0, 0]],
        ['color' => 'ALODON',  'w' => [0, 0, 0, 0, 0]],
      ],
      '9'  => [
        ['color' => 'FILAMENTO BLANCO COMPACTADO', 'w' => [206, 0, 0, 0, 0]],
      ],
    ];
    $tramaTotales = $sumTot($tramaData);

    // ====== 2) CONSUMO COMBINACIÓN 1 ======
    $comb1Data = [
      '8'  => [['color' => 'TERMO', 'w' => [0, 0, 0, 0, 0]]],
      '12' => [
        ['color' => 'AZUL', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'MARRON', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'CORAL', 'w' => [30, 0, 0, 0, 0]],
        ['color' => 'VERDE BOTELLA', 'w' => [8, 31, 6, 6, 0]],
        ['color' => 'MARRÓN', 'w' => [26, 0, 0, 0, 0]],
        ['color' => 'POL LILA 828', 'w' => [14, 32, 0, 0, 0]],
        ['color' => 'POL PETROLEO', 'w' => [5, 0, 0, 0, 0]],
        ['color' => 'POLIESTER BLANCO', 'w' => [6, 0, 0, 0, 0]],
      ],
      '3' => [['color' => 'TERMO', 'w' => [0, 0, 0, 0, 0]]],
      '10' => [['color' => 'TERMO', 'w' => [90, 3, 0, 0, 0]]],
      '8.86' => [['color' => 'RAYON', 'w' => [5, 0, 0, 0, 0]]],
    ];
    $comb1Totales = $sumTot($comb1Data);

    // ====== 3) CONSUMO COMBINACIÓN 2 ======
    $comb2Data = [
      '3' => [
        ['color' => 'POL. PETROLEO', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'POL. ROSA 1765', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'POLIESTER ROJO', 'w' => [0, 0, 0, 0, 0]],
      ],
      '11.81' => [
        ['color' => 'FIL TURQUESA', 'w' => [11, 0, 0, 0, 0]],
        ['color' => 'FIL VAINILLA 464', 'w' => [11, 0, 0, 0, 0]],
      ],
      '12' => [
        ['color' => 'VERDE', 'w' => [30, 0, 0, 0, 0]],
        ['color' => 'GRIS CLARO', 'w' => [26, 0, 0, 0, 0]],
        ['color' => 'BEIGE 3694', 'w' => [8, 31, 6, 0, 0]],
        ['color' => 'POL. MORADO C 2086', 'w' => [14, 32, 0, 0, 0]],
      ],
      '8.86' => [
        ['color' => 'FIL CIELO 410', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'FIL LILA 3210', 'w' => [14, 0, 0, 0, 0]],
        ['color' => 'RAYON', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'FIL. DORADO BRILLOSO', 'w' => [0, 0, 0, 0, 0]],
      ],
      '10' => [
        ['color' => 'TERMO', 'w' => [60, 0, 0, 0, 0]],
        ['color' => 'TORZAL', 'w' => [106, 0, 0, 0, 0]],
      ],
      '3.5' => [
        ['color' => 'ALGODÓN', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'OPEN', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'ANILLO', 'w' => [0, 0, 0, 0, 0]],
      ],
    ];
    $comb2Totales = $sumTot($comb2Data);

    // ====== 4) CONSUMO COMBINACIÓN 3 ======
    $comb3Data = [
      '8.86' => [
        ['color' => 'RAYON', 'w' => [15, 0, 0, 0, 0]],
        ['color' => 'FIL VAINILLA 464', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'FIL ROSA 1765', 'w' => [9, 0, 0, 0, 0]],
        ['color' => 'FIL. RIGIDO BRILLOSO', 'w' => [0, 0, 0, 0, 0]],
      ],
    ];
    $comb3Totales = $sumTot($comb3Data);

    // ====== 5) CONSUMO COMBINACIÓN 4 ======
    $comb4Data = []; // vacía
    $comb4Totales = $sumTot($comb4Data);

    // ====== 6) CONSUMO PIE ======
    $pieData = [
      '10' => [
        ['color' => '0',                    'w' => [3358, 532, 46, 0, 0]],
        ['color' => 'OPEN 50-50/POL.-ALG.', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'OPEN',                 'w' => [0, 0, 0, 0, 0]],
      ],
      '12' => [
        ['color' => '0',      'w' => [467, 0, 0, 0, 0]],
        ['color' => 'ANILLO', 'w' => [396, 0, 0, 0, 0]],
      ],
    ];
    $pieTotales = $sumTot($pieData);

    // ====== 7) CONSUMO RIZO ======
    // Primer col sin título (igual que Excel)
    $rizoData = [
      ' ' => [
        ['color' => 'A12',                   'w' => [0, 0, 0, 0, 0]],
        ['color' => 'H',                     'w' => [5260, 144, 0, 0, 0]],
        ['color' => 'Fórmula1',              'w' => [0, 0, 0, 0, 0]],
        ['color' => 'Fil600 (virgen)/A12',   'w' => [0, 0, 0, 0, 0]],
        ['color' => 'A20',                   'w' => [0, 0, 0, 0, 0]],
        ['color' => 'Hprpe',                 'w' => [2079, 1837, 175, 0, 0]],
        ['color' => 'HR',                    'w' => [140, 0, 0, 0, 0]],
        ['color' => 'Fil (reciclado-secual)', 'w' => [0, 0, 0, 0, 0]],
        ['color' => 'O16',                   'w' => [2861, 0, 0, 0, 0]],
        ['color' => 'Fil 370 (secual)/A12',  'w' => [0, 0, 0, 0, 0]],
      ],
    ];
    $rizoTotales = $sumTot($rizoData);

    //GRAFICO de KG RIZO |-|-|-|-|-|-|-|-|-|-|-|-|-|-|-||-|-|-|-|-|-|-|-|-|-|-|-|-|-|-||-|-|-|-|-|-|-|-|-|-|-|-|-|-|-||-|-|-|-|-|-|-|-|-|-|-|-|-|-|-|
    // Semanas (etiquetas del eje X)
    $labels = [
      '30/jun–06/jul',
      '07/jul–13/jul',
      '14/jul–20/jul',
      '21/jul–27/jul',
      '28/jul–03/ago',
      '04/ago–10/ago',
      '11/ago–17/ago',
      '18/ago–24/ago',
      '25/ago–31/ago',
      '01/sep–07/sep'
    ];

    // Series (datos quemados). Cada arreglo debe tener el mismo length que $labels
    $series = [
      'O16'                    => [5915, 5238, 4095, 3954, 4857, 2861,   0,   0,   0,   0],
      'Fil 370 (secual)/A12'   => [800, 700, 600, 500, 400, 300,   0,   0,   0,   0],
      'Fil (reciclado-secual)' => [600, 500, 400, 300, 200, 100,   0,   0,   0,   0],
      'HR'                     => [0,   0,   0, 600, 300,   0,   0,   0,   0,   0],
      'Fil600 (virgen)/A12'    => [1859, 1962, 1394,   0,   0,   0,   0,   0,   0,   0],
      'A20'                    => [3781, 3542, 5888, 2786, 740,   0,   0,   0,   0,   0],
      'H'                      => [9437, 7307, 7508, 9669, 8530, 5260,   0,   0, 144,   0],
      'A12'                    => [9091, 3386, 8821, 2974, 236,   0,   0,   0,   0,   0],
    ];

    // Totales por semana para la línea
    $totales = [];
    for ($i = 0; $i < count($labels); $i++) {
      $suma = 0;
      foreach ($series as $vals) $suma += $vals[$i] ?? 0;
      $totales[] = $suma;
    }



    return view('TEJIDO-SCHEDULING.reportes.consumo', compact(
      'semanas',
      'tramaData',
      'tramaTotales',
      'comb1Data',
      'comb1Totales',
      'comb2Data',
      'comb2Totales',
      'comb3Data',
      'comb3Totales',
      'comb4Data',
      'comb4Totales',
      'pieData',
      'pieTotales',
      'rizoData',
      'rizoTotales',
      'labels', //grafico KGRIZO
      'series', //grafico KGRIZO
      'totales' //grafico KGRIZO
    ));
  }
}
