<?php
namespace models;

use PDO;

class CategoriesManager extends Model {


    public function insert($categorie) {
        $query = Model::getBdd()->prepare("INSERT INTO categories (nom_categorie) VALUES (:categorie)");
        $query->execute(array(
            'categorie' => $categorie
        ));
    }

    public function deleteCategorie($id) {
        $query = Model::getBdd()->prepare("DELETE FROM categories WHERE id_categorie = :id");
        $query->execute(array(
            'id' => $id
        ));
    }

    public function selectAll() {
        $query = Model::getBdd()->query("SELECT * FROM categories");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}