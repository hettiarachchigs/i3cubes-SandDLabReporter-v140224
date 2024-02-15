<?php

include_once 'product.php';
include_once 'database.php';
include_once 'constants.php';
include_once 'cls_system.php';
include_once 'cls_log.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of equipment
 *
 * @author Administrator
 */
class inventory_item{
    public $id,$product_id,$batch_no,$adde_emp_id;
    public $serial,$qty,$status,$remarks,$date_added,$date_expiary,$location_id,$location_name;
    public $qty_init,$qty_balance;
    public $code,$name,$unit_name;
    public $product;
            
    function __construct($id = '') {
        $this->id=$id;
    }
    public function getData(){
        $str="SELECT t1.*,t2.*,t2.name as location_name FROM inventory as t1 left join store_location as t2 on t1.store_location_id=t2.id left join product as t0 on t1.product_id=t0.id"
                . " WHERE t1.id='$this->id';";
        //print $str;
        $res = dbQuery($str);
        $row=dbFetchAssoc($res);
        $this->product_id=$row['product_id'];
        $this->batch_no=$row['batch_no'];
        $this->qty_init=$row['initial_qty'];
        $this->qty_balance=$row['balance_qty'];
        $this->date_added=$row['date_entry'];
        $this->date_expiary=$row['date_expiary'];
        $this->status=$row['status'];
        $this->remarks=$row['remarks'];
        $this->location_id=$row['store_location_id'];
        $this->location_name=$row['location_name'];
        $this->system_type=$row['sys_type'];
        $this->code=$row['code'];
        $this->name=$row['name'];
    }
    public function save(){
        $str="INSERT INTO inventory (batch_no,initial_qty,balance_qty,date_entry,date_expiary,remarks,product_id,status,employee_id,store_location_id) "
                . "VALUES("
                . getStringFormatted($this->batch_no).","
                . getStringFormatted($this->qty_init).","
                . getStringFormatted($this->qty_balance).","
                . "NOW(),"
                . getStringFormatted($this->date_expiary).","
                . getStringFormatted($this->remarks).","
                . getStringFormatted($this->product_id).","
                . "'1',"
                . getStringFormatted($this->adde_emp_id).","
                . getStringFormatted($this->location_id)
                . ");";
        //print $str;
        $result = dbQuery($str);
        if($result){
            $this->id= dbInsertId();
            return dbInsertId();
        }
        else{
            return false;
        }
    }

    public function getProduct(){
        $this->product=new product($this->product_id);
        $this->product->getData();
        return $this->product;
    }
    public function delete() {
        $str = "UPDATE inventory set status='" . constants::$Deleted . "' where id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function setItemStatus($s) {
        $str = "UPDATE inventory set status='" . $s. "' where id='$this->id'";
        //print $str;
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function addRemarks($note){
        $note= getStringFormatted($note);
        $str = "UPDATE inventory set remarks=$note where id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function setLocation($loc_id) {
        $str = "UPDATE inventory set store_location_id=". getStringFormatted($loc_id)." where id='$this->id'";
        //print $str;
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
}
