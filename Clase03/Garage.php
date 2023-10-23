<?php
    include_once "Auto.php";

    class Garage{
        private $_razonSocial;
        private $_precioPorHora;
        private $_autos;

        public function __construct($razonSocial, $precioPorHora = null, $listaDeAutos = null)
        {
            if (is_string($razonSocial) && strlen($razonSocial) > 2)
            {
                $this->_razonSocial = $razonSocial;
                $this->_autos = array();

                if (is_numeric($precioPorHora) && $precioPorHora >= 0)
                    $this->_precioPorHora = $precioPorHora;

                if (is_array($listaDeAutos) && count($listaDeAutos) > 0)
                    $this->_autos = $listaDeAutos;
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

        static function Alta($garage){
            if ($garage->_razonSocial !== null) 
            {
                $archivo = fopen("C:/xampp/htdocs/Clase03/garages.csv", "a");
                fputcsv($archivo, 
                [$garage->_razonSocial,
                 $garage->_precioPorHora !== null ? $garage->_precioPorHora : "",
                 count($garage->_autos) > 0 ? $garage->GetListaDeAutos() : ""]);
                fclose($archivo);
            }
        }

        private function GetListaDeAutos(){
            $listaString = "";
            foreach ($this->_autos as $auto) {
                $listaString = $listaString . $auto->ToString();
                $listaString = $listaString . "*";
            }

            return $listaString;
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
                    
                    if (count($datos) >= 1)
                    {
                        $nuevoGarage = self::CrearPorDatos($datos);
                        array_push($lista, $nuevoGarage);
                    }
                }
        
                fclose($archivo);
                return $lista;
            }
            
            return [];
        }

        private static function CrearPorDatos($datos){
            $razonSocial = $datos[0];
            $precioPorHora = isset($datos[1]) ? $datos[1] : null;
            if (isset($datos[2]))
            {
                $autosString = explode("*", $datos[2]);
                $listaDeAutos = array();
                foreach ($autosString as $autoString) {
                    $datosAuto = explode("-", $autoString);
                    $nuevoAuto = Auto::CrearPorDatos($datosAuto);
                    array_push($listaDeAutos, $nuevoAuto);
                }
            } else {
                $listaDeAutos = null;
            }

            $nuevoGarage = new Garage($razonSocial, $precioPorHora, $listaDeAutos);
            return $nuevoGarage;
        }
    }
?>