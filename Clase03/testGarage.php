<?php
    // Esto corresponde a 'ejercicio20.php' de la Clase03
    // Crear un método de clase para poder hacer el alta de un Garage y, guardando los datos en un archivo
    // garages.csv.
    // Hacer los métodos necesarios en la clase Garage para poder leer el listado desde el archivo
    // garage.csv
    // Se deben cargar los datos en un array de garage.
    // En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los
    // métodos.

    include "Garage.php";

    $listaDeAutos = Auto::CargarLista("C:/xampp/htdocs/Clase03/autos.csv");

    $garageUno = new Garage("Garage Pepito");
    $garageDos = new Garage("Garage Juanito");
    $garageTres = new Garage("Garage Miguelito", 500);
    $garageCuatro = new Garage("Garage Carlito", 1200);
    $garageCinco = new Garage("Garage Maurito", 850);

    $garageUno->Add($listaDeAutos[0]);
    $garageUno->Add($listaDeAutos[1]);
    $garageUno->Add($listaDeAutos[3]);

    // Garage::Alta($garageUno);   // Descomentar para hacer la escritura del archivo (ya esta hecha)

    $garageTres->Add($listaDeAutos[4]);
    $garageTres->Add($listaDeAutos[5]);
    $garageTres->Add($listaDeAutos[6]);

    // Garage::Alta($garageTres);  // Descomentar para hacer la escritura del archivo (ya esta hecha)

     $garageCuatro->Add($listaDeAutos[0]);
     $garageCuatro->Add($listaDeAutos[2]);
     $garageCuatro->Add($listaDeAutos[4]);
     $garageCuatro->Add($listaDeAutos[6]);
 
    // Garage::Alta($garageCuatro);  // Descomentar para hacer la escritura del archivo (ya esta hecha)

    $garageCinco->Add($listaDeAutos[2]);

    // Garage::Alta($garageCinco);  // Descomentar para hacer la escritura del archivo (ya esta hecha)

    $listaDeGaragesCargada = Garage::CargarLista("C:/xampp/htdocs/Clase03/garages.csv");

    foreach ($listaDeGaragesCargada as $garage) {
        $garage->MostrarGarage();
    }
?>