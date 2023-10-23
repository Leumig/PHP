<?php

require_once "ManejadorArchivos.php";

class Reserva implements JsonSerializable{
    private $_tipoCliente;
    private $_numeroCliente;
    private $_fechaEntrada;
    private $_fechaSalida;
    private $_tipoHabitacion;
    private $_importe;
    private $_estado;
    private $_id;
    private $_imagen;
    private static $_contadorId = 500;

    public function setEstado($estado) {
        $this->_estado = $estado;
    }
    public function setImporte($importe) {
        $this->_importe = $importe;
    }
    public function getId() {
        return $this->_id;
    }
    public function getNumeroCliente() {
        return $this->_numeroCliente;
    }
    public function getImporte() {
        return $this->_importe;
    }

    public function __construct($tipocliente, $numerocliente, $fechaEntrada, $fechaSalida,
        $tipoHabitacion, $importe, $estado = null, $imagen = null, $id = null) {

        $this->_tipoCliente = $tipocliente;
        $this->_numeroCliente = $numerocliente;
        $this->_tipoHabitacion = $tipoHabitacion;
        $this->_importe = $importe;
        $estado !== null ? $this->_estado = $estado : $this->_estado = "Activa";
        
        if ($fechaEntrada instanceof DateTime && $fechaSalida instanceof DateTime) {
            $this->_fechaEntrada = date_format($fechaEntrada, "d-m-Y");
            $this->_fechaSalida = date_format($fechaSalida, "d-m-Y");
        } else {
            $this->_fechaEntrada = $fechaEntrada;
            $this->_fechaSalida = $fechaSalida;
        }
   
        $this->_id = $id;
        $id !== null ? self::$_contadorId++ : $this->_id = self::$_contadorId++;
        
        $imagen !== null ?
        $this->_imagen = $imagen : self::guardarImagen($tipocliente, $numerocliente, $this->_id);
    }

    public function jsonSerialize() {
        return [
            "tipocliente" => $this->_tipoCliente,
            "numerocliente" => $this->_numeroCliente,
            "fechaEntrada" => $this->_fechaEntrada,
            "fechaSalida" => $this->_fechaSalida,
            "tipoHabitacion" => $this->_tipoHabitacion,
            "importe" => $this->_importe,
            "estado" => $this->_estado,
            "imagen" => $this->_imagen,
            "id" => $this->_id,
        ];
    }

    private function guardarImagen($tipocliente, $numerocliente, $id) {
        if (isset($_FILES["imagen"]))
        {
            $nombreImagen = $tipocliente . "_" . $numerocliente . "_" . $id . ".jpg";
            $this->_imagen = $nombreImagen;

            $destino = "imagenes/ImagenesDeReservas2023/" . $nombreImagen;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
        }
    }

    static function cargarLista() {
        $lista = [];

        $ruta = "./data/reservas.json";
        $manejador = new ManejadorArchivos($ruta);
        $lista = $manejador->Leer("Reserva");

        return $lista;
    }

    static function guardarLista($lista) {
        if (count($lista) > 0) {
            $ruta = "./data/reservas.json";
            $manejador = new ManejadorArchivos($ruta);
            $manejador->Guardar($lista);
        }
    }

    static function altaReserva($cliente, $fechaEntrada, $fechaSalida, $tipoHabitacion, $importe, &$lista) {
        $respuesta = "No se pudo realizar";

        $fechaEntrada = DateTime::createFromFormat("d-m-Y", $fechaEntrada);
        $fechaSalida = DateTime::createFromFormat("d-m-Y", $fechaSalida);

        if ($cliente !== null && $fechaEntrada instanceof DateTime &&
            $fechaSalida instanceof DateTime && $fechaSalida >= $fechaEntrada) {

            $nuevaReserva = new Reserva($cliente->getTipoCliente(), $cliente->getNumeroCliente(),
            $fechaEntrada, $fechaSalida, $tipoHabitacion, $importe);
    
            array_push($lista, $nuevaReserva);
            $respuesta = "Realizada correctamente";
        }

        return $respuesta;
    }

    static function getReservaPorId($id, $lista) {
        $respuesta = null;

        foreach ($lista as $reserva) {
            if ($reserva->_id == $id) {
                $respuesta = $reserva;
                break;
            }
        }

        return $respuesta;
    }

    static function listarPorTipoYFecha($tipoHabitacion, $lista, $fecha = null) {
        $respuesta = "No se pudo realizar la consulta";

        if ($tipoHabitacion == "Simple" || $tipoHabitacion == "Double" || $tipoHabitacion == "Suite") {
            if ($fecha !== null) {
                $fecha = DateTime::createFromFormat("d-m-Y", $fecha);
            } else {
                $fecha = new DateTime("yesterday");
            }

            $listaFiltrada = [];

            foreach ($lista as $reserva) {
                $fechaReservaE = DateTime::createFromFormat("d-m-Y", $reserva->_fechaEntrada);
                $fechaReservaS = DateTime::createFromFormat("d-m-Y", $reserva->_fechaSalida);

                if ($reserva->_tipoHabitacion == $tipoHabitacion && 
                    $fechaReservaE <= $fecha && $fechaReservaS >= $fecha) {
                    array_push($listaFiltrada, $reserva);
                }
            }
            
            $respuesta = array_reduce($listaFiltrada, fn($acum, $r) => $acum + $r->_importe, 0);
        }

        return $respuesta;
    }

    static function listarPorCliente($numeroCliente, $lista) {
        $respuesta = [];

        foreach ($lista as $reserva) {
            if ($reserva->_numeroCliente == $numeroCliente) {
                array_push($respuesta, $reserva);
            }
        }

        return $respuesta;
    }

    static function listarPorFechas($fechaMin, $fechaMax, $lista) {
        $respuesta = [];

        $fechaMin = DateTime::createFromFormat("d-m-Y", $fechaMin);
        $fechaMax = DateTime::createFromFormat("d-m-Y", $fechaMax);
        foreach ($lista as $reserva) {
            $fechaReserva = DateTime::createFromFormat("d-m-Y", $reserva->_fechaEntrada);

            if ($fechaReserva >= $fechaMin && $fechaReserva <= $fechaMax) {
                array_push($respuesta, $reserva);
            }
        }

        usort($respuesta, function ($a, $b) {
            $fechaA = DateTime::createFromFormat("d-m-Y", $a->_fechaEntrada);
            $fechaB = DateTime::createFromFormat("d-m-Y", $b->_fechaEntrada);
    
            return $fechaA <=> $fechaB;
        });

        return $respuesta;
    }

    static function listarPorTipo($tipoHabitacion, $lista) {
        $respuesta = [];

        foreach ($lista as $reserva) {
            if ($reserva->_tipoHabitacion == $tipoHabitacion) {
                array_push($respuesta, $reserva);
            }
        }

        return $respuesta;
    }
}
?>