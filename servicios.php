<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* conexión */
require_once('App/Drivers/conexion.php');
$conexion = new Conexion();

/* id del usuario en sesión */
$idUsuario = isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : 0;

$citas = [];

if ($idUsuario !== 0) {

    /* Consulta corregida: tipo 0 = usuario, tipo 1 = perfil */
    $sql = "
        SELECT 
            c.id,
            c.motivo,
            c.fecha,
            c.hora,
            c.estatus,
            c.tipo,
            CASE 
                WHEN c.tipo = '0' THEN CONCAT(u.nombre, ' ', u.apellidos)
                WHEN c.tipo = '1' THEN CONCAT(p.nombres, ' ', p.apellidos)
                ELSE 'Desconocido'
            END AS paciente
        FROM cita c
        LEFT JOIN usuario u ON (c.tipo = '0' AND c.idpaciente = u.id)
        LEFT JOIN perfil p  ON (c.tipo = '1' AND c.idpaciente = p.id)
        WHERE 
            (c.tipo = '0' AND c.idpaciente = {$idUsuario})
            OR
            (c.tipo = '1' AND p.fk_usuario = {$idUsuario})
    ";

    $res = $conexion->query($sql);

    if ($res) {
        while ($row = $res->fetch_assoc()) {

            /* Normalizar hora (HH:MM) */
            if (!empty($row['hora'])) {
                $row['hora'] = substr($row['hora'], 0, 5);
            } else {
                $row['hora'] = '';
            }

            /* TRADUCIR ESTATUS: 0 = Pendiente, 1 = Completada (según pediste) */
            $estatus_raw = trim((string)$row['estatus']);

            if ($estatus_raw === '0') {
                // 0 = pendiente
                $row['estatus_text'] = 'Pendiente';
                $row['estatus_key'] = 'pending';
            }
            elseif ($estatus_raw === '1') {
                // 1 = completada
                $row['estatus_text'] = 'Completada';
                $row['estatus_key'] = 'completed';
            }
            else {
                $row['estatus_text'] = 'Desconocido';
                $row['estatus_key'] = 'unknown';
            }
            $citas[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Pantalla de Citas</title>

    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif !important;
            background: #f4f7f5;
        }
        :root{
            --green-1: #2ecc71;
            --green-2: #1faa5b;
            --yellow: #f1c40f;
            --muted: #6b7a74;
            --card-bg: #f8fdfb;
        }
        .contenedor-citas {
            width: 100%;
            max-width: 980px;
            margin: 24px auto;
            margin-top: 120px;
            background: #ffffff;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(18,50,40,0.08);
        }
        .header-top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap: 12px;
        }
        .titulo-seccion{
            font-size:1.45rem;
            font-weight:800;
            color:#226a50;
        }
        .btn-crear{
            padding:9px 16px;
            background:linear-gradient(135deg,var(--green-1),var(--green-2));
            color:#fff;
            border-radius:10px;
            text-decoration:none;
            font-weight:700;
        }

        /* FILTRO */
        .filtro-box{
            display:flex;
            align-items:center;
            gap:10px;
            margin-top:15px;
        }
        .input-date{
            padding:8px 12px;
            border-radius:8px;
            border:1px solid #d5e3dc;
            font-size:0.9rem;
        }
        .btn-limpiar{
            padding:7px 12px;
            border-radius:8px;
            background:#e74c3c;
            color:#fff;
            cursor:pointer;
            border:none;
            font-weight:700;
        }
        .btn-filtrar{
            padding:7px 12px;
            border-radius:8px;
            background:#3498db;
            color:#fff;
            cursor:pointer;
            border:none;
            font-weight:700;
        }

        /* CITA */
        .lista-citas{
            margin-top:20px;
            display:flex;
            flex-direction:column;
            gap:10px;
        }
        .cita-item{
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:12px;
            border-radius:12px;
            background:var(--card-bg);
            border:1px solid #e6efea;
        }

        .cita-left{ display:flex; flex-direction:column; gap:6px; min-width:200px; }
        .cita-paciente{ font-weight:700; color:#15392f; font-size:1rem; }
        .cita-motivo{ background:#dff8eb; padding:6px 10px; border-radius:10px; font-weight:600; font-size:0.82rem; color:#126442; }

        .cita-center{ display:flex; flex-direction:column; gap:6px; min-width:150px; }
        .meta-row{ font-size:0.9rem; color:var(--muted); }
        .meta-row span{ font-weight:700; color:#1d3b32; }

        .status-badge{
            padding:8px 12px;
            border-radius:999px;
            font-weight:700;
            font-size:0.82rem;
        }
        .pending{ background:rgba(241,196,15,0.12); color:var(--yellow); }
        .completed{ background:rgba(46,204,113,0.12); color:var(--green-1); }
        .unknown{ background:#e0e0e0; color:#444; }

        /* RESPONSIVE SOLO PARA MÓVIL */
        @media (max-width: 600px) {
            .btn-crear{
                margin-right: 30px;
            }

            .cita-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                margin-right: 30px;
            }

            .cita-left, .cita-center {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                width: 100%;
            }

            .status-badge{
                align-self: flex-start;
                margin-top: 6px;
            }
        }

        /* Ocultar para JS */
        .hidden{ display:none !important; }

        .empty {
            padding:14px;
            border-radius:10px;
            background:#fff;
            border:1px dashed #d8eae0;
            color:#6b7a74;
            font-style:italic;
        }
    </style>
</head>
<body>

    <?php include './Components/Header/header_servicios_home.php'; ?>
    <?php include 'barraServicios.php'?>

<div class="contenedor-citas">

    <div class="header-top">
        <h2 class="titulo-seccion">Mis citas</h2>
        <a class="btn-crear" href="./App/Views/form_reservar_cita1.php">+ Nueva cita</a>
    </div>

    <!-- FILTRO -->
    <div class="filtro-box">
        <input type="date" id="filtroFecha" class="input-date" aria-label="Filtrar por fecha">
        <button class="btn-filtrar" id="btnFiltrar" type="button">Filtrar</button>
        <button class="btn-limpiar" id="btnQuitar" type="button">Quitar filtro</button>
    </div>

    <div class="lista-citas" id="listaCitas">
        <?php if (empty($citas)): ?>
            <div class="empty">No hay citas registradas para tu cuenta.</div>
        <?php else: ?>
            <?php foreach ($citas as $fila): ?>
                <?php
                    $fecha_attr = htmlspecialchars($fila['fecha'] ?? '');
                    $paciente = htmlspecialchars($fila['paciente'] ?? 'Sin nombre');
                    $motivo = htmlspecialchars($fila['motivo'] ?? 'Sin motivo');
                    $hora = htmlspecialchars($fila['hora'] ?? '');
                    $estatus_text = htmlspecialchars($fila['estatus_text'] ?? 'Desconocido');
                    $estatus_key = htmlspecialchars($fila['estatus_key'] ?? 'unknown'); // pending|completed|unknown
                    $estatus_class = ($estatus_key === 'pending') ? 'pending' : (($estatus_key === 'completed') ? 'completed' : 'unknown');
                ?>

                <div class="cita-item"
                     data-fecha="<?= $fecha_attr ?>"
                     data-hora="<?= $hora ?>"
                     data-estatus="<?= $estatus_key ?>"
                >
                    <div class="cita-left">
                        <div class="cita-paciente"><?= $paciente ?></div>
                        <div class="cita-motivo"><?= $motivo ?></div>
                    </div>

                    <div class="cita-center">
                        <div class="meta-row"><span>Fecha:</span> <?= $fecha_attr ?></div>
                        <div class="meta-row"><span>Hora:</span> <?= $hora ?></div>
                    </div>

                    <div class="status-badge <?= $estatus_class ?>"><?= $estatus_text ?></div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
/* UTIL: convierte fecha+hora a timestamp (ms). Si falta valor devuelve -Infinity para ponerlo al final */
function toTimestamp(fecha, hora) {
    if (!fecha) return -Infinity;
    // hora puede ser '' o 'HH:MM'
    let timePart = (hora && hora.trim() !== '') ? hora.trim() : '00:00';
    // Crear string ISO local
    const iso = fecha + 'T' + timePart + ':00';
    const t = Date.parse(iso);
    return isNaN(t) ? -Infinity : t;
}

/* Ordena nodos .cita-item dentro de #listaCitas
   Reglas:
   - pendientes (data-estatus="pending") primero, luego completadas ("completed")
   - dentro de cada grupo: fecha desc (más alta primero), hora desc
*/
function sortCitasInDOM(container) {
    const items = Array.from(container.querySelectorAll('.cita-item'));
    items.sort((a, b) => {
        const estA = a.dataset.estatus || 'unknown';
        const estB = b.dataset.estatus || 'unknown';
        const scoreA = (estA === 'pending') ? 0 : (estA === 'completed' ? 1 : 2);
        const scoreB = (estB === 'pending') ? 0 : (estB === 'completed' ? 1 : 2);

        if (scoreA !== scoreB) return scoreA - scoreB; // pendientes primero

        // mismo estatus: comparar fecha+hora (desc)
        const tA = toTimestamp(a.dataset.fecha, a.dataset.hora);
        const tB = toTimestamp(b.dataset.fecha, b.dataset.hora);

        return tB - tA; // fecha/hora más alta primero
    });

    // Re-append en nuevo orden
    items.forEach(it => container.appendChild(it));
}

/* Filtrar por fecha: muestra solo las que coinciden con la fecha dada (YYYY-MM-DD)
   y ordena las visibles con la misma regla.
*/
function filtrarPorFecha(fecha) {
    const container = document.getElementById('listaCitas');
    const items = Array.from(container.querySelectorAll('.cita-item'));
    items.forEach(item => {
        if (!fecha) {
            item.classList.remove('hidden');
        } else {
            item.classList.toggle('hidden', item.dataset.fecha !== fecha);
        }
    });
    // ordenar solo los visibles (mejora UX)
    sortVisibleCitas(container);
}

/* Ordena solo los visibles dentro del contenedor (no reordena ocultos) */
function sortVisibleCitas(container) {
    const visible = Array.from(container.querySelectorAll('.cita-item:not(.hidden)'));
    visible.sort((a, b) => {
        const estA = a.dataset.estatus || 'unknown';
        const estB = b.dataset.estatus || 'unknown';
        const scoreA = (estA === 'pending') ? 0 : (estA === 'completed' ? 1 : 2);
        const scoreB = (estB === 'pending') ? 0 : (estB === 'completed' ? 1 : 2);

        if (scoreA !== scoreB) return scoreA - scoreB;
        const tA = toTimestamp(a.dataset.fecha, a.dataset.hora);
        const tB = toTimestamp(b.dataset.fecha, b.dataset.hora);
        return tB - tA;
    });

    // append visible items in order; ensure hidden ones stay but after (we'll re-append hidden after)
    const hidden = Array.from(container.querySelectorAll('.cita-item.hidden'));
    visible.forEach(it => container.appendChild(it));
    hidden.forEach(it => container.appendChild(it));
}

/* Inicialización al cargar página */
document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('listaCitas');
    const inputFecha = document.getElementById('filtroFecha');
    const btnFiltrar = document.getElementById('btnFiltrar');
    const btnQuitar = document.getElementById('btnQuitar');

    // Si no hay filtro (campo vacío), ordenar TODO según regla
    if (!inputFecha.value) {
        sortCitasInDOM(container);
    } else {
        // si venía un valor (raro), aplicar filtro y ordenar visibles
        filtrarPorFecha(inputFecha.value);
    }

    // evento filtrar
    btnFiltrar.addEventListener('click', () => {
        const fecha = inputFecha.value;
        filtrarPorFecha(fecha);
    });

    // quitar filtro: limpiar input, mostrar todo y ordenar según regla
    btnQuitar.addEventListener('click', () => {
        inputFecha.value = '';
        filtrarPorFecha('');
        sortCitasInDOM(container);
    });

    // soporte Enter dentro del input fecha
    inputFecha.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            filtrarPorFecha(inputFecha.value);
        }
    });
});
</script>

</body>
</html>
