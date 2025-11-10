<?php
session_start(); 
require_once('../Models/perfil_dependiente.php');


$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$parentesco = $_POST['parentesco'];


$fk_usuario = $_SESSION['usuario_id']; 

$perfil = new PerfilDependiente();


$dep = $perfil->consultarDependiente($nombres, $apellidos, $fk_usuario);
if ($dep) {
    echo "<h3>Este dependiente ya está registrado</h3>
          <div class='center'>
              <a class='btn-green' href='../Views/formulario_perfil_dependiente.php'>Regresar</a>
          </div>";
    exit;
}


if ($perfil->guardar($nombres, $apellidos, $parentesco, $fk_usuario)) {
    echo "<h3>Dependiente registrado exitosamente</h3>
          <div class='center'>
              <a class='btn-green' href='../../index.php'>Volver al inicio</a>
          </div>";
} else {
    echo "<h3>Error al registrar el dependiente</h3>
          <div class='center'>
              <a class='btn-green' href='../Views/formulario_perfil_dependiente.php'>Intentar de nuevo</a>
          </div>";
}
?>
