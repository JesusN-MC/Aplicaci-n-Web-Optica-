<?php
session_start();
$idUsuario = $_SESSION['usuario_id'];

require_once('../Drivers/conexion.php');
$conexion = new Conexion();

$fecha = $_GET["fecha"] ?? date("Y-m-d");

$consultaU = "SELECT id, nombre, apellidos FROM usuario WHERE id = $idUsuario";
$respuestaU = $conexion->query($consultaU);
$usuario = $respuestaU->fetch_assoc();

$constulaP = "SELECT id, nombres, apellidos FROM perfil WHERE fk_usuario = $idUsuario";
$respuestaP = $conexion->query($constulaP);

$horasPosibles = [
    "09:00", "10:00", "11:00",
    "12:00", "13:00", "16:00",
    "17:00", "18:00"
];

$consulta = "SELECT hora FROM cita WHERE fecha = '$fecha'";
$resultado = $conexion->query($consulta);

$horasOcupadas = [];
while ($fila = $resultado->fetch_assoc()) {

    // Convertir 10:00:00 → 10:00
    $horaNormalizada = date("H:i", strtotime($fila["hora"]));
    $horasOcupadas[] = $horaNormalizada;
}


// Deja solo las horas libres:
$horasDisponibles = array_values(array_diff($horasPosibles, $horasOcupadas));


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar una Cita</title>
    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/inputs.css">
    <link rel="stylesheet" href="../Components/Header/style.css">
    <link rel="stylesheet" href="../../Components/Productos_Filtro/style.css">

</head>
<body style="flex-direction: row; margin-top: 140px;">
     <?php include '../../Components/Header/header_servicios.php'; ?>
     <?php include '../../barraServicios.php'?>
     
    <div class="container" style="padding: 20px; padding-top:50px">
        <form action="../Drivers/fechas.php" method="POST" style="margin-bottom: 18px;">
                <div class="select-group">
            <?php
                
                $fechabase =  date("Y-m-d");

                $fecha = $_GET["fecha"] ?? date("Y-m-d");
                $proximas = [];
                for ($i = 1; $i <= 6; $i++) {
                    $nuevaFecha = date("Y-m-d", strtotime($fechabase . " + $i day"));
                    $proximas[] = $nuevaFecha;
                }
                echo '<select name="fecha" required onchange="this.form.submit()">';
                $selected ="";

                if($fecha == $fecha){
                    $selected = 'selected';
                }
                echo "<option value='$fechabase' $selected>$fechabase</option>";

                foreach ($proximas as $f)  {
                    $selected = ($f == $fecha) ? 'selected' : '';
                    echo "<option value='$f' $selected>$f</option>";
                }

                echo '</select>';
            ?>
            <label for="">Fecha</label>
            </div>
        </form>
        <form id="login-form" action="../Drivers/reservar_citas.php" method="POST">
            <input type="hidden" name="fecha" value="<?php echo $fecha; ?>">

            <div class="select-group">
            <?php
                echo '<select name="hora" required>';
                foreach ($horasDisponibles as $h) {
                echo "<option value='$h'>$h</option>";
                }
                echo '</select>';
            ?>
            <label>Horas disponibles</label>
            </div>


            <div class="input-group">
                <input type="text" name="motivo" id="nombre" required>
                <label for="motivo">Motivo</label> <br>
            </div>
            
            <div class="select-group">
                <Select name="paciente" required>
                    <option value="0-<?= $usuario['id'] ?>">
                        <?= $usuario['nombre'] . " " . $usuario['apellidos'] ?>
                    </option>

                    <?php while($fila = $respuestaP->fetch_assoc()) { ?>
                        <option value="1-<?= $fila['id'] ?>">
                            <?= $fila['nombres'] . " " . $fila['apellidos'] ?>
                        </option>
                    <?php } ?>
                </Select>
                <label for="">Seleccione al paciente</label>
            </div>


            <button type="submit">Reservar Cita</button>
            <button onclick="location.href='../../servicios.php'">Regresar</button>
      </form>
    </div>
</body>
</html>