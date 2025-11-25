<?php
    session_start();
$motivo = $_POST['motivo'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$idpaciente = $_POST['idpaciente'];
$tipo = $_POST['tipo'];

include('../Models/cita.php');

$clase = new Cita();
$resultado = $clase->reservar_cita($motivo, $fecha, $hora, $idpaciente, $tipo);

if ($resultado) {
    header("Location: ../../servicios.php");
} else {
    echo "Error al reservar cita";
}
    
?>