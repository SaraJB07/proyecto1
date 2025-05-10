<?php
namespace app\models\entities;

use app\models\drivers\ConexDB;


class Ingreso extends entity{

    protected $id = null;
    protected $month = "";
    protected $year = "";


    public function obtenerIngreso() {
        $sql = "SELECT income.*, reports.month, reports.year from income INNER JOIN reports on income.idReport= reports.id";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $ingresos = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $ingreso = new Ingreso();
                $ingreso->set('id', $rowDb['id']);
                $ingreso->set('month', $rowDb['nombre']);
                $ingreso->set('email', $rowDb['email']);
                array_push($ingresos, $ingreso);
            }
        }
        $conex->close();
        return $ingresos;
        
    }

    public function guardarIngreso() {
            $sql = "insert into reports (id,month,year) values ";
            $sql .= "('" . $this->id . "','" . $this->month . "'," . $this->year . ")";
            $conex = new ConexDB();
            $resultDb = $conex->execSQL($sql);
            $conex->close();
            return $resultDb;
    }

    public function actualizarIngreso() {
        $sql = "update personas set ";
        $sql .= "month='" . $this->month . "',";
        $sql .= "year='" . $this->year . "',";
        $sql .= " where id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function delete(){

    }
}
?>
