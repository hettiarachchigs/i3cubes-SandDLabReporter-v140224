<?php

include_once 'database.php';
include_once 'cls_inventory_item.php';

class grnManager {

    function searchGRN($from, $to, $vendor_id, $shipment_id) {
        $res = array();
        $sql = array();
        if ($from != "") {
            if ($to == "") {
                $to = date("Y-m-d");
            }
            array_push($sql, "t1.Date>'$from 00:00:00' AND t1.Date<'$to 23:59:59'");
        }
        if ($vendor_id != '') {
            array_push($sql, "t1.vendor_id='$vendor_id'");
        }
        if ($shipment_id != "") {
            array_push($sql, "t1.ShipmentID LIKE '%$shipment_id%");
        }
        if (!empty($sql)) {
            $where = implode(" AND ", $sql);
            $str = "SELECT t1.*,t2.name FROM grn as t1 left join vendor as t2 on t1.vendor_id=t2.id where $where;";
        } else {
            $str = "SELECT t1.*,t2.name FROM grn as t1 left join vendor as t2 on t1.vendor_id=t2.id where t1.status='1';";
        }
        //print $str;
        $result = dbQuery($str);
        $cont = new constants();
        while ($row = dbFetchAssoc($result)) {
            $grn = new grn($row['id']);
            $grn->ref_no = $row['GRN'];
            $grn->shipment_id = $row['ShipmentID'];
            $grn->vendor_id = $row['vendor_id'];
            $grn->vendor_name = $row['name'];
            $grn->status_id = $row['status'];
            $grn->status_name = $cont->getGRN_STATUS($row['status']);
            $grn->date_added = $row['Date'];
            array_push($res, $grn);
        }
        return $res;
    }

    function getGRNItemsforserial($serial) {
        $result = array();
//        $str="SELECT t1.*,t1.id as sys_id,t1.status as sys_status,t2.*,t3.name as customer_entity_name FROM customer_systems as t1 left join systems as t2 on t1.systems_id=t2.id left join customer_entity as t3 on t1.customer_entity_id=t3.id WHERE t1.grn_id='$id' and t1.serial='$serial' ORDER BY t1.id;";	
        $str = "SELECT t1.*,t1.id as sys_id,t1.status as sys_status,t2.*,t3.name as customer_entity_name "
                . "FROM customer_systems as t1 left "
                . "join systems as t2 on t1.systems_id=t2.id left "
                . "join customer_entity as t3 on t1.customer_entity_id=t3.id WHERE  t1.serial='$serial' and t1.status<>0 ORDER BY t1.id;";
//        print $str;
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)) {
            $sys = new system($row['sys_id']);
            $sys->id = $row['sys_id'];
            $sys->serial = $row['serial'];
            $sys->customerID = $row['customer_entity_id'];
            $sys->system_id = $row['systems_id'];
            $sys->system_code = $row['product_code'];
            $sys->system_name = $row['description'];
            $sys->v_warr_end = $row['vendor_warranty_end'];
            $sys->price = $row['price'];
            $sys->status = $row['sys_status'];
            $sys->qty = $row['qty'];
            array_push($result, $sys);
        }
        return $result;
    }
    function isSerialAvailable($serial){
        $str="SELECT count(*) FROM inventory_track as t1 left join systems as t2 on t1.systems_id=t2.id WHERE t1.serial='$serial' AND t1.status<>'0' AND t2.type='I';";
        $result= dbQuery($str);
        $row= dbFetchArray($result);
        if($row[0]==0){
            $str="SELECT count(*) FROM customer_systems as t1 left join systems as t2 on t1.systems_id=t2.id WHERE t1.serial='$serial' AND t1.status<>'0' AND t2.type='I';";
            $result= dbQuery($str);
            $row= dbFetchArray($result);
            if($row[0]==0){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }
    }
    function getItemHistoryFromGRN($serial="", $partcode="") {
        $result = array();
        if($serial!=""){
            $str="SELECT t1.*,t2.GRN,t2.Date,t3.name as customer_name FROM inventory_track as t1 left join grn as t2 on t1.reference_id=t2.id "
                    . "left join customer_entity as t3 on t1.customer_entity_id_to=t3.id WHERE t1.serial='$serial' AND t1.reference_to='GRN';";
            //print $str;
            $res = dbQuery($str);
            while ($row = dbFetchAssoc($res)) {
                $inv_item=new inventory_track_item($row['id']);
                $inv_item->reference_id=$row['reference_id'];
                $inv_item->referene_ref=$row['GRN'];
                $inv_item->date=$row['Date'];
                $inv_item->customer_name_to=$row['customer_name'];
                $inv_item->qty=$row['qty'];
                $inv_item->status=$row['status'];
                array_push($result, $inv_item);
            }
        }
        return $result;
    }
    
    function getGRNforFT($ft_id,$status="") {
        if($status!=""){
            $where_str="AND status='".$status."'";
        }
        else{
            $where_str="";
        }
        $result = array();
//        $str="SELECT t1.*,t1.id as sys_id,t1.status as sys_status,t2.*,t3.name as customer_entity_name FROM customer_systems as t1 left join systems as t2 on t1.systems_id=t2.id left join customer_entity as t3 on t1.customer_entity_id=t3.id WHERE t1.grn_id='$id' and t1.serial='$serial' ORDER BY t1.id;";	
        $str = "SELECT * FROM grn WHERE  fault_ticket_id='$ft_id' and status<>0 $where_str ORDER BY id;";
//        print $str;
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)) {
            $grn = new grn($row['id']);
            $grn->ref_no = $row['GRN'];
            $grn->shipment_id = $row['ShipmentID'];
            $grn->vendor_id = $row['vendor_id'];
            $grn->status_id = $row['status'];
            $grn->date_added = $row['Date'];
            array_push($result, $grn);
        }
        return $result;
    }

}

?>