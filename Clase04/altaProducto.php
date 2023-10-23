<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if (isset($_POST["codigo"]) && isset($_POST["nombre"]) 
            && isset($_POST["tipo"]) && isset($_POST["stock"]) && isset($_POST["precio"]))
        {
            $codigo = $_POST["codigo"];
            $nombre = $_POST["nombre"];
            $tipo = $_POST["tipo"];
            $stock = $_POST["stock"];
            $precio = $_POST["precio"];

            require "./Producto/Producto.php";

            $listaDeProductos = Producto::cargarLista();

            $productoNuevo = new Producto($codigo, $nombre, $tipo, $stock, $precio);
            
            $respuesta = Producto::altaProducto($productoNuevo, $listaDeProductos);
            echo "Respuesta del alta del Producto: " . $respuesta . "</br>";

            $respuesta = Producto::guardarLista($listaDeProductos) ? "TRUE" : "FALSE";
            echo "Se pudieron guardar los productos: " . $respuesta;
        } else {
            echo "Datos enviados por POST no válidos";
        }
    } else {
        echo "Verbo HTTP erróneo. Debe ser POST";
    }
?>