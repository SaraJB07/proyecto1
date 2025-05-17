<?php

namespace app\controllers;

use app\models\entities\Ingreso;

class IngresoController {
    
    public function queryAllIngreso()
    {
        $ingreso = new Ingreso();
        $data = $ingreso->all();
        return $data;
    }

    
    public function saveNewIngreso($request)
    {
        $ingreso = new Ingreso();
        $ingreso->set('value', $request['valueInput']);
        $ingreso->set('month', $request['monthInput']);
        $ingreso->set('year', $request['yearInput']);
        $conex = new \app\models\drivers\ConexDB();
        $result = $conex->execSQL("SELECT id FROM reports ORDER BY id DESC LIMIT 1");
        $idReport = null;
        if ($row = $result->fetch_assoc()) {
        $idReport = $row['id'];
    }
    $conex->close();

    $ingreso->set('idReport', $idReport);
        return $ingreso->save();
    }

    
    public function updateIngreso($request)
    {
        echo "ID: " . $request['idInput'];
        echo "Value: " . $request['valueInput'];
        $ingreso = new Ingreso();
        $ingreso->set('id', $request['idInput']);
        $ingreso->set('value', $request['valueInput']);
        if (!empty($request['idReport'])) {
            $ingreso->set('idReport', $request['idReport']);
        } else {
            $found = $ingreso->find($request['idInput']);
            $ingreso->set('idReport', $found->get('idReport'));
        }
        return $ingreso->update();
    }

    
    public function deleteIngreso($id)
    {
        $ingreso = new Ingreso();
        $ingreso->set('id', $id);
        if (!$ingreso->isDeletable()) { 
            return false;
        }
        return $ingreso->delete();
    }
}
?>