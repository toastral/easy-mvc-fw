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
        $data = [];
        $Content_settings = new DB_Model\Content_settings();
        $Content_settings->getList();
        $data = [
            'settings_phone' => $Content_settings->ItemList[1]->value,
            'settings_site_title' => $Content_settings->ItemList[2]->value
        ];

        $Content_tiny_desc = new DB_Model\Content_tiny_desc();
        $Content_tiny_desc->getList();

        $data['content_tiny_top_1'] = $Content_tiny_desc->ItemList[1]->title;
        $data['content_tiny_top_2'] = $Content_tiny_desc->ItemList[2]->title;
        $data['content_tiny_top_3'] = $Content_tiny_desc->ItemList[3]->title;
        $data['content_tiny_top_4'] = $Content_tiny_desc->ItemList[4]->title;

        $data['content_tiny_middle_1'] = $Content_tiny_desc->ItemList[5]->title;
        $data['content_tiny_middle_2'] = $Content_tiny_desc->ItemList[6]->title;
        $data['content_tiny_middle_3'] = $Content_tiny_desc->ItemList[7]->title;
        $data['content_tiny_middle_4'] = $Content_tiny_desc->ItemList[8]->title;

        $data['content_tiny_map_1'] = $Content_tiny_desc->ItemList[9]->title;
        $data['content_tiny_map_2'] = $Content_tiny_desc->ItemList[10]->title;
        $data['content_tiny_map_3'] = $Content_tiny_desc->ItemList[11]->title;
        $data['content_tiny_map_4'] = $Content_tiny_desc->ItemList[12]->title;

        $data['content_tiny_email_1'] = $Content_tiny_desc->ItemList[13]->title;
        $data['content_tiny_email_2'] = $Content_tiny_desc->ItemList[14]->title;
        $data['content_tiny_copy'] = $Content_tiny_desc->ItemList[15]->title;


        $Content_tiny_desc = new DB_Model\Content_img_desc();
        $Content_tiny_desc->getListByBlockId(3);
        $data['ItemServices'] = $Content_tiny_desc->ItemList;

        $Content_tiny_desc->getListByBlockId(6);
        $data['ItemWorks'] = $Content_tiny_desc->ItemList;

        $this->view->generate('front/main.php', $data);
    }

    function super($p1, $p2, $p3, $p4)
    {
        $a = ['ss'=>$p1, 'joke'=>$p2, 'some'=>$p3, 'another'=>$p4];
        print_r($a);
        echo json_encode($a);
    }
}