<?php
    // Aplicación 9 (Arrays asociativos)
    // Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
    // contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
    // lapiceras.

    $lapicera1 = array("Color"=>"Rojo", "Marca"=>"Bic", "Trazo"=>"Grueso", "Precio"=>120);
    $lapicera2 = array("Color"=>"Azul", "Marca"=>"Faber-Castell", "Trazo"=>"Medio", "Precio"=>100);
    $lapicera3 = array("Color"=>"Negro", "Marca"=>"Filgo", "Trazo"=>"Fino", "Precio"=>140);

    echo "Lapicera 1</br>";
    foreach ($lapicera1 as $key => $value) {
        echo $key . ": " . $value . "</br>";
    }

    echo "Lapicera 2</br>";
    foreach ($lapicera2 as $key => $value) {
        echo $key . ": " . $value . "</br>";
    }

    echo "Lapicera 3</br>";
    foreach ($lapicera3 as $key => $value) {
        echo $key . ": " . $value . "</br>";
    }
?>