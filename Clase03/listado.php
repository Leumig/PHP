<?php
    // var_dump($_GET);
    // var_dump($_SERVER);
    if ($_SERVER["REQUEST_METHOD"] === "GET") // Valido que el verbo de la petición sea GET
    {
        if (isset($_GET["listado"])) // Valido que exista y esté seteada la key 'listado'
            $listado = $_GET["listado"];
    
        if ($listado === "usuarios")
        {
            require "Usuario.php";

            $archivo = fopen("C:/xampp/htdocs/Clase03/usuarios.csv", "r");
    
            $lista = Usuario::cargarLista();

            fclose($archivo);
        }

        if (isset($lista))
        {
            echo "<ul>";
            foreach ($lista as $item) {
                echo "<li>";
                echo $item->mostrar();
                echo "</li>";
            }
            echo "</ul>";
        }
    }
?>