<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["nombre"]) && isset($_POST["apellido"])
        && isset($_POST["tipoDocumento"]) && isset($_POST["numeroDocumento"]) && isset($_POST["email"])
        && isset($_POST["tipoCuenta"]) && isset($_POST["moneda"]) && isset($_POST["saldoInicial"]))
    {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $tipoDocumento = $_POST["tipoDocumento"];
        $numeroDocumento = $_POST["numeroDocumento"];
        $email = $_POST["email"];
        $tipoCuenta = $_POST["tipoCuenta"];
        $moneda = $_POST["moneda"];
        $saldoInicial = $_POST["saldoInicial"];

        if (strlen($nombre) > 2 && strlen($apellido) > 2 && strlen($tipoDocumento) > 2 &&
            strlen($email) > 3 && strlen($moneda) > 3 && ($tipoCuenta === "CA" || $tipoCuenta === "CC") && 
            ($moneda === '$' || $moneda === 'U$S') && 
            is_numeric($numeroDocumento) && is_numeric($saldoInicial) && $saldoInicial > 0)
        {
            require "./clases/Cuenta.php";

            $listaDeCuentas = Cuenta::cargarLista();

            $CuentaNueva = new Cuenta($nombre, $apellido, $tipoDocumento, $numeroDocumento,
            $email, $tipoCuenta, $moneda, $saldoInicial);

            $respuesta = Cuenta::altaCuenta($CuentaNueva, $listaDeCuentas);

            echo json_encode(["alta" => $respuesta]);

            Cuenta::guardarLista($listaDeCuentas);
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