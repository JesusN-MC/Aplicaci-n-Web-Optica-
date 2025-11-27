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
    <title>Gestión de Productos</title>

    <!-- Mantengo tus hojas si las usas además -->
    <link rel="stylesheet" href="../../Components/Productos_Filtro/style.css">
    <link rel="stylesheet" href="../../CSS/gestion_producto.css">

    <style>
        :root{
            --green-1: #2ecc71;
            --green-2: #1faa5b;
            --accent: #226a50;
            --muted: #6b7a74;
            --card-bg: #f8fdfb;
            --bg: #f4f7f5;
            --shadow: 0 6px 20px rgba(18,50,40,0.08);
            --glass: rgba(255,255,255,0.8);
        }

        /* Base */
        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background: var(--bg);
            color: #15392f;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
            padding-bottom: 60px;
        }

        .page {
            width: 100%;
            max-width: 1200px;
            margin: 40px auto 80px;
            padding: 18px;
        }

        /* Filter bar / subheader */
        .filter-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            margin-bottom:16px;
        }
        .filter-left h2{
            margin:0;
            font-size:1.35rem;
            color:var(--accent);
            font-weight:800;
        }
        .filter-right{
            display:flex;
            gap:10px;
            align-items:center;
        }

        .btn-green{
            background: linear-gradient(135deg,var(--green-1),var(--green-2));
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight:700;
            text-decoration:none;
            box-shadow: 0 6px 18px rgba(34,106,80,0.08);
        }
        .btn-green.min{
            padding:6px 10px;
            font-size:0.9rem;
        }

        /* Card wrapper for table */
        .table-card{
            background: var(--card-bg);
            border-radius: 14px;
            padding: 14px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0,0,0,0.03);
            overflow: hidden;
            margin-top: 80px;
        }

        table{
            margin: 0;
            width:100%;
            border-collapse: collapse;
            min-width: 680px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        thead th{
            text-align:left;
            padding:14px 16px;
            background: linear-gradient(180deg, rgba(34,106,80,0.06), rgba(34,106,80,0.02));
            color: var(--accent);
            font-weight:800;
            font-size:0.95rem;
            border-bottom: 1px solid #eef6f0;
        }

        thead th.center, tbody td.center{
            text-align:center;
        }

        tbody td{
            padding:12px 16px;
            vertical-align: middle;
            font-size:0.95rem;
            color:#2b4f43;
            border-bottom: 1px solid #f1f6f3;
        }

        tbody tr{
            transition: transform .12s ease, box-shadow .12s ease, background .12s;
            cursor: pointer;
        }

        tbody tr:hover{
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(18,50,40,0.06);
            background: #fbfff9;
        }

        /* Badges / status */
        .status {
            display:inline-block;
            padding:6px 10px;
            border-radius:999px;
            font-weight:700;
            font-size:0.82rem;
        }
        .status.activo {
            background: rgba(46,204,113,0.12);
            color: var(--green-1);
        }
        .status.inactivo {
            background: rgba(200,200,200,0.12);
            color: #666;
        }

        /* Actions column */
        .actions {
            display:flex;
            gap:8px;
            justify-content:start;
            align-items:center;
        }

        .actions button, .actions a{
            border: none;
            padding:8px 10px;
            border-radius:8px;
            cursor: pointer;
            font-weight:700;
            font-size:0.92rem;
        }

        .actions .asig {
            background: linear-gradient(135deg,#c1a383,#b98e66);
            color:#fff;
        }

        .actions .edit {
            background: #3498db;
            color: #fff;
        }

        .actions .delete {
            background: #e74c3c;
            color: #fff;
        }

        .actions .small {
            padding:6px 8px;
            font-size:0.86rem;
        }

        /* Responsive: hide some columns on small screens; keep table accessible */
        @media (max-width: 980px){
            .page{ padding:12px; }
            table { min-width: 520px; }
        }

        @media (max-width: 768px) {

            /* esconder columnas 3,4,5 (marca, categoria, estatus) como pediste */
            th:nth-child(3),
            td:nth-child(3),
            th:nth-child(4),
            td:nth-child(4),
            th:nth-child(5),
            td:nth-child(5) { 
                display: none;
            }

            table td, table th {
                padding: 10px 8px;
                font-size: 14px;
                white-space: nowrap;
            }

            .actions {
                gap:6px;
            }

            .actions button {
                padding:6px 8px;
                font-size:12px;
            }
        }

        /* Very small screens: make rows wrap more nicely */
        @media (max-width: 420px){
            thead { display:none; }
            table, tbody, tr, td { display:block; width:100%; }
            tbody tr { margin-bottom:12px; }
            td { 
                display:flex; 
                justify-content:space-between; 
                padding:10px; 
                border-radius:10px; 
                background:white;
                box-shadow: 0 6px 18px rgba(8,30,20,0.03);
            }
            td.actions { justify-content:flex-end; }
            td::before { content: ''; }
        }
    </style>
</head>
<body>
    <?php include '../../Components/Header/header_productos.php'; ?>

    <div class="page">
        <section class="filter-bar">
            <div class="filter-left">
                <h2>Gestión de Productos</h2>
            </div>
            <div class="filter-right">
                <button class="btn-green" onclick="location.href='../../App/Views/historial_producto.php'">Historial de Productos</button>
                <button class="btn-green" onclick="location.href='../../App/Views/crear_producto.php'">Crear Producto</button>
            </div>
        </section>

        <div class="table-card">
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
                            // fila clickable: ir a visualizar (stopPropagation en botones)
                            echo '<tr onclick="window.location=\'visualizar_producto.php?producto='.$fila['id'].'\'">';
                            echo '<td class="center">'.$fila['id'].'</td>';
                            echo '<td>'.$fila['nombre'].'</td>';
                            echo '<td>'.$fila['marca'].'</td>';
                            echo '<td>'.$fila['categoria'].'</td>';

                            $estatusLabel = ($fila['estatus']=='1') ? '<span class="status activo">Activo</span>' : '<span class="status inactivo">Inactivo</span>';
                            echo '<td>'.$estatusLabel.'</td>';

                            echo '<td class="actions">';
                                if($fila['stock'] > 0){
                                    echo '<button class="asig small" onclick="event.stopPropagation(); location.href=\'../../App/Views/asignar_producto.php?producto='.$fila['id'].'\'">Asignar</button>';
                                }
                                echo '<button class="edit small" onclick="event.stopPropagation(); location.href=\'../../App/Views/actualizar_producto.php?producto='.$fila['id'].'\'">Editar</button>';
                                
                                if($fila['estatus']=='1'){
                                    echo '<button class="delete small" onclick="event.stopPropagation(); location.href=\'../../App/Drivers/deshabilitar_producto.php?producto='.$fila['id'].'\'">Desactivar</button>';
                                } else {
                                    echo '<button class="btn-green min small" onclick="event.stopPropagation(); location.href=\'../../App/Drivers/habilitar_producto.php?producto='.$fila['id'].'\'">Habilitar</button>';
                                }
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
