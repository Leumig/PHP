<?php

require_once "ManejadorArchivos.php";

class Cuenta implements JsonSerializable{
    private $_nombre;
    private $_apellido;
    private $_tipoDocumento;
    private $_numeroDni;
    private $_email;
    private $_tipoCuenta;
    private $_moneda;
    private $_saldoInicial;
    private $_imagen;
    private $_numeroCuenta;
    private static $_contadorId = 100000;

    public function getTipoCuenta() {
        return $this->_tipoCuenta;
    }
    public function getNumeroCuenta() {
        return $this->_numeroCuenta;
    }
    public function getMoneda() {
        return $this->_moneda;
    }

    public function setSaldo($saldo) {
        if (is_numeric($saldo))
            $this->_saldoInicial = $saldo;
    }

    public function __construct($nombre, $apellido, $tipoDocumento, $numeroDni, $email,
        $tipoCuenta, $moneda, $saldoInicial, $imagen = null, $numeroCuenta = null) {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_tipoDocumento = $tipoDocumento;
        $this->_numeroDni = $numeroDni;
        $this->_email = $email;
        $this->_tipoCuenta = $tipoCuenta;
        $this->_moneda = $moneda;
        $this->_saldoInicial = $saldoInicial;

        $imagen !== null ? $this->_imagen = $imagen : self::guardarImagen($numeroCuenta, $tipoCuenta);

        $this->_numeroCuenta = $numeroCuenta;

        $numeroCuenta !== null && is_numeric($numeroCuenta) ?
        self::$_contadorId++ : $this->_numeroCuenta = self::$_contadorId++;
    }

    public function jsonSerialize() {
        return [
            "nombre" => $this->_nombre,
            "apellido" => $this->_apellido,
            "tipoDocumento" => $this->_tipoDocumento,
            "numeroDni" => $this->_numeroDni,
            "email" => $this->_email,
            "tipoCuenta" => $this->_tipoCuenta,
            "moneda" => $this->_moneda,
            "saldoInicial" => $this->_saldoInicial,
            "imagen" => $this->_imagen,
            "numeroCuenta" => $this->_numeroCuenta,
        ];
    }

    private function guardarImagen($numeroCuenta, $tipoCuenta) {
        if (isset($_FILES["imagen"]))
        {
            $nombreImagen = $numeroCuenta . $tipoCuenta . ".jpg";
            $this->_imagen = $nombreImagen;

            $destino = "imagenes/ImagenesDeCuentas/2023/" . $nombreImagen;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
        }
    }

    static function cargarLista() {
        $lista = [];

        $ruta = "./data/banco.json";
        $manejador = new ManejadorArchivos($ruta);
        $lista = $manejador->Leer("Cuenta");

        return $lista;
    }

    static function guardarLista($lista) {
        if (count($lista) > 0) {
            $ruta = "./data/banco.json";
            $manejador = new ManejadorArchivos($ruta);
            $manejador->Guardar($lista);
        }
    }

    static function altaCuenta($cuentaNueva, &$listaDeCuentas) {
        $respuesta = "No se pudo hacer";

        if ($cuentaNueva->_numeroCuenta !== null && count($listaDeCuentas) > 0)
        {
            $respuesta = "Ingresada";

            foreach ($listaDeCuentas as $cuenta) {
                if ($cuenta->_nombre === $cuentaNueva->_nombre &&
                    $cuenta->_tipoCuenta === $cuentaNueva->_tipoCuenta)
                {
                    $cuenta->_saldoInicial = $cuentaNueva->_saldoInicial;
                    $respuesta = "Actualizada";
                    break;
                }
            }
        }

        if ($respuesta === "Ingresada") {
            array_push($listaDeCuentas, $cuentaNueva);
        }

        return $respuesta;
    }

    static function getCuentaPorNumero($numeroCuenta, $lista) {
        $respuesta = null;

        foreach ($lista as $cuenta) {
            if ($cuenta->_numeroCuenta === $numeroCuenta) {
                $respuesta = $cuenta;
                break;
            }
        }

        return $respuesta;
    }

    static function consultarCuentaExistente($numero, $tipo, $listaDeCuentas, &$bool = false) {
        $respuesta = "No hay una cuenta con ese numero ni tampoco de ese tipo";

        if (($tipo === "CA" || $tipo === "CC") && count($listaDeCuentas) > 0) {
            foreach ($listaDeCuentas as $cuenta) {
                if ($cuenta->_numeroCuenta === $numero) {
                    if ($cuenta->_tipoCuenta === $tipo) {
                        $respuesta = "Moneda: " . $cuenta->_moneda . " - Saldo: " . $cuenta->_saldoInicial;
                        $bool = true;
                    }
                    else {
                        $respuesta = "Existe el numero de cuenta, pero no es de ese tipo";
                    }

                    break;
                }
            }
        }

        return $respuesta;
    }

    public function modificarCuenta($nombre, $apellido, $tipoDocumento, $numeroDni, $email,
        $tipoCuenta, $moneda, $imagen, $numeroCuenta) {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_tipoDocumento = $tipoDocumento;
        $this->_numeroDni = $numeroDni;
        $this->_email = $email;
        $this->_tipoCuenta = $tipoCuenta;
        $this->_moneda = $moneda;
        //$this->_imagen = $imagen;
        $this->_numeroCuenta = $numeroCuenta;
    }




    
    /*
    static function borrarCuenta($cuenta, &$listaDeCuentas) {
        $index = array_search($cuenta, $listaDeCuentas);
        array_splice($listaDeCuentas, $index, 1);

        $ubicacionActual = "imagenes/ImagenesDeLaCuenta/" . $cuenta->_imagen;
        $destino = "imagenes/BACKUPCuentaS/" . $cuenta->_imagen;

        rename($ubicacionActual, $destino);
    }*/
}
?>