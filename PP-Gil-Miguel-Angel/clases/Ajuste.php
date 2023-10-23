<?php

require_once "ManejadorArchivos.php";

class Ajuste implements JsonSerializable{
    private $_idReserva;
    private $_motivo;
    private $_id;
    private static $_contadorId = 1;

    public function __construct($idReserva, $motivo, $id = null) {
        $this->_idReserva = $idReserva;
        $this->_motivo = $motivo;

        $this->_id = $id;
        $id !== null ? self::$_contadorId++ : $this->_id = self::$_contadorId++;
    }

    public function jsonSerialize() {
        return [
            "idReserva" => $this->_idReserva,
            "motivo" => $this->_motivo,
            "id" => $this->_id,
        ];
    }

    static function cargarLista() {
        $lista = [];

        $ruta = "./data/ajustes.json";
        $manejador = new ManejadorArchivos($ruta);
        $lista = $manejador->Leer("Ajuste");

        return $lista;
    }

    static function guardarLista($lista) {
        if (count($lista) > 0) {
            $ruta = "./data/ajustes.json";
            $manejador = new ManejadorArchivos($ruta);
            $manejador->Guardar($lista);
        }
    }

    static function altaAjuste($reserva, $motivo, &$listaDeAjustes) {
        $respuesta = "No se pudo realizar";

        if ($reserva !== null) {
            $nuevoAjuste = new Ajuste($reserva->getId(), $motivo);

            $reserva->setEstado("Ajustada por: " . $motivo);

            array_push($listaDeAjustes, $nuevoAjuste);
            $respuesta = "Realizado correctamente";
        }

        return $respuesta;
    }

    static function getAjustePorId($id, $lista) {
        $respuesta = null;

        foreach ($lista as $Ajuste) {
            if ($Ajuste->_id == $id) {
                $respuesta = $Ajuste;
                break;
            }
        }

        return $respuesta;
    }
}
?>