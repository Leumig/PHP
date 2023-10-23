<?php
    include_once "Auto.php";

    class Garage{
        private $_razonSocial;
        private $_precioPorHora;
        private $_autos;

        public function __construct($razonSocial, $precioPorHora = null)
        {
            if (is_string($razonSocial) && strlen($razonSocial) > 2)
            {
                $this->_razonSocial = $razonSocial;
                $this->_autos = array();

                if (is_numeric($precioPorHora) && $precioPorHora >= 0)
                    $this->_precioPorHora = $precioPorHora;
            }
        }

        public function MostrarGarage(){
            echo "</br>*** Información del Garage ***</br>";
            echo "Razón Social: " . $this->_razonSocial . "</br>";
            if ($this->_precioPorHora !== null)
                echo "Precio por Hora: $" . $this->_precioPorHora . "</br>";
            else echo "Precio por Hora: no especificado</br>";    
                
            if (count($this->_autos) > 0)
            {
                echo "** Lista de Autos **</br>";
                foreach ($this->_autos as $auto) {
                    Auto::MostrarAuto($auto);
                }
            } else{
                echo "Este Garage está vacío</br>";
            }

            echo "</br>";
        }

        public function Equals($auto){
            return in_array($auto, $this->_autos);
        }

        public function Add($auto){
            if (!in_array($auto, $this->_autos))
                array_push($this->_autos, $auto);
            else 
                echo "El Garage ya tiene ese auto!</br>";
        }

        public function Remove($auto){
            if (in_array($auto, $this->_autos))
            {
                $indice = array_search($auto, $this->_autos);
                // unset($this->_autos[$indice]); //Borra el contenido y no reacomoda el array
                array_splice($this->_autos, $indice, 1); //Borra el contenido y reacomoda el array
            }
            else 
                echo "El Garage no tiene ese auto!</br>";
        }
    }
?>