<?php 
    $id = $_GET['categoria'];

    include('../../App/Models/categoria.php');
    $clase = new Categoria();
    
    $clase->habilitar($id);
    header("Location: ../../App/Views/gestion_categorias.php");

?>