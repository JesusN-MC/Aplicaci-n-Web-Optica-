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
    <title>Listado de Perfiles Dependientes</title>
  
    <link rel="stylesheet" href="../../CSS/inputs.css">
    <link rel="stylesheet" href="../../CSS/historial_clinico_compras.css">
    <link rel="stylesheet" href="../../Components/Header/style.css">

    <!-- Estilo propio para ajustar el espacio debajo del header -->
    <style>
        main, .filter-bar {
            margin-top: 80px; /* ajusta según la altura de tu header */
        }
    </style>
</head>
<body>

<?php include '../../Components/Header/header_login.php'; ?>

<section class="filter-bar">
    <div class="filter-left">
        <h2>Perfiles Dependientes</h2>
    </div>
    <div class="filter-right">
        <button class="btn-green" onclick="location.href='formulario_perfil_dependiente.php'">Agregar Dependiente</button>
    </div>
</section>

<table>
    <thead>
        <tr>
            <th class="center">ID</th>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Parentesco</th>
            <th class="center">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../Models/perfil_dependiente.php';

        $perfil = new PerfilDependiente();
        $fk_usuario = $_SESSION['usuario_id'];
        $resultado = $perfil->mostrar($fk_usuario);

        if ($resultado) {
            foreach ($resultado as $dep) {
                echo '<tr>';
                echo '<td class="center">'.$dep['id'].'</td>';
                echo '<td>'.$dep['nombres'].'</td>';
                echo '<td>'.$dep['apellidos'].'</td>';
                echo '<td>'.$dep['parentesco'].'</td>';
                echo '<td class="actions">
                        <button class="edit" onclick="location.href=\'editar_perfil.php?id='.$dep['id'].'\'">Editar</button>
                        <button class="delete" onclick="location.href=\'eliminar_perfil.php?id='.$dep['id'].'\'">Eliminar</button>
                      </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5" class="center">No hay dependientes registrados</td></tr>';
        }
        ?>
    </tbody>
</table>

</body>
</html>

