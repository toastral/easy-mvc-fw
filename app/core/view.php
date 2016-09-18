<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 18.09.2016
 * Time: 7:50
 */
class View
{
    public $template_view; // здесь можно указать общий вид по умолчанию.

    function generate( $content_view, $template_view, $data = null)
    {

        if(is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }


        include 'app/views/'.$template_view;
    }
}