<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Conexión */
require_once('../../App/Drivers/conexion.php');
$conexion = new Conexion();

/* id objetivo recibido por GET */
$idUsuarioTarget = isset($_GET['id']) ? intval($_GET['id']) : 0;

/* obtener nombre del usuario objetivo (si existe) */
$usuarioTarget = null;
if ($idUsuarioTarget > 0) {
    $sqlU = "SELECT id, nombre, apellidos FROM usuario WHERE id = {$idUsuarioTarget} LIMIT 1";
    $resU = $conexion->query($sqlU);
    if ($resU && $resU->num_rows > 0) {
        $usuarioTarget = $resU->fetch_assoc();
    }
}

/* --- CONSULTA: traer citas del usuario y de sus perfiles dependientes --- */
$citas = [];

if ($idUsuarioTarget > 0) {

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
            (c.tipo = '0' AND c.idpaciente = {$idUsuarioTarget})
            OR
            (c.tipo = '1' AND p.fk_usuario = {$idUsuarioTarget})
        ORDER BY c.fecha ASC, c.hora ASC
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

            /* TRADUCIR ESTATUS: 0 = Pendiente, 1 = Completada */
            $estatus_raw = trim((string)$row['estatus']);

            if ($estatus_raw === '0') {
                $row['estatus_text'] = 'Pendiente';
                $row['estatus_key'] = 'pending';
            } elseif ($estatus_raw === '1') {
                $row['estatus_text'] = 'Completada';
                $row['estatus_key'] = 'completed';
            } else {
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
    <title>Citas del Usuario (vista)</title>
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
            max-width: 1200px;
            margin: 24px auto;
            margin-top: 120px;
            background: #ffffff;
            padding: 20px;
            border-radius: 18px;
            box-shadow: 0 6px 20px rgba(18,50,40,0.08);
            box-sizing: border-box;
        }
        .header-top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap: 12px;
            flex-wrap:wrap;
        }
        .titulo-seccion{
            font-size:1.45rem;
            font-weight:800;
            color:#226a50;
        }
        .subtitulo {
            color: #3f6b57;
            font-weight:600;
            margin-top:6px;
            font-size:0.98rem;
        }

        /* FILTRO */
        .filtro-box{
            display:flex;
            align-items:center;
            gap:10px;
            margin-top:15px;
            flex-wrap:wrap;
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
            gap:12px;
        }
        .cita-item{
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:14px;
            border-radius:12px;
            background:var(--card-bg);
            border:1px solid #e6efea;
            transition: transform .12s ease, box-shadow .12s ease, background .12s;
            cursor:pointer;
        }
        .cita-item:hover{ transform: translateY(-3px); box-shadow: 0 6px 18px rgba(18,50,40,0.06); background:#f2fbf6; }

        .cita-left{ display:flex; flex-direction:column; gap:6px; min-width:240px; }
        .cita-paciente{ font-weight:700; color:#15392f; font-size:1rem; }
        .cita-motivo{ background:#dff8eb; padding:6px 10px; border-radius:10px; font-weight:600; font-size:0.84rem; color:#126442; display:inline-block; }

        .cita-center{ display:flex; flex-direction:column; gap:6px; min-width:200px; }
        .meta-row{ font-size:0.9rem; color:var(--muted); }
        .meta-row span{ font-weight:700; color:#1d3b32; margin-right:6px; }

        .status-badge{
            padding:8px 12px;
            border-radius:999px;
            font-weight:700;
            font-size:0.82rem;
            white-space:nowrap;
        }
        .pending{ background:rgba(241,196,15,0.12); color:var(--yellow); }
        .completed{ background:rgba(46,204,113,0.12); color:var(--green-1); }
        .unknown{ background:#e0e0e0; color:#444; }

        /* Responsive */
        @media (max-width: 880px) {
            .cita-item {
                flex-direction: column;
                align-items: flex-start;
                gap:8px;
            }
            .cita-left, .cita-center { width:100%; display:flex; justify-content:space-between; }
            .cita-center { gap:4px; }
        }

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

    <?php include '../../Components/Header/header_servicios.php'; ?>
    <?php include '../../barraServicios2.php'?>

<div class="contenedor-citas">

    <div class="header-top">
        <div>
            <div style="display: flex;">
                <button onclick="history.back()" style="background: transparent; border: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="witdh: 20px; height: 20px; color: black;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h2 class="titulo-seccion">
                    Citas de <?= $usuarioTarget ? htmlspecialchars($usuarioTarget['nombre'] . ' ' . $usuarioTarget['apellidos']) : 'Usuario desconocido' ?>
                </h2>
            </div>
            
            <?php if ($usuarioTarget): ?>
                <div class="subtitulo">Citas del usuario y de sus perfiles dependientes</div>
            <?php else: ?>
                <div class="subtitulo" style="color:#b03a3a;">ID inválido o usuario no encontrado</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- FILTRO -->
    <div class="filtro-box">
        <input type="date" id="filtroFecha" class="input-date" aria-label="Filtrar por fecha">
        <button class="btn-filtrar" id="btnFiltrar" type="button">Filtrar</button>
        <button class="btn-limpiar" id="btnQuitar" type="button">Quitar filtro</button>
    </div>

    <div class="lista-citas" id="listaCitas">
        <?php if ($idUsuarioTarget <= 0): ?>
            <div class="empty">No se indicó un usuario válido. Pasa ?idUsuario=ID en la URL.</div>
        <?php elseif (empty($citas)): ?>
            <div class="empty">No hay citas para este usuario.</div>
        <?php else: ?>
            <?php foreach ($citas as $fila): ?>
                <?php
                    $fecha_attr = htmlspecialchars($fila['fecha'] ?? '');
                    $paciente = htmlspecialchars($fila['paciente'] ?? 'Sin nombre');
                    $motivo = htmlspecialchars($fila['motivo'] ?? 'Sin motivo');
                    $hora = htmlspecialchars($fila['hora'] ?? '');
                    $estatus_text = htmlspecialchars($fila['estatus_text'] ?? 'Desconocido');
                    $estatus_key = htmlspecialchars($fila['estatus_key'] ?? 'unknown');
                    $estatus_class = ($estatus_key === 'pending') ? 'pending' : (($estatus_key === 'completed') ? 'completed' : 'unknown');
                ?>

                <div class="cita-item"
                     data-id="<?= intval($fila['id']) ?>"
                     data-fecha="<?= $fecha_attr ?>"
                     data-hora="<?= $hora ?>"
                     data-estatus="<?= $estatus_key ?>"
                     onclick="abrirCita(this)"
                >
                    <div class="cita-left">
                        <div class="cita-paciente"><?= $paciente ?></div>
                        <div class="cita-motivo"><?= $motivo ?></div>
                    </div>

                    <div class="cita-center">
                        <div class="meta-row"><span>Fecha:</span> <?= $fecha_attr ?: '—' ?></div>
                        <div class="meta-row"><span>Hora:</span> <?= $hora ?: '—' ?></div>
                    </div>

                    <div class="status-badge <?= $estatus_class ?>"><?= $estatus_text ?></div>
                </div>

            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
/* Ahora: SIEMPRE abrir la vista de solo lectura.
   La ruta base solicitada: ../../ruta/visualizar_formulario_clinico.php?id_cita=ID
*/
function abrirCita(elemento) {
    const id = elemento.getAttribute('data-id');
    const target = 'visualizar_formulario_clinico.php?id_cita=' + encodeURIComponent(id);
    window.location.href = target;
}

/* UTIL y UI: filtrado/ordenamiento */
function toTimestamp(fecha, hora) {
    if (!fecha) return -Infinity;
    let timePart = (hora && hora.trim() !== '') ? hora.trim() : '00:00';
    const iso = fecha + 'T' + timePart + ':00';
    const t = Date.parse(iso);
    return isNaN(t) ? -Infinity : t;
}

function sortCitasInDOM(container) {
    const items = Array.from(container.querySelectorAll('.cita-item'));
    items.sort((a, b) => {
        const estA = a.dataset.estatus || 'unknown';
        const estB = b.dataset.estatus || 'unknown';
        const scoreA = (estA === 'pending') ? 0 : (estA === 'completed' ? 1 : 2);
        const scoreB = (estB === 'pending') ? 0 : (estB === 'completed' ? 1 : 2);
        if (scoreA !== scoreB) return scoreA - scoreB;
        const tA = toTimestamp(a.dataset.fecha, a.dataset.hora);
        const tB = toTimestamp(b.dataset.fecha, b.dataset.hora);
        return tB - tA;
    });
    items.forEach(it => container.appendChild(it));
}

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
    sortVisibleCitas(container);
}

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
    const hidden = Array.from(container.querySelectorAll('.cita-item.hidden'));
    visible.forEach(it => container.appendChild(it));
    hidden.forEach(it => container.appendChild(it));
}

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('listaCitas');
    const inputFecha = document.getElementById('filtroFecha');
    const btnFiltrar = document.getElementById('btnFiltrar');
    const btnQuitar = document.getElementById('btnQuitar');

    if (!container) return;

    // ordenar todas inicialmente
    sortCitasInDOM(container);

    btnFiltrar.addEventListener('click', () => {
        const fecha = inputFecha.value;
        filtrarPorFecha(fecha);
    });

    btnQuitar.addEventListener('click', () => {
        inputFecha.value = '';
        filtrarPorFecha('');
        sortCitasInDOM(container);
    });

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
