<?php
    /***********************************************************************************************************
    Aplicación 14 (Potencias de números)
    Mostrar por pantalla las primeras 4 potencias de los números del uno 1 al 4 (hacer una función que
    las calcule invocando la función pow).
    ***********************************************************************************************************/

    function CalcularPotencia($numero, $potencia){
        return pow($numero, $potencia);
    }

    for ($numeroActual = 1; $numeroActual < 5; $numeroActual++) { 
        echo "Primeras 4 potencias del número: " . $numeroActual . "</br>";

        for ($potenciaActual = 1; $potenciaActual < 5; $potenciaActual++) { 
            $potencia = CalcularPotencia($numeroActual, $potenciaActual);
            echo $potencia . "</br>";
        }

        echo "</br>";
    }
?>