<?php
    /***********************************************************************************************************
    Aplicación 12 (Invertir palabra)
    Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden
    de las letras del Array.
    Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.
    ***********************************************************************************************************/

    function InvertirCadena($cadena){
        /*$tamañoCadena = strlen($cadena) - 1;
    
        foreach ((array) $cadena as $arrayCaracteres) {
            for ($i = $tamañoCadena; $i >= 0; $i--) { 
                echo $arrayCaracteres[$i];
            }
        }*/

        $cadenaInvertida = array_reverse(str_split($cadena));
        foreach ($cadenaInvertida as $caracter) {
            echo $caracter;
        }
    }

    InvertirCadena("HOLA");
?>