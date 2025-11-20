<?php
require_once('../Drivers/conexion.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_usuario = 0;
if (isset($_SESSION['usuario_id'])) {
    $id_usuario = $_SESSION['usuario_id'];
}

$conexion = new Conexion();

$sql = "SELECT * FROM cita WHERE idpaciente = $id_usuario";
$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Citas</title>
      <link rel="stylesheet" href="../../CSS/index.css">
    <link rel="stylesheet" href="../../CSS/gestion_result.css">
    <link rel="stylesheet" href="../../Components/Header/style.css">
    <link rel="stylesheet" href="../../CSS/historial_clinico_compras.css">
</head>
<body>
    <?php include '../../Components/Header/header_servicios.php'; ?>

<h1>Historial de Citas</h1>

<table>
    <thead>
        <tr>
            <th>ID Cita</th>
            <th>Motivo</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Nota</th>
        </tr>
    </thead>
    <tbody>

        <?php
        if ($resultado && $resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {

                if ($row['nota']) {
                    $nota = $row['nota'];
                } else {
                    $nota = 'Sin nota';
                }

                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['motivo'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['hora'] . "</td>";
                echo "<td>" . $nota . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5' class='center'>No hay citas registradas</td></tr>";
        }
        ?>

    </tbody>
</table>

</body>
</html>
