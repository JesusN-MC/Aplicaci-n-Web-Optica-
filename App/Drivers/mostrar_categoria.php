<?php 
    class Categoria{
        function __construct() {
            require_once('./App/Drivers/conexion.php');
            $this->conexion = new Conexion();
        }

        function activas(){
            $consulta = "SELECT * FROM categoria WHERE estatus = 1";
            $respuesta = $this->conexion->query($consulta);
            return $respuesta;
        }
        public function buscarPorId($id) {
            return $this->conexion->query("SELECT * FROM categorias WHERE id = $id")->fetch_assoc();
        }

        
    }
?>