<?php
class Nota {
    function __construct() {
        require_once('../Drivers/conexion.php');
        $this->conexion = new Conexion();
    }

    // Crear nota
    function guardar($titulo, $contenido, $fk_cita) {
        $consulta = "INSERT INTO nota (id, titulo, contenido, fk_cita) 
                     VALUES (NULL, '{$titulo}', '{$contenido}', '{$fk_cita}')";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Actualizar nota
    function actualizar($id, $titulo, $contenido) {
        $consulta = "UPDATE nota 
                     SET titulo = '{$titulo}', contenido = '{$contenido}'
                     WHERE id = {$id}";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Eliminar nota
    function eliminar($id) {
        $consulta = "DELETE FROM nota WHERE id = {$id}";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Consultar nota por id
    function consultar($id) {
        $consulta = "SELECT * FROM nota WHERE id = {$id}";
        $respuesta = $this->conexion->query($consulta);
        return $respuesta;
    }

    // Listar notas por cita (la que usa el formulario)
    function listarPorCita($fk_cita) {
        $consulta = "SELECT * FROM nota WHERE fk_cita = {$fk_cita} ORDER BY id DESC";
        $respuesta = $this->conexion->query($consulta);

        $notas = [];
        while ($fila = $respuesta->fetch_assoc()) {
            $notas[] = $fila;
        }

        return $notas;
    }
}
?>
