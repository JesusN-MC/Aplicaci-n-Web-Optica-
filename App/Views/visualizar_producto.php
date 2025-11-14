<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Producto</title>

    <link rel="stylesheet" href="../../CSS/login.css">
    <link rel="stylesheet" href="../../CSS/inputs.css">

    <style>
        body {
            background: #f5f7fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .view-container {
            width: 90%;
            max-width: 950px;
            background: #fff;
            margin-top: 400px;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
            animation: fadeIn 0.4s ease;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            color: #333;
        }

        .content {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .img-box {
            flex: 1;
            
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .img-box img {
            width: 100%;
            max-width: 350px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.18);
        }

        .info-box {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .info-item label {
            padding-top: 10vh;
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }

        .info-item div {
            margin-top: 4px;
            padding: 10px 14px;
            background: #f0f2f5;
            border-radius: 10px;
            font-size: 17px;
            color: #333;
            border-left: 4px solid #096545ff;
        }

        textarea {
            width: 100%;
            height: 120px;
            resize: none;
            padding: 10px;
            border-radius: 10px;
            background: #f0f2f5;
            border: none;
            border-left: 4px solid #096545ff;
            color: #333;
            font-size: 16px;
        }

        .btn-back {
            margin-top: 30px;
            display: block;
            width: 180px;
            text-align: center;
            background: #4a90e2;
            padding: 12px;
            font-size: 17px;
            color: white;
            border-radius: 10px;
            margin-left: auto;
            transition: 0.2s;
        }

        .btn-back:hover {
            background: #3b7ac2;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <?php 
        include '../../Components/Header/header_productos.php'; 

        $id = $_GET['producto'];
        include '../Models/producto.php';
        $clase = new Producto();
        $res = $clase->consultar($id);
        $datos = mysqli_fetch_assoc($res);

        // Cargar imagen existente
        $imagen = "../../Assets/" . $datos['imagen_principal'];
    ?>

    <div class="view-container">

        <h2>Detalles del Producto</h2>

        <div class="content">

            <!-- Información -->
            <div class="info-box">

                
                <div class="img-box">
                    <img src="<?php echo $imagen ?>" alt="Imagen del producto">
                </div>
                <div class="info-item">
                    <label>Nombre del Producto</label>
                    <div><?php echo $datos['nombre'] ?></div>
                </div>
                <div class="info-item">
                    <label>Marca</label>
                    <div><?php echo $datos['marca'] ?></div>
                </div>

                <div class="info-item">
                    <label>Categoría</label>
                    <div>
                        <?php
                            include '../Models/categoria.php';
                            $cat = new Categoria();
                            $r = $cat->consultar($datos['fk_categoria']);
                            $filaCat = mysqli_fetch_assoc($r);
                            echo $filaCat['nombre'];
                        ?>
                    </div>
                </div>

                <div class="info-item">
                    <label>Precio</label>
                    <div>$<?php echo number_format($datos['precio'], 2) ?></div>
                </div>

                <div class="info-item">
                    <label>Stock</label>
                    <div><?php echo $datos['stock'] ?></div>
                </div>

                <div class="info-item">
                    <label>Descripción</label>
                    <textarea readonly><?php echo $datos['descripcion'] ?></textarea>
                </div>

            </div>
        </div>

        <a class="btn-back" href="../../index.php">Regresar</a>

    </div>

</body>
</html>
