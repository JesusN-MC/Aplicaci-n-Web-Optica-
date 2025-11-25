<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Compra </title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin:0;
            padding:0;
        }

        .wrapper{
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 100px;
        }

        .card{
            background: white;
            padding: 30px;
            width: 420px;
            border-radius: 11px;
            box-shadow: 0 3px 10px rgba(0,0,0,.15);
            text-align: center;
            animation: fadeIn .4s ease-in-out;
        }

        h2{
            margin-top:0;
            color:#333;
        }

        .ok-icon{
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 10px;
        }

        .info{
            margin: 20px 0;
            text-align: left;
            background: #fafafa;
            padding: 15px;
            border-radius: 10px;
        }

        .info p{
            margin: 6px 0;
        }

        .btn{
            margin-top:20px;
            display:block;
            width:100%;
            padding:12px;
            background:#4CAF50;
            border:none;
            color:white;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
            transition: .2s;
        }

        .btn:hover{
            background:#45a049;
        }

        .btn-secondary{
            background:#607d8b;
        }

        .btn-secondary:hover{
            background:#546e7a;
        }

        @keyframes fadeIn {
            from{ opacity: 0; transform: translateY(30px); }
            to{ opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<?php 
    include '../../Components/Header/header_productos.php'; 

    $idCompra = $_GET['compra'];

    include '../Models/compra.php';
    $compra = new Compra();
    $res = $compra->consultar($idCompra);
    $c = mysqli_fetch_assoc($res);

    $idProducto = $c['fk_producto'];
    $idUsuario = $c['fk_usuario'];

    include '../Models/producto.php';
    $p = new Producto();
    $rp = $p->consultar($idProducto);
    $producto = mysqli_fetch_assoc($rp);

    include '../Models/usuario.php';
    $u = new Usuario();
    $ru = $u->buscarPorId($idUsuario);
    $usuario = mysqli_fetch_assoc($ru);
?>

<div class="wrapper">
    <div class="card">
            <h2>Detalles de la Compra</h2>
            <div class="ok-icon">✔</div>
            
            <p>La Compra se realizo de manera correcta.</p>

            <div class="info">
                <p><strong>Producto:</strong> <?php echo $producto['nombre']; ?></p>
                <p><strong>Marca:</strong> <?php echo $producto['marca']; ?></p>
                <p><strong>Categoría:</strong> <?php echo $producto['categoria']; ?></p>
                <p><strong>ID Producto:</strong> <?php echo $producto['id']; ?></p>
                
                <!-- Información del usuario -->
                <p><strong>Usuario:</strong> <?php echo $usuario['nombre'] . " " . $usuario['apellidos']; ?></p>
                <p><strong>ID Usuario:</strong> <?php echo $usuario['id']; ?></p>

                
                <p><strong>Fecha:</strong> <?php echo $c['fecha']; ?></p>
                <p><strong>Hora:</strong> <?php echo $c['hora']; ?></p>
                <p><strong>Total:</strong> <?php echo $c['total']; ?></p>
            </div>

            <button class="btn" onclick="history.back()">
                Regresar
            </button>

    </div>
</div>

</body>
</html>
