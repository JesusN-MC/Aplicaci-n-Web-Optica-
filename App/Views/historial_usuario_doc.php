<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../Drivers/conexion.php';
$conexion = new Conexion();

$sql = "
    SELECT 
        cita.id,
        usuario.nombre AS nombre_paciente,
        usuario.apellidos AS apellidos_paciente,
        cita.motivo,
        cita.fecha,
        cita.hora,
        cita.estatus,
        nota.contenido AS nota
    FROM cita
    INNER JOIN usuario ON usuario.id = cita.idpaciente
    LEFT JOIN nota ON nota.fk_cita = cita.id
    ORDER BY cita.fecha DESC, cita.hora DESC
";

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de citas - Doctor</title>

    <link rel="stylesheet" href="../../CSS/index.css">
    <link rel="stylesheet" href="../../CSS/gestion_result.css">
    <link rel="stylesheet" href="../../Components/Header/style.css">
    <link rel="stylesheet" href="../../CSS/historial_clinico_compras.css">
</head>
<body>

<?php include '../../Components/Header/header_servicios.php'; ?>

<main>
    <h1>Historial de citas de usuarios</h1>

    <section>
        <table>
            <thead>
                <tr>
                    <th>Paciente</th>
                    <th>Motivo</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {

                        if ($row['estatus'] == 1) {
                            $estado = "Activa";
                        } else {
                            $estado = "Finalizada";
                        }

                        if ($row['nota'] != "" && $row['nota'] !== null) {
                            $nota = $row['nota'];
                        } else {
                            $nota = "Sin nota";
                        }

                        echo '<tr>';
                        echo '<td>' . $row['nombre_paciente'] . ' ' . $row['apellidos_paciente'] . '</td>';
                        echo '<td>' . $row['motivo'] . '</td>';
                        echo '<td>' . $row['fecha'] . '</td>';
                        echo '<td>' . $row['hora'] . '</td>';
                        echo '<td>' . $estado . '</td>';
                        echo '<td>' . $nota . '</td>';
                        echo '<td><a href="detalle_cita.php?id=' . $row['id'] . '">Ver</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7" class="center">No hay citas registradas</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

</main>

</body>
</html>
