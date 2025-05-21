<?php
// GenerarReporte.php: Recibe el mes y año, obtiene datos y muestra el reporte
include '../../../controllers/ReporteController.php';
include '../../../models/drivers/ConexDB.php';

use app\controllers\ReporteController;

$mes = $_POST['monthInput'] ?? null;
$anio = $_POST['yearInput'] ?? null;

$controller = new ReporteController();
$reporte = $controller->reporteMes($mes, $anio);

// Calcular límites y totales por categoría
$limites = isset($reporte['limites']) ? $reporte['limites'] : [];
$totalesCat = [];
$sugerencias = [];
if (!empty($reporte['gastos'])) {
    foreach ($reporte['gastos'] as $gasto) {
        $cat = $gasto['categoria'];
        if (!isset($totalesCat[$cat])) $totalesCat[$cat] = 0;
        $totalesCat[$cat] += $gasto['value'];
    }
}
 ?>
 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte del Mes</title>
    <link rel="stylesheet" href="../../css/General.css">
    <link rel="stylesheet" href="../../css/Categoria.css">
</head>
<body>
    <div class="logo">
       <h1>Reporte de <?= $reporte['mes'] ?>/<?= $reporte['anio'] ?></h1>
    <h2>Ingreso del mes: $<?= number_format($reporte['ingreso'], 2) ?></h2>
    <h3>Gastos:</h3>
    </div>    
    <?php
    // Definir límites máximos por categoría obtenidos desde la base de datos
    $limites = isset($reporte['limites']) ? $reporte['limites'] : [];
    // Calcular totales por categoría
    $totalesCat = [];
    foreach ($reporte['gastos'] as $gasto) {
        $cat = $gasto['categoria'];
        if (!isset($totalesCat[$cat])) $totalesCat[$cat] = 0;
        $totalesCat[$cat] += $gasto['value'];
    }
    $sugerencias = [];
    ?>
    <?php if (empty($reporte['gastos'])): ?>
        <p>No hay gastos registrados para este mes.</p>
    <?php else: ?>
        <table class="Tabla">
            <tr>
                <th>Categoría</th>
                <th>Valor</th>
                <th>Porcentaje del ingreso</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($totalesCat as $cat => $valor): 
                $porc = $reporte['ingreso'] > 0 ? ($valor / $reporte['ingreso']) * 100 : 0;
                $limite = isset($limites[$cat]) ? $limites[$cat] : 15;
                $excedido = $porc > $limite;
                if ($excedido) $sugerencias[] = $cat;
            ?>
                <tr>
                    <td><?= htmlspecialchars($cat) ?></td>
                    <td>$<?= number_format($valor, 2) ?></td>
                    <td><?= number_format($porc, 1) ?>% (máx <?= $limite ?>%)</td>
                    <td style="color:<?= $excedido ? 'red' : 'green' ?>; font-weight:bold;">
                        <?= $excedido ? '¡Excedido!' : 'OK' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php 
        // Calcular ahorro y porcentaje de ahorro
        $totalGastos = 0;
        foreach ($reporte['gastos'] as $gasto) {
            $totalGastos += $gasto['value'];
        }
        $ahorro = $reporte['ingreso'] - $totalGastos;
        $porcentajeAhorro = $reporte['ingreso'] > 0 ? ($ahorro / $reporte['ingreso']) * 100 : 0;
        ?>
        <h3>Ahorro del mes: $<?= number_format($ahorro, 2) ?> (<?= number_format($porcentajeAhorro, 1) ?>%)</h3>
        <?php if ($porcentajeAhorro < 10): ?>
            <p>Advertencia: No hubo ahorro suficiente. El porcentaje de ahorro fue de <?= number_format($porcentajeAhorro, 1) ?>%.</p>
        <?php else: ?>
            <p>¡Felicidades! Tu ahorro es igual o mayor al 10%.</p>
        <?php endif; ?>
        <br>
        <?php if (!empty($sugerencias)): ?>
            <h4>Sugerencia:</h4>
            <ul>
                <?php foreach ($sugerencias as $cat): ?>
                    <li>Baja el consumo en <b><?= htmlspecialchars($cat) ?></b></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>¡Tus gastos están dentro de los límites recomendados!</p>
        <?php endif; ?>
     


        <?php endif; ?>
        <a href="../../../views/Principal.php" class="button-link">Volver</a>
    <br>
</body>
</html>




