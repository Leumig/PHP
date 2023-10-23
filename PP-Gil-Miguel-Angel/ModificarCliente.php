<?php
if ($_SERVER["REQUEST_METHOD"] === "PUT")
{
    parse_str(file_get_contents("php://input"), $datosPUT);

    if (isset($datosPUT["nombre"]) && isset($datosPUT["apellido"]) && isset($datosPUT["tipoDocumento"]) &&
        isset($datosPUT["numeroDocumento"]) && isset($datosPUT["email"]) && 
        isset($datosPUT["tipoCliente"]) && isset($datosPUT["pais"]) &&
        isset($datosPUT["ciudad"]) && isset($datosPUT["telefono"]) && isset($datosPUT["numeroCliente"]))
    {
        $nombre = $datosPUT["nombre"];
        $apellido = $datosPUT["apellido"];
        $tipoDocumento = $datosPUT["tipoDocumento"];
        $numeroDocumento = $datosPUT["numeroDocumento"];
        $email = $datosPUT["email"];
        $tipoCliente = $datosPUT["tipoCliente"];
        $pais = $datosPUT["pais"];
        $ciudad = $datosPUT["ciudad"];
        $telefono = $datosPUT["telefono"];
        $numeroCliente = $datosPUT["numeroCliente"];

        require "./clases/Validaciones.php";

        if (validarString($nombre, 3, 16) && validarString($apellido, 3, 16) &&
            validarString($tipoDocumento, 1, 10) && validarString($email, 5, 35, false, true) &&
            validarString($ciudad, 4, 20) && validarEntero($telefono, 1000000000, 9999999999) &&
            validarEntero($numeroDocumento, 10000000, 99999999) && validarString($pais, 4, 20) &&
            ($tipoCliente === "individual" || $tipoCliente === "corporativo"))
        {
            require "./clases/Cliente.php";

            $listaDeClientes = Cliente::cargarLista();

            $respuesta = false;
            Cliente::consultarClienteExistente($tipoCliente, $numeroCliente, $listaDeClientes, $respuesta);
            $cliente = Cliente::getClientePorNumero($numeroCliente, $listaDeClientes);

            if ($respuesta !== false && $cliente !== null) {
                $cliente->modificarCliente($nombre, $apellido, $tipoDocumento, $numeroDocumento,
                $email, $pais, $ciudad, $telefono);

                Cliente::guardarLista($listaDeClientes);
                echo json_encode(["modificacion" => "Realizada correctamente"]);
            } else {
                echo json_encode(["error" => "No se encontro al cliente"]);
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