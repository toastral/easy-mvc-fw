<?php
/**
 * Created by PhpStorm.
 * User: work
 * Date: 14.09.2016
 * Time: 18:49
 */
class DB{
    public $db;

    function __construct(){
        $this->db = DbConn::getInstance()->getConnection();
    }

    function query($q){
        $res = $this->db->query($q);
        if(!$res){
            throw new Exception("Mysql query failure: [".$q."] (" . $this->db->errno . ") " . $this->db->error);
        }
        return $res;
    }
    function escape($val){
        return $this->db->real_escape_string($val);
    }
}
?>