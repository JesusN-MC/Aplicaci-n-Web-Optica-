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
    <!-- <link rel="stylesheet" href="../../CSS/historial_clinico_compras.css"> -->
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
    <h1>Historial de citas de usuarios</h1>

    <section>
        <div class="categorias-container">
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

                
                $nombrePaciente = $row['nombre_paciente'] . ' ' . $row['apellidos_paciente'];
                $motivo = $row['motivo'];
                $fecha = $row['fecha'];
                $hora = $row['hora'];
                $estadoEsc = $estado;
                $notaEsc = $nota;
                $idCita = (int)$row['id'];

                
                echo '
                <a href="detalle_cita.php?id=' . $idCita . '">
                    <div class="product-card">
                        <h3>' . $nombrePaciente . '</h3>
                        <p>Motivo: ' . $motivo . '</p>
                        <p><img src="../../Assets/fecha.jfif" class="icono"> Fecha: ' . $fecha . '</p>
                        <p><img src="../../Assets/hora.jfif" class="icono"> Hora: ' . $hora . '</p>
                        <p>Estado: ' . $estadoEsc . '</p>
                        <p>' . $notaEsc . '</p>
                    </div>
                </a>';
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
