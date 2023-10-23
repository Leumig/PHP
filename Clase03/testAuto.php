<?php
    // Esto corresponde a 'ejercicio19.php' de la Clase03
    // Crear un método de clase para poder hacer el alta de un Auto, guardando los datos en un archivo autos.csv.
    // Hacer los métodos necesarios en la clase Auto para poder leer el listado desde el archivo autos.csv
    // Se deben cargar los datos en un array de autos.

    include "Auto.php";

    $autoUno = new Auto("Lamborghini", "Azul");
    $autoDos = new Auto("BMW", "Rojo");
    $autoTres = new Auto("Fiat", "Gris", 725000);
    $autoCuatro = new Auto("Fiat", "Verde", 400000);
    $autoCinco = new Auto("Ford", "Azul", 780500, new DateTime("1990-06-10"));
    $autoSeis = new Auto("Ford", "Blanco", 905000, new DateTime("2006-12-04"));
    $autoSiete = new Auto("Chevrolet", "Amarillo", 1900250, new DateTime("2015-01-11"));
    
    $listaDeAutos = array($autoUno, $autoDos, $autoTres, $autoCuatro, $autoCinco, $autoSeis, $autoSiete);

    /*foreach ($listaDeAutos as $auto) {
        Auto::Alta($auto);
    }*/
    //Descomentar el foreach para hacer la escritura de autos en el archivo (ya está hecha)

    $listaDeAutosCargada = Auto::CargarLista("C:/xampp/htdocs/Clase03/autos.csv");

    foreach ($listaDeAutosCargada as $auto) {
        Auto::MostrarAuto($auto);
    }
?>