<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../models/drivers/ConexDB.php';
include '../models/entities/Entity.php';
include '../models/entities/Categorie.php';
include '../controllers/CategorieController.php';

use app\controllers\CategorieController;
use app\models\entities\Categorie;

$category  = null;
if (!empty($_GET['id'])) {
    $category = new Categorie();
    $category->set('id', $_GET['id']);
    // Consultar si es modificable
    $isModificable = $category->isModificable();
    // Obtener datos de la categoría
    $conex = new \app\models\drivers\ConexDB();
    $result = $conex->execSQL("SELECT * FROM categories WHERE id = " . intval($_GET['id']));
    if ($result && $row = $result->fetch_assoc()) {
        $category->set('name', $row['name']);
        $category->set('percentage', $row['percentage']);
    }
    $conex->close();
} else {
    $isModificable = true;
}

$conex = new \app\models\drivers\ConexDB();
$categorias = $conex->execSQL("SELECT id, name FROM categories");
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario Categoria</title>
</head>

<body>
<div class="logo">
    <h1>
        <?= empty($_GET['id']) ? 'Registrar categoria' : 'Modificar Categoria'; ?>
    </h1>
</div>
 


    <form action="../views/acciones/Categoria_Acciones/RegistrarCategoria.php" method="post">
        <?php if (!empty($_GET['id'])): ?>
            <input type="hidden" name="idInput" value="<?= $_GET['id'] ?>">
        <?php endif; ?>
        <div>
            <label>Nombre categoria</label>
            <input type="text" name="nombreInput" value="<?= $category ? $category->get('name') : '' ?>" <?= (!$isModificable ? 'readonly' : '') ?> required>
        </div>
        <div>
            <label>Porcentaje:</label>
            <input type="number" name="porcentajeInput" 
            value="<?= $category ? $category->get('percentage') : '' ?>" min="1" max="100" step="1" required <?= (!$isModificable ? 'readonly' : '') ?>>
        </div>
        <?php if ($isModificable): ?>
        <div>
            <button type="submit">Guardar</button>
        </div>
        <?php else: ?>
        <div>No se puede modificar esta categoría porque tiene gastos asociados.</div>
        <?php endif; ?>
        <a href="../views/Categoria.php">Volver</a>
    
    </form>
    
</body>
</html>