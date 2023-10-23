<?php
    class Auto{
        private $_color;
        private $_precio;
        private $_marca;
        private $_fecha;

        //Tengo la posibilidad de usar parámetros predeterminados (en este caso, precio y fecha)
        //O puedo tener un único __construct, y que ese constructor LLAME a otras funciones creadas por mí, entonces creo funciones Constructor1, Constructor2, etc, y hago que el __construct llame al que necesite, dependiendo de la cantidad de parámetros que recibió. Lo comprobaría con un IF.
        public function __construct($marca, $color, $precio = null, $fecha = null){
            if (is_string($marca) && is_string($color))
            {
                $this->_marca = $marca;
                $this->_color = $color;
                
                if (is_numeric($precio) && $precio >= 0)
                    $this->_precio = $precio;
                
                if ($fecha instanceof DateTime)    
                    $this->_fecha = $fecha;
            }
        }

        public function AgregarImpuestos($impuesto){
            if (is_numeric($impuesto))
                $this->_precio += $impuesto;
        }

        static function MostrarAuto($auto){
            if ($auto->_marca !== null && $auto->_color !== null)
            {
                echo "</br>*** Información del Auto ***</br>";
                echo "Marca: $auto->_marca</br>";
                echo "Color: $auto->_color</br>";
    
                if ($auto->_precio !== null)
                    echo "Precio: $" . $auto->_precio . "</br>";
                else echo "Precio: no especificado</br>";
    
                if ($auto->_fecha !== null)
                    echo "Fecha: " . $auto->_fecha->format("d/m/Y") . "</br>";
                else echo "Fecha: no especificada</br>";
                
                echo "</br>";
            }
        }

        public function Equals($auto){
            return $this->_marca === $auto->_marca;
        }

        static function Add($autoUno, $autoDos){
            if ($autoUno->_marca === $autoDos->_marca && $autoUno->_color === $autoDos->_color)
            {
                return (double) $autoUno->_precio + $autoDos->_precio;
            } else{
                echo "</br>Esos autos no son de la misma marca y color";
            }
        }
    }
?>