<?php

require_once('../Drivers/conexion.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conexion = new Conexion();

$id_usuario = $_SESSION['usuario_id'] ?? 0;
$rol_usuario = $_SESSION['rol'] ?? '';

if ($rol_usuario === 'admin') {
    $sql_pendientes = "
        SELECT 
            c.id AS cita_id,
            c.motivo,
            c.fecha,
            c.hora,
            c.estatus,
            u.nombre AS nombre_paciente,
            u.apellidos AS apellidos_paciente,
            n.contenido AS nota
        FROM cita c
        LEFT JOIN usuario u ON u.id = c.idpaciente
        LEFT JOIN nota n ON n.fk_cita = c.id
        WHERE c.estatus = '0'
        ORDER BY c.fecha ASC, c.hora ASC
    ";

    $sql_completadas = "
        SELECT 
            c.id AS cita_id,
            c.motivo,
            c.fecha,
            c.hora,
            c.estatus,
            u.nombre AS nombre_paciente,
            u.apellidos AS apellidos_paciente,
            n.contenido AS nota
        FROM cita c
        LEFT JOIN usuario u ON u.id = c.idpaciente
        LEFT JOIN nota n ON n.fk_cita = c.id
        WHERE c.estatus = '1'
        ORDER BY c.fecha ASC, c.hora ASC
    ";
} else {
    $sql_pendientes = "
        SELECT 
            c.id AS cita_id,
            c.motivo,
            c.fecha,
            c.hora,
            c.estatus,
            n.contenido AS nota,
            u.nombre AS nombre_paciente,
            u.apellidos AS apellidos_paciente
        FROM cita c
        LEFT JOIN nota n ON n.fk_cita = c.id
        LEFT JOIN usuario u ON u.id = c.idpaciente
        WHERE c.estatus = '0'
          AND (c.idpaciente = $id_usuario 
               OR c.idpaciente IN (SELECT id FROM perfil WHERE fk_usuario = $id_usuario))
        ORDER BY c.fecha ASC, c.hora ASC
    ";

    $sql_completadas = "
        SELECT 
            c.id AS cita_id,
            c.motivo,
            c.fecha,
            c.hora,
            c.estatus,
            n.contenido AS nota,
            u.nombre AS nombre_paciente,
            u.apellidos AS apellidos_paciente
        FROM cita c
        LEFT JOIN nota n ON n.fk_cita = c.id
        LEFT JOIN usuario u ON u.id = c.idpaciente
        WHERE c.estatus = '1'
          AND (c.idpaciente = $id_usuario 
               OR c.idpaciente IN (SELECT id FROM perfil WHERE fk_usuario = $id_usuario))
        ORDER BY c.fecha ASC, c.hora ASC
    ";
}

$pendientes = $conexion->query($sql_pendientes);
$completadas = $conexion->query($sql_completadas);

function mostrarTabla($resultado, $rol_usuario, $titulo)
{
    echo "<h2>$titulo</h2>";

    if (!$resultado || $resultado->num_rows == 0) {
        echo "<p style='opacity:.6'>No hay citas registradas</p>";
        return;
    }

    echo "<table class='tabla-usuarios'>
        <thead>
            <tr>";

    if ($rol_usuario === 'admin')
        echo "<th>Paciente</th>";

    echo "
                <th>ID</th>
                <th>Motivo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
    ";

    while ($row = $resultado->fetch_assoc()) {
        if ($row['estatus'] === '0') {
            $estado_texto = "Pendiente";
            $estado_clase = "estado-pendiente";
        } else {
            $estado_texto = "Completada";
            $estado_clase = "estado-completada";
        }

        if (!empty($row['nota'])) {
            $nota = $row['nota'];
        } else {
            $nota = "Sin nota";
        }

        echo "<tr>";

        if ($rol_usuario === 'admin') {
            $nombre = $row['nombre_paciente'] ?? "Desconocido";
            $apellidos = $row['apellidos_paciente'] ?? "";
            echo "<td>$nombre $apellidos</td>";
        }

        echo "
            <td>{$row['cita_id']}</td>
            <td>{$row['motivo']}</td>
            <td><img src='../../Assets/fecha.jfif' class='icono'> {$row['fecha']}</td>
            <td><img src='../../Assets/hora.jfif' class='icono'> {$row['hora']}</td>
            <td class='$estado_clase'>$estado_texto</td>
            <td>$nota</td>
        </tr>";
    }

    echo "</tbody></table>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historial de Citas</title>
<link rel="stylesheet" href="../../CSS/gestion_producto.css">
<link rel="stylesheet" href="../../CSS/gestion_perfiles_dependientes.css">
<style>
main { margin-top: 100px !important; }
.icono { width: 14px; height: 14px; margin-right: 4px; vertical-align: middle; }
.estado-pendiente { color: #FFC107; font-weight: bold; }
.estado-completada { color: #4CAF50; font-weight: bold; }
</style>
</head>
<body>
<?php include '../../Components/Header/header_servicios.php'; ?>
<main>
    <h1>Historial de Citas</h1>
    <?php
    mostrarTabla($pendientes, $rol_usuario, "Citas Pendientes");
    mostrarTabla($completadas, $rol_usuario, "Citas Completadas");
    ?>
</main>
</body>
</html>
