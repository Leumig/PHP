<?php
    // Aplicación 10 (Arrays de Arrays)
    // Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
    // contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
    // Arrays de Arrays.

    $lapiceraUno = array("Color"=>"Rojo", "Marca"=>"Bic", "Trazo"=>"Grueso", "Precio"=>120);
    $lapiceraDos = array("Color"=>"Azul", "Marca"=>"Faber-Castell", "Trazo"=>"Medio", "Precio"=>100);
    $lapiceraTres = array("Color"=>"Negro", "Marca"=>"Filgo", "Trazo"=>"Fino", "Precio"=>140);

    // Array asociativo
    $lapiceroUno = array(
    "Primer Lapicera"=>$lapiceraUno,
    "Segunda Lapicera"=>$lapiceraDos,
    "Tercer Lapicera"=>$lapiceraTres);

    // Array indexado
    $lapiceroDos = array($lapiceraUno, $lapiceraDos, $lapiceraTres);

    echo "Lapicero 1 (array asociativo)<br/>";

    foreach ($lapiceroUno as $keyLapicero => $valueLapicero) {
        echo "</br>" . $keyLapicero . "</br>";

        foreach ($valueLapicero as $key => $value) {
            echo $key . ": " . $value . "</br>";
        }
    }

    echo "<br/><br/>Lapicero 2 (array indexado)<br/>";
    $indiceActual = 1;

    foreach ($lapiceroDos as $keyLapicero => $valueLapicero) {
        echo "</br>Lapicera " . $indiceActual . "</br>";

        foreach ($valueLapicero as $key => $value) {
            echo $key . ": " . $value . "</br>";
        }

        $indiceActual++;
    }
   
    // Otra forma
    /*for ($i = 0; $i < count($lapiceroDos) ; $i++) {
        $indiceActual = $i + 1;
        echo "</br>Lapicera " . $indiceActual . "</br>";

        foreach ($lapiceroDos[$i] as $key => $value) {
            echo $key . ": " . $value . "</br>";
        }
    }*/
?>