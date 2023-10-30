<?php
if ($_SERVER["REQUEST_METHOD"] === "DELETE")
{
    $datosDELETE = $_GET;

    if (isset($datosDELETE["numeroDocumento"]) && isset($datosDELETE["tipoCliente"]) 
        && isset($datosDELETE["numeroCliente"]))
    {
        $numeroDocumento = $datosDELETE["numeroDocumento"];
        $tipoCliente = $datosDELETE["tipoCliente"];
        $numeroCliente = $datosDELETE["numeroCliente"];

        if (is_numeric($numeroCliente) && ($tipoCliente === "individual" || $tipoCliente === "corporativo") &&
            is_numeric($numeroDocumento))
        {
            require "./clases/Cliente.php";

            $listaDeClientes = Cliente::cargarLista();

            $respuesta = false;
            Cliente::consultarClienteExistenteNuevo($numeroDocumento, $numeroCliente, $listaDeClientes, $respuesta);

            $cliente = Cliente::getClientePorNumero($numeroCliente, $listaDeClientes);

            if ($respuesta !== false && $cliente !== null) {
                Cliente::borrarCliente($numeroDocumento, $cliente, $listaDeClientes);
                Cliente::guardarLista($listaDeClientes);
                echo json_encode(["baja" => "Realizada correctamente"]);
            } else {
                echo json_encode(["error" => "No se encontro al cliente"]);
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