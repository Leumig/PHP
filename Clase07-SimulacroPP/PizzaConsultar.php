<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["sabor"]) && isset($_POST["tipo"]))
    {
        $sabor = $_POST["sabor"];
        $tipo = $_POST["tipo"];

        require "./clases/Pizza.php";

        $listaDePizzas = Pizza::cargarLista();
        
        $respuesta = Pizza::consultarPizzaExistente($sabor, $tipo, $listaDePizzas);
        
        echo json_encode(["respuesta" => $respuesta]);
    } else {
        echo json_encode(["error" => "Parametros enviados por POST no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser POST"]);
}
?>