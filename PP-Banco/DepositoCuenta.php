<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["tipoCuenta"]) && isset($_POST["numeroCuenta"]) &&
        isset($_POST["moneda"]) && isset($_POST["importe"]))
    {
        $tipoCuenta = $_POST["tipoCuenta"];
        $numeroCuenta = $_POST["numeroCuenta"];
        $moneda = $_POST["moneda"];
        $importe = $_POST["importe"];

        if (($tipoCuenta === "CA" || $tipoCuenta === "CC") && is_numeric($importe) && $importe > 0 &&
            is_numeric($importe) && $importe > 0)
        {
            require "./clases/Cuenta.php";
            require "./clases/Deposito.php";

            $listaDeCuentas = Cuenta::cargarLista();
            $listaDeDepositos = Deposito::cargarLista();

            $cuenta = Cuenta::getCuentaPorNumero($numeroCuenta, $listaDeCuentas);

            if ($cuenta !== null) {
                $respuesta = Deposito::altaDeposito($cuenta, $importe, $listaDeDepositos);
                echo json_encode(["Deposito" => $respuesta]);
    
                Cuenta::guardarLista($listaDeCuentas);
                Deposito::guardarLista($listaDeDepositos);
            } else {
                echo json_encode(["error" => "No existe esa cuenta"]);
            }
        } else {
            echo json_encode(["error" => "Valores enviados por POST no validos"]);
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por POST no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erróneo. Debe ser POST"]);
}
?>