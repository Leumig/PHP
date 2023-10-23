<?php
if ($_SERVER["REQUEST_METHOD"] === "GET")
{
    if (isset($_GET["consulta"]))
    {
        $consulta = $_GET["consulta"];

        require "./clases/Reserva.php";
        $listaReservas = Reserva::cargarLista();

        switch ($consulta) {
            case "A":
                if (isset($_GET["tipoHabitacion"])) {
                    $tipoHabitacion = $_GET["tipoHabitacion"];

                    if (isset($_GET["fecha"])) {
                        $fecha = $_GET["fecha"];
                        $respuesta = Reserva::listarPorTipoYFecha($tipoHabitacion, $listaReservas, $fecha);
                    } else {
                        $respuesta = Reserva::listarPorTipoYFecha($tipoHabitacion, $listaReservas);
                    }

                    echo json_encode(["A" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta A no validos"]);
                }
                break;
            case "B":
                if (isset($_GET["numeroCliente"])) {
                    $numeroCliente = $_GET["numeroCliente"];

                    $respuesta = Reserva::listarPorCliente($numeroCliente, $listaReservas);

                    echo json_encode(["B" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta B no validos"]);
                }
                break;
            case "C":
                if (isset($_GET["fechaMin"]) && isset($_GET["fechaMax"])) {
                    $fechaMin = $_GET["fechaMin"];
                    $fechaMax = $_GET["fechaMax"];

                    $respuesta = Reserva::listarPorFechas($fechaMin, $fechaMax, $listaReservas);

                    echo json_encode(["C" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta C no validos"]);
                }
                break;
            case "D":
                if (isset($_GET["tipoHabitacion"])) {
                    $tipoHabitacion = $_GET["tipoHabitacion"];

                    $respuesta = Reserva::listarPorTipo($tipoHabitacion, $listaReservas);

                    echo json_encode(["D" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta D no validos"]);
                }
                break;
            default:
                echo json_encode(["error" => "Las consultas solo pueden ser A, B, C o D"]);
                break;
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por GET no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser GET"]);
}
?>