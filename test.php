<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 17.09.2016
 * Time: 19:05
 */
class Test{
    function method1(){
        echo "I am method1()\n";
    }
    function method2($name){
        echo "I am $name\n";
    }
}

$route = ['index.php', 'show', '55'];
$keys = ["controller", "action", "p1", "p2", "p3", "p4"];
$stuffed_route = [];
foreach($keys as $i => $param){
    $val = "";
    if(!empty($route[$i])) $val = $route[$i];
    $stuffed_route[$param] = $val;
}
extract($stuffed_route);
$extr = [$controller, $action, $p1, $p2, $p3, $p4];
print_r($extr);




exit;
$a = ["p1" => "888", "p2" =>"222", "p3" =>"333"];
print_r(
    extract($a, EXTR_PREFIX_SAME, "my__"));

$Test = new Test();
$Test->method1($p1, $p2, $p3);
$Test->method2($p1, $p2, $p3);