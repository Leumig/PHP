<?php
    // Aplicación 2 (Mostrar fecha y estación)
    // Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con distintos formatos (seleccione los formatos que más le guste).
    // Además, indicar qué estación del año es. Utilizar una estructura selectiva múltiple.

    $fecha = date("d/m/Y");
    echo "$fecha<br/>";

    $fecha = date("D/M/Y");
    echo "$fecha<br/>";

    $fecha = date("l/F/Y");
    echo "$fecha<br/>";

    $estacion = "";

    switch (date("n")) {
        case 3:
        case 4:
        case 5:
            $estacion = "Primavera";
            break;
        case 6:
        case 7:
        case 8:
            $estacion = "Verano";
            break;
        case 1:
        case 2:
        case 12:
            $estacion = "Invierno";
            break;
        default:
            $estacion = "Otoño";
    }

    echo "La estación es: " . $estacion;
?>