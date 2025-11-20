<?php 
    class Cita{
        function __construct() {
            require_once('../Drivers/conexion.php');
            $this->conexion = new Conexion();
        }
    
        function guardar($motivo, $apellido, $fnac, $genero, $telefono, $correo, $pass){
            $consulta = "INSERT INTO cita (id, motivo, fecha, hora, estatus, idpaciente, tipo) VALUES (null, '{$motivo}', '{$apellido}', '{$fnac}', '{$estatus}', '{$idpaciente}', '{$tipo}')";
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