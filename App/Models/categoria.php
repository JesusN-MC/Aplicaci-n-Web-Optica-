<?php 
    class Categoria{
        function __construct() {
            require_once('../Drivers/conexion.php');
            $this->conexion = new Conexion();
        }
    
        function guardar($nombre){
            $consulta = "INSERT INTO categoria (id, nombre, estatus) VALUES (null, '{$nombre}', '1')";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        function mostrar(){
            $consulta = "SELECT * FROM categoria";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        function activas(){
            $consulta = "SELECT * FROM categoria WHERE estatus = 1";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        function deshabilitar($id){
            $consulta = "UPDATE categoria SET estatus = 0 WHERE id = '{$id}'";
            $respuesta = $this->conexion->query($consulta);
        }

        function habilitar($id){
            $consulta = "UPDATE categoria SET estatus = 1 WHERE id = '{$id}'";
            $respuesta = $this->conexion->query($consulta);
        }

        function actualizar($id, $nombre){
            $consulta = "UPDATE categoria SET nombre = '{$nombre}' WHERE id = '{$id}'";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        
    }
?>