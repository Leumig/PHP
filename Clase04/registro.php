<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        require "./Usuario/Usuario.php";
   
        if (isset($_POST["nombre"]) && isset($_POST["clave"]) && isset($_POST["email"]))
        {
            $listaDeUsuarios = Usuario::cargarLista();

            $nombre = $_POST["nombre"];
            $clave = $_POST["clave"];
            $email = $_POST["email"];
            $foto = "Usuario/fotos/" . $_FILES["foto"]["name"];

            $usuarioCreado = New Usuario($nombre, $clave, $email, $foto); 
            array_push($listaDeUsuarios, $usuarioCreado);

            $respuesta = Usuario::guardarLista($listaDeUsuarios) ? "TRUE" : "FALSE";
            echo "Se pudieron guardar los usuarios: " . $respuesta;
        }
        else 
        {
            echo "Datos enviados por POST no válidos";
        }
    } else
    {
        echo "Verbo HTTP erróneo. Debe ser POST";
    }
?>