<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../../../controllers/IngresoController.php';
include '../../../models/drivers/ConexDB.php';
include '../../../models/entities/Entity.php';
include '../../../models/entities/Ingreso.php';


use app\controllers\IngresoController;
use app\entities\Entity;
use app\entities\Ingreso;

$controller = new IngresoController();
$result = empty($_POST['idInput'])
    ? $controller->saveNewIngreso($_POST)
    : $controller->updateIngreso($_POST);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de la operación:</title>
</head>

<body>
    <h1>Resultado</h1>
    
    
    <?php
    if ($result) {
        echo '<p>Datos guardados</p>';
    } else {
        echo '<p>No se pudo guardar los datos</p>';
    }
    ?>
    <a href="../../Ingreso.php">Volver</a>
</body>

</html>