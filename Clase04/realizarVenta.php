<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if (isset($_POST["codigoProducto"]) && isset($_POST["idUsuario"]) && isset($_POST["cantidadItems"]))
        {
            $codigoProducto = $_POST["codigoProducto"];
            $idUsuario = $_POST["idUsuario"];
            $cantidadItems = $_POST["cantidadItems"];

            require "./Producto/Producto.php";
            require "./Usuario/Usuario.php";
            require "./Venta/Venta.php";

            $listaDeProductos = Producto::cargarLista();
            $listaDeUsuarios = Usuario::cargarLista();
            $listaDeVentas = Venta::cargarLista();

            $productoNuevo = Producto::getProductoPorCodigo($codigoProducto, $listaDeProductos);
            $usuarioNuevo = Usuario::getUsuarioPorId($idUsuario, $listaDeUsuarios);

            $respuesta = Venta::realizarVenta($productoNuevo, $usuarioNuevo, $cantidadItems, $listaDeVentas);
            echo "Respuesta realizar Venta: " . $respuesta . "</br>";

            Producto::guardarLista($listaDeProductos); //Actualizo el stock del producto comprado en el JSON
            
            $respuesta = Venta::guardarLista($listaDeVentas) ? "TRUE" : "FALSE";
            echo "Se pudieron guardar las ventas: " . $respuesta;
        } else {
            echo "Datos enviados por POST no válidos";
        }
    } else {
        echo "Verbo HTTP erróneo. Debe ser POST";
    }
?>