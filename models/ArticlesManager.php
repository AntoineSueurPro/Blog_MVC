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
         $query = Model::getBdd()->query('SELECT articles.id_article as id_article, articles.image_article as image, articles.titre as titre, articles.contenu as contenu, membres.pseudo as auteur, categories.nom_categorie as categorie, articles.created_at as created_at FROM articles LEFT JOIN categories ON articles.categorie = categories.id_categorie INNER JOIN membres ON articles.id_auteur = membres.id_membre ORDER BY articles.id_article DESC');
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

     public function updateViewsOnArticle($id_article) {
        $date = new \DateTime();
        $date = $date->format('Y-m-d');

        $query = Model::getBdd()->prepare('SELECT * FROM vues WHERE id_article = :id_article AND date_vues = :date_vue');
        $query->execute([
            'id_article' => $id_article,
            'date_vue' => $date
        ]);
        $res = $query->fetch(PDO::FETCH_ASSOC);

        if($res ||  ($res && count($res)> 0)) {
            $nb = intval($res['nb_vues'], 10) +1;
            $query = Model::getBdd()->prepare('UPDATE vues SET nb_vues = :nb WHERE id = :id');
            $query->execute([
                ':nb' => $nb,
                ':id' => $res['id']
            ]);
        } else {
            $query = Model::getBdd()->prepare('INSERT INTO vues (id_article, nb_vues, date_vues) VALUES (:id, :nb_vues, :date_vues)');
            $query->execute([
                ':id' => $id_article,
                ':nb_vues' => 1,
                'date_vues' => $date
            ]);
        }

     }

     public function getNbViewAndDate() {
         $query = Model::getBdd()->query('SELECT SUM(nb_vues) as nb, date_vues FROM vues GROUP BY date_vues ORDER BY date_vues');
         $res = $query->fetchAll(PDO::FETCH_ASSOC);
         $res = json_encode($res, true);
         echo $res;
     }

 }
