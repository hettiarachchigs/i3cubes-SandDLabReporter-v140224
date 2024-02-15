<?php
include_once 'database.php';
include_once 'functions.php';

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
class store_location {

    public $id;
    public $name;
    public $status_id,$status_name;
    function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $str = "SELECT * FROM store_location WHERE id='$this->id';";
        $result = dbQuery($str);
        if ($row = dbFetchAssoc($result)) {
            $this->name = $row['name'];
            $this->status_id = $row['status'];
        }
    }
    public function save(){
        $str="INSERT INTO store_location (name,status) VALUES(".getStringFormatted($this->name)
               .",'1');";
        $result = dbQuery($str);
        //print $str;
        if($result){
            $this->id= dbInsertId();
            return true;
        }
        else{
            return false;
        }
        
    }
    public function update(){
        if($this->id!=""){
            $str="UPDATE store_location set name=".getStringFormatted($this->name)." WHERE id='$this->id';";

            $result = dbQuery($str);
            if($result){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public function delete(){
        if($this->id!=""){
            $str="UPDATE store_location set status='0' WHERE id='$this->id';";
            $result = dbQuery($str);
            if($result){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
    public function toString(){
        $str="VAR:{id=". $this->id."|name=".$this->name."}";
        return $str;
        
    }

}
