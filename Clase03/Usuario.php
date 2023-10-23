<?php
    class Usuario {
        private $_nombre;
        private $_clave;
        private $_email;

        public function __construct($nombre, $clave, $email) {
            if (is_string($nombre) && is_string($clave) && is_string($email))
            {
                $this->_nombre = $nombre;
                $this->_clave = $clave;
                $this->_email = $email;
            }
        }

        public function mostrar() { 
            echo "Nombre: " . $this->_nombre ." - Clave: " . $this->_clave . " - Email: " . $this->_email;
            echo "</br>";
        }

        static function alta($usuario){
            $respuesta = "";
            if ($usuario->_clave !== null && $usuario->_clave !== null && $usuario->_clave !== null)
            {
                $archivo = fopen("C:/xampp/htdocs/Clase03/usuarios.csv", "a");
                $respuesta = fputcsv($archivo, [$usuario->_nombre, $usuario->_clave, $usuario->_email]);
                fclose($archivo);
            }

            return is_integer($respuesta);
        }

        static function cargarLista(){
            $respuesta = [];
            if (file_exists("usuarios.csv"))
            {
                $archivo = fopen("usuarios.csv", "r");
                $lista = array();
    
                while (($datos = fgetcsv($archivo)) !== false)
                {                   
                    if (count($datos) >= 3)
                    {
                        $nuevoUsuario = new Usuario($datos[0], $datos[1], $datos[2]);
                        array_push($lista, $nuevoUsuario);
                    }
                }
                
                fclose($archivo);
                $respuesta = $lista;
            }    

            return $respuesta;
        }

        static function comprobarLogin($lista, $clave, $email)
        {
            $mismaClave = false;
            $mismoEmail = false;
            
            $respuesta = "Usuario no registrado";

            foreach ($lista as $usuario) {
                if ($usuario->_clave === $clave)
                    $mismaClave = true;

                if ($usuario->_email === $email)
                    $mismoEmail = true;
            }

            if($mismaClave && $mismoEmail)
                $respuesta = "Verificado";

            if($mismoEmail && !$mismaClave)
                $respuesta = "Error en los datos";

            return $respuesta;
        }
    }
?>