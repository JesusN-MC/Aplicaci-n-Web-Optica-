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
    <title>Gestión de Categorías</title>

    <!-- Tus estilos existentes -->
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
        }

        body{
            margin:0;
            background: var(--bg);
            font-family: Inter, system-ui, sans-serif;
            color:#1b3b32;
            padding-bottom:50px;
        }

        .page {
            width: 100%;
            max-width: 1050px;
            margin: 40px auto;
            padding: 16px;
        }

        /* Subheader */
        .filter-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:18px;
        }
        .filter-left h2{
            margin:0;
            font-size:1.4rem;
            font-weight:800;
            color:var(--accent);
        }

        .btn-green{
            background: linear-gradient(135deg,var(--green-1),var(--green-2));
            padding:10px 15px;
            border:none;
            border-radius:10px;
            font-weight:700;
            color:white;
            cursor:pointer;
            box-shadow: 0 6px 16px rgba(34,106,80,0.15);
        }
        .btn-green.min{
            padding:6px 10px;
            font-size:0.9rem;
        }

        /* Tabla envuelta en tarjeta */
        .table-card{
            background: var(--card-bg);
            padding:14px;
            border-radius:14px;
            box-shadow: var(--shadow);
            border:1px solid rgba(0,0,0,0.05);
            width: 90%;
            max-width: 980px;
            margin-top: 80px;
        }

        table{
            margin: 0;
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:12px;
            overflow:hidden;
        }

        thead th{
            padding:14px;
            font-size:0.95rem;
            color:var(--accent);
            font-weight:800;
            background: rgba(34,106,80,0.05);
            border-bottom:1px solid #e7f2ed;
        }
        tbody td{
            padding:12px 16px;
            font-size:0.95rem;
            border-bottom:1px solid #eef5f1;
        }

        tbody tr{
            cursor:pointer;
            transition: all .12s ease;
        }
        tbody tr:hover{
            background:#fafff8;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(20,60,40,0.08);
        }

        .center{text-align:center;}

        .status{
            padding:6px 12px;
            border-radius:999px;
            font-weight:700;
            font-size:0.82rem;
        }
        .status.activo{
            background: rgba(46,204,113,0.12);
            color:var(--green-1);
        }
        .status.inactivo{
            background: rgba(0,0,0,0.1);
            color:#666;
        }

        /* Botones */
        .actions{
            display:flex;
            gap:8px;
            justify-content:center;
        }
        .actions button{
            padding:8px 10px;
            border:none;
            border-radius:8px;
            font-weight:700;
            font-size:0.9rem;
            cursor:pointer;
            color:white;
        }
        .edit{ background:#3498db; }
        .delete{ background:#e74c3c; }

        /* Responsive */
        @media(max-width:768px){
            thead th:nth-child(3),
            td:nth-child(3){ display:none; }

            table td, table th{
                padding:10px 8px;
                font-size:14px;
            }
            .actions button{
                padding:6px 8px;
                font-size:12px;
            }
        }

        @media(max-width:420px){
            thead{display:none;}
            table,tbody,tr,td{display:block;width:100%;}
            tbody tr{margin-bottom:12px;}
            td{
                display:flex;
                justify-content:space-between;
                padding:12px;
                background:white;
                border-radius:12px;
                box-shadow:0 6px 18px rgba(0,0,0,0.05);
            }
            td.actions{
                justify-content:flex-end;
                gap:6px;
            }
        }
    </style>
</head>

<body>
    <?php include '../../Components/Header/header_productos.php'; ?>

<div class="page">
    
    <section class="filter-bar">
        <div class="filter-left">
            <h2>Gestión de Categorías</h2>
        </div>
        <div class="filter-right">
            <button class="btn-green" onclick="location.href='../../App/Views/crear_categoria.php'">Crear Categoría</button>
        </div>
    </section>

    <div class="table-card">
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

                        echo '<tr>';

                        echo '<td class="center">'.$fila['id'].'</td>';
                        echo '<td>'.$fila['nombre'].'</td>';

                        if ($fila['estatus'] == '1') {
                            echo '<td><span class="status activo">Activo</span></td>';
                            echo '<td class="actions">
                                    <button class="edit" onclick="event.stopPropagation(); location.href=\'../../App/Views/actualizar_categoria.php?categoria='.$fila['id'].'\'">Editar</button>
                                    <button class="delete" onclick="event.stopPropagation(); location.href=\'../../App/Drivers/deshabilitar_categoria.php?categoria='.$fila['id'].'\'">Desactivar</button>
                                  </td>';
                        } else {
                            echo '<td><span class="status inactivo">Inactivo</span></td>';
                            echo '<td class="actions">
                                    <button class="edit" onclick="event.stopPropagation(); location.href=\'../../App/Views/actualizar_categoria.php?categoria='.$fila['id'].'\'">Editar</button>
                                    <button class="btn-green min" onclick="event.stopPropagation(); location.href=\'../../App/Drivers/habilitar_categoria.php?categoria='.$fila['id'].'\'">Habilitar</button>
                                  </td>';
                        }

                        echo '</tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
