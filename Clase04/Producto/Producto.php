<?php
    class Producto implements JsonSerializable{
        private $_codigo;
        private $_nombre;
        private $_tipo;
        private $_stock;
        private $_precio;
        private $_id;

        public function getCodigo(){
            return $this->_codigo;
        }
        public function getStock(){
            return $this->_stock;
        }
        public function setStock($stock){
            if (is_numeric($stock))
                $this->_stock = $stock;
        }

        public function __construct($codigo, $nombre, $tipo, $stock, $precio, $id = null) {
            if (is_string($codigo) && strlen($codigo) === 6 && is_string($nombre) &&
             is_string($tipo) && is_numeric($stock) && is_numeric($precio))
            {
                $this->_codigo = $codigo;
                $this->_nombre = $nombre;
                $this->_tipo = $tipo;
                $this->_stock = $stock;
                $this->_precio = $precio;

                $this->_id = $id !== null && is_numeric($id)?$this->_id = $id:$this->_id = random_int(1, 10000);
            }
        }

        public function jsonSerialize() {
            return [
                "codigo" => $this->_codigo,
                "nombre" => $this->_nombre,
                "tipo" => $this->_tipo,
                "stock" => $this->_stock,
                "precio" => $this->_precio,
                "id" => $this->_id,
            ];
        }

        static function cargarLista(){
            $respuesta = array();

            if (file_exists("productos.json"))
            {
                $archivo = fopen("productos.json", "r");
                $datos = fread($archivo, 10000000);
                fclose($archivo);

                $lista = json_decode($datos);
    
                if ($lista !== null && count($lista) > 0)
                {
                    $lista = self::crearProductosPorStdClass($lista);
                    $respuesta = $lista;
                }
            }    

            return $respuesta;
        }

        static function guardarLista($lista) {
            $respuesta = false;

            if (count($lista) > 0)
            {
                $archivo = fopen("C:/xampp/htdocs/Clase04/productos.json", "w");

                $stringJSON = json_encode($lista, JSON_PRETTY_PRINT);

                if ($stringJSON != null)
                {
                    $respuesta = fputs($archivo, $stringJSON);
                }
                
                fclose($archivo);
            }

            return is_integer($respuesta);
        }

        static private function crearProductosPorStdClass($listaStd) {
            if ($listaStd !== null && count($listaStd) > 0)
            {
                $listaConvertida = array();

                foreach ($listaStd as $elementoStd) {
                    $productoNuevo = new Producto($elementoStd->codigo, $elementoStd->nombre, $elementoStd->tipo, $elementoStd->stock, $elementoStd->precio, $elementoStd->id);
                    
                    array_push($listaConvertida, $productoNuevo);
                }

                return $listaConvertida;
            }
        }

        static function altaProducto($productoNuevo, &$listaDeProductos) {
            $respuesta = "No se pudo hacer";

            if ($productoNuevo->_id !== null && $listaDeProductos !== null)
            {
                $respuesta = "Ingresado";

                foreach ($listaDeProductos as $producto) {
                    if ($producto->_codigo === $productoNuevo->_codigo)
                    {
                        $producto->_stock += $productoNuevo->_stock;
                        $respuesta = "Actualizado";
                        break;
                    }
                }
            }

            if ($respuesta === "Ingresado") {
                array_push($listaDeProductos, $productoNuevo);
            }

            return $respuesta;
        }

        static function getProductoPorCodigo($codigo, $lista)
        {
            $respuesta = null;

            foreach ($lista as $producto) {
                if ($producto->_codigo === $codigo)
                {
                    $respuesta = $producto;
                    break;
                }
            }

            return $respuesta;
        }
    }
?>