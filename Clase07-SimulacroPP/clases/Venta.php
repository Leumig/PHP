<?php

require_once "ManejadorArchivos.php";

class Venta implements JsonSerializable{
    private $_emailUsuario;
    private $_saborPizza;
    private $_tipoPizza;
    private $_cantidad;
    private $_id;
    private $_numeroDePedido;
    private $_fecha;
    private $_imagen;
    private static $_contadorId = 1;

    public function getFecha() {
        return $this->_fecha;
    }
    public function getSabor() {
        return $this->_saborPizza;
    }
    public function getEmail() {
        return $this->_emailUsuario;
    }

    public function __construct($emailUsuario, $saborPizza, $tipoPizza, $cantidad,
        $numeroDePedido = null, $imagen = null, $fecha = null, $id = null) {

        $this->_emailUsuario = $emailUsuario;
        $this->_saborPizza = $saborPizza;
        $this->_tipoPizza = $tipoPizza;
        $this->_cantidad = $cantidad;
        $this->_numeroDePedido = $numeroDePedido !== null ? $numeroDePedido : rand(10000, 99999);
        $this->_fecha = $fecha !== null ? $fecha : date_format(new Datetime(), "d-m-Y");

        $imagen !== null ?
        $this->_imagen = $imagen : self::guardarImagen($tipoPizza, $saborPizza, $emailUsuario, $fecha);

        $this->_id = $id;
        $id !== null ? self::$_contadorId++ : $this->_id = self::$_contadorId++;
    }

    public function jsonSerialize() {
        return [
            "emailUsuario" => $this->_emailUsuario,
            "saborPizza" => $this->_saborPizza,
            "tipoPizza" => $this->_tipoPizza,
            "cantidad" => $this->_cantidad,
            "numeroDePedido" => $this->_numeroDePedido,
            "imagen" => $this->_imagen,
            "fecha" => $this->_fecha,
            "id" => $this->_id,
        ];
    }

    private function guardarImagen($tipo, $sabor, $email, $fecha) {
        if (isset($_FILES["imagen"]))
        {
            $divisionEmail = explode("@", $email);
            $usuario = $divisionEmail[0];

            $nombreImagen = $tipo . "_" . $sabor . "_" . $usuario .
             "_" . date_format(new DateTime($fecha), "d-m-Y") . ".jpg";

            $this->_imagen = $nombreImagen;

            $destino = "imagenes/ImagenesDeLaVenta/" . $nombreImagen;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
        }
    }

    static function cargarLista() {
        $lista = [];

        $ruta = "./listados/Venta.json";
        $manejador = new ManejadorArchivos($ruta);
        $lista = $manejador->Leer("Venta");

        return $lista;
    }

    static function guardarLista($lista) {
        if (count($lista) > 0) {
            $ruta = "./listados/Venta.json";
            $manejador = new ManejadorArchivos($ruta);
            $manejador->Guardar($lista);
        }
    }

    static function altaVenta($email, $pizza, $cantidad, &$listaDeVentas) {
        $respuesta = "No se pudo realizar";
        $stockPizza = $pizza->getCantidad();

        if ($stockPizza > 0)
        {
            if ($cantidad >= $stockPizza)
            {
                $cantidad = $stockPizza;
                $pizza->setCantidad(0);
            } else {
                $stockNuevo = $stockPizza - $cantidad;
                $pizza->setCantidad($stockNuevo);
            }

            $nuevaVenta = new Venta($email, $pizza->getSabor(), $pizza->getTipo(), $cantidad);
            array_push($listaDeVentas, $nuevaVenta);

            $respuesta = "Realizada correctamente";
        } else {
            $respuesta = "Ya no queda stock de esa pizza!";
        }

        return $respuesta;
    }

    public function modificarVenta($email, $sabor, $tipo, $cantidad) {
        $this->_emailUsuario = $email;
        $this->_saborPizza = $sabor;
        $this->_tipoPizza = $tipo;
        $this->_cantidad = $cantidad;
    }

    static function borrarVenta($venta, &$listaDeVentas) {
        $index = array_search($venta, $listaDeVentas);
        array_splice($listaDeVentas, $index, 1);

        $ubicacionActual = "imagenes/ImagenesDeLaVenta/" . $venta->_imagen;
        $destino = "imagenes/BACKUPVENTAS/" . $venta->_imagen;

        rename($ubicacionActual, $destino);
    }

    static function getVentaPorPedido($pedido, $listaDeVentas) {
        $respuesta = null;

        foreach ($listaDeVentas as $venta) {
            if ($venta->_numeroDePedido == $pedido)
            {
                $respuesta = $venta;
                break;
            }
        }

        return $respuesta;
    }
}
?>