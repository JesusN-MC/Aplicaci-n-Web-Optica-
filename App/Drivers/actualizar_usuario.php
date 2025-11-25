<?php
    if (session_status() === PHP_SESSION_NONE) {
            
        session_start();
    }
    $id = $_SESSION['usuario_id'];
    $nombre = $_POST['nombre'];
    $apellido= $_POST['apellido'];
    $fnac =  $_POST['fnac'];
    $genero =  $_POST['genero'];
    $telefono =  $_POST['telefono'];
    $correo = $_POST['correo'];
    $pass= $_POST['pass'];
    
    include('../Models/usuario.php');
    $clase = new Usuario();
    $resultado = $clase->actualizar($nombre, $apellido, $fnac, $genero, $telefono, $correo, $pass);

    
if ($resultado) {
    $_SESSION['usuario_nombre'] = $nombre;
    $_SESSION['usuario_apellido'] = $apellido;
    $_SESSION['usuario_fnac'] = $fnac;
    $_SESSION['usuario_genero'] = $genero;
    $_SESSION['usuario_telefono'] = $telefono;
    $_SESSION['usuario_correo'] = $correo;
    $_SESSION['usuario_pass'] = $pass;
    header("Location: ../Views/editar_usuario.php");
    
    
    #echo "Datos actualizados con éxito.";
} else {
    // Si hay un error, mostrar mensaje
    echo "Hubo un error al actualizar los datos.";
}


?>