<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* id de la cita */
$id_cita = isset($_GET["id_cita"]) ? intval($_GET["id_cita"]) : 0;

/* Conexión */
require_once "../Drivers/conexion.php";
$conexion = new Conexion();

/* Modelo Nota */
require_once "../Models/Nota.php";
$notasObj = new Nota();
$notas = $notasObj->listarPorCita($id_cita);

/* Inicialización */
$cita = null;
$paciente = null;
$es_dependiente = false;

$nombre_completo = "Sin información";
$edad = null;
$fecha_hora_text = "";
$motivo = "";
$descripcion = "";
$nombre_duenio = ""; // ← NUEVO (solo para dependientes)

/* Obtener cita */
if ($id_cita > 0) {

    $stmt = $conexion->prepare("SELECT id, motivo, fecha, hora, estatus, idpaciente, tipo FROM cita WHERE id = ?");
    $stmt->bind_param("i", $id_cita);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {

        $cita = $res->fetch_assoc();
        $motivo = $cita['motivo'] ?? '';
        $fecha = $cita['fecha'] ?? '';
        $hora = isset($cita['hora']) ? substr($cita['hora'], 0, 5) : '';
        $fecha_hora_text = trim($fecha . ' ' . $hora);

        $tipo = isset($cita['tipo']) ? trim((string)$cita['tipo']) : '';
        $id_paciente = (int)$cita['idpaciente'];

        /* -------- PERFIL DEPENDIENTE -------- */
        if ($tipo === '1') {

            $es_dependiente = true;

            $stmtP = $conexion->prepare("SELECT id, nombres, apellidos, parentesco, estatus, fk_usuario 
                                         FROM perfil 
                                         WHERE id = ?");
            $stmtP->bind_param("i", $id_paciente);
            $stmtP->execute();
            $resP = $stmtP->get_result();

            if ($resP && $resP->num_rows > 0) {

                $perfil = $resP->fetch_assoc();
                $paciente = $perfil;

                $nombre_completo = trim(($perfil['nombres'] ?? '') . ' ' . ($perfil['apellidos'] ?? ''));

                if (!empty($perfil['parentesco'])) {
                    $descripcion = "Parentesco: " . $perfil['parentesco'];
                }

                /* === NUEVO: obtener nombre del usuario dueño === */
                if (!empty($perfil['fk_usuario'])) {

                    $fkuser = (int)$perfil['fk_usuario'];

                    $stmtU2 = $conexion->prepare("SELECT nombre, apellidos FROM usuario WHERE id = ?");
                    $stmtU2->bind_param("i", $fkuser);
                    $stmtU2->execute();
                    $resU2 = $stmtU2->get_result();

                    if ($resU2 && $resU2->num_rows > 0) {
                        $u = $resU2->fetch_assoc();
                        $nombre_duenio = trim(($u['nombre'] ?? '') . ' ' . ($u['apellidos'] ?? ''));
                    }

                    if (isset($stmtU2)) $stmtU2->close();
                }
            }

            if (isset($stmtP)) $stmtP->close();

        } 

        /* -------- USUARIO NORMAL -------- */
        else {

            $es_dependiente = false;

            $stmtU = $conexion->prepare("SELECT id, nombre, apellidos, fecha_nacimiento, genero, telefono, correo 
                                         FROM usuario 
                                         WHERE id = ?");
            $stmtU->bind_param("i", $id_paciente);
            $stmtU->execute();
            $resU = $stmtU->get_result();

            if ($resU && $resU->num_rows > 0) {

                $usuario = $resU->fetch_assoc();
                $paciente = $usuario;

                $nombre_completo = trim(($usuario['nombre'] ?? '') . ' ' . ($usuario['apellidos'] ?? ''));

                if (!empty($usuario['fecha_nacimiento']) && $usuario['fecha_nacimiento'] !== '0000-00-00') {
                    try {
                        $fn = new DateTime($usuario['fecha_nacimiento']);
                        $hoy = new DateTime();
                        $edad = $hoy->diff($fn)->y;
                    } catch (Exception $e) {
                        $edad = null;
                    }
                }

                if (!empty($usuario['telefono'])) {
                    $descripcion = "Tel: " . $usuario['telefono'];
                } elseif (!empty($usuario['correo'])) {
                    $descripcion = "Correo: " . $usuario['correo'];
                }
            }

            if (isset($stmtU)) $stmtU->close();
        }
    }

    if (isset($stmt)) $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Seguimiento de Cita</title>
  <link rel="stylesheet" href="../../CSS/formulario_clinico.css">
  <link rel="stylesheet" href="../../Components/Header/style.css">
</head>

<body style="display:flex; justify-content:center; margin-top: 80px; padding-bottom: 40px; flex-direction: row;">
    <?php include '../../Components/Header/header_servicios.php'; ?>
    <?php include '../../barraServicios2.php'?>

    <div class="container">

        <section class="appointment-info">
            <h2>Detalles de la Cita</h2>

            <div class="appointment-detail">
                <strong>Nombre:</strong>
                <span><?= htmlspecialchars($nombre_completo) ?></span>
            </div>

            <?php if ($es_dependiente && !empty($nombre_duenio)): ?>
            <div class="appointment-detail">
                <strong>Usuario a cargo:</strong>
                <span><?= htmlspecialchars($nombre_duenio) ?></span>
            </div>
            <?php endif; ?>

            <?php if (!$es_dependiente): ?>
            <div class="appointment-detail">
                <strong>Edad:</strong>
                <span><?= $edad !== null ? htmlspecialchars($edad . " años") : "<em>Edad no disponible</em>" ?></span>
            </div>
            <?php endif; ?>

            <?php if ($es_dependiente && !empty($paciente['parentesco'])): ?>
            <div class="appointment-detail">
                <strong>Parentesco:</strong>
                <span><?= htmlspecialchars($paciente['parentesco']) ?></span>
            </div>
            <?php endif; ?>

            <div class="appointment-detail">
                <strong>Fecha y hora:</strong>
                <span><?= htmlspecialchars($fecha_hora_text ?: 'No disponible') ?></span>
            </div>

            <div class="appointment-detail">
                <strong>Motivo:</strong>
                <span><?= htmlspecialchars($motivo ?: 'Sin motivo') ?></span>
            </div>
        </section>

        <section class="notes-section">
            <div class="notes-header">
                <h3>Notas de Seguimiento</h3>
                <button type="button" class="btn" id="addNote">+ Agregar nota</button>
            </div>

            <form action="guardar_nota.php" method="POST">
                <input type="hidden" name="fk_cita" value="<?= htmlspecialchars($id_cita) ?>">

                <div id="notesList"></div>

                <!-- GUARDAR NORMAL -->
                <button class="btn" 
                        style="margin-top:20px;" 
                        type="submit"
                        name="accion"
                        value="guardar">
                    Guardar cambios
                </button>

                <!-- GUARDAR Y COMPLETAR -->
                <button class="btn" 
                        style="margin-top:20px; margin-left:20px; background:#f1c40f;" 
                        type="submit"
                        name="accion"
                        value="completar">
                    Completar Cita
                </button>

            </form>
        </section>

    </div>

<script>
/* (tu script permanece igual, sin tocar estilos ni estructura) */
const notesList = document.getElementById("notesList");
const addNoteBtn = document.getElementById("addNote");

function autoGrow(textarea) {
    textarea.style.height = "auto";
    textarea.style.height = textarea.scrollHeight + "px";
}

function createNoteElement(id = "", title = "", content = "") {
    const note = document.createElement("div");
    note.classList.add("note");

    note.innerHTML = `
        <input type="hidden" name="id_nota[]" value="${id}">
        <div class="input-group">
            <textarea name="titulo[]" rows="1" required>${title}</textarea>
            <label>Título</label>
        </div>
        <div class="input-group">
            <textarea name="contenido[]" rows="2" required>${content}</textarea>
            <label>Contenido</label>
        </div>
        <div class="actions">
            <button type="button" class="btn btn-delete">Eliminar nota</button>
        </div>
    `;

    note.querySelectorAll("textarea").forEach(area => {
        area.addEventListener("input", () => autoGrow(area));
        autoGrow(area);
    });

    note.querySelector(".btn-delete").addEventListener("click", () => {
        if (id !== "") {
            const hidden = document.createElement("input");
            hidden.type = "hidden";
            hidden.name = "eliminar[]";
            hidden.value = id;
            notesList.appendChild(hidden);
        }
        note.remove();
        checkEmpty();
    });

    notesList.appendChild(note);
}

function checkEmpty() {
    if (notesList.children.length === 0) {
        createNoteElement("", "", "");
    }
}

window.addEventListener("DOMContentLoaded", () => {
    const notasBD = <?= json_encode($notas, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    if (Array.isArray(notasBD) && notasBD.length > 0) {
        notasBD.forEach(n => createNoteElement(n.id, n.titulo, n.contenido));
    } else {
        createNoteElement("", "", "");
    }
});

addNoteBtn.addEventListener("click", () => {
    createNoteElement("", "", "");
});
</script>

</body>
</html>
