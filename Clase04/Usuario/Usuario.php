<?php
    class Usuario implements JsonSerializable{
        private $_nombre;
        private $_clave;
        private $_email;
        private $_id;
        private $_fechaDeRegistro;
        private $_fotoDePerfil;

        public function getId(){
            return $this->_id;
        }

        public function __construct($nombre, $clave, $email, $foto, $id = null, $fechaDeRegistro = null) {
            if (is_string($nombre) && is_string($clave) && is_string($email))
            {
                $this->_nombre = $nombre;
                $this->_clave = $clave;
                $this->_email = $email;
                $this->_fotoDePerfil = $foto;
                self::guardarImagen();

                $this->_id = $id !== null && is_numeric($id)?$this->_id = $id:$this->_id = random_int(1, 10000);

                if ($fechaDeRegistro !== null)
                {
                    $this->_fechaDeRegistro = $fechaDeRegistro;
                } else {
                    $this->_fechaDeRegistro = date_format(new DateTime(), "d-m-Y");
                }
            }
        }

        public function jsonSerialize() {
            return [
                "nombre" => $this->_nombre,
                "clave" => $this->_clave,
                "email" => $this->_email,
                "id" => $this->_id,
                "fechaDeRegistro" => $this->_fechaDeRegistro,
                "fotoDePerfil" => $this->_fotoDePerfil,
                //Las keys se van a reflejar en el JSON con su value
            ];
        }

        public function mostrar() { 
            echo "ID: " . $this->_id . " - Nombre: " . $this->_nombre ." - Clave: " . $this->_clave . 
            " - Email: " . $this->_email . " - Fecha de Registro: " . $this->_fechaDeRegistro . 
            " - Foto de Perfil: " . $this->_fotoDePerfil;
            echo "</br>";
        }

        static function cargarLista(){
            $respuesta = array();

            if (file_exists("usuarios.json"))
            {
                $archivo = fopen("usuarios.json", "r");
                $datos = fread($archivo, 10000000);
                fclose($archivo);

                $lista = json_decode($datos);
    
                if ($lista !== null && count($lista) > 0)
                {
                    $lista = self::crearUsuariosPorStdClass($lista);
                    $respuesta = $lista;
                }
            }    

            return $respuesta;
        }

        static function guardarLista($lista){
            $respuesta = false;

            if (count($lista) > 0)
            {
                $archivo = fopen("C:/xampp/htdocs/Clase04/usuarios.json", "w");

                $stringJSON = json_encode($lista, JSON_PRETTY_PRINT);

                if ($stringJSON != null)
                {
                    $respuesta = fputs($archivo, $stringJSON);
                }
                
                fclose($archivo);
            }

            return is_integer($respuesta);
        }

        static private function guardarImagen(){
            if (isset($_FILES["foto"]))
            {
                $destino = "Usuario/fotos/" . $_FILES["foto"]["name"];
                move_uploaded_file($_FILES["foto"]["tmp_name"], $destino);
            }
        }

        static private function crearUsuariosPorStdClass($listaStd)
        {
            if ($listaStd !== null && count($listaStd) > 0)
            {
                $listaConvertida = array();

                foreach ($listaStd as $elementoStd) {
                    $instanciaNueva = new Usuario($elementoStd->nombre, $elementoStd->clave, $elementoStd->email, $elementoStd->fotoDePerfil, $elementoStd->id, $elementoStd->fechaDeRegistro);
                    
                    array_push($listaConvertida, $instanciaNueva);
                }

                return $listaConvertida;
            }
        }

        static function getUsuarioPorId($id, $lista)
        {      
            $respuesta = null;

            foreach ($lista as $usuario) {
                if ($usuario->_id == $id)
                {
                    $respuesta = $usuario;
                    break;
                }
            }

            return $respuesta;
        }
    }
?>