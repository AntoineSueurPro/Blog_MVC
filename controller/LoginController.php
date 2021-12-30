<?php
 namespace controller;

 class LoginController{

     private $manager;

     public function __construct() {
         $this->manager = new \models\MembresManager;
     }

     public function index(){

         if(isset($_SESSION['membre'])) {
             header('Location: index.php');
         }

         if(!empty($_POST)) {
             $error = array();
             foreach ($_POST as $key => $value) {
                 $_POST[$key] = htmlspecialchars($value);
             }
             if(strlen($_POST['pseudo']) < 0) {
                 $_SESSION['error']['pseudo'] = 'Veuillez remplir le champs';
             }
             if($this->manager->login($_POST)) {
                 $_SESSION['membre'] = $this->manager->login($_POST);
                 header('Location: index.php');
             } else {
                 $error[] = 'Pseudo ou mot de passe incorrect';
                 $_SESSION['error'] = $error;
             }
         }
         require ('views/login.view.php');
     }

     public function logout() {
         session_destroy();
         header('Location: index.php');
     }
 }