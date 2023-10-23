<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["tipoCuenta"]) && isset($_POST["numeroCuenta"]))
    {
        $tipoCuenta = $_POST["tipoCuenta"];
        $numeroCuenta = $_POST["numeroCuenta"];

        require "./clases/Cuenta.php";

        $listaDeCuentas = Cuenta::cargarLista();
        
        $respuesta = Cuenta::consultarCuentaExistente($tipoCuenta, $numeroCuenta, $listaDeCuentas);
        
        echo json_encode(["respuesta" => $respuesta]);
    } else {
        echo json_encode(["error" => "Parametros enviados por POST no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser POST"]);
}
?>