<?php
	function Saludar() {    
		echo "Hola!";
	}

	class ClaseUno
	{
		// Atributos (private - protected- public/var - static)
		protected $_nombre;
		protected $_apellido;
		
		// Constructor
		public function __construct($_nombre, $_apellido) { 
			$this->_nombre = $_nombre;
			$this->_apellido = $_apellido;
		}
		
		// Métodos (private - protected- public/var - static)
		private function Func1($param) {
			echo "Esta es la función 1 y recibe un parámetro: $param";
		}
		protected function Func2() {
			echo "Esta es la función 2 </br>";
		}
		public function Func3() {
			echo "Esta es la función 3 </br>";
		}
	}

	$primerObjeto = new ClaseUno("Miguel", "Gil");

	var_dump($primerObjeto);
	echo "</br>";

	$primerObjeto->Func3();

	class ClaseBase {
		public $_id;
		public $_nombre;

		public function __construct($id, $nombre) {
			// Inicializar variables acá
			if ($this->validar($id)){
				$this->_id = $id;
				$this->_nombre = $nombre;
			}
		}
		public function validar($id){
			// Reliza una validación
			return true;
		}
	}

	class ClaseDerivada extends ClaseBase{
		public $_edad;

		public function __construct($id, $nombre, $edad){
			
			//Llamamos al constructor de la clase padre
			parent::__construct($id, $nombre);

			//Inicializamos las variables propias de esta clase
			$this->_edad = $edad;
		}
	}

	$segundoObjeto = new ClaseDerivada(2, "Juan", 20);

	var_dump($segundoObjeto);
	echo "</br>";
?>