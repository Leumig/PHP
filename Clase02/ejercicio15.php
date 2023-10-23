<?php
    /***********************************************************************************************************
    Aplicación 15 (Par e impar)
    Crear una función llamada EsPar que reciba un valor entero como parámetro y devuelva TRUE si
    este número es par ó FALSE si es impar.
    Reutilizando el código anterior, crear la función EsImpar.
    ***********************************************************************************************************/

    function EsPar($numero){
        return $numero % 2 == 0;
    }

    function EsImpar($numero){
        return !($numero % 2 == 0);
    }

    $resultadoUno = EsPar(4)? "TRUE" : "FALSE";
    $resultadoDos = EsPar(7)? "TRUE" : "FALSE";
    $resultadoTres = EsImpar(5)? "TRUE" : "FALSE";
    $resultadoCuatro = EsImpar(10)? "TRUE" : "FALSE";

    echo $resultadoUno . "</br>";
    echo $resultadoDos . "</br>";
    echo $resultadoTres . "</br>";
    echo $resultadoCuatro . "</br>";
?>