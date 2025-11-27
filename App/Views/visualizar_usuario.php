<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../App/Drivers/conexion.php');
$conexion = new Conexion();

$idUsuario = $_GET['id'] ?? 0;
$idUsuario = intval($idUsuario);

/* === OBTENER INFORMACIÓN DEL USUARIO === */
$sqlUser = "SELECT id, nombre, apellidos, correo, telefono FROM usuario WHERE id = $idUsuario LIMIT 1";
$resUser = $conexion->query($sqlUser);
$usuario = $resUser->fetch_assoc();

/* === OBTENER PERFILES DEPENDIENTES === */
$sqlPerfiles = "SELECT id, nombres, apellidos, parentesco, estatus FROM perfil WHERE fk_usuario = $idUsuario ORDER BY nombres ASC";
$resPerfiles = $conexion->query($sqlPerfiles);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>

    <style>
        :root{
            --green-1:#2ecc71;
            --muted:#6b7a74;
            --card-bg:#f8fdfb;
            --bg:#f4f7f5;
            --accent:#226a50;
        }

        body{
            margin:0;
            font-family:Inter, system-ui;
            background:var(--bg);
            color:#15392f;
        }

        .contenedor{
            width:100%;
            max-width:900px;
            margin:120px auto 40px;
            background:#fff;
            padding:32px;
            border-radius:16px;
            box-shadow:0 10px 35px rgba(0,0,0,0.06);
        }

        .titulo{
            font-size:1.8rem;
            font-weight:800;
            color:var(--accent);
            margin-bottom:20px;
        }

        .card{
            background:var(--card-bg);
            border:1px solid #dce7e1;
            padding:22px;
            border-radius:14px;
            margin-bottom:20px;
            box-shadow:0 4px 18px rgba(0,0,0,0.05);
        }

        .card h3{
            margin:0 0 10px 0;
            font-size:1.3rem;
            color:var(--accent);
        }

        .info-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:12px 20px;
        }

        .info-item{
            font-size:1rem;
            color:#24433a;
        }
        .info-label{
            font-weight:700;
            color:var(--muted);
        }

        .perfil-box{
            margin-top:30px;
        }

        .perfil-item{
            padding:18px;
            background:#fdfefd;
            border:1px solid #e6efea;
            border-radius:12px;
            margin-bottom:12px;
            transition:0.15s;
        }

        .perfil-item:hover{
            background:#f1fbf6;
            transform:translateY(-3px);
        }

        .perfil-nombre{
            font-size:1.15rem;
            font-weight:700;
            color:#15392f;
            margin-bottom:8px;
        }

        .perfil-dato{
            font-size:0.95rem;
            color:#4f6a63;
            margin-bottom:4px;
        }

        .botones{
            margin-top:32px;
            display:flex;
            gap:16px;
        }

        .btn{
            padding:12px 18px;
            border-radius:10px;
            text-decoration:none;
            font-weight:700;
            font-size:1rem;
            background:var(--accent);
            color:white;
            display:inline-block;
            transition:0.15s;
        }
        .btn:hover{
            background:#1a5240;
        }

        @media(max-width:650px){
            .info-grid{
                grid-template-columns:1fr;
            }
        }
    </style>
</head>
<body>

<?php include '../../Components/Header/header_servicios.php'; ?>
<?php include '../../barraServicios2.php'; ?>

<div class="contenedor">

    <div style="display: flex;">
        <button onclick="history.back()" style="background: transparent; border: none;">
                <svg xmlns="http://www.w3.org/2000/svg" style="witdh: 20px; height: 20px; color: black;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
        </button>
        <h2 class="titulo">Información del Usuario</h2>
    </div>
    

    <div class="card">
        <h3>Datos Generales</h3>
        <div class="info-grid">
            <div class="info-item"><span class="info-label">ID:</span> <?= $usuario['id'] ?></div>
            <div class="info-item"><span class="info-label">Nombre:</span> <?= $usuario['nombre'] . " " . $usuario['apellidos'] ?></div>
            <div class="info-item"><span class="info-label">Correo:</span> <?= $usuario['correo'] ?></div>
            <div class="info-item"><span class="info-label">Teléfono:</span> <?= $usuario['telefono'] ?></div>
        </div>
    </div>

    <div class="perfil-box">
        <h3 class="titulo" style="font-size:1.4rem; margin-bottom:14px;">Perfiles Dependientes</h3>

        <?php if ($resPerfiles->num_rows == 0): ?>
            <div class="perfil-item">Este usuario no tiene perfiles registrados.</div>
        <?php else: ?>
            <?php while ($p = $resPerfiles->fetch_assoc()): ?>
                <div class="perfil-item">
                    <div class="perfil-nombre"><?= $p['nombres'] . ' ' . $p['apellidos'] ?></div>
                    <div class="perfil-dato"><strong>Parentesco:</strong> <?= $p['parentesco'] ?></div>
                    
                    
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <div class="botones" style="display: flex;">
        <div>
            <a href="historial_compras.php?id=<?= $idUsuario ?>" class="btn">Historial de Compras</a>
            <a href="historial_citas.php?id=<?= $idUsuario ?>" class="btn">Historial de Citas</a>
        </div>
    </div>

</div>

</body>
</html>
