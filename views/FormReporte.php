<?php
include '../models/drivers/ConexDB.php';
include '../models/entities/entity.php';
include '../controllers/ReporteController.php';


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
$conex->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Obtener Reporte</title>
    <link rel="stylesheet" href="css/General.css">
    <link rel="stylesheet" href="css/FormReporte.css">
</head>

<body>
    <div class="logo">
        <h1><?= empty($_GET['id']) ? 'Obtener Reporte' : '' ?></h1> 
    </div>

    <form action="../views/acciones/Reporte/GenerarReporte.php" method="post">
        <div>
            <label>Mes:</label>
            <select name="monthInput" required>
                <option value="">Seleccione un mes</option>
                <?php
                $mesesNombres = [
                    '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
                    '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
                    '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
                ];
                foreach ($meses as $mes):
                    $nombreMes = isset($mesesNombres[$mes]) ? $mesesNombres[$mes] : $mes;
                ?>
                    <option value="<?= htmlspecialchars($mes) ?>">
                        <?= htmlspecialchars($nombreMes) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>Año: </label>
            <select name="yearInput" required>
                <option value="">Seleccione un año</option>
                <?php foreach ($anios as $anio): ?>
                    <option value="<?= htmlspecialchars($anio) ?>">
                        <?= htmlspecialchars($anio) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <button type="submit">Ver Reporte</button>
        </div>
       
    </form>
    <a href="Principal.php" class="button-link">Volver</a>
</body>
</html>