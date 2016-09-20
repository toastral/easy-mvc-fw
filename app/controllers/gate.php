<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 18.09.2016
 * Time: 7:54
 */
class ControllerGate extends Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        if(isset($_POST['auth_me']) && $_POST['user'] == PANEL_USER && $_POST['pass'] == PANEL_PASS){
            $_SESSION['auth_code'] = Utills::getAuthHash();
            header("Location: ".ROOT_WWW . '/back');
            exit;
        }
        $this->view->generate('login.php');
    }

    function logout()
    {
        unset($_SESSION['auth_code']);
        header("Location: ". ROOT_WWW );
        exit;
    }

}