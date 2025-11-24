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
            <h2>Historial de Productos</h2>
        </div>
        <div class="filter-right">
            <button class="btn-green" onclick="history.back()">Regresar</button>
        </div>
    </section>

    <table>
        <thead>
            <tr>
                <th class="center">ID</th>
                <th>Producto</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include '../Models/compra.php';
                $clase = new Compra();
                $resultado = $clase->comprasGenerales();

                
                foreach($resultado as $fila){
                    echo '<tr onclick="window.location=\'visualizar_producto.php?producto='.$fila['id'].'\'">';
                    
                    echo '<td class="center">'.$fila['id'].'</td>';
                    echo '<td>'.$fila['producto'].'</td>';
                    echo '<td>'.$fila['usuario'].'</td>';
                    echo '<td>'.$fila['total'].'</td>';
                    echo '<td>'.$fila['fecha'].'</td>';
                    echo '<td>'.$fila['hora'].'</td>';
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