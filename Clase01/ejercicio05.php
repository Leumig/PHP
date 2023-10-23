<?php
    // Aplicación 5 (Números en letras)
    // Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
    // por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
    // entre el 20 y el 60.
    // Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.

    $num = 43;
    $numEnLetras = "";

    $unidad = array(1=>"uno", 2=>"dos", 3=>"tres", 4=>"cuatro", 5=>"cinco", 6=>"seis", 7=>"siete", 8=>"ocho", 9=>"nueve");

    $decena = array("", "diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta");

    if ($num >= 20 && $num <= 60)
    {
        if ($num >= 21 && $num <= 29)
        {       
            $numEnLetras  = "veinti" . $unidad[$num - 20];
        }else if ($num % 10 == 0)
        {
            $numEnLetras = $decena[$num / 10];
        }else
        {
            $numEnLetras = $decena[(int) $num / 10] . " y " . $unidad[$num % 10];
        }
    
        echo $numEnLetras;
    }
?>