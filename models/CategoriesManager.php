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

    public function getNbViewPerCategories() {
        $query = Model::getBdd()->query('SELECT SUM(vues.nb_vues) as nb, categories.nom_categorie, articles.id_article, articles.categorie FROM categories LEFT JOIN articles ON articles.categorie = categories.id_categorie LEFT JOIN vues ON vues.id_article = articles.id_article GROUP BY categories.nom_categorie ORDER BY nb DESC');
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $res = json_encode($res, true);
        echo $res;
    }
}

