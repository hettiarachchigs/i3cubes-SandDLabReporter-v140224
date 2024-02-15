<?php

include_once './cls_inventory_item.php';
include_once 'database.php';
include_once 'constants.php';
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
class inventory_item_manager{
    
    public function getAllAvailable(){
        $ary_result=array();
        $str="SELECT t1.*,t0.name as product_name,t0.code as product_code,t2.name as location_name,t5.unit FROM inventory as t1 left join store_location as t2 on t1.store_location_id=t2.id left join product as t0 on t1.product_id=t0.id"
                . " left join units as t5 on t0.units_id=t5.id WHERE t1.balance_qty>'0' AND t1.status='1';";
        $result= dbQuery($str);
        while($row= dbFetchAssoc($result)){
            $trk_item=new inventory_item($row['id']);
            $trk_item->product_id=$row['product_id'];
            $trk_item->batch_no=$row['batch_no'];
            $trk_item->qty_init=$row['initial_qty'];
            $trk_item->qty_balance=$row['balance_qty'];
            $trk_item->date_added=$row['date_entry'];
            $trk_item->date_expiary=$row['date_expiary'];
            $trk_item->status=$row['status'];
            $trk_item->remarks=$row['remarks'];
            $trk_item->location_id=$row['store_location_id'];
            $trk_item->location_name=$row['location_name'];
            $trk_item->code=$row['product_code'];
            $trk_item->name=$row['product_name'];
            $trk_item->unit_name=$row['unit'];
            array_push($ary_result,$trk_item);
        }
        return $ary_result;
    }
    public function getItemByBatchNo($batch_no){
        $str="SELECT t1.*,t0.name as product_name,t0.code as product_code,t2.name as location_name,t5.unit FROM inventory as t1 left join store_location as t2 on t1.store_location_id=t2.id left join product as t0 on t1.product_id=t0.id"
                . " left join units as t5 on t0.units_id=t5.id WHERE t1.batch_no='$batch_no' AND t1.status='1' ORDER BY t1.id DESC LIMIT 1;";
        $result= dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchAssoc($result);
            $trk_item=new inventory_item($row['id']);
            $trk_item->product_id=$row['product_id'];
            $trk_item->batch_no=$row['batch_no'];
            $trk_item->qty_init=$row['initial_qty'];
            $trk_item->qty_balance=$row['balance_qty'];
            $trk_item->date_added=$row['date_entry'];
            $trk_item->date_expiary=$row['date_expiary'];
            $trk_item->status=$row['status'];
            $trk_item->remarks=$row['remarks'];
            $trk_item->location_id=$row['store_location_id'];
            $trk_item->location_name=$row['location_name'];
            $trk_item->code=$row['product_code'];
            $trk_item->name=$row['product_name'];
            $trk_item->unit_name=$row['unit'];
            return $trk_item;
        }
        else{
            return null;
        }
    }
}
