<?php
    /***********************************************************************************************************
    Aplicación 18 (Auto - Garage)
    Crear la clase Garage que posea como atributos privados:
    
    _razonSocial (String)
    _precioPorHora (Double)
    _autos (Autos[], reutilizar la clase Auto del ejercicio anterior)
    
    Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:
    
    i. La razón social.
    ii. La razón social, y el precio por hora.
    
    Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y que
    mostrará todos los atributos del objeto.
    Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un
    objeto de tipo Auto. Sólo devolverá TRUE si el auto está en el garaje.
    Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage” (sólo si
    el auto no está en el garaje, de lo contrario informarlo).
    Ejemplo: $miGarage->Add($autoUno);
    Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del “Garage”
    (sólo si el auto está en el garaje, de lo contrario informarlo).
    Ejemplo: $miGarage->Remove($autoUno);
    En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los métodos.
    ***********************************************************************************************************/
    
    /*
    include_once "Auto.php";

    class Garage{
        private $_razonSocial;
        private $_precioPorHora;
        private $_autos;

        public function __construct($razonSocial, $precioPorHora = null)
        {
            if (is_string($razonSocial) && strlen($razonSocial) > 3)
            {
                $this->_razonSocial = $razonSocial;

                if (is_numeric($precioPorHora))
                {
                    $this->_precioPorHora = $precioPorHora;
                }

                $this->_autos = array();
            }
        }

        public function MostrarGarage(){
            echo "</br>*** Información del Garage ***</br>";
            echo "Razón Social: $this->_razonSocial</br>";
            if ($this->_precioPorHora !== null)
                echo "Precio por Hora: $$this->_precioPorHora</br>";
            else echo "Precio por Hora: no especificado</br>";    
                
            if (count($this->_autos) > 0)
            {
                echo "*** Lista de Autos ***</br>";
                foreach ($this->_autos as $auto) {
                    Auto::MostrarAuto($auto);
                }
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
                echo "El garaje ya tiene ese auto!</br>";
        }

        public function Remove($auto){
            if (in_array($auto, $this->_autos))
            {
                $indice = array_search($auto, $this->_autos);
                unset($this->_autos[$indice]);
            }
            else 
                echo "El garaje no tiene ese auto!</br>";
        }
    }
    */
?>