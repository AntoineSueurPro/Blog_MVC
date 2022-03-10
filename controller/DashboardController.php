<?php

namespace controller;

class DashboardController
{
    private $categorieManager;
    private $articlesManager;
    private $commentairesManager;
    private $membresManager;

    public function __construct()
    {
        $this->categorieManager = new \models\CategoriesManager;
        $this->articlesManager = new \models\ArticlesManager;
        $this->commentairesManager = new \models\CommentairesManager;
        $this->membresManager = new \models\MembresManager;
    }

    public function index()
    {
        if (!isset($_SESSION['membre']) || $_SESSION['membre']['role'] === 0) {
            header('Location: index.php');
        }

        if (!empty($_POST) && isset($_POST['nom_categorie']) && $_POST['nom_categorie'] != '') {
            foreach ($_POST as $key => $value) {
                $_POST[$key] = htmlspecialchars($value);
            }
            $this->categorieManager->insert($_POST['nom_categorie']);
            $_SESSION['info']['categorieadd'] = 'Catégorie ajoutée !';
            header('Location: index.php?route=dashboard&onglet=categorie');
        }


            if (isset($_GET['action']) && $_GET['action'] === 'addArticle') {

                if (!empty($_POST)) {

                    $error = array();
                    foreach ($_POST as $key => $value) {
                        if($key != 'contenu') {
                            $_POST[$key] = htmlspecialchars($value);
                        }
                    }

                    if(trim(strlen($_POST['contenu'])) == 0 ) {
                        $error[] = 'Veuillez remplir la partie article';
                    }
                    if (isset($_FILES['image_article'])) {

                        if (trim(strlen($_POST['titre'])) == 0 ) {
                            $error[] = 'Veuillez mettre un titre pour votre article';
                        }

                        $tmp_name = $_FILES['image_article']['tmp_name'];
                        $file_extension = strrchr($_FILES['image_article']['type'], "/");
                        $file_extension = str_replace("/", ".", $file_extension);
                        $file_name = date("ymdhs") . $file_extension;
                        $folder = 'public/img/';
                        $max_size = 1000000;
                        $file_size = filesize($tmp_name);
                        $extension_array = array('.png', '.jpg', '.jpeg');

                        if ($_FILES['image_article']['name'] === "") {
                            $error[] = 'Veuillez mettre une photo pour votre article';
                        } elseif (!in_array($file_extension, $extension_array)) {
                            $error[] = "Veuillez insérer une photo au bon format";
                        }
                        if ($file_size > $max_size) {
                            $error[] = 'Fichier trop volumineux';
                        }


                        if (empty($error)) {
                            if (move_uploaded_file($tmp_name, $folder . $file_name)) {
                                $this->articlesManager->insert($_POST, $_SESSION['membre']['id_membre'], $file_name);
                                $_SESSION['info']['articleadd'] = 'Article ajouté !';
                                header('Location: index.php?route=dashboard&onglet=article');
                            }
                        } else {
                            $_SESSION['error'] = $error;
                        }
                    }


                }
                $categories = $this->categorieManager->selectAll();
                require('views/formArticle.php');
            }


            elseif (isset($_GET['action']) && $_GET['action'] === 'editArticle' && isset($_GET['articleId'])) {
                if (is_numeric($_GET['articleId'])) {

                    $article = $this->articlesManager->selectOne($_GET['articleId']);
                    $categories = $this->categorieManager->selectAll();
                    if(!$article) {
                        header("Location: index.php?route=dashboard");
                    }

                    if (!empty($_POST)) {
                        foreach ($_POST as $key => $value) {
                            if($key != 'contenu') {
                                $_POST[$key] = htmlspecialchars($value);
                            }
                        }
                        if (isset($_FILES['image_article']) && $_FILES['image_article']['name'] != "") {

                            $tmp_name = $_FILES['image_article']['tmp_name'];
                            $file_extension = strrchr($_FILES['image_article']['type'], "/");
                            $file_extension = str_replace("/", ".", $file_extension);
                            $file_name = date("ymdhs") . $file_extension;
                            $folder = 'public/img/';
                            $max_size = 1000000;
                            $file_size = filesize($tmp_name);
                            $extension_array = array('.png', '.jpg', '.jpeg');

                            if ($file_size > $max_size) {
                                $error[] = 'Fichier trop volumineux';
                            }

                            if (!in_array($file_extension, $extension_array)) {
                                $error[] = "Mauvais type de fichier";
                            }

                            if (empty($error)) {
                                if (move_uploaded_file($tmp_name, $folder . $file_name)) {
                                    unlink('public/img/' . $article['image']);
                                    $this->articlesManager->update($file_name, $_POST, $article['id_article']);
                                    $_SESSION['info'] = 'Article modifié !';
                                    header('Location: index.php?route=dashboard&onglet=article');
                                }
                            } else {
                                $_SESSION['error'] = $error;
                            }
                        } else {
                            $this->articlesManager->update($article['image'], $_POST, $article['id_article']);
                            $_SESSION['info']['articlemodif'] = 'Article modifié !';
                            header('Location: index.php?route=dashboard&onglet=article');
                        }
                    }
                    require('views/formArticle.php');

                } else {
                    header("Location: index.php?route=dashboard");
                }
            }

            elseif (isset($_GET['action']) && $_GET['action'] === 'deleteArticle' && isset($_GET['articleId'])) {
                if (is_numeric($_GET['articleId'])) {
                    $this->commentairesManager->deleteAllCommentOnArticle($_GET['articleId']);
                    $article = $this->articlesManager->selectOne($_GET['articleId']);

                    unlink('public/img/' . $article['image']);
                    $this->articlesManager->delete($_GET['articleId']);
                    $_SESSION['info']['article'] = 'Article supprimé !';
                    header('Location: index.php?route=dashboard&onglet=article');

                } else {
                    header('Location: index.php?route=dashboard');
                }
            }
            elseif (isset($_GET['action']) && $_GET['action'] === 'deleteMembre' && isset($_GET['membreId'])) {
                if (is_numeric($_GET['membreId'])) {
                    $membre = $this->membresManager->selectOne($_GET['membreId']);
                    if($membre['role'] != "0") {
                        $_SESSION['info']['membre'] = 'Les administrateurs ne peuvent être supprimés.';
                        header('Location: index.php?route=dashboard&onglet=membres');
                    }
                    $this->commentairesManager->deleteAllCommentFromUser($_GET['membreId']);

                    if ($membre['avatar'] != NULL) {
                        unlink('public/img' . $membre['avatar']);
                    }
                    $this->membresManager->deleteAccount($_GET['membreId']);
                    $_SESSION['info']['membre'] = 'Membre supprimé !';
                    header('Location: index.php?route=dashboard&onglet=membres');
                } else {
                    header('Location: index.php?route=dashboard&onglet=article');
                }
            }

            elseif (isset($_GET['action']) && $_GET['action'] === 'deleteCategorie' && isset($_GET['categorieId'])) {
                if (is_numeric($_GET['categorieId'])) {
                    $this->articlesManager->setCategorieToNull($_GET['categorieId']);
                    $this->categorieManager->deleteCategorie($_GET['categorieId']);
                    $_SESSION['info']['categorie'] = 'Catégorie supprimée !';
                    header('Location: index.php?route=dashboard&onglet=categorie');
                }
                header('Location: index.php?route=dashboard&onglet=categorie');
            }

         else {
            $categories = $this->categorieManager->selectAll();
            $membres = $this->membresManager->selectAll();
            $articles = $this->articlesManager->selectAll();
            $lastComments = $this->commentairesManager->get3LastComment();
            require('views/dashboard.view.php');
        }

    }

    function getCommentAndDates() {
            $this->commentairesManager->getCommentDateAjax();
    }

    function getMembersAndDates() {
        $this->membresManager->getNbMembrebyDate();
    }

    public function getNbViews() {
        $this->articlesManager->getNbViewAndDate();
    }

    public function getNbViewsPerCategories() {
        $this->categorieManager->getNbViewPerCategories();
    }
}