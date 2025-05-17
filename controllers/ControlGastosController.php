<?php

namespace app\controllers;

use app\models\entities\ControlGastos;

class ControlGastosController {

    public function queryAllGastos() {
        $Gasto= new ControlGastos();
        $data = $Gasto->all();
        return $data;

        
    }

    public function saveGasto($request) {
        $Gasto = new ControlGastos();
        $Gasto->set('value', $request['valueInput']);
        $Gasto->set('idCategory', $request['categoryInput']);
        $Gasto->set('month', $request['monthInput']);
        $Gasto->set('year', $request['yearInput']);
        return $Gasto->save();
    }

    public function updateGasto($request) {
        $Gasto = new ControlGastos();
        $Gasto->set('id', $request['idInput']);
        $Gasto->set('value', $request['valueInput']);
        $Gasto->set('idCategory', $request['categoryInput']);
        // No cambiar mes ni año en edición, solo usar los actuales
        $conex = new \app\models\drivers\ConexDB();
        $sqlCurrent = "SELECT r.month, r.year FROM bills b INNER JOIN reports r ON b.idReport = r.id WHERE b.id = " . intval($request['idInput']);
        $resCurrent = $conex->execSQL($sqlCurrent);
        $mesActual = null;
        $anioActual = null;
        if ($resCurrent && $row = $resCurrent->fetch_assoc()) {
            $mesActual = $row['month'];
            $anioActual = $row['year'];
        }
        $conex->close();
        $Gasto->set('month', $mesActual);
        $Gasto->set('year', $anioActual);
        // Solo actualizar valor y categoría
        return $Gasto->update(false);
    }

    public function deleteGasto($id) {
        $Gasto = new ControlGastos();
        $Gasto->set('id', $id);
        return $Gasto->delete();
    }
}