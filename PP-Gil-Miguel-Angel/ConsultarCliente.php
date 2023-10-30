<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["numero"]) && isset($_POST["documento"]))
    {
        $numero = $_POST["numero"];
        $documento = $_POST["documento"];

        require "./clases/Cliente.php";

        $listaDeClientes = Cliente::cargarLista();
        
        $respuesta = Cliente::consultarClienteExistenteNuevo($documento, $numero, $listaDeClientes);
        
        echo json_encode(["respuesta" => $respuesta]);
    } else {
        echo json_encode(["error" => "Parametros enviados por POST no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser POST"]);
}
?>