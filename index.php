<?php
require_once 'vendor/autoload.php';
require_once 'autoload.php';
session_start();
$router = new router\Router;
$router->run();