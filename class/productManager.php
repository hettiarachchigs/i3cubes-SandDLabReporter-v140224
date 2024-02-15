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
class productManager {

    public function getAllProducts() {
        $res=array();
        $str = "SELECT t1.*,t2.* FROM product as t1 left join units as t2 on t1.units_id=t2.id WHERE t1.status='1';";
        $result = dbQuery($str);
        while ($row= dbFetchAssoc($result)){
            $item=new product($row['id']);
            $item->code=$row['code'];
            $item->name = $row['name'];
            $item->remarks = $row['remarks'];
            $item->units_id = $row['units_id'];
            $item->status = $row['status'];
            //$item->status_name=$row['description'];
            $item->units_name=$row['unit'];
            array_push($res, $item);
        }
        return $res;
    }
    public function getPartByCode($code){
        $item=null;
        $str = "SELECT t1.*,t2.* FROM product as t1 left join units as t2 on t1.units_id=t2.id WHERE t1.code='$code';";
        $result = dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchAssoc($result);
            $item=new product($row['id']);
            $item->code=$row['code'];
            $item->name = $row['name'];
            $item->remarks = $row['remarks'];
            $item->units_id = $row['units_id'];
            $item->status = $row['status'];
            //$item->status_name=$row['description'];
            $item->units_name=$row['unit'];
        }
        return $item;
    }
    public function getPartByName($name){
        $item=null;
        $str = "SELECT t1.*,t2.* FROM product as t1 left join units as t2 on t1.units_id=t2.id WHERE t1.name='$name';";
        $result = dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchAssoc($result);
            $item=new product($row['id']);
            $item->code=$row['code'];
            $item->name = $row['name'];
            $item->remarks = $row['remarks'];
            $item->units_id = $row['units_id'];
            $item->status = $row['status'];
            //$item->status_name=$row['description'];
            $item->units_name=$row['unit'];
        }
        return $item;
    }
    public function getUnitID($unit){
        $str="SELECT * FROM units WHERE unit='$unit';";
        $result = dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchAssoc($result);
            return $row['id'];
        }
        else{
            return null;
        }
    }
    ///////////////////////////////////////
}
