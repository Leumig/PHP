<?php
    // Aplicación 1 (Sumar números)
    // Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no supere a 1000.
    // Mostrar los números sumados y al finalizar el proceso, indicar cuántos números se sumaron.

    $numeroActual = 1;
    $contador = -1; //Lo pongo en -1 para que no contabilice la última suma, la cual va a superar 1000
    $acumulador = 1;

    while($acumulador <= 1000)
    {
        echo "$acumulador <br/>";

        $acumulador += $numeroActual;

        $numeroActual++;
        $contador++; 
    }

    // echo "En total se sumaron: " . $contador . " números";
    echo "En total se sumaron: $contador números";
?>