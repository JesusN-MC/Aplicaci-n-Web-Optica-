<?php
require_once "../Models/nota.php";
$nota = new Nota();

$fk_cita = $_POST["fk_cita"];
$accion = $_POST["accion"] ?? "guardar"; // saber qué botón se presionó

// -------------------------------
// 1. ELIMINAR NOTAS
// -------------------------------
if (!empty($_POST["eliminar"])) {
    foreach ($_POST["eliminar"] as $idEliminar) {
        $nota->eliminar($idEliminar);
    }
}

// -------------------------------
// 2. GUARDAR / ACTUALIZAR NOTAS
// -------------------------------
if (!empty($_POST["titulo"])) {

    for ($i = 0; $i < count($_POST["titulo"]); $i++) {

        $id_nota   = $_POST["id_nota"][$i];
        $titulo    = $_POST["titulo"][$i];
        $contenido = $_POST["contenido"][$i];

        if ($id_nota == "") {
            // NUEVA NOTA
            $nota->guardar($titulo, $contenido, $fk_cita);
        } else {
            // EXISTENTE — ACTUALIZAR
            $nota->actualizar($id_nota, $titulo, $contenido);
        }
    }
}

// -------------------------------
// 3. REDIRECCIONAR SEGÚN LO QUE PIDAN
// -------------------------------
if ($accion === "completar") {
    header("Location: ../Drivers/completar_cita.php?id=" . $fk_cita);
    exit();
}

// Si solo guardó:
header("Location: ../Views/formulario_clinico.php?id_cita=" . $fk_cita);
exit();
?>
