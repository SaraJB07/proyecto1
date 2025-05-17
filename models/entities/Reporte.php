<?php 

namespace app\models\entities;

use app\models\drivers\ConexDB;

class Report extends Entity {
    protected $id = null;
    protected $dateOrder= null;
    protected $total = null;
    protected $idTable= null;
    protected $isCancelled=null;
    
    public function all()
    {
        $sql = "SELECT * FROM orders";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $Orders= [];

        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $Order = new Report();
                $Order->set('id', $rowDb['id']);
                $Order->set('dateOrder', $rowDb['dateOrder']);
                $Order->set('total', $rowDb['total']);
                $Order->set('idTable', $rowDb['idTable']);
                $Order->set('isCancelled', $rowDb['isCancelled']);
                array_push($Orders, $Order);
            }
        }

        $conex->close();
        return $Orders;
    }

    
    public function save()
    {
        $sql = "INSERT INTO orders (dateOrder, total, idTable, isCancelled) VALUES ";
        $sql .= "('" . $this->dateOrder . "'," . $this->total . "," . $this->idTable . "," . $this->isCancelled . ")";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    
    public function update()
    {
        $sql = "UPDATE orders  SET ";
        $sql .= "dateOrder='" . $this->dateOrder . "',";
        $sql .= "total=" . $this->total . ",";
        $sql .= "idTable=" . $this->idTable;
        $sql .= "isCancelled=" . $this->isCancelled;
        $sql .= " WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    
    public function delete()
    {
        $sql = "DELETE FROM orders WHERE id=" . $this->id;
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    ///////////////////////////////////////////////////////
    public function reporte($inicio, $fin) {
        $db = new ConexDB();
    
        
        $sql1 = "SELECT * FROM orders WHERE isCancelled = 0 AND dateOrder BETWEEN '$inicio' AND '$fin'";
        $res1 = $db->execSQL($sql1);
    
        $ordenes = [];
        $total = 0;
    
        while ($fila = $res1->fetch_assoc()) {
            $ordenes[] = $fila;
            $total += $fila['total'];
        }
    
        $db->close();
    
        return [
            'ordenes' => $ordenes,
            'total' => $total,
            
        ];
    }
    /////////////////////////////////////////////////////////
    public function reporte2($inicio, $fin) {
        $db = new ConexDB();
    
        
        $sql1 = "SELECT * FROM orders WHERE isCancelled = 1 AND dateOrder BETWEEN '$inicio' AND '$fin'";
        $res1 = $db->execSQL($sql1);
    
        $ordenes = [];
        $total = 0;
    
        while ($fila = $res1->fetch_assoc()) {
            $ordenes[] = $fila;
            $total += $fila['total'];
        }
    
        $db->close();
    
        return [
            'ordenes' => $ordenes,
            'total' => $total,
            
        ];
    }
}