<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {   
        if (isset($_POST["clave"]) && isset($_POST["email"]))
        {
            $clave = $_POST["clave"];
            $email = $_POST["email"]; 
             
            require "Usuario.php";
 
            $listaUsuarios = Usuario::cargarLista();

            $respuesta = Usuario::comprobarLogin($listaUsuarios, $clave, $email);

            echo $respuesta;
        } else
        {
            echo "Datos enviados por POST no válidos";
        }
    } else
    {
        echo "Verbo HTTP erróneo. Debe ser POST";
    }
?>