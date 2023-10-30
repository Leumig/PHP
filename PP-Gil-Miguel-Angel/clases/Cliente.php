<?php

require_once "ManejadorArchivos.php";

class Cliente implements JsonSerializable{
    private $_nombre;
    private $_apellido;
    private $_tipoDocumento;
    private $_numeroDocumento;
    private $_email;
    private $_tipoCliente;
    private $_pais;
    private $_ciudad;
    private $_telefono;
    private $_estado;
    private $_modalidadPago;
    private $_imagen;
    private $_numeroCliente;
    private static $_contadorId = 100000;

    public function getTipoCliente() {
        return $this->_tipoCliente;
    }
    public function getNumeroCliente() {
        return $this->_numeroCliente;
    }

    public function __construct($nombre, $apellido, $tipoDocumento, $numeroDocumento, $email,
        $tipoCliente, $pais, $ciudad, $telefono, $estado = null, $modalidadPago = null, $imagen = null, $numeroCliente = null) {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_tipoDocumento = $tipoDocumento;
        $this->_numeroDocumento = $numeroDocumento;
        $this->_email = $email;
        $this->_tipoCliente = $tipoCliente;
        $this->_pais = $pais;
        $this->_ciudad = $ciudad;
        $this->_telefono = $telefono;
        $estado !== null ? $this->_estado = $estado : $this->_estado = "Activo";
        $modalidadPago !== null ? $this->_modalidadPago = $modalidadPago : $this->_modalidadPago = "Efectivo";

        $this->_numeroCliente = $numeroCliente;
        $numeroCliente !== null ? self::$_contadorId++ : $this->_numeroCliente = self::$_contadorId++;

        if ($imagen !== null) $this->_imagen = $imagen;
    }

    public function jsonSerialize() {
        return [
            "nombre" => $this->_nombre,
            "apellido" => $this->_apellido,
            "tipoDocumento" => $this->_tipoDocumento,
            "numeroDocumento" => $this->_numeroDocumento,
            "email" => $this->_email,
            "tipoCliente" => $this->_tipoCliente,
            "pais" => $this->_pais,
            "ciudad" => $this->_ciudad,
            "telefono" => $this->_telefono,
            "estado" => $this->_estado,
            "modalidadPago" => $this->_modalidadPago,
            "imagen" => $this->_imagen,
            "numeroCliente" => $this->_numeroCliente,
        ];
    }

    static function cargarLista() {
        $lista = [];

        $ruta = "./data/hoteles.json";
        $manejador = new ManejadorArchivos($ruta);
        $lista = $manejador->Leer("Cliente");

        return $lista;
    }

    static function guardarLista($lista) {
        if (count($lista) > 0) {
            $ruta = "./data/hoteles.json";
            $manejador = new ManejadorArchivos($ruta);
            $manejador->Guardar($lista);
        }
    }

    static function altaClienteNuevo($clienteNuevo, &$listaDeClientes) {
        $respuesta = "No se pudo hacer";

        if ($clienteNuevo->_numeroCliente !== null)
        {
            $respuesta = "Ingresada";

            foreach ($listaDeClientes as $cliente) {
                if ($cliente->_numeroDocumento == $clienteNuevo->_numeroDocumento &&
                    $cliente->_numeroCliente == $clienteNuevo->_numeroCliente) {
                    $respuesta = "Ya existe un cliente con ese numero y documento";
                }
            }

            if ($respuesta === "Ingresada") {
                array_push($listaDeClientes, $clienteNuevo);
                $clienteNuevo->guardarImagen();
            }
        }

        return $respuesta;
    }

    private function guardarImagen() {
        if (isset($_FILES["imagen"]))
        {
            $nombreImagen = $this->_numeroCliente . $this->_tipoCliente . ".jpg";
            $this->_imagen = $nombreImagen;

            $destino = "imagenes/ImagenesDeClientes/2023/" . $nombreImagen;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino);
        }
    }

    static function getClientePorNumero($numeroCliente, $lista) {
        $respuesta = null;

        foreach ($lista as $cliente) {
            if ($cliente->_numeroCliente == $numeroCliente) {
                $respuesta = $cliente;
                break;
            }
        }

        return $respuesta;
    }

    static function consultarClienteExistenteNuevo($documento, $numero, $listaDeClientes, &$bool = false) {
        $respuesta = "No hay un cliente con ese numero y documento";

        if (count($listaDeClientes) > 0) {
            foreach ($listaDeClientes as $cliente) {
                if ($cliente->_numeroCliente == $numero) {
                    if ($cliente->_numeroDocumento == $documento && $cliente->_estado == "Activo") {
                        $respuesta = "Pais: " . $cliente->_pais . " - Ciudad: " . $cliente->_ciudad
                        . " - Telefono: " . $cliente->_telefono;
                        $bool = true;
                    }
                    else {
                        $respuesta = "Existe el numero de cliente, pero no con ese documento";
                    }

                    break;
                }
            }
        }

        return $respuesta;
    }



    public function modificarCliente($nombre, $apellido, $tipoDocumento, $numeroDocumento, $email,
        $pais, $ciudad, $telefono) {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_tipoDocumento = $tipoDocumento;
        $this->_numeroDocumento = $numeroDocumento;
        $this->_email = $email;
        $this->_pais = $pais;
        $this->_ciudad = $ciudad;
        $this->_telefono = $telefono;
    }

    static function borrarCliente($numeroDocumento, $cliente, &$lista) {

        foreach ($lista as $cliente) {
            if ($cliente->_numeroDocumento == $numeroDocumento) {

                $cliente->_estado = "Eliminado";

                $ubicacionActual = "imagenes/ImagenesDeClientes/2023/" . $cliente->_imagen;
                $destino = "imagenes/ImagenesBackupClientes/2023/" . $cliente->_imagen;
        
                rename($ubicacionActual, $destino);
                break;
            }
        }
    }
}
?>