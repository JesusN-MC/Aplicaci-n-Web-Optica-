<?php 
    class Usuario{
        function __construct() {
            require_once('../Drivers/conexion.php');
            $this->conexion = new Conexion();
        }
    
        function guardar($nombre, $apellido, $fnac, $genero, $telefono, $correo, $pass){
            $consulta = "INSERT INTO usuario (id, nombre, apellidos, fecha_nacimiento, genero, telefono, correo, contraseña) VALUES (null, '{$nombre}', '{$apellido}', '{$fnac}', '{$genero}', '{$telefono}','{$correo}', '{$pass}')";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        function mostrar(){
            $consulta = "SELECT * FROM usuario";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }

        
        function consultarCorreo($correo){
            $consulta = "SELECT * FROM usuario WHERE correo = '$correo'";
            $resultado = $this->conexion->query($consulta);

            if ($resultado && $resultado->num_rows > 0) {
                $usuario = $resultado->fetch_assoc();
                return $usuario; // devuelve los datos del usuario
            } else {
                return null; // no encontrado
            }
        }
    }
?>