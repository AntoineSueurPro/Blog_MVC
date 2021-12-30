<?php
namespace controller;

class ErrorController {

    public function pageNotFound() {
        require ('views/page_not_found.view.php');
    }

    public function errorServer() {
        require ('views/serverError.view.php');
    }
}