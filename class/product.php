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
class product {

    public $id;
    public $code,$name,$remarks;
    public $status_id,$status_name;
    public $units_id,$units_name;
    function __construct($id = '') {
        $this->id = $id;
    }

    public function getData() {
        $str = "SELECT t1.*,t2.* FROM product as t1 left join units as t2 on t1.units_id=t2.id WHERE t1.id='$this->id';";
        $result = dbQuery($str);
        if ($row = dbFetchAssoc($result)) {
            $this->code = $row['code'];
            $this->name = $row['name'];
            $this->remarks = $row['remarks'];
            $this->status_id = $row['status'];
            $this->units_id=$row['units_id'];
            $this->units_name=$row['unit'];
        }
    }
    public function save(){
        $str="INSERT INTO product (code,name,remarks,status,units_id) VALUES(".getStringFormatted($this->code)
               .",".getStringFormatted($this->name).",". getStringFormatted($this->remarks)
               .",'1',". getStringFormatted($this->units_id).");";
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
            $str="UPDATE product set code=".getStringFormatted($this->code).",name=".getStringFormatted($this->name)
                    .",remarks=".getStringFormatted($this->remarks)
                    .",units_id=". getStringFormatted($this->units_id)." WHERE id='$this->id';";

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
            $str="UPDATE product set status='0' WHERE id='$this->id';";
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
        $str="VAR:{id=". $this->id."|code=".$this->code."|name=".$this->name."|remarks=".$this->rem4."|status_id=".$this->status_id."|status_name=".$this->status_name.
                "|units_id=".$this->units_id."|unit_name=".$this->units_name."}";
        return $str;
        
    }

}
