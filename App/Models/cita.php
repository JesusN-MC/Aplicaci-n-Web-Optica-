<?php 
    class Cita{
        function __construct() {
            require_once('../Drivers/conexion.php');
            $this->conexion = new Conexion();
        }
    
        function reservar_cita($motivo, $fecha, $hora, $idpaciente, $tipo){
            $estatus= 'A';
            $consulta = "INSERT INTO cita (id, motivo, fecha, hora, estatus, idpaciente, tipo) VALUES (null, '{$motivo}', '{$fecha}', '{$hora}', 0, '{$idpaciente}', '{$tipo}')";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        function mostrar(){
            $consulta = "SELECT * FROM cita";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }
    }
?>