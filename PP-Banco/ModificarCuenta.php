<?php
if ($_SERVER["REQUEST_METHOD"] === "PUT")
{
    parse_str(file_get_contents("php://input"), $datosPUT);

    if (isset($datosPUT["nombre"]) && isset($datosPUT["apellido"]) && isset($datosPUT["tipoDocumento"]) &&
        isset($datosPUT["numeroDni"]) && isset($datosPUT["email"]) && isset($datosPUT["tipoCuenta"]) &&
        isset($datosPUT["moneda"]) && isset($datosPUT["imagen"]) && isset($datosPUT["numeroCuenta"]))
    {
        if ($datosPUT["nombre"])
        {
            require "./clases/Cuenta.php";

            $nombre = $datosPUT["nombre"];
            $apellido = $datosPUT["apellido"];
            $tipoDocumento = $datosPUT["tipoDocumento"];
            $numeroDni = $datosPUT["numeroDni"];
            $email = $datosPUT["email"];
            $tipoCuenta = $datosPUT["tipoCuenta"];
            $moneda = $datosPUT["moneda"];
            $imagen = $datosPUT["imagen"];
            $numeroCuenta = $datosPUT["numeroCuenta"];

            $listaDeCuentas = Cuenta::cargarLista();
            Cuenta::consultarCuentaExistente($numeroCuenta, $tipoCuenta, $listaDeCuentas, $respuesta);
            $cuenta = Cuenta::getCuentaPorNumero($numeroCuenta, $listaDeCuentas);

            if ($respuesta && $cuenta !== null) {
                $cuenta->modificarCuenta($email, $sabor, $tipo, $cantidad);
                Cuenta::guardarLista($listaDeCuentas);
                echo json_encode(["modificacion" => "Realizada correctamente"]);
            } else {
                echo json_encode(["error" => "No existe esa cuenta"]);
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