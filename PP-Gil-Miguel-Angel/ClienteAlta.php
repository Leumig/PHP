<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["tipoDocumento"]) &&
        isset($_POST["numeroDocumento"]) && isset($_POST["email"]) && isset($_POST["tipoCliente"]) && 
        isset($_POST["pais"]) && isset($_POST["ciudad"]) && isset($_POST["telefono"]))
    {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $tipoDocumento = $_POST["tipoDocumento"];
        $numeroDocumento = $_POST["numeroDocumento"];
        $email = $_POST["email"];
        $tipoCliente = $_POST["tipoCliente"];
        $pais = $_POST["pais"];
        $ciudad = $_POST["ciudad"];
        $telefono = $_POST["telefono"];

        require "./clases/Validaciones.php";

        if (validarString($nombre, 3, 16) && validarString($apellido, 3, 16) &&
            validarString($tipoDocumento, 1, 10) && validarString($email, 5, 35, false, true) &&
            validarString($ciudad, 4, 20) && validarNumerico($telefono, 1000000000, 9999999999) &&
            validarNumerico($numeroDocumento, 10000000, 99999999) && validarString($pais, 4, 20) &&
            ($tipoCliente === "individual" || $tipoCliente === "corporativo"))
        {
            require "./clases/Cliente.php";

            $listaDeClientes = Cliente::cargarLista();

            if (isset($_POST["modalidadPago"])) {

                $modalidadPago = $_POST["modalidadPago"];

                if (validarString($modalidadPago)) {
                    $clienteNuevo = new Cliente($nombre, $apellido, $tipoDocumento, $numeroDocumento,
                    $email, $tipoCliente, $pais, $ciudad, $telefono, null, $modalidadPago);
                } else {
                    $clienteNuevo = new Cliente($nombre, $apellido, $tipoDocumento, $numeroDocumento,
                    $email, $tipoCliente, $pais, $ciudad, $telefono);
                }
            } else {
                $clienteNuevo = new Cliente($nombre, $apellido, $tipoDocumento, $numeroDocumento,
                $email, $tipoCliente, $pais, $ciudad, $telefono);
            }

            $respuesta = Cliente::altaClienteNuevo($clienteNuevo, $listaDeClientes);

            echo json_encode(["alta" => $respuesta]);

            Cliente::guardarLista($listaDeClientes);
        } else {
            echo json_encode(["error" => "Valores enviados por POST no validos"]);
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por POST no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser POST"]);
}