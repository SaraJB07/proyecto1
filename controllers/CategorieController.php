<?php

namespace app\controllers;

require_once __DIR__ . '/../models/entities/Categorie.php';

use app\models\entities\Categorie;

class CategorieController {

    public function queryAllCategories() {
        $categorie = new Categorie();
        $data = $categorie->all();
        return $data;
    }

    public function saveNewCategorie($request) {
         $categorie = new Categorie();
         $categorie->set('name', $request['nombreInput']);
        $categorie->set('percentage', $request['porcentajeInput']);
         return $categorie->save();
    }

    public function updateCategorie($request) {
        $categorie = new Categorie();
        $categorie->set('id', $request['idInput']);
        $categorie->set('name', $request['nombreInput']);
        // Asegúrate de setear el porcentaje también en update
        $categorie->set('percentage', $request['porcentajeInput']);
        return $categorie->update();
    }

    public function deleteCategorie($id) {
        $categorie = new Categorie();
        $categorie->set('id', $id);
        return $categorie->delete();
    }
}