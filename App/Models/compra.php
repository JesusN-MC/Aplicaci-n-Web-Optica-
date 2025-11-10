<?php
class Compra {
    function __construct() {
        require_once('../Drivers/conexion.php');
        $this->conexion = new Conexion();
    }

    // para guaardar una compra
    function guardar($id_producto, $fk_usuario, $cantidad, $fecha) {
        $consulta = "INSERT INTO compra (id_producto, fk_usuario, cantidad, fecha) 
                     VALUES ({$id_producto}, {$fk_usuario}, {$cantidad}, '{$fecha}')";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // para mostrar todas las compras de un usuario
    function mostrar($fk_usuario) {
        $consulta = "SELECT * FROM compra WHERE fk_usuario = {$fk_usuario}";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
}
?>


