<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('formatar_data_brasileira')) {
    function formatar_data_brasileira($data)
    {
        if (empty($data) || $data === '0000-00-00') {
            return '';
        }

        $data_formatada = DateTime::createFromFormat('Y-m-d', $data);

        return $data_formatada ? $data_formatada->format('d-m-Y') : $data;
    }
}

if (!function_exists('formatar_valor_brasileiro')) {
    function formatar_valor_brasileiro($valor)
    {
        if ($valor === null || $valor === '') {
            return '';
        }

        return 'R$ ' . number_format((float) $valor, 2, ',', '.');
    }
}
