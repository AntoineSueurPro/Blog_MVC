<?php

namespace controller;

class HomeController {

    private $artcilesManager;
    private $categoriesManager;

    public function __construct() {
        $this->artcilesManager = new \models\ArticlesManager;
        $this->categoriesManager = new \models\CategoriesManager;
    }

    public function index() {

        $categories = $this->categoriesManager->selectAll();
        $article = $this->artcilesManager->selectTheLastOne();
        require('views/home.view.php');
    }

    public function ajax() {
        if(isset($_GET['categorie']) && $_GET['categorie'] != "" && $_GET['categorie'] != 'Tout') {
            $this->artcilesManager->selectAllAjax($_GET['categorie']);
        } else {
            $this->artcilesManager->selectAllAjaxWithoutCategorie();
        }
    }

    public function mentionLegale() {
        require('views/mentions.view.php');
    }
}