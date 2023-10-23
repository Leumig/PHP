<?php
    // Aplicación 6 (Carga aleatoria)
    // Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
    // función rand). Mediante una estructura condicional, determinar si el promedio de los números
    // son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
    // resultado.

    $numeros = array(rand(1, 10), rand(1, 10), rand(1, 10), rand(1, 10), rand(1, 10));

    $sumaTotalNumeros = array_sum($numeros);
    $promedio = $sumaTotalNumeros / count($numeros);

    foreach ($numeros as $key => $value) {
        echo $numeros[$key] . "</br>";
    }
   
    if ($promedio > 6)
    {
        echo "El promedio es mayor a 6 ($promedio)";
    }else if ($promedio < 6)
    {
        echo "El promedio es menor a 6 ($promedio)";
    }else {
        echo "El promedio es igual a 6";
    }
?>