<?php

namespace app\controllers;

use app\models\entities\Reporte;
use app\models\drivers\ConexDB;

class ReporteController {
    
   public function reporteMes($mes, $anio) {
        $conex = new \app\models\drivers\ConexDB();
        // Obtener ingreso del mes
        $sqlIngreso = "SELECT value FROM income i INNER JOIN reports r ON i.idReport = r.id WHERE r.month = '".$mes."' AND r.year = '".$anio."' LIMIT 1";
        $resIngreso = $conex->execSQL($sqlIngreso);
        $ingreso = ($resIngreso && $row = $resIngreso->fetch_assoc()) ? $row['value'] : 0;
        // Obtener gastos del mes
        $sqlGastos = "SELECT b.value, c.name as categoria FROM bills b INNER JOIN reports r ON b.idReport = r.id INNER JOIN categories c ON b.idCategory = c.id WHERE r.month = '".$mes."' AND r.year = '".$anio."'";
        $resGastos = $conex->execSQL($sqlGastos);
        $gastos = [];
        if ($resGastos && $resGastos->num_rows > 0) {
            while ($row = $resGastos->fetch_assoc()) {
                $gastos[] = $row;
            }
        }
        // Obtener límites por categoría desde la base de datos
        $sqlLimites = "SELECT name, percentage FROM categories";
        $resLimites = $conex->execSQL($sqlLimites);
        $limites = [];
        if ($resLimites && $resLimites->num_rows > 0) {
            while ($row = $resLimites->fetch_assoc()) {
                $limites[$row['name']] = (float)$row['percentage'];
            }
        }

        $conex->close();
        return [
            'mes' => $mes,
            'anio' => $anio,
            'ingreso' => $ingreso,
            'gastos' => $gastos,
            'limites' => $limites
        ];
    }

    

    
 
}
?>