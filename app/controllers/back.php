<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 18.09.2016
 * Time: 7:54
 */
class ControllerBack extends Controller{
    public $thum_w = "346";
    public $thum_h = "198";

    public $max_img_w = "700";

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

    function settings(){
        $Settings = new \DB_Model\Content_settings();
        $Settings->getList();
        $this->view->generate('back/blocks/settings.php', ['Settings' => $Settings->ItemList]);
    }

    function top(){
        $Tiny = new \DB_Model\Content_tiny_desc();
        $Tiny->getListByBlockId(1);

        $this->view->generate('back/blocks/tiny.php', ['TinyBlocks' => $Tiny->ItemList]);
    }
    function form1(){
        $Tiny = new \DB_Model\Content_tiny_desc();
        $Tiny->getListByBlockId(2);

        $this->view->generate('back/blocks/tiny_without_icon.php', ['TinyBlocks' => $Tiny->ItemList]);
    }
    function services(){
        $Img = new \DB_Model\Content_img_desc();
        $Img->getListByBlockId(3);

        $this->view->generate('back/blocks/services.php', ['ImgBlocks' => $Img->ItemList]);
    }

    function services_img($content_img_desc_id){
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $content_img_desc_id;
        if(!$Img->getItem()) throw new MyException('Item not found', 2000);

        $this->view->generate('back/blocks/services_img.php', ['Item' => $Img->Item]);
    }

    function works_img($content_img_desc_id){
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $content_img_desc_id;
        if(!$Img->getItem()) throw new MyException('Item not found', 2000);

        $this->view->generate('back/blocks/works_img.php', ['Item' => $Img->Item]);
    }

    function services_img_upload($content_img_desc_id){

        $p = ROOT_PATH."/images/services/";
        $new_img = $this->_img_upload($content_img_desc_id, $p);

        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $content_img_desc_id;
        $Img->Item->img = $new_img;
        $Img->update_img();

        $this->createThumb($p.$new_img, $p.'thumbs/'.$new_img, $this->thum_w, $this->thum_h);

        header('Location: '.ROOT_WWW. '/back/services/');
        exit;
    }

    function works_img_upload($content_img_desc_id){

        $p = ROOT_PATH."/images/works/";
        $new_img = $this->_img_upload($content_img_desc_id, $p);

        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $content_img_desc_id;
        $Img->Item->img = $new_img;
        $Img->update_img();

        $this->createThumb($p.$new_img, $p.'thumbs/'.$new_img, $this->thum_w, $this->thum_h);

        header('Location: '.ROOT_WWW. '/back/works/');
        exit;
    }

    function _img_upload($content_img_desc_id, $path){
        //удалим старый баннер
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->id = $content_img_desc_id;
        if(!$Img->getItem()) throw new MyException('Item not found', 2001);
        @unlink(ROOT_PATH."/images/".$Img->Item->img);

        if($_FILES['userfile']['error']) throw new MyException("при загрузки файла произошла ошибка", 2002);

        $name = strtolower($_FILES['userfile']['name']);
        $tmp = explode(".", $name);
        $ext = array_pop($tmp);
        $new_img = $content_img_desc_id.".".$ext;

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $path.$new_img)) {
            //echo "File is valid, and was successfully uploaded.\n";
        } else throw new MyException("move_uploaded_file - не получается загрузить файл \n", 2003);

        return $new_img;
    }

    function services_add(){
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->title       = $_POST['title'];
        $Img->Item->block_id    = 3;
        $Img->Item->date_year   = 0;
        $Img->Item->date_month  = 0;
        $Img->Item->date_day    = 0;
        $Img->Item->price       = 0;
        $Img->create();
        $content_img_desc_id = $Img->Item->id;

        $p = ROOT_PATH."/images/services/";
        if($_FILES['userfile']['size']){
            $new_img = $this->_img_upload($content_img_desc_id, $p);
        }else{
            $new_img = $content_img_desc_id.".jpg";
            copy(ROOT_PATH."/images/tmp_auto.jpg", $p.$new_img);
        }

        $Img->Item->id = $content_img_desc_id;
        $Img->Item->img = $new_img;
        $Img->update_img();

        $this->resizeByWidth($p.$new_img, $p.$new_img, $this->max_img_w);
        $this->createThumb($p.$new_img, $p.'thumbs/'.$new_img, $this->thum_w, $this->thum_h);

        header('Location: '.ROOT_WWW. '/back/services/');
        exit;
    }

    function works_add(){
        $Img = new \DB_Model\Content_img_desc();
        $Img->Item->title       = $_POST['title'];
        $Img->Item->block_id    = 6;
        $Img->Item->date_year   = $_POST['date_year'];
        $Img->Item->date_month  = $_POST['date_month'];
        $Img->Item->date_day    = $_POST['date_day'];
        $Img->Item->price       = $_POST['price'];
        $Img->create();
        $content_img_desc_id = $Img->Item->id;

        $p = ROOT_PATH."/images/works/";
        if($_FILES['userfile']['size']){
            $new_img = $this->_img_upload($content_img_desc_id, $p);
        }else{
            $new_img = $content_img_desc_id.".jpg";
            copy(ROOT_PATH."/images/tmp_auto.jpg", $p.$new_img);
        }

        $Img->Item->id = $content_img_desc_id;
        $Img->Item->img = $new_img;
        $Img->update_img();

        $this->resizeByWidth($p.$new_img, $p.$new_img, $this->max_img_w);
        $this->createThumb($p.$new_img, $p.'thumbs/'.$new_img, $this->thum_w, $this->thum_h);

        header('Location: '.ROOT_WWW. '/back/works/');
        exit;
    }
    function form2(){
        $Tiny = new \DB_Model\Content_tiny_desc();
        $Tiny->getListByBlockId(4);

        $this->view->generate('back/blocks/tiny_without_icon.php', ['TinyBlocks' => $Tiny->ItemList]);
    }
    function advantages(){
        $Tiny = new \DB_Model\Content_tiny_desc();
        $Tiny->getListByBlockId(5);

        $this->view->generate('back/blocks/tiny.php', ['TinyBlocks' => $Tiny->ItemList]);
    }
    function works(){
        $Full = new \DB_Model\Content_img_desc();
        $Full->getListByBlockId(6);

        $this->view->generate('back/blocks/works.php', ['FullBlocks' => $Full->ItemList]);
    }
    function map(){
        $Tiny = new \DB_Model\Content_tiny_desc();
        $Tiny->getListByBlockId(7);

        $this->view->generate('back/blocks/tiny.php', ['TinyBlocks' => $Tiny->ItemList]);
    }

    function bottom(){
        $Tiny = new \DB_Model\Content_tiny_desc();
        $Tiny->getListByBlockId(8);

        $this->view->generate('back/blocks/tiny_without_icon.php', ['TinyBlocks' => $Tiny->ItemList]);
    }

    function createThumb($path_src, $path_new, $w, $h)
    {
        $img = new abeautifulsite\SimpleImage($path_src);
        $img->thumbnail($w, $h)->save($path_new);
    }

    function resizeByWidth($path_src, $path_new, $w)
    {
        $img = new abeautifulsite\SimpleImage($path_src);
        $img->fit_to_width($w)->save($path_new);
    }


    function makecropthumb($width, $height){
        $img = new abeautifulsite\SimpleImage('/vagrant/easy-mvc-fw/shab.jpg');
    }

    function testcrop($x1, $y1, $x2, $y2){
        $img = new abeautifulsite\SimpleImage('/vagrant/easy-mvc-fw/images/services/25.jpg');
        //$img->fit_to_width($width)->output();
        $img->thumbnail($this->thum_w, $this->thum_h)->output();
        #$img->thumbnail($width, $height)->save('/vagrant/easy-mvc-fw/mages/services/25-crop.jpg');
        //$img->crop($x1, $y1, $x2, $y2)->output();
    }

}