<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>prueba</title>
    <link rel="stylesheet" href="../../CSS/index.css">
    <link rel="stylesheet" href="../../Components/Productos_Filtro/style.css">
    <link rel="stylesheet" href="../../CSS/gestion_producto.css">
</head>
<body>
    <?php include '../../Components/Header/header_productos_gestion.php'; ?>
    <!-- subheader -->
    <section class="filter-bar">
        <div class="filter-left">
            <h2>Gestion de Categorias</h2>
        </div>
        <div class="filter-right">
            <button class="btn-green" onclick="location.href='../../App/Views/crear_categoria.php'">Crear Categoría</button>
        </div>
    </section>

    <table>
        <thead>
            <tr>
                <th class="center">ID</th>
                <th>Nombre</th>
                <th>Estatus</th>
                <th class="center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include '../Models/categoria.php';
                $categoria = new Categoria();
                $resultado = $categoria->mostrar();

                
                foreach($resultado as $fila){
                    echo    '<tr>';
                    echo        '<td class="center">'.$fila['id'].'</td>';
                    echo        '<td>'.$fila['nombre'].'</td>';
                    if($fila['estatus'] == '1'){
                        echo '<td>Activo</td>';
                        echo    '<td class="actions">
                                    <button class="edit">Editar</button>
                                    <button class="delete">Deshabilitar</button>
                                </td>';
                        echo '</tr>';
                    }else{
                        echo '<td>Inactivo</td>';
                        echo    '<td class="actions">
                                    <button class="edit" onclick="location.href="../../App/Drivers/edit_categoria.php?id='.$fila['id'].'" " >Editar</button>
                                    <button class="habilitar">Habilitar</button>
                                </td>';
                        echo '</tr>';
                    }
                    
                }
            ?>

        </tbody>
    </table>
</body>
</html>