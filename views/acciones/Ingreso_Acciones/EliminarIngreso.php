<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../../../controllers/IngresoController.php';
include '../../../models/drivers/ConexDB.php';
include '../../../models/entities/Entity.php';
include '../../../models/entities/Ingreso.php';

use app\controllers\IngresoController;
use app\models\entities\Ingreso;

$controller = new IngresoController();
$id = $_GET['id'];
$ingreso = (new Ingreso())->find($id);
$result = $controller->deleteIngreso($id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de la operación</title>
</head>
<body>
<div class="logo">
    <h1>Resultado de la operación</h1>
</div>
    <?php
        if ($result) {
            echo '<br><p>Ingreso eliminado</p>';
        } else {
            echo '<p>No se puede eliminar el ingreso</p>';
        }
    ?>
    <a href="../../Ingreso.php">Volver</a>
</body>
</html>