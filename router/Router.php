<?php

namespace router;
use Exception;

class Router
{

    private $homeController;
    private $registerController;
    private $loginController;
    private $profilController;
    private $dashboardController;
    private $articleController;
    private $errorController;

    public function __construct()
    {
        $this->homeController = new \controller\HomeController;
        $this->registerController = new \controller\RegisterController;
        $this->loginController = new \controller\LoginController;
        $this->profilController = new \controller\ProfilController;
        $this->dashboardController = new \controller\DashboardController;
        $this->articleController = new \controller\ArticleController;
        $this->errorController = new \controller\ErrorController;

    }

    public function run()
    {

        $route = $_GET['route'] ?? 'home';
        try {
            if (isset($route)) {

                if ($route === 'home') {
                    $this->homeController->index();
                } elseif ($route === 'inscription') {
                    $this->registerController->index();
                } elseif ($route === 'login') {
                    $this->loginController->index();
                } elseif ($route === 'logout') {
                    $this->loginController->logout();
                } elseif ($route === 'profil') {
                    $this->profilController->index();
                }elseif ($route === 'dashboard') {
                    $this->dashboardController->index();
                } elseif ($route === 'article') {
                    $this->articleController->index();
                } elseif ($route === 'ajax') {
                    $this->homeController->ajax();
                }
                else {
                    $this->errorController->pageNotFound();
                }
            }
        } catch (Exception $e) {
//            $this->errorController->errorServer();
//            echo $e->getMessage();
        }
    }
}