<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../Drivers/conexion.php';
$conexion = new Conexion();

$fk_usuario = $_SESSION['usuario_id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial clínico y de compras</title>

    <link rel="stylesheet" href="../../CSS/index.css">
    <link rel="stylesheet" href="../../CSS/gestion_result.css">
    <link rel="stylesheet" href="../../Components/Header/style.css">
    <link rel="stylesheet" href="../../CSS/historial_clinico_compras.css">
</head>
<body>

<?php include '../../Components/Header/header_servicios.php'; ?>

<main>
    <h1>Historial clínico y de compras</h1>

    <section>
        <h2>Historial de citas</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Nota</th>
                    <th>Estado</th>
                    <th>Enlace</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $citasSql = "
                    SELECT cita.id, cita.fecha, cita.estatus, nota.contenido AS nota
                    FROM cita
                    LEFT JOIN nota ON nota.fk_cita = cita.id
                    WHERE cita.idpaciente = $fk_usuario
                ";

                $resultadoCitas = $conexion->query($citasSql);

                if ($resultadoCitas && $resultadoCitas->num_rows > 0) {
                    while ($row = $resultadoCitas->fetch_assoc()) {

                        $estado = ($row['estatus'] == 1) ? 'Activa' : 'Finalizada';
                        $nota = $row['nota'] ? $row['nota'] : 'Sin nota';

                        echo '<tr>';
                        echo '<td>' . $row['fecha'] . '</td>';
                        echo '<td>' . $nota . '</td>';
                        echo '<td>' . $estado . '</td>';
                        echo '<td><a href="detalle_cita.php?id=' . $row['id'] . '">Ver</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4" class="center">No hay citas registradas</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2>Historial de compras</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Enlace</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $comprasSql = "
                    SELECT compra.id, producto.nombre AS producto, compra.fecha, compra.total
                    FROM compra
                    INNER JOIN producto ON compra.fk_producto = producto.id
                    WHERE compra.fk_usuario = $fk_usuario
                 ";

                $resultadoCompras = $conexion->query($comprasSql);

                if ($resultadoCompras && $resultadoCompras->num_rows > 0) {
                    while ($row = $resultadoCompras->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['producto'] . '</td>';
                        echo '<td>' . $row['fecha'] . '</td>';
                        echo '<td>$' . $row['total'] . '</td>';
                        echo '<td><a href="detalle_compra.php?id=' . $row['id'] . '">Ver</a></td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4" class="center">No hay compras registradas</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

</main>

</body>
</html>
