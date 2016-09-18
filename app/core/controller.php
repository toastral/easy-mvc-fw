<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 18.09.2016
 * Time: 7:52
 */
class Controller {

    public $model;
    public $view;

    function __construct()
    {
        $this->view = new View();
    }

}