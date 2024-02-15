<?php
include_once 'database.php';
include_once 'product.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of item
 *
 * @author Administrator
 */
class store_locationManager {

    public function getAll() {
        $res=array();
        $str = "SELECT * FROM store_location WHERE status='1';";
        $result = dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            $s=new store_location($row['id']);
            $s->name=$row['name'];
            array_push($res, $s);
        }
        return $res;
    }
    public function getByName($name){
        $str = "SELECT * FROM store_location WHERE name='$name';";
        $result = dbQuery($str);
        if(dbNumRows($result)>0){
            $row= dbFetchAssoc($result);
            $s=new store_location($row['id']);
            $s->name=$row['name'];
            return $s;
        }
        else{
            return null;
        }
    }
    ///////////////////////////////////////
}
