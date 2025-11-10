<?php 
    class Producto{
        function __construct() {
            require_once('./App/Drivers/conexion.php');
            $this->conexion = new Conexion();
        }
    

        function activos($fkCat){
            $consulta = "SELECT p.*, c.nombre AS categoria FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id WHERE p.fk_categoria = '{$fkCat}' AND p.estatus = 1;";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }
    }
?>