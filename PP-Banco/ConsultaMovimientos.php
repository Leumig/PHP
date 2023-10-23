<?php
if ($_SERVER["REQUEST_METHOD"] === "GET")
{
    if (isset($_GET["primerFecha"]) && isset($_GET["segundaFecha"]) && 
        isset($_GET["email"]) && isset($_GET["sabor"]))
    {
        if (strlen($_GET["email"]) > 2 && strlen($_GET["sabor"]) > 2 && 
            strlen($_GET["primerFecha"]) > 8 && strlen($_GET["segundaFecha"]) > 8)
        {
            require "./clases/Venta.php";
            
            // Consulta A
            $listaDeVentas = Venta::cargarLista();
            echo json_encode(["A)" => count($listaDeVentas)], JSON_PRETTY_PRINT);

            
            // Consulta B
            $listaEntreFechas = array_filter($listaDeVentas, function($venta) {
                $primerFecha = DateTime::createFromFormat("d-m-Y", $_GET["primerFecha"]);
                $segundaFecha = DateTime::createFromFormat("d-m-Y", $_GET["segundaFecha"]);
                $fechaDeVenta = DateTime::createFromFormat("d-m-Y", $venta->getFecha());
    
                return $fechaDeVenta > $primerFecha && $fechaDeVenta < $segundaFecha;
            });
             
            usort($listaEntreFechas, function($a, $b) {
                return strcmp($a->getSabor(), $b->getSabor());
            });
            echo json_encode(["B)" => $listaEntreFechas], JSON_PRETTY_PRINT);
    
    
            // Consulta C
            $listaDeVentasUsuario = array_filter($listaDeVentas, function($venta) {
                return $venta->getEmail() === $_GET["email"];
            });
            echo json_encode(["C)" => $listaDeVentasUsuario], JSON_PRETTY_PRINT);
    

            // Consulta D
            $listaDeVentasSabor = array_filter($listaDeVentas, function($venta) {
                return $venta->getSabor() === $_GET["sabor"];
            });
            echo json_encode(["D)" => $listaDeVentasSabor], JSON_PRETTY_PRINT);
        } else {
            echo json_encode(["error" => "Valores enviados por GET no validos"]);
        }
    } else {
        echo json_encode(["error" => "Parametros enviados por GET no validos"]);
    }
} else {
    echo json_encode(["error" => "Verbo HTTP erroneo. Debe ser GET"]);
}
?>