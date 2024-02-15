<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'database.php';
include_once 'cls_material.php';
class material_manager {
    
    function getMaterials ($status="",$name="",$code=""){
        $sql_arr = array();
        if($status !=""){
            array_push($sql_arr, "status = '$status'");
        }else {
            array_push($sql_arr, "status <> 3");
        }
        if($name !=""){
            array_push($sql_arr, "name = '$name'");
        }
        if($code !=""){
            array_push($sql_arr, "code = '$code'");
        }
        if(count($sql_arr)>0){
            $str = implode(" AND ", $sql_arr);
            $where = " WHERE ".$str;
        }else {
            $where = "";
        }
        $result = array();
        $str = "SELECT * FROM material $where";
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)){
            $material = new material($row['id']);
            $material->code = $row['code'];
            $material->name = $row['name'];
            array_push($result, $material);
            
        }
        return $result;
    }
}