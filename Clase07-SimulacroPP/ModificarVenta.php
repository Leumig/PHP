<?php
if ($_SERVER["REQUEST_METHOD"] === "PUT")
{
    parse_str(file_get_contents("php://input"), $datosPUT);

    if (isset($datosPUT["pedido"]) && isset($datosPUT["email"]) && isset($datosPUT["sabor"]) &&
        isset($datosPUT["tipo"]) && isset($datosPUT["cantidad"]))
    {
        if (is_numeric($datosPUT["pedido"]) && strlen($datosPUT["email"]) > 3 && 
            strlen($datosPUT["sabor"]) > 3 && ($datosPUT["tipo"] === "piedra" || $datosPUT["tipo"] === "molde"))
        {
            require "./clases/Venta.php";
            
            $pedido = $datosPUT["pedido"];
            $email = $datosPUT["email"];
            $sabor = $datosPUT["sabor"];
            $tipo = $datosPUT["tipo"];
            $cantidad = $datosPUT["cantidad"];

            $listaDeVentas = Venta::cargarLista();
            $venta = Venta::getVentaPorPedido($pedido, $listaDeVentas);

            if ($venta !== null) {
                $venta->modificarVenta($email, $sabor, $tipo, $cantidad);
                Venta::guardarLista($listaDeVentas);
                echo json_encode(["modificacion" => "Realizada correctamente"]);
            } else {
                echo json_encode(["error" => "No existe una venta con ese numero de pedido"]);
            }
        } else {
            echo json_encode(["error" => "Valores enviados por PUT no validos"]);
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por PUT no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser PUT"]);
}
?>