<?php

require_once "ManejadorArchivos.php";

class Pizza implements JsonSerializable{
    private $_sabor;
    private $_precio;
    private $_tipo;
    private $_cantidad;
    private $_imagen;
    private $_id;
    private static $_contadorId = 1;

    public function getSabor() {
        return $this->_sabor;
    }
    public function getTipo() {
        return $this->_tipo;
    }

    public function getCantidad() {
        return $this->_cantidad;
    }
    public function setCantidad($cantidad) {
        if (is_numeric($cantidad))
            $this->_cantidad = $cantidad;
    }

    public function __construct($sabor, $precio, $tipo, $cantidad, $imagen = null, $id = null) {
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_cantidad = $cantidad;

        $imagen !== null ? $this->_imagen = $imagen : self::guardarImagen($tipo, $sabor);

        $this->_id = $id;
        $id !== null && is_numeric($id) ? self::$_contadorId++ : $this->_id = self::$_contadorId++;
    }

    public function jsonSerialize() {
        return [
            "sabor" => $this->_sabor,
            "precio" => $this->_precio,
            "tipo" => $this->_tipo,
            "cantidad" => $this->_cantidad,
            "imagen" => $this->_imagen,
            "id" => $this->_id,
        ];
    }

    private function guardarImagen($tipo, $sabor) {
        if (isset($_FILES["imagen"]))
        {
            $nombreImagen = $tipo . "_" . $sabor . ".jpg";
            $this->_imagen = $nombreImagen;

            $destino = "imagenes/ImagenesDePizzas/" . $nombreImagen;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
        }
    }

    static function cargarLista() {
        $lista = [];

        $ruta = "./listados/Pizza.json";
        $manejador = new ManejadorArchivos($ruta);
        $lista = $manejador->Leer("Pizza");

        return $lista;
    }

    static function guardarLista($lista) {
        if (count($lista) > 0) {
            $ruta = "./listados/Pizza.json";
            $manejador = new ManejadorArchivos($ruta);
            $manejador->Guardar($lista);
        }
    }

    static function altaPizza($pizzaNueva, &$listaDePizzas) {
        $respuesta = "No se pudo hacer";

        if ($pizzaNueva->_id !== null && count($listaDePizzas) > 0)
        {
            $respuesta = "Ingresada";

            foreach ($listaDePizzas as $pizza) {
                if ($pizza->_sabor === $pizzaNueva->_sabor && $pizza->_tipo === $pizzaNueva->_tipo)
                {
                    $pizza->_precio = $pizzaNueva->_precio;
                    $pizza->_cantidad += $pizzaNueva->_cantidad;
                    $respuesta = "Actualizada";
                    break;
                }
            }
        }

        if ($respuesta === "Ingresada") {
            array_push($listaDePizzas, $pizzaNueva);
        }

        return $respuesta;
    }

    static function getPizzaPorSaborYTipo($sabor, $tipo, $lista) {
        $respuesta = null;

        foreach ($lista as $pizza) {
            if ($pizza->_sabor === $sabor && $pizza->_tipo === $tipo) {
                $respuesta = $pizza;
                break;
            }
        }

        return $respuesta;
    }

    static function consultarPizzaExistente($sabor, $tipo, $listaDePizzas) {
        $respuesta = "No hay de ese sabor ni tampoco de ese tipo";

        if (strlen($sabor) > 2 && ($tipo === "molde" || $tipo === "piedra") && count($listaDePizzas) > 0) {
            $saborExistente = false;
            $tipoExistente = false;
    
            foreach ($listaDePizzas as $pizza) {
                if ($pizza->getSabor() === $sabor) $saborExistente = true;
                if ($pizza->getTipo() === $tipo)   $tipoExistente = true;
            }

            if ($saborExistente && $tipoExistente)       $respuesta = "Si, hay de ese sabor y tipo";
            else if ($saborExistente && !$tipoExistente) $respuesta = "Hay de ese sabor, pero no de ese tipo";
            else if (!$saborExistente && $tipoExistente) $respuesta = "Hay de ese tipo, pero no de ese sabor";
        }
        return $respuesta;
    }
}
?>