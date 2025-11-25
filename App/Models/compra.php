<?php
class Compra {
    function __construct() {
        require_once('../Drivers/conexion.php');
        $this->conexion = new Conexion();
    }

    function guardar($total, $id_producto, $fk_usuario) {
        $consulta = "INSERT INTO compra (id, total, fecha, hora, fk_usuario, fk_producto) VALUES (NULL, '{$total}', NOW(), CURTIME(), '{$fk_usuario}', '{$id_producto}')";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    function mostrar($fk_usuario) {
        $consulta = "SELECT * FROM compra WHERE fk_usuario = {$fk_usuario}";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    function comprasGenerales() {
        $consulta = "SELECT  c.id, p.nombre AS producto, u.nombre AS usuario, c.total, c.fecha, c.hora FROM compra c INNER JOIN producto p ON c.fk_producto = p.id INNER JOIN usuario u ON c.fk_usuario = u.id ORDER BY c.id DESC";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    function consultar($id){
        $consulta = "SELECT * FROM compra WHERE $id = {$id}";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }
}
?>


