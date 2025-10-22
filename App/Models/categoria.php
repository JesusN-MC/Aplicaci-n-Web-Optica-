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

        
    }
?>