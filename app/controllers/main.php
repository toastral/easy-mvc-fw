<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 18.09.2016
 * Time: 7:54
 */
class ControllerMain extends Controller{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $this->view->generate('main.php', 'template_view.php');
    }

    function super($p1, $p2, $p3, $p4)
    {
        $a = ['ss'=>$p1, 'joke'=>$p2, 'some'=>$p3, 'another'=>$p4];
        print_r($a);
        echo json_encode($a);
    }
}