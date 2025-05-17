<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../controllers/ControlGastosController.php';
include '../models/drivers/ConexDB.php';
include '../models/entities/Entity.php';
include '../models/entities/ControlGastos.php';

use app\controllers\ControlGastosController;
use app\entities\Entity;
use app\entities\ControlGastos;


$conex = new \app\models\drivers\ConexDB();
$categorias = $conex->execSQL("SELECT id, name FROM categories");
$mesesAnios = $conex->execSQL("SELECT DISTINCT month, year FROM reports ORDER BY year DESC, month DESC");

$meses = [];
$anios = [];
if ($mesesAnios && $mesesAnios->num_rows > 0) {
    while ($fila = $mesesAnios->fetch_assoc()) {
        if (!in_array($fila['month'], $meses)) {
            $meses[] = $fila['month'];
        }
        if (!in_array($fila['year'], $anios)) {
            $anios[] = $fila['year'];
        }
    }
}

// Cargar datos del gasto si es edición
$gasto = null;
if (!empty($_GET['id'])) {
    $idGasto = intval($_GET['id']);
    $gastoObj = new \app\models\entities\ControlGastos();
    $allGastos = $gastoObj->all();
    foreach ($allGastos as $g) {
        if ($g->get('id') == $idGasto) {
            $gasto = $g;
            break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el guardado o actualización del gasto aquí...
    // ... código de guardado ...
    header('Location: ControlGastos.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Gastos</title>
</head>
<body>

<h1>
    <?php echo empty($_GET['id']) ? 'Registrar Gasto' : 'Modificar Gasto'; ?>
</h1>

<form action="../views/acciones/ControlGastos/RegistroGastos.php" method="post">
    <?php if (!empty($_GET['id'])): ?>
        <input type="hidden" name="idInput" value="<?= $_GET['id'] ?>">
    <?php endif; ?>

    <div>
        <label>Categoria:</label>
        <select name="categoryInput" required>
            <option value="">Seleccione una categoría</option>
            <?php
            if ($categorias && $categorias->num_rows > 0) {
                while ($cat = $categorias->fetch_assoc()) {
                    $selected = ($gasto && $cat['id'] == $gasto->get('idCategory')) ? 'selected' : '';
                    echo "<option value='{$cat['id']}' $selected>{$cat['name']}</option>";
                }
            }
            ?>
        </select>
    </div>

    <div>
        <label>Mes:</label>
        <select name="monthInput" required <?php if (!empty($_GET['id'])) echo 'disabled'; ?>>
            <option value="">Seleccione un mes</option>
            <?php
            foreach ($meses as $mes) {
                $selected = ($gasto && $mes == $gasto->get('month')) ? 'selected' : '';
                echo "<option value='$mes' $selected>$mes</option>";
            }
            ?>
        </select>
        <?php if (!empty($_GET['id']) && $gasto): ?>
            <input type="hidden" name="monthInput" value="<?= $gasto->get('month') ?>">
        <?php endif; ?>
    </div>

    <div>
        <label>Año: </label>
        <select name="yearInput" required <?php if (!empty($_GET['id'])) echo 'disabled'; ?>>
            <option value="">Seleccione un año</option>
            <?php
            foreach ($anios as $anio) {
                $selected = ($gasto && $anio == $gasto->get('year')) ? 'selected' : '';
                echo "<option value='$anio' $selected>$anio</option>";
            }
            ?>
        </select>
        <?php if (!empty($_GET['id']) && $gasto): ?>
            <input type="hidden" name="yearInput" value="<?= $gasto->get('year') ?>">
        <?php endif; ?>
    </div>

    <div>
        <label>Valor del Gasto: </label>
        <input type="number" name="valueInput" value="<?= $gasto ? $gasto->get('value') : '' ?>" min="1" step="1" required>
    </div>

    <div>
        <button type="submit">Guardar</button>
    </div>

    <a href="ControlGastos.php">Volver</a>
</form>

</body>
</html>
