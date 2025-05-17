<?php

include '../../../models/drivers/ConexDB.php';
include '../../../models/entities/Entity.php';
include '../../../models/entities/ControlGastos.php';
include '../../../controllers/ControlGastosController.php';

use app\models\entities\ControlGastos;
use app\controllers\ControlGastosController;

$controller = new ControlGastosController();
$result = $controller->deleteGasto($_GET['id']);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar Categoria</title>
</head>

<body>
<div class="logo">
    <h1>Resultado de la operación:</h1>
</div>
<?php
    if (is_array($result)) {
        if (!$result['gastoEliminado'] && !empty($result['bloqueada'])) {
            echo '<p>No se puede eliminar la categoría porque tiene gastos asociados.</p>';
        } elseif ($result['gastoEliminado']) {
            echo '<p>Datos eliminados</p>';
        } else {
            echo '<p>No se pudo borrar los datos</p>';
        }
    } else {
        echo ($result ? '<p>Datos eliminados</p>' : '<p>No se pudo borrar los datos</p>');
    }
?>
<a href="../../ControlGastos.php">Volver</a>
</body>

</html>