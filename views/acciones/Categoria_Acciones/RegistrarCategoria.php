<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../../../models/drivers/ConexDB.php';
include '../../../models/entities/Entity.php';
include '../../../models/entities/Categorie.php';
include '../../../controllers/CategorieController.php';

use app\controllers\CategorieController;

$controller = new CategorieController();
$result = empty($_POST['idInput'])
    ? $controller->saveNewCategorie($_POST)
    : $controller->updateCategorie($_POST);
  
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
    <link rel="stylesheet" href="../../css/respuesta.css">
     <link rel="stylesheet" href="../../css/General.css">
</head>

<body>
<div class="logo">
    <h1>Resultado</h1>
</div>
    <div class="form-ingreso-container">
    <?php
    if (is_array($result) && !empty($result['excesoPorcentaje'])) {
        echo '<p>La suma de los porcentajes de las categorías no puede superar el 100%.</p>';
    } elseif ($result) {
        echo '<p>Datos guardados</p>';
    } else {
        echo '<p>No se pudo guardar los datos</p>';
    }
    ?>
    </div>
    <br>
    <a href="../../Categoria.php" class="button-link">Volver</a> 


</body>

</html>