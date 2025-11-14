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
    <title>Gestionar Perfil Dependientes</title>
    <link rel="stylesheet" href="../../CSS/gestion_producto.css">
    <link rel="stylesheet" href="../../CSS/gestion_perfiles_dependientes.css"> <!-- tu nuevo CSS -->
</head>
<body>

<?php include '../../Components/Header/header_productos.php'; ?>

<section class="barra">
    <div class="lado-izq">
        <h2>Gestionar Usuarios Dependientes</h2>
    </div>
    <div class="lado-der">
        <button class="btn-verde" onclick="location.href='formulario_perfil_dependiente.php'">
            Agregar Dependiente
        </button>
    </div>
</section>

<table>
    <thead>
        <tr>
            <th class="center">ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Parentesco</th>
            <th class="center">Acciones</th>
        </tr>
    </thead>

    <tbody>
        <?php
        include '../../App/Models/perfil_dependiente.php';
        $clase = new PerfilDependiente();
        $fk_usuario = $_SESSION['usuario_id'];
        $resultado = $clase->mostrar($fk_usuario);

        foreach ($resultado as $fila) {

            echo "<tr>";
            echo "<td class='center'>{$fila['id']}</td>";
            echo "<td>{$fila['nombres']}</td>";
            echo "<td>{$fila['apellidos']}</td>";
            echo "<td>{$fila['parentesco']}</td>";


            if ($fila['estatus'] === 'A') {
                echo "<td class='actions'>
                        <button class='edit'
                            onclick=\"location.href='editar_perfil_dependiente.php?id={$fila['id']}'\">
                            Editar
                        </button>

                        <button class='delete'
                            onclick=\"location.href='../../App/Drivers/deshabilitar_perfil_dependiente.php?id={$fila['id']}'\">
                            Deshabilitar
                        </button>
                      </td>";
            } else {
                echo "<td class='actions'>
                        <button class='edit'
                            onclick=\"location.href='editar_perfil_dependiente.php?id={$fila['id']}'\">
                            Editar
                        </button>

                        <button class='btn-verde'
                            onclick=\"location.href='../../App/Drivers/habilitar_perfil_dependiente.php?id={$fila['id']}'\">
                            Habilitar
                        </button>
                      </td>";
            }

            echo "</tr>";
        }
        ?>
    </tbody>
</table>

</body>
</html>
