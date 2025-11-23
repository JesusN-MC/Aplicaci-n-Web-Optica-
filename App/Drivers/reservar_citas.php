<?php
    session_start();
$motivo = $_POST['motivo'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$idpaciente = $_POST['idpaciente'];
$tipo = $_POST['tipo'];  // este debe venir del formulario

include('../Models/cita.php');

$clase = new Cita();
$resultado = $clase->guardar($motivo, $fecha, $hora, $idpaciente, $tipo);

if ($resultado) {
    header("Cita reservada");
} else {
    echo "Error al reservar cita";
}
    
?>