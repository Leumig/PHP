<?php
class ManejadorArchivos {
    private $urlArchivo;

    public function __construct($urlArchivo) {
        $this->urlArchivo = $urlArchivo;
    }

    public function Leer($clase = null) { // Puede recibir o no el nombre de una clase
        $data = [];

        if (file_exists($this->urlArchivo)) {
            $jsonString = file_get_contents($this->urlArchivo);
            $data = json_decode($jsonString);

            // Si recibio una clase específica, convierte la data leída
            if ($clase !== null) $data = $this->ConvertirAClase($data, $clase);
        } 
        
        return $data;
    }

    public function Guardar($data) {
        $jsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($this->urlArchivo, $jsonString);
    }

    private function ConvertirAClase($dataSTD, $clase) {
        $listaConvertida = [];

        if ($dataSTD !== null && count($dataSTD) > 0 && is_string($clase))
        {
            $reflectionClass = new ReflectionClass($clase);
            $constructor = $reflectionClass->getConstructor();
            
            foreach ($dataSTD as $objetoSTD) {
                $valores = [];

                foreach ($constructor->getParameters() as $param) {
                    $param = $param->getName();
                    property_exists($objetoSTD, $param) ? $valores[] = $objetoSTD->$param : $valores[] = null;
                }

                $objetoConvertido = $reflectionClass->newInstanceArgs($valores);
                array_push($listaConvertida, $objetoConvertido);
            }
        }

        return $listaConvertida;
    }
}
?>