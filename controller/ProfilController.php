<?php

namespace controller;

use models\MembresManager;

class ProfilController
{

    private $manager;
    private $commentairesManager;
    private $articleManager;

    public function __construct()
    {
        $this->manager = new \models\MembresManager;
        $this->commentairesManager = new \models\CommentairesManager;
        $this->articleManager = new \models\ArticlesManager;
    }

    public function index()
    {
        if (!isset($_SESSION['membre'])) {
            header('Location: index.php');
        }

        if (isset($_GET['action'])) {

            if ($_GET['action'] === 'updatePassword') {


                if (!empty($_POST)) {
                    $error = 0;
                    foreach ($_POST as $key => $value) {
                        $_POST[$key] = htmlspecialchars($value);
                    }
                    if(strlen($_POST['new_password']) < 6) {
                        $error++;
                        $_SESSION['error']['taille'] = 'Votre mot de passe doit contenir au moins 6 caractères';
                    }
                    if ($_POST['new_password'] != $_POST['new_password_confirm']) {
                        $error++;
                        $_SESSION['error']['confirm'] = 'Le nouveau mot de passe et la confirmation doivent être identiques';
                    }
                    if ($error === 0) {
                        if ($this->manager->updatePassword($_POST['old_password'], $_SESSION["membre"]['id_membre'], $_POST['new_password'])) {
                            $_SESSION['info'] = 'Mot de passe modifié avec succès';
                            header('Location: index.php?route=profil');
                        } else {
                            $_SESSION['error']['actuel'] = 'Votre mot de passe actuel n\'est pas valide';
                        }
                    }
                }
                require('views/updatePassword.view.php');
            }

            if ($_GET['action'] === 'updateAvatar') {

                if (isset($_FILES['avatar'])) {

                    $error = array();
                    $tmp_name = $_FILES['avatar']['tmp_name'];
                    $file_extension = strrchr($_FILES['avatar']['type'], "/");
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
                            $this->manager->updateAvatar($file_name, $_SESSION['membre']['id_membre']);

                            if ($_SESSION['membre']['avatar'] != 'avatar.jpg') {
                                unlink($folder . $_SESSION['membre']['avatar']);
                            }
                            $_SESSION['info'] = "Avatar modifié avec succès";
                            $_SESSION['membre']['avatar'] = $file_name;
                            header('Location: index.php?route=profil');
                        } else {
                            $error[] = 'Erreur dans l\'upload de votre avatar. Veuillez recommencer';
                            $_SESSION['error'] = $error;
                        }
                    } else {
                        $_SESSION['error'] = $error;
                    }
                }
                require('views/updateAvatar.view.php');
            }
            if ($_GET['action'] === 'deleteAccount') {
                $this->commentairesManager->deleteAllCommentFromUser($_SESSION['membre']['id_membre']);
                $this->manager->deleteAccount($_SESSION['membre']['id_membre']);
                if ($_SESSION['membre']['avatar'] != 'avatar.jpg') {
                    unlink('public/img/' . $_SESSION['membre']['avatar']);

                }
                unset($_SESSION['membre']);
                header('Location: index.php');
            }

        } else {
            require('views/profil.view.php');
        }


    }
}