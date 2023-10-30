<?php
if ($_SERVER["REQUEST_METHOD"] === "GET")
{
    if (isset($_GET["consulta"]))
    {
        $consulta = $_GET["consulta"];

        require "./clases/Reserva.php";
        require "./clases/Cliente.php";
        require "./clases/Validaciones.php";

        $listaReservas = Reserva::cargarLista();
        $listaClientes = Cliente::cargarLista();

        switch ($consulta) {
            case "A":
                if (isset($_GET["tipoHabitacion"])) {
                    $tipoHabitacion = $_GET["tipoHabitacion"];

                    if (isset($_GET["fecha"]) && validarFecha($_GET["fecha"])) {
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

                    if (validarFecha($fechaMin) && validarFecha($fechaMax)) {
                        $respuesta = Reserva::listarPorFechas($fechaMin, $fechaMax, $listaReservas);
                        echo json_encode(["C" => $respuesta]);
                    } else {
                        echo json_encode(["error" => "Valores para la consulta C no validos"]);
                    }
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
            case "E":
                if (isset($_GET["tipoCliente"])) {
                    $tipoCliente = $_GET["tipoCliente"];

                    if (isset($_GET["fecha"]) && validarFecha($_GET["fecha"])) {
                        $fecha = $_GET["fecha"];
                        $respuesta = Reserva::listarCanceladasPorTipoYFecha($tipoCliente, $listaReservas, $fecha);
                    } else {
                        $respuesta = Reserva::listarCanceladasPorTipoYFecha($tipoCliente, $listaReservas);
                    }

                    echo json_encode(["E" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta E no validos"]);
                }
                break;
            case "F":
                if (isset($_GET["numeroCliente"])) {
                    $numeroCliente = $_GET["numeroCliente"];

                    $respuesta = Reserva::listarCanceladasPorCliente($numeroCliente, $listaReservas);

                    echo json_encode(["F" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta F no validos"]);
                }

                break;
            case "G":
                if (isset($_GET["fechaMin"]) && isset($_GET["fechaMax"])) {
                    $fechaMin = $_GET["fechaMin"];
                    $fechaMax = $_GET["fechaMax"];

                    if (validarFecha($fechaMin) && validarFecha($fechaMax)) {
                        $respuesta = Reserva::listarCanceladasPorFechas($fechaMin, $fechaMax, $listaReservas);
                        echo json_encode(["G" => $respuesta]);
                    } else {
                        echo json_encode(["error" => "Valores para la consulta G no validos"]);
                    }
                } else {
                    echo json_encode(["error" => "Parametros para la consulta G no validos"]);
                }
                break;
            case "H":
                if (isset($_GET["tipoCliente"])) {
                    $tipoCliente = $_GET["tipoCliente"];

                    $respuesta = Reserva::listarCanceladasPorTipoCliente($tipoCliente, $listaReservas);

                    echo json_encode(["H" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta H no validos"]);
                }

                break;
            case "I":
                if (isset($_GET["numeroCliente"])) {
                    $numeroCliente = $_GET["numeroCliente"];

                    $respuesta = Reserva::listarPorCliente($numeroCliente, $listaReservas);

                    echo json_encode(["I" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta I no validos"]);
                }
                break;
            case "J":
                if (isset($_GET["modalidadPago"])) {
                    $modalidadPago = $_GET["modalidadPago"];

                    $respuesta = Reserva::listarPorModalidadPago($modalidadPago, $listaReservas, $listaClientes);

                    echo json_encode(["J" => $respuesta]);
                } else {
                    echo json_encode(["error" => "Parametros para la consulta J no validos"]);
                }
                break;
            default:
                echo json_encode(["error" => "Las consultas solo pueden ser A-J"]);
                break;
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por GET no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser GET"]);
}
?>