<?php
    if ($_SERVER["REQUEST_METHOD"] === "GET")
    {
        if (isset($_GET["listado"]))
        {
            $listado = $_GET["listado"];
    
            if ($listado === "usuarios")
            {
                require "./Usuario/Usuario.php";
                $lista = Usuario::cargarLista();
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
            } else
            {
                echo "La lista está vacía o no existe";
            }
        }else {
            echo "No se envió ningún listado";
        }
    } else {
        echo "Verbo HTTP erróneo. Debe ser GET";
    }
?>