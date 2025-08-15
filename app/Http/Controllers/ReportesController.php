<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
  //CONTROLADOR para todo lo relacionado con REPORTES c:

  public function consumo(Request $request)
  {
    // ====== 1) Leer rango de fechas (GET) y normalizar a semanas ======
    $inicioStr = $request->query('inicio');
    $finStr    = $request->query('fin');

    // Defaults: últimas 6 semanas terminando esta semana
    $hoy = Carbon::now();
    $inicio = $inicioStr ? Carbon::parse($inicioStr) : $hoy->copy()->subWeeks(5);
    $fin    = $finStr    ? Carbon::parse($finStr)    : $hoy->copy();

    if ($inicio->gt($fin)) {
      [$inicio, $fin] = [$fin, $inicio];
    }

    // Alinear a semanas (Lun–Dom)
    $inicio = $inicio->copy()->startOfWeek(Carbon::MONDAY);
    $fin    = $fin->copy()->endOfWeek(Carbon::SUNDAY);

    // Construir semanas y etiquetas por rango (dd/M–dd/M)
    $semanasFechas = [];
    $etiquetasX    = [];
    $cursor = $inicio->copy();
    while ($cursor->lte($fin)) {
      $iniW = $cursor->copy();
      $finW = $cursor->copy()->endOfWeek(Carbon::SUNDAY);
      $semanasFechas[] = [$iniW, $finW];
      $etiquetasX[] = $iniW->format('d/M') . '–' . $finW->format('d/M');
      $cursor->addWeek()->startOfWeek(Carbon::MONDAY);
    }
    $weekCount = count($semanasFechas);
    $semanas = array_map(fn($i) => "Semana " . ($i + 1) . ".", range(0, $weekCount - 1));

    // ====== 2) Helpers para datos mock ======
    $gen = function (int $n, string $seed, float $density = 0.33, int $min = 20, int $max = 6000) {
      // Genera n valores; ~density con valor, el resto 0 (determinista por seed+semana)
      $out = [];
      for ($i = 0; $i < $n; $i++) {
        $h = crc32($seed . '|' . $i);
        $hit = ($h % 1000) / 1000.0 < $density;
        $val = $hit ? ($min + ($h % ($max - $min + 1))) : 0;
        $out[] = $val;
      }
      return $out;
    };

    $sumTot = function (array $data, int $n) {
      $t = array_fill(0, $n, 0);
      foreach ($data as $filas) {
        foreach ($filas as $fila) {
          for ($i = 0; $i < $n; $i++) {
            $t[$i] += $fila['w'][$i] ?? 0;
          }
        }
      }
      return $t;
    };

    // ====== 3) Tablas (datos quemados pero del tamaño de $weekCount) ======

    // 1) CONSUMO TRAMA
    $tramaData = [
      '12' => [
        ['color' => 'ALGODÓN', 'w' => $gen($weekCount, 'trama-12-algodon', 0.45, 50, 800)],
        ['color' => 'ANILLO',  'w' => $gen($weekCount, 'trama-12-anillo',  0.25, 40, 600)],
      ],
      '10' => [
        ['color' => 'ALGODÓN',           'w' => $gen($weekCount, 'trama-10-algodon-a', 0.35, 60, 900)],
        ['color' => 'POLIESTER-ALGODÓN', 'w' => $gen($weekCount, 'trama-10-polialg',  0.20, 50, 500)],
        ['color' => 'ALGODÓN CRUDO',     'w' => $gen($weekCount, 'trama-10-crudo',    0.18, 30, 400)],
      ],
      '8' => [
        ['color' => 'ALGODÓN', 'w' => $gen($weekCount, 'trama-8-algodon', 0.30, 40, 500)],
      ],
      '9' => [
        ['color' => 'FILAMENTO BLANCO COMPACTADO', 'w' => $gen($weekCount, 'trama-9-filblanco', 0.28, 50, 700)],
      ],
    ];
    $tramaTotales = $sumTot($tramaData, $weekCount);

    // 2) CONSUMO COMBINACIÓN 1
    $comb1Data = [
      '8'  => [['color' => 'TERMO', 'w' => $gen($weekCount, 'comb1-8-termo', 0.15, 20, 200)]],
      '12' => [
        ['color' => 'AZUL',            'w' => $gen($weekCount, 'comb1-12-azul',    0.22, 20, 220)],
        ['color' => 'CORAL',           'w' => $gen($weekCount, 'comb1-12-coral',   0.22, 20, 220)],
        ['color' => 'VERDE BOTELLA',   'w' => $gen($weekCount, 'comb1-12-vbot',    0.35, 30, 260)],
        ['color' => 'POL LILA 828',    'w' => $gen($weekCount, 'comb1-12-lila',    0.25, 20, 240)],
        ['color' => 'POL PETROLEO',    'w' => $gen($weekCount, 'comb1-12-pet',     0.18, 20, 180)],
        ['color' => 'POLIESTER BLANCO', 'w' => $gen($weekCount, 'comb1-12-blanco',  0.25, 20, 220)],
      ],
      '10' => [['color' => 'TERMO', 'w' => $gen($weekCount, 'comb1-10-termo', 0.22, 60, 180)]],
      '8.86' => [['color' => 'RAYON', 'w' => $gen($weekCount, 'comb1-886-rayon', 0.20, 30, 160)]],
    ];
    $comb1Totales = $sumTot($comb1Data, $weekCount);

    // 3) CONSUMO COMBINACIÓN 2
    $comb2Data = [
      '3' => [
        ['color' => 'POL. PETROLEO', 'w' => $gen($weekCount, 'comb2-3-pet', 0.20, 20, 160)],
        ['color' => 'POL. ROSA 1765', 'w' => $gen($weekCount, 'comb2-3-rosa', 0.20, 20, 160)],
      ],
      '11.81' => [
        ['color' => 'FIL TURQUESA',      'w' => $gen($weekCount, 'comb2-1181-tur', 0.30, 40, 220)],
        ['color' => 'FIL VAINILLA 464',  'w' => $gen($weekCount, 'comb2-1181-vai', 0.30, 40, 220)],
      ],
      '12' => [
        ['color' => 'VERDE',             'w' => $gen($weekCount, 'comb2-12-verde', 0.30, 40, 260)],
        ['color' => 'GRIS CLARO',        'w' => $gen($weekCount, 'comb2-12-gris',  0.30, 40, 240)],
        ['color' => 'BEIGE 3694',        'w' => $gen($weekCount, 'comb2-12-beige', 0.25, 30, 220)],
        ['color' => 'POL. MORADO C 2086', 'w' => $gen($weekCount, 'comb2-12-mora',  0.25, 30, 220)],
      ],
      '10' => [
        ['color' => 'TERMO',  'w' => $gen($weekCount, 'comb2-10-termo', 0.28, 60, 260)],
        ['color' => 'TORZAL', 'w' => $gen($weekCount, 'comb2-10-torz',  0.28, 60, 260)],
      ],
    ];
    $comb2Totales = $sumTot($comb2Data, $weekCount);

    // 4) CONSUMO COMBINACIÓN 3
    $comb3Data = [
      '8.86' => [
        ['color' => 'RAYON',             'w' => $gen($weekCount, 'comb3-886-ray',  0.35, 40, 240)],
        ['color' => 'FIL VAINILLA 464',  'w' => $gen($weekCount, 'comb3-886-vai',  0.20, 30, 200)],
        ['color' => 'FIL ROSA 1765',     'w' => $gen($weekCount, 'comb3-886-rosa', 0.22, 30, 200)],
      ],
    ];
    $comb3Totales = $sumTot($comb3Data, $weekCount);

    // 5) CONSUMO COMBINACIÓN 4 (vacía)
    $comb4Data = [];
    $comb4Totales = $sumTot($comb4Data, $weekCount);

    // 6) CONSUMO PIE
    $pieData = [
      '10' => [
        ['color' => '0',                     'w' => $gen($weekCount, 'pie-10-0',    0.75,  40, 6000)],
        ['color' => 'OPEN 50-50/POL.-ALG.', 'w' => $gen($weekCount, 'pie-10-open', 0.15,  20, 400)],
      ],
      '12' => [
        ['color' => '0',      'w' => $gen($weekCount, 'pie-12-0',      0.50,  40, 1200)],
        ['color' => 'ANILLO', 'w' => $gen($weekCount, 'pie-12-anillo', 0.30,  40, 900)],
      ],
    ];
    $pieTotales = $sumTot($pieData, $weekCount);

    // 7) CONSUMO RIZO
    $rizoData = [
      ' ' => [
        ['color' => 'A12',                   'w' => $gen($weekCount, 'rizo-a12',  0.35, 40, 1600)],
        ['color' => 'H',                     'w' => $gen($weekCount, 'rizo-h',    0.60, 80, 9800)],
        ['color' => 'Fórmula1',              'w' => $gen($weekCount, 'rizo-f1',   0.15, 20, 300)],
        ['color' => 'Fil600 (virgen)/A12',   'w' => $gen($weekCount, 'rizo-filv', 0.40, 60, 2000)],
        ['color' => 'A20',                   'w' => $gen($weekCount, 'rizo-a20',  0.35, 40, 4000)],
        ['color' => 'Hprpe',                 'w' => $gen($weekCount, 'rizo-hpr',  0.50, 60, 3500)],
        ['color' => 'HR',                    'w' => $gen($weekCount, 'rizo-hr',   0.25, 40, 900)],
        ['color' => 'Fil (reciclado-secual)', 'w' => $gen($weekCount, 'rizo-filr', 0.20, 40, 800)],
        ['color' => 'O16',                   'w' => $gen($weekCount, 'rizo-o16',  0.60, 60, 6000)],
        ['color' => 'Fil 370 (secual)/A12',  'w' => $gen($weekCount, 'rizo-370',  0.40, 40, 1500)],
      ],
    ];
    $rizoTotales = $sumTot($rizoData, $weekCount);

    // ====== 4) Gráfico KG RIZO (mismas etiquetas $etiquetasX) ======
    $series = [
      'O16'                    => $gen($weekCount, 'serie-o16',  0.60,  80, 6000),
      'Fil 370 (secual)/A12'   => $gen($weekCount, 'serie-370',  0.40,  60, 1800),
      'Fil (reciclado-secual)' => $gen($weekCount, 'serie-filr', 0.30,  60, 1200),
      'HR'                     => $gen($weekCount, 'serie-hr',   0.25,  60, 1500),
      'Fil600 (virgen)/A12'    => $gen($weekCount, 'serie-filv', 0.45,  60, 2200),
      'A20'                    => $gen($weekCount, 'serie-a20',  0.45,  60, 4000),
      'H'                      => $gen($weekCount, 'serie-h',    0.55, 100, 9000),
      'A12'                    => $gen($weekCount, 'serie-a12',  0.45,  60, 4000),
    ];
    $totales = [];
    for ($i = 0; $i < $weekCount; $i++) {
      $s = 0;
      foreach ($series as $vals) {
        $s += $vals[$i] ?? 0;
      }
      $totales[] = $s;
    }

    // ====== 5) Render ======
    return view('TEJIDO-SCHEDULING.reportes.consumo', compact(
      // rango elegido
      'inicio',
      'fin',
      // semanas/labels dinámicos
      'semanas',
      'etiquetasX',
      // tablas
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
      // gráfico
      'series',
      'totales'
    ));
  }
}
