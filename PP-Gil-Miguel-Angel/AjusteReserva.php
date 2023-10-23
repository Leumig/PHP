<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["idReserva"]) && isset($_POST["motivo"]) && isset($_POST["monto"]))
    {
        $idReserva = $_POST["idReserva"];
        $motivo = $_POST["motivo"];
        $monto = $_POST["monto"];

        require "./clases/Validaciones.php";

        if (validarNumerico($idReserva) && validarString($motivo, 3, 20) &&
            validarNumerico($monto, -999999, 999999))
        {
            require "./clases/Reserva.php";
            require "./clases/Ajuste.php";

            $listaDeReservas = Reserva::cargarLista();
            $listaDeAjustes = Ajuste::cargarLista();

            $reserva = Reserva::getReservaPorId($idReserva, $listaDeReservas);

            if ($reserva !== null) {
                $respuesta = Ajuste::altaAjuste($reserva, $motivo, $monto, $listaDeAjustes);
                echo json_encode(["ajuste" => $respuesta]);

                Reserva::guardarLista($listaDeReservas);
                Ajuste::guardarLista($listaDeAjustes);
            } else {
                echo json_encode(["error" => "No existe una reserva con esa ID"]);
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