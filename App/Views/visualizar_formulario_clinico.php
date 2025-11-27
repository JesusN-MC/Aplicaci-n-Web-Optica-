<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Óptica - Vista de Cita</title>
  <link rel="stylesheet" href="../../CSS/formulario_clinico.css">
  <link rel="stylesheet" href="../../Components/Header/style.css">
</head>
<body style="display:flex; justify-content:center; margin-top: 80px; padding-bottom: 40px; flex-direction: row;">

<?php include '../../Components/Header/header_servicios.php'; ?>
<?php include '../../barraServicios2.php'; ?>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_cita = isset($_GET["id_cita"]) ? intval($_GET["id_cita"]) : 0;

require_once "../Drivers/conexion.php";
$conexion = new Conexion();

require_once "../Models/Nota.php";
$notasObj = new Nota();
$notas = $notasObj->listarPorCita($id_cita);

$cita = null;
$paciente = null;
$es_dependiente = false;

$nombre_completo = "Sin información";
$edad = null;
$fecha_hora_text = "";
$motivo = "";
$descripcion = "";
$nombre_duenio = "";

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

        $tipo = trim((string)$cita['tipo']);
        $id_paciente = (int)$cita['idpaciente'];

        if ($tipo === '1') {
            $es_dependiente = true;
            $stmtP = $conexion->prepare("SELECT id, nombres, apellidos, parentesco, estatus, fk_usuario FROM perfil WHERE id = ?");
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

                    $stmtU2->close();
                }
            }
            $stmtP->close();
        } else {
            $stmtU = $conexion->prepare("SELECT id, nombre, apellidos, fecha_nacimiento, genero, telefono, correo FROM usuario WHERE id = ?");
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
            $stmtU->close();
        }
    }
    $stmt->close();
}
?>

<div class="container">

    <section class="appointment-info">
        <h2>Detalles de la Cita</h2>

        <div class="appointment-detail"><strong>Nombre:</strong> <span><?= htmlspecialchars($nombre_completo) ?></span></div>

        <?php if ($es_dependiente && !empty($nombre_duenio)): ?>
        <div class="appointment-detail"><strong>Usuario a cargo:</strong> <span><?= htmlspecialchars($nombre_duenio) ?></span></div>
        <?php endif; ?>

        <?php if (!$es_dependiente): ?>
        <div class="appointment-detail"><strong>Edad:</strong> <span><?= $edad !== null ? htmlspecialchars($edad . " años") : "<em>No disponible</em>" ?></span></div>
        <?php endif; ?>

        <?php if ($es_dependiente && !empty($paciente['parentesco'])): ?>
        <div class="appointment-detail"><strong>Parentesco:</strong> <span><?= htmlspecialchars($paciente['parentesco']) ?></span></div>
        <?php endif; ?>

        <div class="appointment-detail"><strong>Fecha y hora:</strong> <span><?= htmlspecialchars($fecha_hora_text ?: 'No disponible') ?></span></div>

        <div class="appointment-detail"><strong>Motivo:</strong> <span><?= htmlspecialchars($motivo ?: 'Sin motivo') ?></span></div>
    </section>

    <section class="notes-section">
        <div class="notes-header">
            <h3>Notas</h3>
        </div>

        <div id="notesList" style="margin-top:20px;">
            <?php if (!empty($notas)): ?>
                <?php foreach ($notas as $n): ?>
                    <div class="note readonly">
                        <div class="input-group">
                            <textarea rows="1" readonly><?= htmlspecialchars($n['titulo']) ?></textarea>
                            <label>Título</label>
                        </div>
                        <div class="input-group">
                            <textarea rows="2" readonly><?= htmlspecialchars($n['contenido']) ?></textarea>
                            <label>Contenido</label>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:#777;">No hay notas registradas.</p>
            <?php endif; ?>
        </div>

        <button class="btn" onclick="history.back()" style="margin-top:20px; background:#3498db;">Regresar</button>
    </section>

</div>
<script>document.addEventListener("DOMContentLoaded", () => {
    const groups = document.querySelectorAll(".input-group");

    groups.forEach(group => {
        const textarea = group.querySelector("textarea");
        const label = group.querySelector("label");

        if (!textarea || !label) return;

        // función para activar/desactivar el label
        const toggle = () => {
            if (textarea.value.trim() !== "") {
                label.classList.add("active");
            } else {
                label.classList.remove("active");
            }
        };

        // activar al cargar (para textos desde PHP)
        toggle();

        // activar al escribir
        textarea.addEventListener("input", toggle);
        textarea.addEventListener("focus", () => label.classList.add("active"));
        textarea.addEventListener("blur", toggle);
    });
});
</script>
<style>
    .input-group label.active {
    top: -10px;
    left: 8px;
    font-size: 0.8rem;
    color: var(--blue);
}

</style>
</body>
</html>
