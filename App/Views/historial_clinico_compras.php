<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

    <!-- Historial de Citas -->
    <section>
        <h2>Historial de citas</h2>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Notas</th>
                    <th>Estado</th>
                    <th>Enlace</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../Models/cita.php';

                $cita = new Cita();
                $fk_usuario = $_SESSION['usuario_id'];
                $resultado = $cita->mostrar(); // Se muestra todo y se filtra por usuario si quieres agregar esa lógica más adelante

                if ($resultado) {
                    while ($row = $resultado->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['fecha'] . '</td>';
                        echo '<td>' . $row['notas'] . '</td>';
                        echo '<td>' . ($row['estatus'] == 1 ? 'Activa' : 'Finalizada') . '</td>';
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

    <!-- Historial de Compras -->
    <section>
        <h2>Historial de compras</h2>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Fecha</th>
                    <th>Cantidad</th>
                    <th>Enlace</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../Models/compra.php';

                $compra = new Compra();
                $fk_usuario = $_SESSION['usuario_id'];
                $resultado = $compra->mostrar($fk_usuario);

                if ($resultado) {
                    while ($row = $resultado->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['producto'] . '</td>';
                        echo '<td>' . $row['fecha'] . '</td>';
                        echo '<td>' . $row['cantidad'] . '</td>';
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
