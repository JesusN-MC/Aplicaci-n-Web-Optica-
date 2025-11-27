<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../App/Drivers/conexion.php');
$conexion = new Conexion();

/* rol */
$isAdmin = isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === 'admin';

/* === CONSULTAR USUARIOS === */
$sql = "SELECT id, nombre, apellidos, correo, telefono FROM usuario ORDER BY nombre ASC";
$res = $conexion->query($sql);

$usuarios = [];
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuarios</title>

    <style>
        :root{
            --green-1:#2ecc71;
            --muted:#6b7a74;
            --card-bg:#f8fdfb;
            --bg:#f4f7f5;
            --accent:#226a50;
        }

        /* Reset ligero */
        *{box-sizing:border-box}
        body {
            margin:0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background:var(--bg);
            color:#15392f;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }

        /* CONTENEDOR PRINCIPAL (aprovecha más ancho) */
        .contenedor {
            width:100%;
            max-width:980px; /* amplio */
            margin:80px auto 40px;
            background:#fff;
            padding:28px 28px;
            border-radius:14px;
            margin-top: 120px;
            box-shadow:0 8px 30px rgba(18,50,40,0.06);
        }

        .header-top {
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:12px;
            margin-bottom:8px;
        }

        .titulo-seccion {
            font-size:1.6rem;
            font-weight:800;
            color:var(--accent);
            margin:0;
        }

        /* BUSCADOR */
        .buscador-box{
            margin-top:12px;
            display:flex;
            gap:12px;
            align-items:center;
        }

        .buscador {
            width:100%;
            padding:10px 14px;
            border-radius:10px;
            border:1px solid #e0e6e2;
            font-size:0.98rem;
            outline:none;
            transition:box-shadow .15s, border-color .15s;
        }
        .buscador:focus{
            box-shadow:0 6px 18px rgba(34,106,80,0.06);
            border-color: rgba(34,106,80,0.18);
        }

        /* LIST HEAD (encabezados tipo tabla) */
        .list-head {
            display:grid;
            grid-template-columns: 80px 1.6fr 2fr 1fr 80px; /* id / nombre / correo / tel / acciones/IDextra */
            gap:12px;
            padding:10px 14px;
            margin-top:22px;
            border-bottom:1px solid #eef6f0;
            color:var(--muted);
            font-weight:700;
            font-size:0.92rem;
            align-items:center;
        }

        /* LISTA DE FILAS */
        .lista {
            margin-top:12px;
            display:flex;
            flex-direction:column;
            gap:12px;
        }

        /* FILA: estilo tarjeta pero en GRID */
        .usuario-item {
            display:grid;
            grid-template-columns: 80px 1.6fr 2fr 1fr 80px; /* mantener igual que header */
            gap:12px;
            align-items:center;
            padding:14px 16px;
            border-radius:10px;
            background:var(--card-bg);
            border:1px solid #e6efea;
            transition:transform .14s ease, box-shadow .14s ease, background .14s;
        }

        .usuario-item:hover{
            transform: translateY(-4px);
            box-shadow:0 10px 30px rgba(18,50,40,0.06);
            background:#f2fbf6;
        }

        /* COLUMNAS */
        .u-id {
            font-weight:600;
            color:#497158;
            text-align:left;
            padding-left:6px;
        }

        .u-nombre {
            font-weight:600;
            color:#15392f;
            font-size:1rem;
        }

        .u-correo {
            color:#4f6a63;
            font-size:0.95rem;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
            max-width:100%;
        }

        .u-telefono {
            justify-self:start;
            padding:6px 10px;
            border-radius:8px;
            background:#dff8eb;
            color:#1f6d50;
            font-weight:700;
            font-size:0.93rem;
            width:max-content;
        }

        .u-right {
            text-align:right;
            color:#6b7a74;
            font-size:0.88rem;
            font-weight:700;
        }

        .empty {
            padding:20px;
            border-radius:10px;
            background:#fff;
            border:1px dashed #d8eae0;
            color:#6b7a74;
            font-style:italic;
            text-align:center;
        }

        /* --- NUEVAS CLASES que usamos en móvil --- */
        .u-top { display:flex; justify-content:space-between; align-items:center; gap:12px; }
        .u-bottom { display:flex; gap:14px; align-items:center; color:#6b7a74; font-size:0.9rem; }

        /* RESPONSIVE: en pantallas medianas hacemos 2 columnas en filas */
        @media (max-width:900px){
            .list-head, .usuario-item{
                grid-template-columns: 60px 1fr 1fr; /* id / nombre / detalles */
            }
            .u-correo { grid-column: 3 / 4; }
            .u-telefono { grid-column: 2 / 3; justify-self:start; }
            .u-right { grid-column: 3 / 4; justify-self:end; }
        }

        /* MOVIL: apilar, mostrar ID+NOMBRE arriba (misma fila) y TELEFONO+CORREO abajo en pequeño */
        @media (max-width:560px){
            .list-head { display:none; }

            .usuario-item{
                grid-template-columns: 1fr;
                gap:8px;
                padding:12px;
            }

            /* Hacemos el top con id + nombre */
            .u-top { 
                display:flex;
                justify-content:space-between;
                align-items:center;
                gap:12px;
            }
            .u-id {
                font-weight:700;
                color:#497158;
                padding-left:0;
                font-size:0.95rem;
            }
            .u-nombre {
                font-size:1rem;
                font-weight:700;
                color:#15392f;
                text-align:right;
            }

            /* Bottom: correo y telefono en texto pequeño y tenue */
            .u-bottom {
                display:flex;
                flex-direction:row;
                gap:12px;
                color:#6b7a74;
                font-size:0.86rem;
                align-items:center;
                flex-wrap:wrap;
            }
            .u-correo {
                white-space:normal;
                overflow:visible;
                text-overflow:clip;
                font-size:0.86rem;
            }
            .u-telefono {
                background:transparent;
                padding:0;
                font-weight:600;
                color:#1f6d50;
                font-size:0.9rem;
            }

            .u-right { display:none; }
        }
    </style>
</head>

<body>

    <?php include '../../Components/Header/header_servicios.php'; ?>
    <?php include '../../barraServicios2.php' ?>

<div class="contenedor">

    <div class="header-top">
        <h2 class="titulo-seccion">Lista de Usuarios</h2>
    </div>

    <!-- BUSCADOR -->
    <div class="buscador-box">
        <input type="text" id="buscarUsuario" class="buscador" placeholder="Buscar por nombre...">
    </div>

    <!-- ENCABEZADOS (solo visual) -->
    <div class="list-head" aria-hidden="true">
        <div>ID</div>
        <div>Nombre</div>
        <div>Teléfono</div>
        <div>Correo</div>
        <div></div>
    </div>

    <div class="lista" id="listaUsuarios">
        <?php if (empty($usuarios)): ?>
            <div class="empty">No hay usuarios registrados.</div>
        <?php else: ?>
            <?php foreach ($usuarios as $u): ?>
                <?php
                    $nombre = trim($u['nombre'] . ' ' . $u['apellidos']);
                    $nombre_safe = htmlspecialchars($nombre);
                    $correo = htmlspecialchars($u['correo'] ?? '');
                    $telRaw = trim($u['telefono'] ?? '');
                    $tel = $telRaw !== '' ? htmlspecialchars($telRaw) : 'Sin número';
                    $dataNombre = htmlspecialchars(strtolower($nombre), ENT_QUOTES);
                    $id = (int)$u['id'];
                ?>

                <div class="usuario-item cursor-pointer hover:bg-gray-200 transition"
                    data-nombre="<?= $dataNombre ?>"
                    onclick="window.location.href='visualizar_usuario.php?id=<?= $id ?>'">

                    <!-- Parte superior (ID + Nombre) -->
                    <div class="u-top" style="grid-column: 1 / -1;">
                        <div class="u-id">#<?= $id ?></div>
                        <div class="u-nombre"><?= $nombre_safe ?></div>
                    </div>

                    <!-- Parte inferior (Teléfono + Correo) -->
                    <div class="u-bottom" style="grid-column: 1 / -1;">
                        <div class="u-telefono"><?= $tel ?></div>
                        <div class="u-correo"><?= $correo ?></div>
                    </div>

                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("buscarUsuario");
    const lista = document.getElementById("listaUsuarios");
    const items = Array.from(lista.querySelectorAll(".usuario-item"));

    input.addEventListener("input", () => {
        const texto = input.value.toLowerCase().trim();

        items.forEach(item => {
            const nombre = item.dataset.nombre || "";
            const coincide = nombre.includes(texto);
            item.style.display = coincide ? "grid" : "none";
        });
    });

    // tecla ESC limpia
    input.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            input.value = "";
            input.dispatchEvent(new Event('input'));
        }
    });
});
</script>

</body>
</html>
