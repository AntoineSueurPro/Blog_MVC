<?php

namespace models;

use PDO, PDOException, Exception;

abstract class Model
{

    private static $pdo;

    private static function setBdd()
    {
        try {
            self::$pdo = new PDO('mysql:host=localhost;dbname=blog_certif;charset=utf8', "root", "", array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ));
        } catch (PDOException $e) {
            die('Probleme de connexion BDD');
        }
    }

    protected function getBdd()
    {
        if (self::$pdo == null) {
            self::setBdd();
        }
        return self::$pdo;
    }
}








