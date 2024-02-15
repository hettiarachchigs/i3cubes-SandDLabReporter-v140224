<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'database.php';
include_once 'constants.php';

class material {
    public $id;
    public $code;
    public $name;
    public $status;
    
    function __construct($id="") {
        $this->id = $id;
    }
    function save(){
        if($this->name!="" && $this->code!=""){
            $code = getStringFormatted($this->code);
            $name = getStringFormatted($this->name);

            $str = "INSERT INTO  material (`code`,`name`,`status`) VALUES ($code,$name,".constants::$Active_STE.")";
            $res = dbQuery($str);
            if($res){
                $this->id= dbInsertId();
                return dbInsertId();
            }  else {
                return false;
            }
        }
        else{
            return false;
        }
    }
    function getMaerialData (){
        $str = "SELECT * FROM material WHERE id = '$this->id'";
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        
        $this->id = $row['id'];
        $this->code = $row['code'];
        $this->name = $row['name'];
    }
    
    function addMaterial(){
        $code = getStringFormatted($this->code);
        $name = getStringFormatted($this->name);
        
        $str = "INSERT INTO  material (`code`,`name`,`status`) VALUES ($code,$name,".constants::$Active_STE.")";
        $res = dbQuery($str);
        if($res){
            return true;
        }  else {
            return false;
        }
    }
    
    function deleteMaterial(){
        if($this->id !=""){
            $str = "UPDATE material SET status = '".constants::$Deleted_STE."'";
            $res = dbQuery($str);
            if($res){
                return true;
            }else{
                return false;
            }
                
        }
    }
    
}