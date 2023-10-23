<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["tipo"]) && isset($_POST["numero"]))
    {
        $tipo = $_POST["tipo"];
        $numero = $_POST["numero"];

        require "./clases/Cliente.php";

        $listaDeClientes = Cliente::cargarLista();
        
        $respuesta = Cliente::consultarClienteExistente($tipo, $numero, $listaDeClientes);
        
        echo json_encode(["respuesta" => $respuesta]);
    } else {
        echo json_encode(["error" => "Parametros enviados por POST no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser POST"]);
}
?>