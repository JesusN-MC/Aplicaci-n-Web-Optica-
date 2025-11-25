<?php
session_start();
$idUsuario = $_SESSION['usuario_id'];

require_once('../Drivers/conexion.php');
$conexion = new Conexion();

$consultaU = "SELECT id, nombre, apellidos FROM usuario WHERE id = $idUsuario";
$respuestaU = $conexion->query($consultaU);
$usuario = $respuestaU->fetch_assoc();

$constulaP = "SELECT id, nombres, apellidos FROM perfil WHERE fk_usuario = $idUsuario";
$respuestaP = $conexion->query($constulaP);

// horas disponibles
$horasPosibles = [
    "09:00", "10:00", "11:00",
    "12:00", "13:00", "16:00",
    "17:00", "18:00"
];

$fechas = [];
for ($i = 0; $i < 7; $i++) {
    $fechas[] = date("Y-m-d", strtotime("+$i days"));
}

$fechasDisponibles = [];

foreach ($fechas as $fecha) {

    // horas ocupadas para esta fecha
    $consultaH = "SELECT hora FROM cita WHERE fecha = '$fecha'";
    $respuestaH = $conexion->query($consultaH);

    $horasOcupadas = [];
    while ($fila = $respuestaH->fetch_assoc()) {
        $horasOcupadas[] = $fila['hora'];
    }

    // contar horas libres
    $horasLibres = array_diff($horasPosibles, $horasOcupadas);

    if (count($horasLibres) > 0) {
        $fechasDisponibles[] = $fecha;
    }
}

$fechaSeleccionada = $_POST['fecha'] ?? ($fechasDisponibles[0] ?? null);

$horasLibres = [];

if ($fechaSeleccionada) {
    $consultaH2 = "SELECT hora FROM cita WHERE fecha = '$fechaSeleccionada'";
    $respuestaH2 = $conexion->query($consultaH2);

    $horasOcupadas = [];
    while ($fila = $respuestaH2->fetch_assoc()) {
        $horasOcupadas[] = $fila['hora'];
    }

    $horasLibres = array_diff($horasPosibles, $horasOcupadas);
}

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
<body>
     <?php include '../../Components/Header/header_servicios.php'; ?>
     <?php include '../../barraServicios.php'?>
     
  <main>
    <div class="container">
      <form id="login-form" action="../Drivers/reservar_citas.php" method="POST">
            
            <div class="input-group">
                <input type="text" name="motivo" id="nombre" required>
                <label for="motivo">Motivo</label> <br>
            </div>

            <div class="input-group">
                <select name="tipo">
                    <option value="">Seleccione tipo de cita</option>
                        <option value="r">Revisión</option> 
                        <option value="c">Consulta</option> 
                </select>
            </div>
            
            <?php
                echo '<select name="fecha" required onchange="this.form.submit()">';
                foreach ($fechasDisponibles as $f) {
                echo "<option value='$f'>$f</option>";
                }
                echo '</select>';
            ?>
            
            <?php
                echo '<select name="hora" required>';
                echo '<option value= ""> Seleccione una hora</option>';
                foreach ($horasLibres as $h) {
                echo "<option value='$h'>$h</option>";
                }
                echo '</select>';
            ?>
            
            <div class="input-group">
                <Select name="idpaciente" required>
                    <option value="">Seleccione al paciente</option>
                <option value="<?= $usuario['id'] ?>">
                    <?= $usuario['nombre'] . " " . $usuario['apellidos'] ?>
                </option>

                <?php while($fila = $respuestaP->fetch_assoc()) { ?>
                    <option value="<?= $fila['id'] ?>">
                        <?= $fila['nombres'] . " " . $fila['apellidos'] ?>
                    </option>
                <?php } ?>
                </Select>
            </div>

            <button type="submit">Reservar Cita</button>
            <button onclick="location.href='../../servicios.php'">Regresar</button>
      </form>
    </div>
  </main>
</body>
</html>