<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../models/drivers/ConexDB.php';
include '../models/entities/entity.php';
include '../models/entities/Categorie.php';
include '../controllers/CategorieController.php';

use app\controllers\CategorieController;
use app\models\entities\Categorie;

$controller = new CategorieController();
$categories = $controller->queryAllCategories();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Categorias</title>
</head>

<body>
    <div class="logo">
    <h1>Categorias</h1>
    </div>

    <a href="formularioCategoria.php">Registrar Categoria</a>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Porcentaje</th>
                
            </tr>
        </thead>
        
        <tbody>
   
    
        <?php
        foreach ($categories as $categorie) {
            echo '<tr>';
            echo '  <td>' . $categorie->get('name') . '</td>';
            echo '  <td>' . $categorie->get('percentage') . '</td>';
            echo '  <td>';
            echo '      <a href="formularioCategoria.php?id=' . $categorie->get('id') . '">Modificar</a> ';
            echo '      <a href="../views/acciones/Categoria_Acciones/EliminarCategoria.php?id=' . $categorie->get('id') . '">Eliminar</a>';
            echo '  </td>';
        }
        ?>
        </tbody>
    </table>
    <a href="../views/Principal.php">Volver a página de inicio</a></body>

</html>