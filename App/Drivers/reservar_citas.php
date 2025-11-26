<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producto Asignado</title>

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
    session_start();
$motivo = $_POST['motivo'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$valor = $_POST["paciente"];   // ejemplo: "perfil-7"

list($tipo, $idpaciente) = explode("-", $valor);

include('../Models/cita.php');

$clase = new Cita();
$resultado = $clase->reservar_cita($motivo, $fecha, $hora, $idpaciente, $tipo);

if ($resultado) {?>
    <div class="wrapper">
        <div class="card">
            <div class="ok-icon">✔</div>
            <h2>Cita Asignada</h2>
            <p>La reservacion se realizó correctamente.</p>

            <button class="btn" onclick="location.href='../../servicios.php'">
                Volver a Citas
            </button>
            
        </div>
    </div>
<?
} else { 
    echo "Error al reservar cita";
}
    
?>
