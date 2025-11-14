<?php
class PerfilDependiente {

    private $conexion;

    function __construct() {
        require_once('../Drivers/conexion.php');
        $this->conexion = new Conexion();
    }

    function guardar($nombres, $apellidos, $parentesco, $fk_usuario) {
        $consulta = "INSERT INTO perfil (nombres, apellidos, parentesco, estatus, fk_usuario) 
                     VALUES ('{$nombres}', '{$apellidos}', '{$parentesco}', 'A', {$fk_usuario})";
        return $this->conexion->query($consulta);
    }

    function consultarDependiente($nombres, $apellidos, $fk_usuario) {
        $consulta = "SELECT * FROM perfil 
                     WHERE nombres = '{$nombres}' 
                     AND apellidos = '{$apellidos}' 
                     AND fk_usuario = {$fk_usuario}";
        $resultado = $this->conexion->query($consulta);

        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        } else {
            return null;
        }
    }

    function mostrar($fk_usuario) {
        $consulta = "SELECT * FROM perfil 
                     WHERE fk_usuario = {$fk_usuario}";
        return $this->conexion->query($consulta);
    }
function buscarPorId($id) {
    $consulta = "SELECT * FROM perfil WHERE id = {$id}";
    $resultado = $this->conexion->query($consulta);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    } else {
        return null;
    }
}

function actualizar($id, $nombres, $apellidos, $parentesco) {
    $consulta = "UPDATE perfil 
                 SET nombres = '{$nombres}',
                     apellidos = '{$apellidos}',
                     parentesco = '{$parentesco}'
                 WHERE id = {$id}";
    return $this->conexion->query($consulta);
}
function deshabilitar($id) {
    $consulta = "UPDATE perfil SET estatus = 'I' WHERE id = {$id}";
    return $this->conexion->query($consulta);
}

function habilitar($id) {
    $consulta = "UPDATE perfil SET estatus = 'A' WHERE id = {$id}";
    return $this->conexion->query($consulta);
}



}
?>
