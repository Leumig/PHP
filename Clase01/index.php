<?php
    // La extensión debe ser .php
    // Todo tiene que estar entre las llaves de apertura y cierre: <?php  y ? >
    // Fuera de ese bloque no podemos hacer nada, el intérprete lo va a ignorar

    echo "Hola Mundo <br/>";

    // echo muestra un string por pantalla o por consola
    // <br/> hace un salto de línea (breakline) en la pantalla

    // Para hacer un salto de línea en la consola, hay que hacer el \n

    $nombre = "Miguel";
    $apellido = "Gil";
    // Las variables siempre empiezan con $. No hay que especificar tipo de dato. Y siempre hay que inicializarlas

    // Todo tiene que terminar con ;

    echo $nombre . "<br/>" . $apellido;
    // El operador '.' lo usamos para concatenar (como si fuera el '+')

    // echo $nombre , "<br/>", $apellido;
    // Esto muestra lo mismo que el anterior, pero es como si hiciera 3 'echo' distintos.
?>
