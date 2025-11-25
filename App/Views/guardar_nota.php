<?php
require_once "../Models/nota.php";
$nota = new Nota();

$fk_cita = $_POST["fk_cita"];

// NOTAS EXISTENTES A ELIMINAR
if (isset($_POST["eliminar"])) {
    foreach ($_POST["eliminar"] as $idEliminar) {
        $nota->eliminar($idEliminar);
    }
}

// RECORRER NOTAS
for ($i = 0; $i < count($_POST["titulo"]); $i++) {

    $id_nota = $_POST["id_nota"][$i];
    $titulo = $_POST["titulo"][$i];
    $contenido = $_POST["contenido"][$i];

    if ($id_nota == "") {
        // NUEVA
        $nota->guardar($titulo, $contenido, $fk_cita);
    } else {
        // EXISTENTE: ACTUALIZAR
        $nota->actualizar($id_nota, $titulo, $contenido);
    }
}

header("Location: ../Views/formulario_clinico.php?id_cita=" . $fk_cita);
?>