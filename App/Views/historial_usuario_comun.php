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

$sql = "
    SELECT 
        cita.id,
        cita.motivo,
        cita.fecha,
        cita.hora,
        cita.estatus,
        nota.contenido AS nota
    FROM cita
    LEFT JOIN nota ON nota.fk_cita = cita.id
    WHERE cita.idpaciente = $id_usuario
    ORDER BY cita.fecha DESC, cita.hora DESC
";

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
    <link rel="stylesheet" href="../../CSS/productos.css">

<style>
    .categorias-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
    }

    .product-card {
        width: 250px;
        border-radius: 10px;
        padding: 15px;
        margin: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        transition: 0.2s;
        background: white;
    }

    .product-card h3 {
        font-size: 18px;
        margin-bottom: 8px;
    }

    .product-card p {
        margin: 3px 0;
        opacity: .85;
    }

    a {
        color: black;
        text-decoration: none;
    }

   
 .icono {
    width: 14px;
    height: 14px;
    max-width: 14px;
    max-height: 14px;
    min-width: 14px;
    min-height: 14px;
    /* object-fit: contain; */
    margin-right: 4px;
    vertical-align: middle;
}

</style>

</head>
<body>

<?php include '../../Components/Header/header_servicios.php'; ?>

<main>
    <h1>Historial de Citas</h1>

    <section>
        <div class="categorias-container">
        <?php
        if ($resultado && $resultado->num_rows > 0) {

            while ($row = $resultado->fetch_assoc()) {

                // 🔥 LO ÚNICO QUE FALTABA
                $fecha = $row['fecha'];
                $hora  = $row['hora'];

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

                echo '
                <div class="product-card">
                    <h3>Cita #' . $row['id'] . '</h3>
                    <p>Motivo: ' . $row['motivo'] . '</p>
                    <p><img src="../../Assets/fecha.jfif" class="icono"> Fecha: ' . $fecha . '</p>
                    <p><img src="../../Assets/hora.jfif" class="icono"> Hora: ' . $hora . '</p>
                    <p>Estado: ' . $estado . '</p>
                    <p>' . $nota . '</p>
                </div>
                ';
            }

        } else {
            echo '<p style="opacity:.6">No hay citas registradas</p>';
        }
        ?>
        </div>
    </section>

</main>

</body>
</html>
