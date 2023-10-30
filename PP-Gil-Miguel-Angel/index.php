<?php
switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["accion"])) {
            if ($_GET["accion"] === "consultarReservas") {
                include "./ConsultasReservas.php";
            } else {
                echo json_encode(["error" => "El parametro 'accion' no tiene un valor valido"]);
            }
        } else {
            echo json_encode(["error" => "No se recibio el parametro 'accion'"]);
        }
        break;
    case "POST":
        if (isset($_POST["accion"])) {
            switch ($_POST["accion"]) {
                case "alta":
                    include "./ClienteAlta.php";
                    break;
                case "consultarCliente":
                    include "./ConsultarCliente.php";
                    break;
                case "reserva":
                    include "./ReservaHabitacion.php";
                    break;
                case "cancelar":
                    include "./CancelarReserva.php";
                    break;
                case "ajuste":
                    include "./AjusteReserva.php";
                    break;
                default:
                echo json_encode(["error" => "El parametro 'accion' no tiene un valor valido"]);
                    break;
            }
        } else {
            echo json_encode(["error" => "No se recibio el parametro 'accion'"]);
        }
        break;
    case "PUT":
        parse_str(file_get_contents("php://input"), $datosPUT);
        if (isset($datosPUT["accion"])) {
            if ($datosPUT["accion"] === "modificar") {
                include "./ModificarCliente.php";
            } else {
                echo json_encode(["error" => "El parametro 'accion' no tiene un valor valido"]);
            }
        } else {
            echo json_encode(["error" => "No se recibio el parametro 'accion'"]);
        }
        break;
    case "DELETE":
        include "./BorrarCliente.php";
        break;
        default:
            echo json_encode(["error" => "Metodo HTTP no permitido"]);
        break;
}
?>