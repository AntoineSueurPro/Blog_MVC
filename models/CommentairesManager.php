<?php

namespace models;

use PDO;

class CommentairesManager extends Model {

    public function insert($commentaire, $auteur, $article) {

        $query = Model::getBdd()->prepare("INSERT INTO commentaires (id_auteur, contenu, created_at, id_article) VALUES (?, ?, NOW(), ?)");
        $query->execute(array(
            $auteur,
            $commentaire['contenu'],
            $article
        ));
    }

    public function selectComFromArticle($idArticle) {
        $query = Model::getBdd()->prepare('SELECT commentaires.id_commentaire, commentaires.contenu as contenu, commentaires.created_at as created_at, membres.pseudo as auteur, membres.avatar as avatar, membres.id_membre as id_membre FROM commentaires INNER JOIN membres ON commentaires.id_auteur = id_membre WHERE commentaires.id_article = :id_article');
        $query->execute(array(
            'id_article' => $idArticle
        ));
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function deleteAllCommentFromUser($idMembre) {
        $query = Model::getBdd()->prepare('DELETE FROM commentaires WHERE id_auteur = :idMembre');
        $query->execute(array(
            'idMembre' => $idMembre
        ));
    }

    public function deleteAllCommentOnArticle($idArticle) {
        $query = Model::getBdd()->prepare("DELETE FROM commentaires WHERE id_article = :idArticle");
        $query->execute(array(
            'idArticle' => $idArticle
        ));
    }

    public function deleteComment($idComment) {
        $query = Model::getBdd()->prepare('DELETE FROM commentaires WHERE id_commentaire = :idComment');
        $query->execute(array(
            'idComment' => $idComment
        ));
    }

    public function checkDelete($idAuteur, $idComment) {
        $query = Model::getBdd()->prepare('SELECT COUNT(*) FROM commentaires WHERE id_commentaire = :idComment AND id_auteur = :idAuteur');
        $query->execute(array(
            'idComment' => $idComment,
            'idAuteur' => $idAuteur
        ));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
