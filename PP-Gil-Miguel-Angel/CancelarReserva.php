<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"]) && isset($_POST["idReserva"]))
    {
        $tipoCliente = $_POST["tipoCliente"];
        $numeroCliente = $_POST["numeroCliente"];
        $idReserva = $_POST["idReserva"];

        if ($tipoCliente === "individual" || $tipoCliente === "corporativo")
        {
            require "./clases/Cliente.php";
            require "./clases/Reserva.php";

            $listaDeClientes = Cliente::cargarLista();
            $listaDeReservas = Reserva::cargarLista();

            $respuesta = false;
            Cliente::consultarClienteExistente($tipoCliente, $numeroCliente, $listaDeClientes, $respuesta);

            if ($respuesta) {
                $reserva = Reserva::getReservaPorId($idReserva, $listaDeReservas);

                if ($reserva !== null && $reserva->getNumeroCliente() == $numeroCliente) {
                    $reserva->setEstado("Cancelada");
                    Reserva::guardarLista($listaDeReservas);
                    echo json_encode(["cancelacion" => "Realizada correctamente"]);
                } else {
                    echo json_encode(["error" => "No existe esa reserva o no tiene ese numero de cliente"]);
                }
            } else {
                echo json_encode(["error" => "No existe un cliente con ese numero y tipo"]);
            }

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