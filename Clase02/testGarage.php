<?php
    // Esto corresponde a 'ejercicio18.php' de la Clase02

    // include "Auto.php"; //No es necesario porque Garage.php ya lo incluye
    include_once "Garage.php";

    $autoUno = new Auto("Lamborghini", "Azul");
    $autoDos = new Auto("Lamborghini", "Rojo");
    $autoTres = new Auto("Chevrolet", "Amarillo", 725000);
    $autoCuatro = new Auto("Fiat", "Gris", 400000, new DateTime("2005-11-23"));
    $autoCinco = new Auto("Ford", "Negro", 580500, new DateTime("1990-06-18"));

    $garageUno = new Garage("Garage Pepito");
    $garageDos = new Garage("Garage Juanito");
    $garageTres = new Garage("Garage Miguelito", 500);
    $garageCuatro = new Garage("Garage Carlito", 1200);
    $garageCinco = new Garage("Garage Maurito", 850);

    $garageUno->MostrarGarage();
    $garageCuatro->MostrarGarage();

    $resultado = $garageUno->Equals($autoUno);
    echo $resultado? "TRUE": "FALSE";
    echo "</br>";

    $garageUno->Add($autoUno);

    $resultado = $garageUno->Equals($autoUno);
    echo $resultado? "TRUE": "FALSE";
    echo "</br>";

    $garageUno->MostrarGarage();

    $garageUno->Add($autoUno);

    $garageUno->Remove($autoDos);

    $resultado = $garageUno->Equals($autoUno);
    echo $resultado? "TRUE": "FALSE";
    echo "</br>";

    $garageUno->Remove($autoUno);

    $resultado = $garageUno->Equals($autoUno);
    echo $resultado? "TRUE": "FALSE";
    echo "</br>";

    $garageCinco->Add($autoTres);
    $garageCinco->Add($autoCuatro);
    $garageCinco->Add($autoCinco);

    $garageCinco->MostrarGarage();

    $garageCinco->Add($autoTres);

    $garageCinco->Remove($autoCuatro);

    $garageCinco->Remove($autoUno);

    $garageCinco->MostrarGarage();

    $garageTres->Add($autoUno);
    $garageTres->Add($autoDos);
    $garageTres->Add($autoTres);
    $garageTres->Add($autoCuatro);
    $garageTres->Add($autoCinco);
    
    $garageTres->MostrarGarage();

    $garageTres->Remove($autoUno);

    $garageTres->MostrarGarage();
?>