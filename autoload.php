<?php

class Autoload
{
    public static function inclusionAuto($className)
    {
        $path = str_replace('\\', '/', $className) . '.php';
        require $path;
    }
}
    spl_autoload_register(array('Autoload', 'inclusionAuto'));
