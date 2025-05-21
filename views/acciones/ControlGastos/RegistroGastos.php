<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../../../models/drivers/ConexDB.php';
include '../../../models/entities/Entity.php';
include '../../../models/entities/ControlGastos.php';
include '../../../controllers/CategorieController.php';
include '../../../controllers/ControlGastosController.php';

use app\models\entities\ControlGastos;
use app\controllers\ControlGastosController;

$controller = new ControlGastosController();

if (!empty($_POST['idInput'])) {
    $result = $controller->updateGasto($_POST);
} else {
    $result = $controller->saveGasto($_POST);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la operación (Registrar Gasto):</title>  
    <link rel="stylesheet" href="../../css/respuesta.css">
    <link rel="stylesheet" href="../../css/General.css">
<body>
    <div class="logo">
    <h1>Resultado</h1>
    </div>
    <div class="form-ingreso-container">
    <?php
    if (is_array($result) && !empty($result['mesAnioNoExiste'])) {
        echo '<p>No se puede guardar el gasto porque el mes y año no existen en los reportes.</p>';
    } elseif ($result) {
        echo '<p>Datos guardados</p>';
    } else {
        echo '<p>No se pudo guardar los datos</p>';
    }
    ?>
    </div>
    <br>
    <a href="../../ControlGastos.php" class="button-link">Volver</a> 

    
</body>
</html>