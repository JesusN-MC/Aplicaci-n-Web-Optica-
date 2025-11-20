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
    <link rel="stylesheet" href="../../Components/Productos_Filtro/style.css">
    <link rel="stylesheet" href="../../CSS/gestion_producto.css">
</head>
<body>
    <?php include '../../Components/Header/header_productos.php'; ?>
    <!-- subheader -->
    <section class="filter-bar">
        <div class="filter-left">
            <h2>Gestion de Productos</h2>
        </div>
        <div class="filter-right">
            <button class="btn-green" onclick="location.href='../../App/Views/crear_producto.php'">Crear Producto</button>
        </div>
    </section>

    <table>
        <thead>
            <tr>
                <th class="center">ID</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Categoria</th>
                <th>Estatus</th>
                <th class="center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include '../Models/producto.php';
                $clase = new Producto();
                $resultado = $clase->mostrar();

                
                foreach($resultado as $fila){
                    echo '<tr onclick="window.location=\'visualizar_producto.php?producto='.$fila['id'].'\'">';
                    
                    echo '<td class="center">'.$fila['id'].'</td>';
                    echo '<td>'.$fila['nombre'].'</td>';
                    echo '<td>'.$fila['marca'].'</td>';
                    echo '<td>'.$fila['categoria'].'</td>';
                    echo '<td>'.($fila['estatus']=='1' ? 'Activo':'Inactivo').'</td>';

                    echo '<td class="actions">';
                    if($fila['stock'] > 0){
                        echo '<button class="asig" onclick="event.stopPropagation(); location.href=\'../../App/Views/asignar_producto.php?producto='.$fila['id'].'\'">Asignar</button>';
                    }

                    echo '<button class="edit" onclick="event.stopPropagation(); location.href=\'../../App/Views/actualizar_producto.php?producto='.$fila['id'].'\'">Editar</button>';
                    
                    if($fila['estatus']=='1'){
                        echo '<button class="delete" onclick="event.stopPropagation(); location.href=\'../../App/Drivers/deshabilitar_producto.php?producto='.$fila['id'].'\'">Desactivar</button>';
                    } else {
                        echo '<button class="btn-green min" onclick="event.stopPropagation(); location.href=\'../../App/Drivers/habilitar_producto.php?producto='.$fila['id'].'\'">Habilitar</button>';
                    }

                    echo '</td>';
                    echo '</tr>';
                }

            ?>

        </tbody>
    </table>
</body>
</html>
<style>
    .asig{
        background-color: #c1a383;
        color: white;
    }


@media (max-width: 768px) {

    th:nth-child(3),
    td:nth-child(3),
    th:nth-child(4),
    td:nth-child(4),
    th:nth-child(5),
    td:nth-child(5) { 
        display: none;
    }

    table td, table th {
        padding: 10px 6px;
        font-size: 14px;
        white-space: nowrap;
    }

    .actions {
        display: flex;
        flex-direction: row;  
        gap: 6px;
        justify-content: flex-end;
        flex-wrap: nowrap; 
    }

    .actions button {
        padding: 6px 8px; 
        font-size: 12px;
    }
}

</style>