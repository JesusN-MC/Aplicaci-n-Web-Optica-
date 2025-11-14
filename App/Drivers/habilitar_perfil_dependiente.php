<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../Models/perfil_dependiente.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $modelo = new PerfilDependiente();
    $modelo->habilitar($id);

header("Location: ../../App/Views/listar_perfil_dependiente.php");

    exit();
} else {
    echo "ID no recibido";
}
?>
