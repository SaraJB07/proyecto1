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
    <link rel="stylesheet" href="../../css/respuesta.css">
     <link rel="stylesheet" href="../../css/General.css">
</head>
<body>
    <div class="logo">
        <h1>Resultado</h1>
    </div>
    <div class="form-ingreso-container">
        <?php
        if ($result) {
            echo '<p>Ingreso eliminado</p>';
            } else {
            echo '<p>No se puede eliminar el ingreso</p>';
            }
         ?>

    </div>
    <br>
    <a href="../../Ingreso.php" class="button-link">Volver</a>   

</body>
</html>