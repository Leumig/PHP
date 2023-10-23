<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["email"]) && isset($_POST["sabor"]) &&
        isset($_POST["tipo"]) && isset($_POST["cantidad"]))
    {
        $emailUsuario = $_POST["email"];
        $sabor = $_POST["sabor"];
        $tipo = $_POST["tipo"];
        $cantidad = $_POST["cantidad"];

        if (strlen($emailUsuario) > 3 && strlen($sabor) > 2 &&
            ($tipo === "piedra" || $tipo === "molde") && is_numeric($cantidad) && $cantidad > 0)
        {
            require "./clases/Pizza.php";
            require "./clases/Venta.php";

            $listaDePizzas = Pizza::cargarLista();
            $listaDeVentas = Venta::cargarLista();

            $pizza = Pizza::getPizzaPorSaborYTipo($sabor, $tipo, $listaDePizzas);

            if ($pizza !== null) {
                $respuesta = Venta::altaVenta($emailUsuario, $pizza, $cantidad, $listaDeVentas);
                echo json_encode(["venta" => $respuesta]);
    
                Pizza::guardarLista($listaDePizzas);
                Venta::guardarLista($listaDeVentas);
            } else {
                echo json_encode(["error" => "No hay una pizza con ese sabor y tipo"]);
            }
        } else {
            echo json_encode(["error" => "Valores enviados por POST no validos"]);
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por POST no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erróneo. Debe ser POST"]);
}
?>