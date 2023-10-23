<?php
switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["accion"])) {
            switch ($_GET["accion"]) {
                case "consultar":
                    include "./ConsultasMovimientos.php";
                    break;
                default:
                    echo json_encode(["error" => "El parametro 'accion' no tiene un valor valido"]);
                    break;
            }
        } else {
            echo json_encode(["error" => "No se recibio el parametro 'accion'"]);
        }
        break;
    case "POST":
        if (isset($_POST["accion"])) {
            switch ($_POST["accion"]) {
                case "alta":
                    include "./CuentaAlta.php";
                    break;
                case "consultar":
                    include "./PizzaConsultar.php";
                    break;
                case "deposito":
                    include "./DepositoCuenta.php";
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
        include "./ModificarCuenta.php";
        break;   
    case "DELETE":
        include "./BorrarVenta.php";
        break;
        default:
            echo json_encode(["error" => "Metodo HTTP no permitido"]);
        break;
}
?>