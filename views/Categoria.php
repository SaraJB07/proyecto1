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
    <link rel="stylesheet" href="css/General.css">
    <link rel="stylesheet" href="css/Categoria.css">
</head>

<body>
    <div class="logo">
        <h1>Categorias</h1>
    </div>

    <a href="formularioCategoria.php" class="button-link">Registrar Categoria</a>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Porcentaje</th>
                <th colspan="2">Opciones</th>
            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($categories as $categorie) {
                echo '<tr>';
                echo '  <td>' . htmlspecialchars($categorie->get('name')) . '</td>';
                echo '  <td>' . htmlspecialchars($categorie->get('percentage')) . '%</td>';
                echo '  <td>';
                echo '    <a href="formularioCategoria.php?id=' . htmlspecialchars($categorie->get('id')) . '" class="modify-link">Modificar</a> ';
                echo '    <a href="../views/acciones/Categoria_Acciones/EliminarCategoria.php?id=' . htmlspecialchars($categorie->get('id')) . '" onclick="return confirm(\'¿Seguro que desea eliminar esta categoría?\')" >Eliminar</a>';
                echo '  </td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <a href="../views/Principal.php" class="button-link">Volver </a>

</body>

</html>
