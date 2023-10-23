<?php
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    if (isset($_POST["idReserva"]) && isset($_POST["motivo"]))
    {
        $idReserva = $_POST["idReserva"];
        $motivo = $_POST["motivo"];

        if (is_numeric($idReserva) && strlen($motivo) > 4 && strlen($motivo) < 20)
        {
            require "./clases/Reserva.php";
            require "./clases/Ajuste.php";

            $listaDeReservas = Reserva::cargarLista();
            $listaDeAjustes = Ajuste::cargarLista();

            $reserva = Reserva::getReservaPorId($idReserva, $listaDeReservas);

            if ($reserva !== null) {
                $respuesta = Ajuste::altaAjuste($reserva, $motivo, $listaDeAjustes);
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