<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 17.09.2016
 * Time: 19:46
 */
function __autoload($class_name)
{

    $parts = explode('\\', $class_name);
    $class_name = end($parts);
    $file = strtolower($class_name).'.php';

    $p = ROOT_PATH. '/app/models/orm/'.$file;
    if(is_file($p)){
        require $p;
    }

    $p = ROOT_PATH. '/app/models/'.$file;
    if(is_file($p)){
        require $p;
    }

}