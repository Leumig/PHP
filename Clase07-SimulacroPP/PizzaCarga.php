<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["sabor"]) && isset($_POST["precio"])
        && isset($_POST["tipo"]) && isset($_POST["cantidad"]))
    {
        $sabor = $_POST["sabor"];
        $precio = $_POST["precio"];
        $tipo = $_POST["tipo"];
        $cantidad = $_POST["cantidad"];

        if (strlen($sabor) > 2 && $precio > 0 && 
            ($tipo === "molde" || $tipo === "piedra") && $cantidad > 0)
        {
            require "./clases/Pizza.php";

            $listaDePizzas = Pizza::cargarLista();
            
            $pizzaNueva = new Pizza($sabor, $precio, $tipo, $cantidad);

            $respuesta = Pizza::altaPizza($pizzaNueva, $listaDePizzas);

            echo json_encode(["carga" => $respuesta]);

            Pizza::guardarLista($listaDePizzas);
        } else {
            echo json_encode(["error" => "Valores enviados por POST no validos"]);
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por POST no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser POST"]);
}
?>