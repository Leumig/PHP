<?php
    /*  Esto corresponde a 'ejercicio17.php' de la Clase02
        En testAuto.php:
        * Crear dos objetos “Auto” de la misma marca y distinto color.
        * Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
        * Crear un objeto “Auto” utilizando la sobrecarga restante.
        * Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500 al
        atributo precio.
        * Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el resultado
        obtenido.
        * Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o no.
        * Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3, 5)
    */

    include_once "Auto.php";

    // * Crear dos objetos “Auto” de la misma marca y distinto color.
    $autoUno = new Auto("Lamborghini", "Azul");
    $autoDos = new Auto("Lamborghini", "Rojo");

    // * Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
    $autoTres = new Auto("Fiat", "Gris", 725000);
    $autoCuatro = new Auto("Fiat", "Gris", 400000);

    // * Crear un objeto “Auto” utilizando la sobrecarga restante.
    $autoCinco = new Auto("Ford", "Negro", 580500, new DateTime("1990-06-10"));

    // * Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500 al atributo precio.
    $autoTres->AgregarImpuestos(1500);
    $autoCuatro->AgregarImpuestos(1500);
    $autoCinco->AgregarImpuestos(1500);

    // * Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el resultado obtenido.
    $importeDouble = Auto::Add($autoUno, $autoDos);
    echo $importeDouble . "</br>";

    // * Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o no.
    $resultado = $autoUno->Equals($autoDos);
    echo $resultado? "TRUE": "FALSE";
    echo "</br>";
    $resultado = $autoUno->Equals($autoCinco);
    echo $resultado? "TRUE": "FALSE";

    // * Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3, 5)
    Auto::MostrarAuto($autoUno);
    Auto::MostrarAuto($autoTres);
    Auto::MostrarAuto($autoCinco);
?>