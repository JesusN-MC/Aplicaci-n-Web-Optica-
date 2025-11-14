<?php
    $nombre = $_POST['nombre'];
    $apellido= $_POST['apellido'];
    $fnac =  $_POST['fnac'];
    $genero =  $_POST['genero'];
    $telefono =  $_POST['telefono'];
    $correo = $_POST['correo'];
    $pass= $_POST['pass'];
    
    include('../Models/usuario.php');
    $clase = new Usuario();
    $resultado = $clase->actualizar($nombre, $apellido, $fnac, $genero, $telefono, $correo, $pass, $id);

    


?>