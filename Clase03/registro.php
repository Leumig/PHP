<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") // Valido que el verbo de la petición sea POST
    {
        require "Usuario.php";
        echo "El POST recibió:" . "</br>";
        var_dump($_POST);
        //$_POST es un array asociativo que contiene lo que recibió la petición POST en su body
    
        //$usuarioUno = New Usuario($_POST["nombre"], $_POST["clave"], $_POST["email"]);
        //Así lo haría rápido sin validar nada
        //var_dump($usuarioUno);
    
        if (isset($_POST["nombre"]))
            $nombre = $_POST["nombre"];
            
        if (isset($_POST["clave"]))
            $clave = $_POST["clave"];
        
        if (isset($_POST["email"]))
            $email = $_POST["email"];

        $usuarioUno = New Usuario($nombre, $clave, $email); 
    
        $usuarioUno->mostrar();
    
        echo Usuario::alta($usuarioUno) ? "TRUE" : "FALSE";
    } else
    {
        echo "Verbo HTTP erróneo. Debe ser POST";
    }
?>