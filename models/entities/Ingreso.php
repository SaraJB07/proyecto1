<?php

namespace app\models\entities;


use app\models\drivers\ConexDB;

class Ingreso extends Entity
{
    protected $id = null;
    protected $value = null;
    protected $idReport = null;  
    protected $month = null; 
    protected $year = null; 
  
      
    
    public function all()
    {
    $sql = "SELECT income.id, income.value, income.idReport, reports.month, reports.year
            FROM income
            INNER JOIN reports ON income.idReport = reports.id";
    $conex = new ConexDB();
    $resultDb = $conex->execSQL($sql);
    $ingresos = [];

    if ($resultDb->num_rows > 0) {
        while ($rowDb = $resultDb->fetch_assoc()) {
            $ingreso = new Ingreso();
            $ingreso->set('id', $rowDb['id']);
            $ingreso->set('value', $rowDb['value']);
             $ingreso->set('idReport', $rowDb['idReport']);
            $ingreso->set('month', $rowDb['month']);
            $ingreso->set('year', $rowDb['year']);
            $ingresos[] = $ingreso;
        }
    }

        $conex->close();
        return $ingresos;
    }

    public function find($id)
    {
        $sql = "SELECT * FROM income WHERE id = " . $id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $a = new Ingreso();
        if ($resultDb->num_rows > 0) {
            $row = $resultDb->fetch_assoc();
            $a->set('id', $row['id']);
            $a->set('value', $row['value']);
            $a->set('idReport', $row['idReport']);
            
        }
        $conex->close();
        return $a;
    }
    
    public function save()
    {
        if (!is_null($this->value) && $this->value !== '' && !is_null($this->month) && $this->month !== '' && !is_null($this->year) && $this->year !== '') {
            $conex = new ConexDB();
            // Validar que no exista ya un registro con el mismo mes y año
            $sql = "SELECT id FROM reports WHERE month = '" . $this->month . "' AND year = '" . $this->year . "'";
            $result = $conex->execSQL($sql);
            if ($result && $result->num_rows > 0) {
                // Ya existe ese mes y año, no guardar
                $conex->close();
                return false;
            }
         
            $sqlReport = "INSERT INTO reports (month, year) VALUES ('" . $this->month . "', '" . $this->year . "')";
            $resultReport = $conex->execSQL($sqlReport);
            if ($resultReport) {
                $idReport = $conex->execSQL("SELECT LAST_INSERT_ID() as id");
                $idReportValue = null;
                if ($row = $idReport->fetch_assoc()) {
                    $idReportValue = $row['id'];
                }
                if ($idReportValue) {
                    $sql = "INSERT INTO income (value, idReport) VALUES ('" . $this->value . "', " . $idReportValue . ")";
                    $resultDb =  $conex->execSQL($sql);
                    $conex->close();
                    return $resultDb;
                }
            }
            $conex->close();
            return false;
        } else {
            return false;
        }
    }

    public function isDeletable()
    {
        return true;
    }

    public function update()
    {
        $conex = new ConexDB();
        $resultDB = false;
        // DEBUG: Verificar valores antes de actualizar
        error_log('UPDATE ingreso id: ' . var_export($this->id, true) . ' value: ' . var_export($this->value, true));
        // Solo actualizar el valor del ingreso
        if (!is_null($this->id) && $this->id !== '' && !is_null($this->value) && $this->value !== '') {
            $sql = "UPDATE income SET value = '" . $this->value . "' WHERE id = " . intval($this->id);
            $resultDB = $conex->execSQL($sql);
        } else {
            error_log('ERROR: id o value nulos');
        }
        $conex->close();
        return $resultDB;
    }

    public function delete()
    {

        $dato = $this->find($this->id);
        $idReport= $dato->idReport;
        $conex = new ConexDB();
        $sql = "DELETE FROM income WHERE id = " . intval($this->id);
        $resultDb = $conex->execSQL($sql);
        $deleteReport = false;
        $reportBlocked = false;
        // Solo intentar borrar el reporte si idReport es válido y el ingreso fue eliminado
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
            } elseif ($countBills > 0) {
                $reportBlocked = true;
            }
        }
        $conex->close();
        return [
            'ingresoEliminado' => $resultDb,
            'reporteEliminado' => $deleteReport,
            'reporteBloqueado' => $reportBlocked
        ];
    }
    
}