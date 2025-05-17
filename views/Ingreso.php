<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../models/drivers/ConexDB.php';
include '../models/entities/entity.php';
include '../models/entities/Ingreso.php';
include '../controllers/IngresoController.php';
include '../controllers/CategorieController.php'; 

use app\controllers\IngresoController;
use app\controllers\CategorieController;
use app\models\entities\Ingreso;

$catController = new CategorieController();
$categories = $catController->queryAllCategories();
$controller = new IngresoController();
$ingresos = $controller->queryAllIngreso();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingresos</title>
</head>
<body>
    <div class="logo">
        <h1>Ingreso</h1>
    </div>

    <a href="formularioIngreso.php">Registrar Ingreso</a> <a href="../views/Principal.php">Volver</a>
    <table>
        <thead>
            <tr>
                
                <th>Mes</th>
                <th>Año</th>
                <th>Ingreso</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($ingresos as $ingreso) {
               echo '<tr>';
        echo '  <td>' . $ingreso->get('month') . '</td>';
        echo '  <td>' . $ingreso->get('year') . '</td>';
        echo '  <td>' . $ingreso->get('value') . '</td>';
        echo '  <td><a href="formularioIngreso.php?id=' . $ingreso->get("id") . '">Modificar</a></td>';
        echo '  <td><a href="acciones/Ingreso_Acciones/EliminarIngreso.php?id=' . $ingreso->get("id") . '" onclick="return confirm(\'¿Seguro que desea eliminar este ingreso?\')">Eliminar</a></td>';
        echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    
</body>
</html>

