<?php
    // Aplicación 7 (Mostrar impares)
    // Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
    // Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
    // salto de línea en HTML es la etiqueta <br/>). Repetir la impresión de los números
    // utilizando las estructuras while y foreach.

    $numerosImpares = array();
    $numeroActual = 1;

    while (count($numerosImpares) < 10) {
        if ($numeroActual % 2 == 0)
        {
            array_push($numerosImpares, $numeroActual);
        }

        $numeroActual++;
    }

    for ($i = 0; $i < count($numerosImpares); $i++) { 
        echo $numerosImpares[$i] . "<br/>";
    }
?>