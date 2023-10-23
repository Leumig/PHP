<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["tipoCliente"]) && isset($_POST["numeroCliente"]) &&
        isset($_POST["fechaEntrada"]) && isset($_POST["fechaSalida"]) && 
        isset($_POST["tipoHabitacion"]) && isset($_POST["importe"]))
    {
        $tipoCliente = $_POST["tipoCliente"];
        $numeroCliente = $_POST["numeroCliente"];
        $fechaEntrada = $_POST["fechaEntrada"];
        $fechaSalida = $_POST["fechaSalida"];
        $tipoHabitacion = $_POST["tipoHabitacion"];
        $importe = $_POST["importe"];

        require "./clases/Validaciones.php";

        if (($tipoCliente === "individual" || $tipoCliente === "corporativo") &&
            ($tipoHabitacion === "Simple" || $tipoHabitacion === "Double" || $tipoHabitacion === "Suite") &&
            validarNumerico($importe) && validarFecha($fechaEntrada) && validarFecha($fechaSalida))
        {
            require "./clases/Cliente.php";
            require "./clases/Reserva.php";

            $listaDeClientes = Cliente::cargarLista();
            $listaDeReservas = Reserva::cargarLista();

            $respuesta = false;

            Cliente::consultarClienteExistente($tipoCliente, $numeroCliente, $listaDeClientes, $respuesta);

            if ($respuesta) {
                $cliente = Cliente::getClientePorNumero($numeroCliente, $listaDeClientes);

                if ($cliente !== null) {
                    $respuesta = Reserva::altaReserva($cliente, $fechaEntrada, $fechaSalida,
                    $tipoHabitacion, $importe, $listaDeReservas);
                    echo json_encode(["reserva" => $respuesta]);

                    Cliente::guardarLista($listaDeClientes);
                    Reserva::guardarLista($listaDeReservas);
                } else {
                    echo json_encode(["error" => "No se encontro al cliente"]);
                }
            } else {
                echo json_encode(["error" => "No se encontro al cliente"]);
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