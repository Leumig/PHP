<?php
if ($_SERVER["REQUEST_METHOD"] === "DELETE")
{
    $datosDELETE = $_GET;

    if (isset($datosDELETE["pedido"]))
    {
        if (is_numeric($datosDELETE["pedido"]))
        {
            require "./clases/Venta.php";
            
            $pedido = $datosDELETE["pedido"];

            $listaDeVentas = Venta::cargarLista();
            $venta = Venta::getVentaPorPedido($pedido, $listaDeVentas);

            if ($venta !== null) {
                Venta::borrarVenta($venta, $listaDeVentas);
                Venta::guardarLista($listaDeVentas);
                echo json_encode(["eliminacion" => "Realizada correctamente"]);
            } else {
                echo json_encode(["error" => "No existe una venta con ese numero de pedido"]);
            }
        } else {
            echo json_encode(["error" => "Valores enviados por DELETE no validos"]);
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por DELETE no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser DELETE"]);
}
?>