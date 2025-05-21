<?php

include '../../../models/drivers/ConexDB.php';
include '../../../models/entities/Entity.php';
include '../../../models/entities/Categorie.php';
include '../../../controllers/CategorieController.php';

use app\controllers\CategorieController;

$controller = new CategorieController();
$result = $controller->deleteCategorie($_GET['id']);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar Categoria</title>
    <link rel="stylesheet" href="../../css/respuesta.css">
     <link rel="stylesheet" href="../../css/General.css">
</head>

<body>
<div class="logo">
    <h1>Resultado</h1>
</div>
<div class="form-ingreso-container">
     <?php
    if (is_array($result)) {
        if (!$result['categoriaEliminada'] && !empty($result['bloqueada'])) {
            echo '<p>No se puede eliminar la categoría porque tiene gastos asociados.</p>';
        } elseif ($result['categoriaEliminada']) {
            echo '<p>Datos eliminados</p>';
        } else {
            echo '<p>No se pudo borrar los datos</p>';
        }
    } else {
        echo ($result ? '<p>Datos eliminados</p>' : '<p>No se pudo borrar los datos</p>');
    }
    ?>
    </div>
    <br>
    <a href="../../Categoria.php" class="button-link">Volver</a> 


</body>

</html>