<?php 
    class Producto{
        function __construct() {
            require_once('../Drivers/conexion.php');
            $this->conexion = new Conexion();
        }
    
        function guardar($nombre, $marca, $descripcion, $categoria, $precio, $stock, $foto){
            $consulta = "INSERT INTO producto (nombre, marca, descripcion, fk_categoria, precio, imagen_principal, stock, estatus) VALUES ('{$nombre}', '{$marca}', '{$descripcion}','{$categoria}', '{$precio}', '{$foto}', '{$stock}', 1) ";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        function activos($fkCat){
            $consulta = "SELECT p.*, c.nombre AS categoria FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id WHERE p.fk_categoria = '{$fkCat}' AND p.estatus = 1;";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        function mostrar(){
            $consulta = "SELECT p.*, c.nombre AS categoria FROM producto p INNER JOIN categoria c ON p.fk_categoria = c.id";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        function deshabilitar($id){
            $consulta = "UPDATE producto SET estatus = 0 WHERE id = '{$id}'";
            $respuesta = $this->conexion->query($consulta);
        }

        function habilitar($id){
            $consulta = "UPDATE producto SET estatus = 1 WHERE id = '{$id}'";
            $respuesta = $this->conexion->query($consulta);
        }

        function actualizar($id, $nombre){
            $consulta = "UPDATE categoria SET nombre = '{$nombre}' WHERE id = '{$id}'";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        
    }
?>