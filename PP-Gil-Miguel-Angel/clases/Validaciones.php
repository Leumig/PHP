<?php
function validarString($cadena, $min = 1, $max = 16, $conNumeros = false, $esEmail = false) {
    $validacion = false;

    if (is_string($cadena)) {
        $cadena = trim($cadena);

        if (strlen($cadena) >= $min && strlen($cadena) <= $max) {
            if (!$conNumeros && preg_match('/^[a-zA-Z]+$/', $cadena)) {
                $validacion = true;
            } elseif ($conNumeros && preg_match('/^[a-zA-Z0-9]+$/', $cadena)) {
                $validacion = true;
            }

            if (!$validacion && $esEmail) {
                $validacion = filter_var($cadena, FILTER_VALIDATE_EMAIL) !== false;
            }
        }
    }

    return $validacion;
}

function validarEntero($valor, $min = 0, $max = 999999) {
    $valor = (int)$valor;
    return is_int($valor) && $valor >= $min && $valor <= $max;
}

function validarFecha($fecha) {
    try {
        $dateTime = new DateTime($fecha);
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>