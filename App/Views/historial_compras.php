<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* conexión */
require_once('../../App/Drivers/conexion.php');
$conexion = new Conexion();

/* id del usuario en sesión */
$idUsuario = $_GET['id'];

$compras = [];

if ($idUsuario !== 0) {

    /* Traer compras del usuario junto con datos del producto.
       Ordenamos por fecha desc, hora desc (más recientes primero). */
    $sql = "
        SELECT
            co.id,
            co.total,
            co.fecha,
            co.hora,
            co.fk_producto,
            p.nombre AS producto_nombre,
            p.marca  AS producto_marca,
            p.precio AS producto_precio
        FROM compra co
        LEFT JOIN producto p ON co.fk_producto = p.id
        WHERE co.fk_usuario = {$idUsuario}
        ORDER BY co.fecha DESC, co.hora DESC
    ";

    $res = $conexion->query($sql);
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            // Normalizar hora a HH:MM
            if (!empty($row['hora'])) {
                $row['hora'] = substr($row['hora'], 0, 5);
            } else {
                $row['hora'] = '';
            }

            // Garantizar valores - nombre marca precio
            $row['producto_nombre'] = $row['producto_nombre'] ?? 'Producto';
            $row['producto_marca']  = $row['producto_marca']  ?? '';
            $row['producto_precio'] = isset($row['producto_precio']) ? number_format((float)$row['producto_precio'], 2) : number_format((float)$row['total'], 2);

            // Estatus UI (no existe en BD): Asignado
            $row['estatus_text'] = 'Asignado';
            $row['estatus_key'] = 'assigned';

            $compras[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Historial de Compras</title>
    <style>
        :root{
            --green-1:#2ecc71;
            --green-2:#1faa5b;
            --muted:#6b7a74;
            --bg:#f4f7f5;
            --card:#f8fdfb;
        }
        *{box-sizing:border-box}
        body{
            margin:0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            background:var(--bg);
            color:#21312b;
            -webkit-font-smoothing:antialiased;
        }

        .contenedor {
            width: 100%;
            max-width:980px;
            margin: 110px auto;
            background:#fff;
            margin-top: 120px;
            padding:18px;
            border-radius:12px;
            box-shadow:0 8px 28px rgba(18,50,40,0.06);
        }

        .header-top{ display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .titulo-seccion{ font-size:1.25rem; font-weight:800; color:#226a50; margin:0; }
        .sub { color:var(--muted); font-size:0.93rem }

        /* filtro */
        .filtro-box{ margin-top:14px; display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .input-date{ padding:8px 12px; border-radius:8px; border:1px solid #d5e3dc; font-size:0.92rem; }
        .btn {
            padding:8px 12px; border-radius:10px; font-weight:700; border:none; cursor:pointer;
            box-shadow:0 3px 8px rgba(0,0,0,0.08);
        }
        .btn-filtrar{ background: linear-gradient(135deg,var(--green-1),var(--green-2)); color:#fff; }
        .btn-limpiar{ background:#e74c3c; color:#fff; }

        /* lista */
        .lista-compras { margin-top:16px; display:flex; flex-direction:column; gap:12px; }
        .compra-item{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            background:var(--card);
            padding:12px;
            border-radius:12px;
            border:1px solid #e6efea;
        }

        .compra-left{ display:flex; flex-direction:column; gap:4px; min-width:240px; }
        .prod-nombre{ font-weight:700; color:#15392f; font-size:1rem; }
        .prod-marca{ font-size:0.88rem; color:var(--muted) }

        .compra-meta{ display:flex; gap:10px; align-items:center; color:var(--muted); font-size:0.92rem; min-width:200px; justify-content:flex-start; }
        .meta-item{ font-weight:700; color:#1d3b32; font-size:0.92rem; background:#f3faf6; padding:6px 8px; border-radius:8px; }

        .compra-right{ display:flex; align-items:center; gap:12px; min-width:120px; justify-content:flex-end; }
        .precio{ font-weight:800; color:#15392f; font-size:1rem; white-space:nowrap; }

        .estatus-badge{ padding:6px 10px; border-radius:999px; font-weight:700; font-size:0.82rem; background:#eef7f0; color:#117a46; border:1px solid rgba(46,204,113,0.12); }

        .empty{ padding:14px; border-radius:10px; background:#fff; border:1px dashed #d8eae0; color:var(--muted); font-style:italic }

        /* responsive: compact on mobile — reduce margins so list doesn't scroll much */
        @media (max-width: 720px){
            .contenedor{ margin:20px 10px; padding:12px; margin-top: 120px}
            .header-top{ flex-direction:column; align-items:flex-start; gap:8px; }
            .filtro-box{ width:100%; gap:8px; }
            .input-date{ flex:1; min-width:140px; }
            .btn{ padding:7px 10px; font-size:0.9rem; }

            .lista-compras{ gap:8px; }
            .compra-item{ padding:10px; border-radius:10px; gap:8px; align-items:flex-start; }
            .compra-left{ min-width:0; }
            .compra-meta{ gap:8px; font-size:0.86rem; flex-wrap:wrap; }

            .compra-right{ min-width:0; gap:8px; flex-direction:column; align-items:flex-end; }
            .precio{ font-size:0.96rem }
            .estatus-badge{ padding:6px 8px; font-size:0.82rem }
        }

        /* tiny screens */
        @media (max-width:420px){
            .compra-item{ padding:8px; }
            .prod-nombre{ font-size:0.98rem }
            .prod-marca{ font-size:0.84rem }
            .meta-item{ font-size:0.82rem; padding:5px 6px }
            .precio{ font-size:0.92rem }
        }
    </style>
</head>
<body>

<?php
     include '../../Components/Header/header_servicios.php';
     include '../../barraServicios2.php';
?>

<main class="contenedor" role="main" aria-labelledby="tituloHist">
    <div class="header-top">
        <div style="display: flex;">
            <button onclick="history.back()" style="background: transparent; border: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="witdh: 20px; height: 20px; color: black;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
            </button>
            <h1 id="tituloHist" class="titulo-seccion">Historial de Productos</h1>
        </div>
        <!-- no hay botón añadir -->
    </div>

    <div class="filtro-box" role="region" aria-label="Filtros">
        <input id="filtroFecha" class="input-date" type="date" aria-label="Filtrar por fecha">
        <button id="btnFiltrar" class="btn btn-filtrar" type="button">Filtrar</button>
        <button id="btnQuitar"  class="btn btn-limpiar" type="button">Quitar filtro</button>
    </div>

    <section class="lista-compras" id="listaCompras" aria-live="polite">
        <?php if (empty($compras)): ?>
            <div class="empty">No hay compras registradas para tu cuenta.</div>
        <?php else: ?>
            <?php foreach ($compras as $fila): 
                $fecha_attr = htmlspecialchars($fila['fecha'] ?? '');
                $hora = htmlspecialchars($fila['hora'] ?? '');
                $nombre = htmlspecialchars($fila['producto_nombre'] ?? 'Producto');
                $marca  = htmlspecialchars($fila['producto_marca'] ?? '');
                $precio = htmlspecialchars($fila['producto_precio'] ?? number_format((float)$fila['total'],2));
                $total_ui = '$' . $precio;
                $estatus_text = htmlspecialchars($fila['estatus_text']);
            ?>
                <article class="compra-item"
                         data-url="visualizar_compra.php?compra=<?= $fila['id'] ?>"
                         onclick="window.location=this.dataset.url;"
                         data-fecha="<?= $fecha_attr ?>"
                         data-hora="<?= $hora ?>"
                         data-timestamp="<?= htmlspecialchars($fila['fecha'] . ' ' . ($fila['hora'] ?: '00:00:00')) ?>"
                         role="article"
                >   

                    <div class="compra-left" aria-hidden="false">
                        <div class="prod-nombre"><?= $nombre ?> <span style="font-weight:600;color:#4e645f">— <?= $marca ?></span></div>
                    </div>

                    <div class="compra-meta" aria-hidden="true">
                        <div class="meta-item"><?= $fecha_attr ?></div>
                        <div class="meta-item"><?= $hora ?></div>
                    </div>

                    <div class="compra-right" aria-hidden="true">
                        <div class="precio"><?= $total_ui ?></div>
                        <div class="estatus-badge"><?= $estatus_text ?></div>
                    </div>
                    
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>
<script>
/* helper: convierte fecha+hora a timestamp (ms) */
function parseTimestamp(fecha, hora){
    if(!fecha) return -Infinity;
    const timePart = hora && hora.trim() ? hora.trim() : '00:00';
    const iso = fecha + 'T' + timePart + ':00';
    const t = Date.parse(iso);
    return isNaN(t) ? -Infinity : t;
}

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('listaCompras');
    if (!container) return;
    const input = document.getElementById('filtroFecha');
    const btnFiltrar = document.getElementById('btnFiltrar');
    const btnQuitar = document.getElementById('btnQuitar');

    // Guardamos el orden original (refs a los nodos). Lo actualizaremos tras ordenar inicialmente.
    let initialOrder = Array.from(container.querySelectorAll('.compra-item'));

    // Función para ordenar DOM por fecha+hora desc y actualizar initialOrder
    function ordenarInicial() {
        const items = Array.from(container.querySelectorAll('.compra-item'));
        items.sort((a,b) => {
            const ta = parseTimestamp(a.dataset.fecha, a.dataset.hora);
            const tb = parseTimestamp(b.dataset.fecha, b.dataset.hora);
            return tb - ta; // desc
        });
        // reinsertar en fragmento para minimizar repaints
        const frag = document.createDocumentFragment();
        items.forEach(it => frag.appendChild(it));
        container.appendChild(frag);
        initialOrder = items.slice(); // copia del nuevo orden
    }

    // Mostrar / ocultar por fecha sin reordenar
    function filtrarPorFecha(fecha) {
        const items = Array.from(container.querySelectorAll('.compra-item'));
        // remover cualquier mensaje previo de filtro vacío
        const prevMsg = document.getElementById('emptyFiltroMsg');
        if (prevMsg) prevMsg.remove();

        if (!fecha) {
            // mostrar todos y restaurar el orden inicial
            items.forEach(it => it.style.display = '');
            // restaurar orden guardado (initialOrder)
            const frag = document.createDocumentFragment();
            initialOrder.forEach(it => frag.appendChild(it));
            container.appendChild(frag);
            return;
        }

        // solo ocultar los que no coinciden (no reordenar)
        let shown = 0;
        items.forEach(it => {
            if (it.dataset.fecha === fecha) {
                it.style.display = '';
                shown++;
            } else {
                it.style.display = 'none';
            }
        });

        // si no hay resultados, mostrar mensaje
        if (shown === 0) {
            const msg = document.createElement('div');
            msg.id = 'emptyFiltroMsg';
            msg.className = 'empty';
            msg.textContent = 'No se encontraron compras en esa fecha.';
            container.parentNode.insertBefore(msg, container.nextSibling);
        }
    }

    // Inicial: ordenar por fecha/hora desc y guardar orden
    ordenarInicial();

    // Events
    btnFiltrar && btnFiltrar.addEventListener('click', () => filtrarPorFecha(input.value));
    btnQuitar && btnQuitar.addEventListener('click', () => {
        input.value = '';
        // quitar mensaje si existe
        const prevMsg = document.getElementById('emptyFiltroMsg');
        if (prevMsg) prevMsg.remove();
        filtrarPorFecha('');
    });

    // soporte Enter
    input && input.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            filtrarPorFecha(input.value);
        }
    });
});
</script>

</body>
</html>
