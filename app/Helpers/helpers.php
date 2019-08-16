<?php

if (!function_exists('_count')) {
    function _count($value)
    {
        if (is_array($value)) {
            return count((array)$value);
        } elseif (is_object($value)) {
            return sizeof($value);
        } else {
            return 0;
        }
    }
}

if (!function_exists('str_numbers')) {
    function str_numbers($value)
    {
        return preg_replace("/[^0-9]/", "", $value);
    }
}

if (!function_exists('lojas')) {
    function lojas()
    {
        return collect(['sp' => 'Santana Presentes', 'ja' => 'Joalharia Adna']);
    }
}

if (!function_exists('the_mask')) {

    function the_mask($value, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#' || $mask[$i] == '*') {
                if (isset($value[$k]))
                    $maskared .= $value[$k++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}

if (!function_exists('mask_cpf_or_cnpj')) {
    function mask_cpf_or_cnpj($value)
    {
        $value = str_numbers($value);
        if (strlen($value) == 11) {
            return the_mask($value, "###.###.###-##");
        } else {
            return the_mask($value, "##.###.###/####-##");
        }
    }
}

if (!function_exists('criptografia_cpf')) {

    function criptografia_cpf($value)
    {
        $cpf = substr_replace($value, '***', 0, 3);
        $cpf = substr_replace($cpf, '**', -2, 2);
        $cpf = substr_replace($cpf, '**', -5, 2);
        return $cpf;
    }
}

if (!function_exists('moeda')) {
    function moeda($get_valor)
    {
        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor);
        return (float)$valor;
    }
}

if (!function_exists('moeda_real')) {
    function moeda_real($valor)
    {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }
}

if (!function_exists('data_brasil')) {
    function data_brasil($data)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $data)->format('d/m/Y');
    }
}

if (!function_exists('data_brasil_hora')) {
    function data_brasil_hora($data)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data)->format('d/m/Y');
    }
}

if (!function_exists('data_brasil_hora_minutos')) {
    function data_brasil_hora_minutos($data)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data)->format('d/m/Y H:i');
    }
}

if (!function_exists('data_hora')) {
    function data_hora($datahora)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i', $datahora);
    }
}

if (!function_exists('hora')) {
    function hora($hora)
    {
        return \Carbon\Carbon::createFromFormat('H:i:s', $hora);
    }
}

if (!function_exists('data_brasil_americana')) {
    function data_brasil_americana($data)
    {
        if (empty($data)) {
            return null;
        }
        return valida_data($data);
    }
}

if (!function_exists('valida_data')) {
    function valida_data($data)
    {
        if (!empty($data)) {
            $data_americana = explode('-', $data);
            if (count($data_americana) >= 3) {
                list($ano, $mes, $dia) = $data_americana;
            } else {
                list($dia, $mes, $ano) = explode('/', $data);
            }
            $res = checkdate($mes, $dia, $ano);
            if ($res) {
                return \Carbon\Carbon::create($ano, $mes, $dia)->format('Y-m-d');
            }
            return null;
        }
        return null;
    }
}

if (!function_exists('verifica_rota')) {
    function verifica_rota()
    {
        $rota = \Route::current()->uri();
        $rotas = ['login', 'admin', 'home'];

        if (in_array($rota, $rotas)) {
            return false;
        }
        return true;
    }
}

if (!function_exists('lista_meses')) {
    function lista_meses($mes = null)
    {
        $meses = collect([
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ]);
        if ($mes) return $meses[$mes];
        return $meses;
    }
}

if (!function_exists('collect_months')) {
    function collect_months()
    {
        return collect([
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ]);
    }
}

if (!function_exists('estados_brasileiros')) {
    function estados_brasileiros()
    {
        return collect([
            'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará',
            'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
            'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul',
            'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'
        ]);
    }
}

if (!function_exists('fpdf_utf8')) {
    function fpdf_utf8($value)
    {
        return iconv(mb_detect_encoding($value), 'windows-1252//IGNORE', $value);
    }
}

if (!function_exists('fpdf_utf8_uppercase')) {
    function fpdf_utf8_uppercase($value)
    {
        return iconv(mb_detect_encoding($value), 'windows-1252//IGNORE', mb_strtoupper($value));
    }
}
