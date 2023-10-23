<?php

require_once "ManejadorArchivos.php";

class Deposito implements JsonSerializable{
    private $_tipoCuenta;
    private $_numeroCuenta;
    private $_moneda;
    private $_monto;
    private $_id;
    private $_fecha;
    private $_imagen;
    private static $_contadorId = 100;

    public function getFecha() {
        return $this->_fecha;
    }
    public function getSabor() {
        return $this->_numeroCuenta;
    }
    public function getEmail() {
        return $this->_tipoCuenta;
    }

    public function __construct($tipoCuenta, $numeroCuenta, $moneda, $monto,
        $imagen = null, $fecha = null, $id = null) {

        $this->_tipoCuenta = $tipoCuenta;
        $this->_numeroCuenta = $numeroCuenta;
        $this->_moneda = $moneda;
        $this->_monto = $monto;
        $this->_fecha = $fecha !== null ? $fecha : date_format(new Datetime(), "d-m-Y");

        $this->_id = $id;
        $id !== null ? self::$_contadorId++ : $this->_id = self::$_contadorId++;
        
        $imagen !== null ?
        $this->_imagen = $imagen : self::guardarImagen($tipoCuenta, $numeroCuenta, $id);
    }

    public function jsonSerialize() {
        return [
            "tipoCuenta" => $this->_tipoCuenta,
            "numeroCuenta" => $this->_numeroCuenta,
            "moneda" => $this->_moneda,
            "monto" => $this->_monto,
            "imagen" => $this->_imagen,
            "fecha" => $this->_fecha,
            "id" => $this->_id,
        ];
    }

    private function guardarImagen($tipoCuenta, $numeroCuenta, $id) {
        if (isset($_FILES["imagen"]))
        {
            $nombreImagen = $tipoCuenta . "_" . $numeroCuenta . "_" . $id . ".jpg";
            $this->_imagen = $nombreImagen;

            $destino = "imagenes/ImagenesDeDepositos2023/" . $nombreImagen;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
        }
    }

    static function cargarLista() {
        $lista = [];

        $ruta = "./data/depositos.json";
        $manejador = new ManejadorArchivos($ruta);
        $lista = $manejador->Leer("Deposito");

        return $lista;
    }

    static function guardarLista($lista) {
        if (count($lista) > 0) {
            $ruta = "./data/depositos.json";
            $manejador = new ManejadorArchivos($ruta);
            $manejador->Guardar($lista);
        }
    }

    static function altaDeposito($cuenta, $importe, &$listaDeDepositos) {
        $respuesta = "No se pudo realizar";

        if ($importe > 0)
        {
            $saldoActual = $cuenta->getSaldo();
            $nuevoSaldo = $saldoActual + $importe;
            $cuenta->setSaldo($nuevoSaldo);
            
            $nuevoDeposito = new Deposito($cuenta->getTipoCuenta(), $cuenta->getNumeroCuenta(),
            $cuenta->getMoneda(), $importe);

            array_push($listaDeDepositos, $nuevoDeposito);

            $respuesta = "Realizado correctamente";
        }

        return $respuesta;
    }
}
?>