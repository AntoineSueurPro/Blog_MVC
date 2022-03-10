<?php

namespace controller;

class ArticleController
{

    private $articleManager;
    private $commentaireManager;

    public function __construct()
    {
        $this->articleManager = new \models\ArticlesManager;
        $this->commentaireManager = new \models\CommentairesManager;
    }

    public function index()
    {
        if (isset($_GET['articleId'])) {
            if (is_numeric($_GET['articleId'])) {
                if (!empty($_POST)) {
                    foreach ($_POST as $key => $value) {
                        $_POST[$key] = htmlspecialchars($value);
                    }
                    $error = 0;

                    if (strlen($_POST['contenu']) === 0) {
                        $error++;
                        $_SESSION['error']['contenu'] = 'Veuillez écrire dans la zone de commentaire avant de publier.';
                    }
                    if ($error === 0) {
                        $_SESSION['test'] = $_POST['contenu'];
                        $this->commentaireManager->insert($_POST, $_SESSION['membre']['id_membre'], $_GET['articleId']);
                        header('Location: index.php?route=article&articleId=' . $_GET['articleId'] . '#commentaire');
                    }
                }
                $commentaires = $this->commentaireManager->selectComFromArticle($_GET['articleId']);
                $nb_commentaires = count($commentaires);
                $article = $this->articleManager->selectOne($_GET['articleId']);
                if (!$article) {
                    header("Location: index.php");
                }
                $this->articleManager->updateViewsOnArticle($_GET['articleId']);
                require('views/article.view.php');

            } else {
                header("Location: index.php");
            }

        } elseif (isset($_GET['action']) && $_GET['action'] === 'deleteComment' && isset($_GET['commentId']) && is_numeric($_GET['commentId'])) {

            $isOk = $this->commentaireManager->checkDelete($_SESSION['membre']['id_membre'], $_GET['commentId']);

            if ($_SESSION['membre']['role'] === '1') {
                $this->commentaireManager->deleteComment($_GET['commentId']);
                $_SESSION['info'] = 'Commentaire supprimé';
                header('Location:' . $_SERVER['HTTP_REFERER'] . '#commentaire');
            } else if ($isOk["COUNT(*)"] === '0') {
                echo '<script> let asking = window.confirm("Vous êtes sur le point de supprimer un commentaire qui n\'est pas le votre, êtes vous sûr ?")
                                if(asking) {
                                    window.location.href= "https://www.youtube.com/watch?v=dQw4w9WgXcQ"
                                   }
                                    else {
                                        window.location.href= "index.php"
                                    }
                    </script>';
            } else {
                $this->commentaireManager->deleteComment($_GET['commentId']);
                $_SESSION['info'] = 'Commentaire supprimé';
                header('Location:' . $_SERVER['HTTP_REFERER'] . '#commentaire');
            }


        } else {
            header('Location: index.php');
        }
    }
}
