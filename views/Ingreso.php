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
    <link rel="stylesheet" href="css/Ingreso.css">
</head>
<body>
    <div class="logo">
        <h1>Ingreso</h1>
    </div>

    <div class="opciones">
    <a href="formularioIngreso.php" class="button-link">Registrar Ingreso</a> 
    </div>
    <br>

    

    <table class="Tabla">
        <thead>
            <tr>
                <th>Mes</th>
                <th>Año</th>
                <th>Ingreso</th>
                <th class="opciones" colspan="2">Opciones</th>
            </tr>
        </thead>
        <div class="tabla1">
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
        </div>

       
    </table>

    <div class="opciones">
    <a href="../views/Principal.php" class="button-link">Volver</a>
    </div>
    
</body>
</html>

