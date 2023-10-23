<?php
    /***********************************************************************************************************
    Aplicación 17 (Auto)
    Realizar una clase llamada “Auto” que posea los siguientes atributos privados:

    _color (String)
    _precio (Double)
    _marca (String).
    _fecha (DateTime)

    Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:

    i. La marca y el color.
    ii. La marca, color y el precio.
    iii. La marca, color, precio y fecha.

    Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un doble por
    parámetro y que se sumará al precio del objeto.
    Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto” por
    parámetro y que mostrará todos los atributos de dicho objeto.
    Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo
    devolverá TRUE si ambos “Autos” son de la misma marca.
    Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son de la
    misma marca, y del mismo color, de lo contrario informarlo) y que retorne un Double con la suma
    de los precios o cero si no se pudo realizar la operación.
    Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);
    En testAuto.php:
    * Crear dos objetos “Auto” de la misma marca y distinto color.
    * Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
    * Crear un objeto “Auto” utilizando la sobrecarga restante.
    * Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500 al
    atributo precio.
    * Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el resultado
    obtenido.
    * Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o no.
    * Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3, 5)
    ***********************************************************************************************************/
    
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
                    echo "Precio: $$auto->_precio</br>";
                else echo "Precio: no especificado</br>";
    
                if ($auto->_fecha !== null)
                    echo "Fecha: " . $auto->_fecha->format("d/m/Y") . "</br>";
                else echo "Fecha: no especificada</br>";
                
                echo "</br>";
            }
        }

        public function Equals($auto){
            return $this === $auto;
        }

        static function Add($autoUno, $autoDos){
            if ($autoUno->_marca === $autoDos->_marca && $autoUno->_color === $autoDos->_color){
                return (double) $autoUno->_precio + $autoDos->_precio;
            } else{
                echo "</br>Esos autos no son de la misma marca y color";
                return 0;
            }
        }
    }

    $autoUno = new Auto("Ford", "Rojo");
    $autoDos = new Auto("Chevrolet", "Amarillo", 1200000);
    $autoTres = new Auto("BMW", "Negro", 3450000, new DateTime("2008-07-12"));
    $autoCuatro = new Auto("Fiat", "Gris", 50000);
    $autoCinco = new Auto("Fiat", "Gris", 20000);
    $autoSeis = new Auto("Fiat", 25000, 475000, new DateTime("1994-03-27")); //Mal apropósito

    $autoDos->AgregarImpuestos(85000);

    Auto::MostrarAuto($autoUno);
    Auto::MostrarAuto($autoDos);
    Auto::MostrarAuto($autoTres);
    Auto::MostrarAuto($autoSeis);

    $resultadoUno = $autoTres->Equals($autoTres);
    echo $resultadoUno? "TRUE": "FALSE";

    echo "</br>";

    $resultadoDos = $autoTres->Equals($autoDos);
    echo $resultadoDos? "TRUE": "FALSE";

    $importeDouble = Auto::Add($autoCuatro, $autoCinco);
    echo "</br>" . $importeDouble;
?>