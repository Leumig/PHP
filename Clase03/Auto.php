<?php
    class Auto{
        private $_color;
        private $_precio;
        private $_marca;
        private $_fecha;

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

        public function ToString(){
            if ($this->_marca !== null && $this->_color !== null)
            {
                $cadena = $this->_marca . "-" . $this->_color;
                if ($this->_precio !== null)
                    $cadena = $cadena . "-" . $this->_precio;
                if ($this->_fecha !== null)
                    $cadena = $cadena . "-" . date_format($this->_fecha, "d/m/Y");

                return $cadena;
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

        static function Alta($auto){
            if ($auto->_marca !== null && $auto->_color !== null) 
            {
                $archivo = fopen("C:/xampp/htdocs/Clase03/autos.csv", "a");
                fputcsv($archivo, 
                [$auto->_marca, $auto->_color,
                 $auto->_precio !== null ? $auto->_precio : "",
                 $auto->_fecha !== null ? $auto->_fecha->format('d/m/Y') : ""]);
                fclose($archivo);
            }
        }
        
        static function CargarLista($path){
            if (is_string($path) && strlen($path) > 1)
            {
                $archivo = fopen($path, "r");
                $lista = array();
                $encabezado = false;

                while (($datos = fgetcsv($archivo)) !== false)
                {
                    if (!$encabezado){
                        $encabezado = true;
                        continue;
                    }
                    
                    if (count($datos) >= 2)
                    {
                        $nuevoAuto = self::CrearPorDatos($datos);
                        array_push($lista, $nuevoAuto);
                    }
                }
        
                fclose($archivo);
                return $lista;
            }
            
            return [];
        }

        static function CrearPorDatos($datos){
            $marca = $datos[0];
            $color = isset($datos[1]) ? $datos[1] : null;
            $precio = isset($datos[2]) ? $datos[2] : null;
            $fecha = isset($datos[3]) ? DateTime::createFromFormat('d/m/Y', $datos[3]) : null;
            $nuevoAuto = new Auto($marca, $color, $precio, $fecha);

            return $nuevoAuto;
        }
    }
?>