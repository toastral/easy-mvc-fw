<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 18.09.2016
 * Time: 7:54
 */
class ControllerBack_ajax extends Controller{

    function __construct()
    {
        parent::__construct();
        if(!Utills::isAuth()){
            header("Location: ".ROOT_WWW . '/');
        }
    }

    function index()
    {
        $Blocks = new \DB_Model\Blocks();
        $Blocks->getList();

        $this->view->generate('back/main.php', ['Bloks' => $Blocks->ItemList]);
    }

    function tiny_change(){
        $Tiny = new \DB_Model\Content_tiny_desc();
        $Tiny->Item->id = $_POST['id'];
        $Tiny->Item->title = $_POST['title'];

        $Tiny->update();

        $a_return = array(
            'is_error' => 0,
            'msg' => "",
        );

        echo json_encode($a_return);
        exit;
    }

    function sett_change(){
        $S = new \DB_Model\Content_settings();
        $S->Item->id = $_POST['id'];
        $S->Item->value = $_POST['value'];

        $S->update();

        $a_return = array(
            'is_error' => 0,
            'msg' => "",
        );

        echo json_encode($a_return);
        exit;
    }

    function services_change(){
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $_POST['id'];
        $Img->Item->title = $_POST['title'];

        $Img->update();

        $a_return = array(
            'is_error' => 0,
            'msg' => "",
        );

        echo json_encode($a_return);
        exit;
    }

    function works_change(){
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $_POST['id'];
        $Img->Item->title = $_POST['title'];

        $Img->Item->date_day = $_POST['date_day'];
        $Img->Item->date_month = $_POST['date_month'];
        $Img->Item->date_year = $_POST['date_year'];
        $Img->Item->price = $_POST['price'];

        $Img->update();

        $a_return = array(
            'is_error' => 0,
            'msg' => "",
        );

        echo json_encode($a_return);
        exit;
    }

    function services_del(){
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $_POST['id'];
        $Img->getItem();
        $Img->delete();

        $p_img = ROOT_PATH."/images/services/".$Img->Item->img;
        $p_thumb = ROOT_PATH."/images/services/thumbs/".$Img->Item->img;
        @unlink($p_img);
        @unlink($p_thumb);
        $a_return = array(
            'is_error' => 0,
            'msg' => "",
        );

        echo json_encode($a_return);
        exit;
    }

    function works_del(){
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $_POST['id'];
        $Img->getItem();
        $Img->delete();

        $p_img = ROOT_PATH."/images/works/".$Img->Item->img;
        $p_thumb = ROOT_PATH."/images/works/thumbs/".$Img->Item->img;
        @unlink($p_img);
        @unlink($p_thumb);
        $a_return = array(
            'is_error' => 0,
            'msg' => "",
        );

        echo json_encode($a_return);
        exit;
    }

    function form1(){

    }
    function services(){

    }
    function form2(){

    }
    function advantages(){

    }
    function works(){

    }
    function map(){

    }
    function bottom(){

    }
    function settings(){

    }

}