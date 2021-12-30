<?php
 namespace models;

 use PDO;

 class ArticlesManager extends Model {

     public function insert($article, $idAuteur, $image) {
         $query = Model::getBdd()->prepare("INSERT INTO articles (image_article, created_at, titre, contenu, id_auteur, categorie) VALUES (?, NOW(), ?, ?, ?, ?)");
         $query->execute(array(
             $image,
             $article['titre'],
             $article['contenu'],
             $idAuteur,
             $article['categorie'] === "" ? NULL : $article['categorie']
         ));
     }

     public function update($image, $article, $idArticle) {
         $query = Model::getBdd()->prepare('UPDATE articles SET image_article = :image, titre = :titre, contenu = :contenu, categorie = :categorie WHERE id_article = :idArticle');
         $query->execute(array(
             'image' => $image,
             'titre' => $article['titre'],
             'contenu' => $article['contenu'],
             'categorie' => $article['categorie'] === "" ? NULL : $article['categorie'],
             'idArticle' => $idArticle
         ));
     }

     public function selectAll() {
         $query = Model::getBdd()->query('SELECT articles.id_article as id_article, articles.image_article as image, articles.titre as titre, articles.contenu as contenu, membres.pseudo as auteur, categories.nom_categorie as categorie, articles.created_at as created_at FROM articles LEFT JOIN categories ON articles.categorie = categories.id_categorie INNER JOIN membres ON articles.id_auteur = membres.id_membre');
         $result = $query->fetchAll(PDO::FETCH_ASSOC);

         return $result;
     }

     public function selectOne($id) {
         $query = Model::getBdd()->prepare('SELECT articles.categorie as id_categorie, articles.id_article as id_article, articles.image_article as image, articles.titre as titre, articles.contenu as contenu, membres.pseudo as auteur, categories.nom_categorie as categorie, articles.created_at as created_at FROM articles LEFT JOIN categories ON articles.categorie = categories.id_categorie INNER JOIN membres ON articles.id_auteur = membres.id_membre WHERE articles.id_article = :id');
         $query->execute(array(
             'id' => $id
         ));
         $result = $query->fetch(PDO::FETCH_ASSOC);
         return $result;
     }

     public function delete($articleId) {
         $query = Model::getBdd()->prepare('DELETE FROM articles WHERE id_article = :idArticle');
         $query->execute(array(
             'idArticle' => $articleId
         ));
     }

     public function selectTheLastOne() {
         $query = Model::getBdd()->query('SELECT articles.categorie as id_categorie, articles.id_article as id_article, articles.image_article as image, articles.titre as titre, articles.contenu as contenu, membres.pseudo as auteur, categories.nom_categorie as categorie, articles.created_at as created_at FROM articles LEFT JOIN categories ON articles.categorie = categories.id_categorie INNER JOIN membres ON articles.id_auteur = membres.id_membre ORDER BY created_at DESC LIMIT 1');
         $result = $query->fetch(PDO::FETCH_ASSOC);
         return $result;
     }

     public function setCategorieToNull($idCategorie) {
        $query = Model::getBdd()->prepare('UPDATE articles SET categorie = NULL WHERE categorie = :idCategorie ');
        $query->execute(array(
            'idCategorie' => $idCategorie
        ));
     }

     public function selectAllAjax($categorie) {
         $query = Model::getBdd()->query("SELECT articles.id_article as id_article, articles.image_article as image, articles.titre as titre, articles.contenu as contenu, membres.pseudo as auteur, categories.nom_categorie as categorie, articles.created_at as created_at FROM articles LEFT JOIN categories ON articles.categorie = categories.id_categorie INNER JOIN membres ON articles.id_auteur = membres.id_membre WHERE categories.nom_categorie = '{$categorie}' ORDER BY id_article DESC");
         $result = $query->fetchAll(PDO::FETCH_ASSOC);
         $result = json_encode($result);
         echo $result;
     }

     public function selectAllAjaxWithoutCategorie() {
         $query = Model::getBdd()->query("SELECT articles.id_article as id_article, articles.image_article as image, articles.titre as titre, articles.contenu as contenu, membres.pseudo as auteur, categories.nom_categorie as categorie, articles.created_at as created_at FROM articles LEFT JOIN categories ON articles.categorie = categories.id_categorie INNER JOIN membres ON articles.id_auteur = membres.id_membre ORDER BY id_article DESC");
         $result = $query->fetchAll(PDO::FETCH_ASSOC);
         $result = json_encode($result);
         echo $result;
     }

 }
