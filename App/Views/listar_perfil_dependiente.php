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
    <title>Gestionar Dependientes</title>
    <style>
        /* ===== Reset ligero ===== */
        *{box-sizing:border-box}
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
            background: #f4f7f5;
            margin: 0;
            padding: 0;
            color: #21312b;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }

        .contenedor {
            width: 100%;
            max-width: 980px;
            margin: 120px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(18,50,40,0.08);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 6px;
        }

        .titulo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #226a50;
            margin: 0;
        }

        .subtitulo {
            font-size: 0.95rem;
            color: #4e645f;
            margin-top: 6px;
        }

        .btn-verde {
            padding: 10px 16px;
            background: linear-gradient(135deg, #2ecc71, #1faa5b);
            color: #fff;
            border-radius: 10px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(31,138,84,0.18);
        }

        /* Table styles (desktop) */
        .table-wrap{ overflow:auto; margin-top:18px; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #f8fdfb;
            border-radius: 12px;
            overflow: hidden;
            /* removed hard min-width to allow fitting on mobile */
        }

        thead {
            background: #e9f6ef;
        }

        th, td {
            padding: 12px 14px;
            text-align: left;
            vertical-align: middle;
        }

        th { color:#1d3b32; font-weight:700; font-size:0.95rem; border-bottom:2px solid #dfeee7 }
        td { color:#2f4b43; border-bottom:1px solid #e6efea; font-size:0.95rem }

        .center{ text-align:center }
        .id-badge{ display:inline-block; background:#e6f6ee; color:#116443; font-weight:700; padding:6px 8px; border-radius:8px; }

        .actions{ display:flex; gap:8px; justify-content:center; align-items:center }
        .actions button{ padding:8px; border-radius:8px; font-weight:700; border:none; cursor:pointer; display:inline-flex; align-items:center; justify-content:center }
        .actions button svg{ width:18px; height:18px; display:block }
        .edit{ background:#3498db; color:#fff }
        .delete{ background:#e74c3c; color:#fff }
        .habilitar{ background:#2ecc71; color:#fff }

        .empty{ padding:16px; border-radius:10px; background:#fff; border:1px dashed #d8eae0; color:#6b7a74; font-style:italic }

        /* ===== Mobile: convert rows to cards (no horizontal scroll) ===== */
        @media (max-width: 720px){
            .contenedor{ margin: 120px auto; padding:12px; width: calc(100% - 28px); max-width:720px; }
            .header-top{ flex-direction:column; align-items:center; gap:8px; text-align:center }
            .header-top > div{ width:100% }
            .titulo{ font-size:1.2rem }
            .subtitulo{ font-size:0.88rem }
            .btn-verde{ width:100%; text-align:center; padding:10px 12px; font-size:0.95rem }

            .table-wrap{ overflow:visible; -webkit-overflow-scrolling: auto; margin-top:12px }
            table{ border-radius:0; background:transparent; box-shadow:none; width:100% }
            thead { display:none } /* hide headers on mobile */
            tbody { display:block }
            tbody tr {
                display:block;
                background:#ffffff;
                border-radius:10px;
                padding:10px;
                margin-bottom:12px;
                box-shadow: 0 4px 14px rgba(18,50,40,0.04);
                border: 1px solid #eef6f1;
            }
            td {
                display:flex;
                justify-content:space-between;
                align-items:center;
                padding:6px 8px;
                border:none;
                font-size:0.95rem;
            }
            td + td { margin-top:6px; }
            td::before {
                content: attr(data-label);
                font-weight:700;
                color:#3b6a5a;
                margin-right:8px;
                flex:0 0 auto;
                font-size:0.9rem;
            }
            .actions {
                justify-content:flex-end;
                gap:8px;
                margin-top:4px;
            }
            .actions button { padding:8px; border-radius:8px; width:40px; height:40px }
            .actions button svg{ width:18px; height:18px }
            .edit{ padding:6px; }
            .delete{ padding:6px; }
            .habilitar{ padding:6px; }

            /* Reduce fonts slightly to fit content */
            body, td, th, .titulo, .subtitulo { font-size: 0.95rem }
        }

        /* desktop nice spacing for actions column */
        @media (min-width: 721px){
            .actions .edit{ padding:8px 10px }
            .actions .delete{ padding:8px 10px }
        }

        /* Small visual tweaks for SVG buttons on desktop */
        .actions button svg { filter: drop-shadow(0 1px 0 rgba(0,0,0,0.06)); }
        /* ===== Mobile: convert rows to cards (no horizontal scroll) ===== */
        @media (max-width: 720px){
            .contenedor{ margin: 120px auto; padding:12px; width: calc(100%); max-width:720px; }

            /* Mantener título y botón en la misma fila */
            .header-top{
                flex-direction:row;
                align-items:center;
                justify-content:space-between;
                gap:8px;
                text-align:left;
                width:100%;
            }
            .header-top > div{ width:auto }

            .titulo{ font-size:1.2rem }
            .subtitulo{ font-size:0.88rem }

            /* No ocupar todo el ancho el botón en móvil */
            .btn-verde{
                width:auto;
                text-align:center;
                padding:10px 14px;
                font-size:0.95rem;
                white-space:nowrap;
            }

            .table-wrap{ overflow:visible; -webkit-overflow-scrolling: auto; margin-top:12px }
            table{ border-radius:0; background:transparent; box-shadow:none; width:100% }
            thead { display:none } /* hide headers on mobile */
            tbody { display:block }
            tbody tr {
                display:block;
                background:#ffffff;
                border-radius:10px;
                padding:10px;
                margin-bottom:12px;
                box-shadow: 0 4px 14px rgba(18,50,40,0.04);
                border: 1px solid #eef6f1;
            }
            td {
                display:flex;
                justify-content:space-between;
                align-items:center;
                padding:6px 8px;
                border:none;
                font-size:0.95rem;
            }
            td + td { margin-top:6px; }
            td::before {
                content: attr(data-label);
                font-weight:700;
                color:#3b6a5a;
                margin-right:8px;
                flex:0 0 auto;
                font-size:0.9rem;
            }
            .actions {
                justify-content:flex-end;
                gap:8px;
                margin-top:4px;
            }
            .actions button { padding:8px; border-radius:8px; width:40px; height:40px }
            .actions button svg{ width:18px; height:18px }
            .edit{ padding:6px; }
            .delete{ padding:6px; }
            .habilitar{ padding:6px; }

            /* Reduce fonts slightly to fit content */
            body, td, th, .titulo, .subtitulo { font-size: 0.95rem }
        }

        h1{
            font-size:1.45rem;
            font-weight:800;
            color:#226a50;
            height: 69px;
            display: flex;
            justify-content:center;
            align-items:center;
        }

    </style>
</head>
<body>

<?php include '../../Components/Header/header_servicios.php'; ?>
<?php include '../../barraServicios2.php'?>

<div class="contenedor">
    <div class="header-top">
        <div>
            <h1 class="titulo">Usuarios Dependientes</h1>
        </div>

        <button class="btn-verde" onclick="location.href='formulario_perfil_dependiente.php'">Agregar Dependiente</button>
    </div>

    <div class="table-wrap">
        <?php
        include '../../App/Models/perfil_dependiente.php';
        $clase = new PerfilDependiente();
        $fk_usuario = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0;
        $resultado = $clase->mostrar($fk_usuario);
        ?>

        <?php if (empty($resultado)): ?>
            <div class="empty">No hay dependientes registrados.</div>
        <?php else: ?>
            <table aria-label="Lista de dependientes">
                <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Parentesco</th>
                        <th class="center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultado as $fila): ?>
                        <tr>
                            <td data-label="Nombres"><?php echo htmlspecialchars($fila['nombres'] . ' ' . $fila['apellidos']); ?></td>
                            <td data-label="Parentesco"><?php echo htmlspecialchars($fila['parentesco']); ?></td>
                            <td class="actions" data-label="Acciones">
                                <!-- Edit icon (pencil) -->
                                <button class="edit" title="Editar" aria-label="Editar" onclick="location.href='editar_perfil_dependiente.php?id=<?php echo $fila['id']; ?>'">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z" fill="#fff"/>
                                        <path d="M20.71 7.04a1.003 1.003 0 0 0 0-1.42l-2.34-2.34a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z" fill="#fff"/>
                                    </svg>
                                </button>

                                <?php if ($fila['estatus'] === 'A'): ?>
                                    <!-- Delete / Deshabilitar icon (trash) -->
                                    <button class="delete" title="Deshabilitar" aria-label="Deshabilitar" onclick="location.href='../../App/Drivers/deshabilitar_perfil_dependiente.php?id=<?php echo $fila['id']; ?>'">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12z" fill="#fff"/>
                                            <path d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" fill="#fff"/>
                                        </svg>
                                    </button>
                                <?php else: ?>
                                    <!-- Enable / Habilitar icon (check) -->
                                    <button class="habilitar" title="Habilitar" aria-label="Habilitar" onclick="location.href='../../App/Drivers/habilitar_perfil_dependiente.php?id=<?php echo $fila['id']; ?>'">
                                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M9 16.2l-3.5-3.5L4 14.2 9 19l11-11-1.5-1.5L9 16.2z" fill="#fff"/>
                                        </svg>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>

</body>
</html>