<?php
    class Venta implements JsonSerializable{
        private $_codigoProducto;
        private $_idUsuario;
        private $_cantidadItems;
        private $_id;

        public function __construct($codigoProducto, $idUsuario, $cantidadItems, $id = null) {
            if (is_string($codigoProducto) && strlen($codigoProducto) === 6 && is_numeric($idUsuario) &&
            is_numeric($cantidadItems) && $cantidadItems > 0)
            {
                $this->_codigoProducto = $codigoProducto;
                $this->_idUsuario = $idUsuario;
                $this->_cantidadItems = $cantidadItems;

                $this->_id = $id !== null && is_numeric($id)?$this->_id = $id:$this->_id = random_int(1, 10000);
            }
        }

        public function jsonSerialize() {
            return [
                "producto" => $this->_codigoProducto,
                "usuario" => $this->_idUsuario,
                "cantidad" => $this->_cantidadItems,
                "id" => $this->_id,
            ];
        }

        static function cargarLista(){
            $respuesta = array();

            if (file_exists("ventas.json"))
            {
                $archivo = fopen("ventas.json", "r");
                $datos = fread($archivo, 10000000);
                fclose($archivo);

                $lista = json_decode($datos);
    
                if ($lista !== null && count($lista) > 0)
                {
                    $lista = self::crearVentasPorStdClass($lista);
                    $respuesta = $lista;
                }
            }    

            return $respuesta;
        }

        static function guardarLista($lista) {
            $respuesta = false;

            if (count($lista) > 0)
            {
                $archivo = fopen("C:/xampp/htdocs/Clase04/ventas.json", "w");

                $stringJSON = json_encode($lista, JSON_PRETTY_PRINT);

                if ($stringJSON != null)
                {
                    $respuesta = fputs($archivo, $stringJSON);
                }
                
                fclose($archivo);
            }

            return is_integer($respuesta);
        }

        static private function crearVentasPorStdClass($listaStd) {
            if ($listaStd !== null && count($listaStd) > 0)
            {
                $listaConvertida = array();

                foreach ($listaStd as $elementoStd) {
                    $instanciaNueva = new Venta($elementoStd->producto, $elementoStd->usuario, $elementoStd->cantidad, $elementoStd->id);
                    
                    array_push($listaConvertida, $instanciaNueva);
                }

                return $listaConvertida;
            }
        }

        static function realizarVenta($producto, $usuario, $cantidad, &$listaDeVentas) {
            $respuesta = "No se pudo hacer";

            if ($producto !== null && $usuario !== null && $producto->getStock() > 0 
                && is_numeric($cantidad) && $cantidad > 0)
            {
                if ($cantidad >= $producto->getStock())
                {
                    $cantidad = $producto->getStock();
                    // $producto->_stock = 0;
                    $producto->setStock(0);
                } else {
                    // $producto->_stock -= $cantidad;
                    $stock = $producto->getStock() - $cantidad;
                    $producto->setStock($stock);
                }
                //Reduzco el stock del producto recibido

                $nuevaVenta = new Venta($producto->getCodigo(), $usuario->getId(), $cantidad);
                array_push($listaDeVentas, $nuevaVenta);

                $respuesta = "Venta realizada";
            }

            return $respuesta;
        }
    }
?>