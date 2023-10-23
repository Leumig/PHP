<?php

require "./ManejadorArchivos.php";

class ControllerEntidad {
    private $_nombre;
    private $_ruta;

    public function __construct($entidad, $ruta) {
        $this->_nombre = $entidad;
        $this->_ruta = $ruta;
    }

    public function cargarLista() {
        $lista = [];

        $manejador = new ManejadorArchivos($this->_ruta);
        $lista = $manejador->Leer($this->_nombre);

        return $lista;
    }

    public function guardarLista($lista) {
        if (count($lista) > 0) {
            $manejador = new ManejadorArchivos($this->_ruta);
            $manejador->Guardar($lista);
        }
    }

    





}



?>