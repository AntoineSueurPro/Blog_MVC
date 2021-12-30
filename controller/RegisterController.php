<?php

namespace controller;

class RegisterController
{

    private $manager;

    public function __construct()
    {
        $this->manager = new \models\MembresManager;
    }

    public function index()
    {
        if(isset($_SESSION['membre'])) {
            header('Location: index.php');
        }

        $error = 0;

        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $_POST[$key] = htmlspecialchars($value);
            }

            if(strlen($_POST['password']) < 6) {
                $error++;
                $_SESSION['error']['password'] = 'Le mot de passe doit contenir au moins 6 caractères.';
            }

            if(trim(strlen($_POST['pseudo'])) < 3 ) {
                $error++;
                $_SESSION['error']['pseudo'] = 'Le pseudo doit contenir au moins 3 caractères';
            } elseif ($this->manager->checkPseudoAndMail($_POST)) {
                $error++;
                $_SESSION['error']['exist'] = 'Le pseudo ou le mail sont déja existant';
            }

            if ($_POST['password'] != $_POST['password_confirm']) {
                $error++;
                $_SESSION['error']['confirm'] = 'Les mots de passe doivent être identiques';
            }

            if ($error === 0) {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $this->manager->insert($_POST);
                $_SESSION['membre'] = $_POST;
                $_SESSION['membre']['role'] = "0";
                $_SESSION['membre']['avatar'] = NULL;
                $_SESSION['membre']['id_membre'] = $this->manager->getId($_POST['pseudo']);
                header('Location: index.php');
            }

        }
        require("views/register.view.php");
    }
}