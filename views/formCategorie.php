<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../models/drivers/ConexDB.php';
include '../models/entities/Entity.php';
include '../models/entities/Categorie.php';
include '../controllers/CategorieController.php';

use app\controllers\CategorieController;
use app\models\entities\Categorie;



$conex = new \app\models\drivers\ConexDB();
$categorias = $conex->execSQL("SELECT id, name FROM categories");
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/formCategory.css">
    <title>Formulario Categoria</title>
</head>

<body>
<div class="logo">
    <h1>
        <?php echo empty($_GET['id']) ? 'Registrar categoria' : 'Modificar'; ?>
    </h1>
</div>
 


    <form action="../views/acciones/Categoria_Acciones/RegistrarCategoria.php" method="post">
        <?php
        if (!empty($_GET['id'])) {
            echo '<input type="hidden" name="idInput" value="' . $_GET['id'] . '">';
        }
        ?>
        <div>
            <label>Nombre categoria</label>
            <input type="text" name="nombreInput" value="<?= $category ? $category->get('name') : '' ?>" <?php if (!empty($_GET['id'])) echo ''; ?> required>
        </div>
        <div>
            <label>Porcentaje:</label>
            <input type="number" name="porcentajeInput" 
            value="<?= $category ? $category->get('percentage') : '' ?>" min="1" step="1" required>
        </div>
        <div>
            <button type="submit">Guardar</button>
        </div>
        <a href="../views/categorie.php">Volver</a>
    
    </form>
    
</body>
</html>