<?php
    $motivo = $_POST['motivo'];
    //$fecha= $_POST['fecha'];
    //$hora =  $_POST['hora'];
    //$estatus =  $_POST['estatus'];
    $idpaciente =  $_POST['idpaciente'];
    $tipo = $_POST['tipo'];
    include('../Models/cita.php');
    $clase = new Cita();
    $resultado= $clase->guardar($motivo, $username, $pass, $correo, $foto, $tipo);
?>