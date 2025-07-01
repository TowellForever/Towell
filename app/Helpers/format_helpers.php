<?php
// This helper will delete .0 y limita decimales a solo 2
if (!function_exists('decimales')) {
    function decimales($valor)
    {
        if (is_numeric($valor)) {
            return rtrim(rtrim(number_format($valor, 2, '.', ''), '0'), '.');
        }
        return $valor;
    }
}
