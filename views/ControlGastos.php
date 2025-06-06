<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../models/drivers/ConexDB.php';
include '../models/entities/Entity.php';
// Las siguientes inclusiones y usos parecen no ser necesarios en este archivo
// include '../models/entities/Ingreso.php';
// include '../models/entities/ControlGastos.php';
// include '../controllers/CategorieController.php';
// use app\controllers\CategorieController;
// use app\models\entities\Categorie;
// use app\models\entities\ControlGastos;


$conex = new \app\models\drivers\ConexDB();

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
    <link rel="stylesheet" href="css/General.css">
    <link rel="stylesheet" href="css/ControlGastos.css">
    
    <title>Control De Gastos</title>
</head>

<body>
    <div class="logo">
        <h1>Gastos Registrados</h1>
    </div>

    <div class=" ">

        </div>

 

    <table>
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Valor</th>
                <th colspan="2">Opciones</th>
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
                    echo '<a href="formularioControlGastos.php?id=' . htmlspecialchars($g['id']) . '" class="modify-link">Modificar</a> ';
                    echo '<a href="../views/acciones/ControlGastos/EliminarGastos.php?id=' . htmlspecialchars($g['id']) . '" onclick="return confirm(\'¿Seguro que desea eliminar este gasto?\')">Eliminar</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No hay gastos registrados.</td></tr>'; }
            ?>
        </tbody>
    </table>
    <br>
    <a href="formularioControlGastos.php" class="button-link">Registrar gasto</a>
    <br>

    <a href="../views/Principal.php"  class="button-link">Volver</a>

</body>

</html>
