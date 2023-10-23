<?php
    /***********************************************************************************************************
    Aplicación 13 (Invertir palabra)
    Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La función
    validará que la cantidad de caracteres que tiene $palabra no supere a $max y además deberá
    determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
    “Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
    1 si la palabra pertenece a algún elemento del listado.
    0 en caso contrario.
    ***********************************************************************************************************/

    function ValidarPalabra($palabra, $max){
        if (!is_string($palabra) ||
            !is_int($max) ||
            strlen($palabra) > $max || 
            ($palabra != "Recuperatorio" && $palabra != "Parcial" && $palabra != "Programacion"))
        {
            return 0;
        }

        return 1;
    }

    $respuesta = ValidarPalabra("Parcial", 7);
    echo $respuesta . "</br>";

    $respuesta = ValidarPalabra("Recuperatorio", 7);
    echo $respuesta . "</br>";

    $respuesta = ValidarPalabra("Parcial", 6);
    echo $respuesta;
?>