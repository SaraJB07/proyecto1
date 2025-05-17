<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../models/drivers/ConexDB.php';
include '../models/entities/Entity.php';
include '../models/entities/Ingreso.php';
include '../controllers/IngresoController.php';

use app\controllers\IngresoController;
use app\models\entities\Ingreso;

$ingreso  = null;
if (!empty($_GET['id'])) {
    $ingreso = (new Ingreso())->find($_GET['id']);
}

$conex = new \app\models\drivers\ConexDB();
$categorias = $conex->execSQL("SELECT id, name FROM categories");
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Formulario Ingreso</title>
</head>

<body>
    <div class="logo">
        <h1><?= empty($_GET['id']) ? 'Registrar Ingreso' : 'Modificar Ingreso' ?></h1> 

    </div>

    <form action="../views/acciones/Ingreso_Acciones/RegistroIngreso.php" method="post">
        <?php if (!empty($_GET['id'])): ?>
            <input type="hidden" name="idInput" value="<?= $_GET['id'] ?>">
        <?php endif; ?>

        <div>
            <label>Mes:</label>
            <input type="text" name="monthInput" required value="<?= $ingreso ? $ingreso->get('month') : '' ?>" <?php if (!empty($_GET['id'])) echo 'readonly'; ?>>      
        </div>

        <!--<div>
            <label>Categoría</label>
            <select name="categoriaInput" required>
                <option value="">Seleccione una categoría</option>
                <?php
                /*
                if ($categorias->num_rows > 0) {
                    while ($cat = $categorias->fetch_assoc()) {
                        $selected = ($dish && $cat['id'] == $dish->get('idCategory')) ? 'selected' : '';
                        echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                    }
                }*/
                ?>
            </select>
        </div>-->

        <div>
            <label>Año: </label>
            <input type="number" name="yearInput" value="<?= $ingreso ? $ingreso->get('year') : '' ?>" min="1" step="1" required <?php if (!empty($_GET['id'])) echo 'readonly'; ?>>
        </div>

        <div>
            <label>Ingreso: </label>
            <input type="number" name="valueInput" value="<?= $ingreso ? $ingreso->get('value') : '' ?>" min="1" step="1" required>
        </div>

        <div>
            <button type="submit">Guardar</button>
        </div>

        <a href="Ingreso.php">Volver</a>
      
    </form>
</body>
</html>