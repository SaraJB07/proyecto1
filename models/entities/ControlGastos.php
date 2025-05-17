<?php 

namespace app\models\entities;

use app\models\drivers\ConexDB;

class ControlGastos extends Entity {
    protected $id = null;
    protected $value = null;
    protected $idCategory= null;
    protected $idReport = null;
    protected $month = null;
    protected $year = null;

    public static function existeMesAnioEnReports($month, $year) {
        $conex = new \app\models\drivers\ConexDB();
        $sql = "SELECT COUNT(*) as count FROM reports WHERE month = '" . $month . "' AND year = '" . $year . "'";
        $result = $conex->execSQL($sql);
        $count = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $count = (int)$row['count'];
        }
        $conex->close();
        return $count > 0;
    }
    
    public function all()
    {
        $sql = "SELECT * FROM bills";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $bills = [];

        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $Gasto = new ControlGastos();
                $Gasto->set('id', $rowDb['id']);
                $Gasto->set('value', $rowDb['value']);
                $Gasto->set('idCategory', $rowDb['idCategory']);
                $Gasto->set('idReport', $rowDb['idReport']);
                $bills[] = $Gasto;
            }
        }

        $conex->close();
        return $bills;
    }

    
    public function save()
    {
        // Validar que el mes y año existen en reports
        if (!self::existeMesAnioEnReports($this->month, $this->year)) {
            return [
                'gastoGuardado' => false,
                'mesAnioNoExiste' => true
            ];
        }
        // Buscar el idReport correspondiente al mes y año
        $conex = new ConexDB();
        $sqlReport = "SELECT id FROM reports WHERE month = '" . $this->month . "' AND year = '" . $this->year . "' LIMIT 1";
        $resultReport = $conex->execSQL($sqlReport);
        $idReport = null;
        if ($resultReport && $row = $resultReport->fetch_assoc()) {
            $idReport = $row['id'];
        }
        if (!$idReport) {
            $conex->close();
            return [
                'gastoGuardado' => false,
                'mesAnioNoExiste' => true
            ];
        }
        // Guardar en bills SOLO con los campos existentes en la tabla
        $sql = "INSERT INTO bills (value, idCategory, idReport) VALUES ('" . $this->value . "', '" . $this->idCategory . "', '" . $idReport . "')";
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    
    public function update($updateIdReport = true)
    {
        $conex = new ConexDB();
        $resultDb = false;
        // Siempre actualiza valor y categoría
        $sql = "UPDATE bills SET value='" . $this->value . "', idCategory='" . $this->idCategory . "' WHERE id=" . $this->id;
        $resultDb = $conex->execSQL($sql);
        // Si se solicita actualizar idReport y hay mes/año válidos, actualiza también el idReport
        if ($updateIdReport && !is_null($this->month) && !is_null($this->year)) {
            $sqlReport = "SELECT id FROM reports WHERE month = '" . $this->month . "' AND year = '" . $this->year . "' LIMIT 1";
            $resultReport = $conex->execSQL($sqlReport);
            $idReportNuevo = null;
            if ($resultReport && $row = $resultReport->fetch_assoc()) {
                $idReportNuevo = $row['id'];
            }
            if ($idReportNuevo) {
                $sql = "UPDATE bills SET idReport='" . $idReportNuevo . "' WHERE id=" . $this->id;
                $conex->execSQL($sql);
            }
        }
        $conex->close();
        return $resultDb;
    }

    
    public function delete()
    {
        $conex = new ConexDB();
        // Obtener idReport antes de borrar
        $sqlGet = "SELECT idReport FROM bills WHERE id=" . intval($this->id);
        $resGet = $conex->execSQL($sqlGet);
        $idReport = null;
        if ($resGet && $row = $resGet->fetch_assoc()) {
            $idReport = $row['idReport'];
        }
        // Eliminar el gasto
        $sql = "DELETE FROM bills WHERE id=" . $this->id;
        $resultDb = $conex->execSQL($sql);
        $deleteReport = false;
        $reportBlocked = false;
        // Solo intentar borrar el reporte si idReport es válido y el gasto fue eliminado
        if ($resultDb && !is_null($idReport) && $idReport !== '') {
            // Verificar que no existan referencias en income ni en bills
            $sql = "SELECT COUNT(*) as count FROM income WHERE idReport = " . intval($idReport);
            $result = $conex->execSQL($sql);
            $countIncome = 0;
            if ($result && $row = $result->fetch_assoc()) {
                $countIncome = (int)$row['count'];
            }
            $sql = "SELECT COUNT(*) as count FROM bills WHERE idReport = " . intval($idReport);
            $result = $conex->execSQL($sql);
            $countBills = 0;
            if ($result && $row = $result->fetch_assoc()) {
                $countBills = (int)$row['count'];
            }
            if ($countIncome === 0 && $countBills === 0) {
                $sqlDeleteReport = "DELETE FROM reports WHERE id = " . intval($idReport);
                $deleteReport = $conex->execSQL($sqlDeleteReport);
            } elseif ($countIncome > 0 || $countBills > 0) {
                $reportBlocked = true;
            }
        }
        $conex->close();
        return [
            'gastoEliminado' => $resultDb,
            'reporteEliminado' => $deleteReport,
            'reporteBloqueado' => $reportBlocked
        ];
    }
}