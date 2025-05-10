<?php
namespace app\models\entities;

use app\models\drivers\ConexDB;


class Ingreso {
    private $db;

    public function obtenerIngreso($mes, $anio) {
        $sql = "SELECT * FROM reports WHERE month = $mes AND year = $anio";
        $resultDb = $this->db->query($sql);
        $resultDb->bind_param("si", $mes, $anio);
        $resultDb->execute();
        return $resultDb->get_result()->fetch_assoc();
    }

    public function guardarIngreso($mes, $anio, $valor) {
        $sql = $this->db->prepare("INSERT INTO reports (month, year) VALUES");
        $sql .= "('" . $this->$mes . "','" . $this->$anio . "')";        
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function actualizarIngreso($mes, $anio, $valor) {
        $query = "UPDATE ingresos SET valor = ? WHERE mes = ? AND anio = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("dsi", $valor, $mes, $anio);
        return $stmt->execute();
    }
}
?>
