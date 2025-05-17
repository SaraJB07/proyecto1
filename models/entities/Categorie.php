<?php

namespace app\models\entities;

ini_set('display_errors', 1);
error_reporting(E_ALL);



use app\models\drivers\ConexDB;

class Categorie extends Entity
{
    protected $id = null;
    protected $name = "";
    protected $percentage = null;

    public static function sumaPorcentajesExcepto($idExcluir = null) {
        $conex = new ConexDB();
        $sql = "SELECT SUM(percentage) as total FROM categories";
        if ($idExcluir !== null) {
            $sql .= " WHERE id != " . intval($idExcluir);
        }
        $result = $conex->execSQL($sql);
        $total = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $total = floatval($row['total']);
        }
        $conex->close();
        return $total;
    }

    public function all()
    {
        $sql = "select * from categories";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $categories = [];
        if ($resultDb->num_rows > 0) {
            while ($rowDb = $resultDb->fetch_assoc()) {
                $categorie = new Categorie();
                $categorie->set('id', $rowDb['id']);
                $categorie->set('name', $rowDb['name']);
                $categorie->set('percentage', $rowDb['percentage']);
                array_push($categories, $categorie);
            }
        }
        $conex->close();
        return $categories;
    }

    public function save()
    {
        // Validar suma de porcentajes
        $suma = self::sumaPorcentajesExcepto();
        $nuevo = floatval($this->percentage);
        if (($suma + $nuevo) > 100) {
            return [
                'categoriaGuardada' => false,
                'excesoPorcentaje' => true
            ];
        }

        $name = $this->name !== null ? "'" . $this->name . "'" : "NULL";
        $percentage = ($this->percentage !== null && $this->percentage !== '') ? $this->percentage : 0;
        $sql = "insert into categories (name, percentage) values ($name, $percentage)";
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function update()
    {
        // Validar suma de porcentajes excluyendo el actual
        $suma = self::sumaPorcentajesExcepto($this->id);
        $nuevo = floatval($this->percentage);
        if (($suma + $nuevo) > 100) {
            return [
                'categoriaGuardada' => false,
                'excesoPorcentaje' => true
            ];
        }

        $sql = "update categories set ";
        $sql .= "name='" . $this->name . "', ";
        $sql .= "percentage=" . floatval($this->percentage);
        $sql .= " where id=" . intval($this->id);
        $conex = new ConexDB();
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return $resultDb;
    }

    public function delete()
    {
        $conex = new ConexDB();
       
        $sql = "SELECT COUNT(*) as count FROM bills WHERE idCategory = " . intval($this->id);
        $result = $conex->execSQL($sql);
        $count = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $count = (int)$row['count'];
        }
        if ($count > 0) {
            $conex->close();
            return [
                'categoriaEliminada' => false,
                'bloqueada' => true
            ];
        }
        $sql = "delete from categories where id=" . intval($this->id);
        $resultDb = $conex->execSQL($sql);
        $conex->close();
        return [
            'categoriaEliminada' => $resultDb,
            'bloqueada' => false
        ];
    }

    public function isModificable()
    {
        // Verificar si la categoría está relacionada a algún gasto
        $conex = new ConexDB();
        $sql = "SELECT COUNT(*) as count FROM bills WHERE idCategory = " . intval($this->id);
        $result = $conex->execSQL($sql);
        $count = 0;
        if ($result && $row = $result->fetch_assoc()) {
            $count = (int)$row['count'];
        }
        $conex->close();
        return $count === 0;
    }
}