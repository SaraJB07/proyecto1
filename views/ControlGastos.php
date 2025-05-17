<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../models/drivers/ConexDB.php';
include '../models/entities/Entity.php';
include '../models/entities/Ingreso.php';
include '../models/entities/ControlGastos.php';
include '../controllers/CategorieController.php';

use app\controllers\CategorieController;
use app\models\entities\Categorie;
use app\models\entities\ControlGastos;

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

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/formDish.css">
    <title>Formulario Control De Gastos</title>
</head>

<body>
    <div class="logo">
        <h1>Control Gastos</h1>
    </div>

    <a href="formularioControlGastos.php">Registrar Gasto</a> <a href="../views/Principal.php">Volver</a>

    <form action="../views/acciones/ControlGastos/RegistroGastos.php" method="post">
        <?php if (!empty($_GET['id'])): ?>
            <input type="hidden" name="idInput" value="<?= $_GET['id'] ?>">
        <?php endif; ?>
    </form>

    <h2>Gastos Registrados</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sqlGastos = "SELECT b.id, b.value, c.name as categoria, r.month, r.year FROM bills b
            INNER JOIN categories c ON b.idCategory = c.id
            INNER JOIN reports r ON b.idReport = r.id";
        $gastos = $conex->execSQL($sqlGastos);
        if ($gastos && $gastos->num_rows > 0) {
            while ($g = $gastos->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($g['categoria']) . '</td>';
                echo '<td>' . htmlspecialchars($g['month']) . '</td>';
                echo '<td>' . htmlspecialchars($g['year']) . '</td>';
                echo '<td>' . htmlspecialchars($g['value']) . '</td>';
                echo '<td>';
                echo '<a href="formularioControlGastos.php?id=' . $g['id'] . '">Modificar</a> ';
                echo '<a href="../views/acciones/ControlGastos/EliminarGastos.php?id=' . $g['id'] . '" onclick="return confirm(\'¿Seguro que desea eliminar este gasto?\')">Eliminar</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td>No hay gastos registrados.</td></tr>';
        }
        ?>
        </tbody>
    </table>
</body>
</html>