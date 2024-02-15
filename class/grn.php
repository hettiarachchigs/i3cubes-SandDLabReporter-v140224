<?php

include_once 'database.php';
include_once 'cls_system.php';
include_once 'cls_stock_manager.php';
include_once 'cls_log.php';
include_once 'cls_inventory_item.php';
class grn {

    public $id, $ref_no, $date_added, $shipment_id, $vendor_id, $vendor_name, $status_id, $status_name, $effective_date, $emp_added,$emp_added_name;
    public $note,$customer_entity_id,$customer_name,$fault_ticket_id,$fault_ticket_ref;

    function __construct($id = '') {
        $this->id = $id;
    }

    function addGRN() {
        $grn_no = $this->getNextGRNNumber();
        $grn_no_str = getStringFormatted($grn_no);
        $shipment_id = getStringFormatted($this->shipment_id);
        $supplier = getStringFormatted($this->vendor_id);
        $eff_date = getStringFormatted($this->effective_date);
        $emp_added = getStringFormatted($this->emp_added);
        $note = getStringFormatted($this->note);
        $ft_id= getStringFormatted($this->fault_ticket_id);
        $customer_entity_id= getStringFormatted($this->customer_entity_id);
        $str = "INSERT INTO grn (GRN,ShipmentID,Date,vendor_id,status,Date_effective,employee_id_added,note,customer_entity_id,fault_ticket_id) VALUES($grn_no_str,$shipment_id,NOW(),$supplier,'1',$eff_date,$emp_added,$note,$customer_entity_id,$ft_id);";
        $res = dbQuery($str);
        if ($res) {
            $this->id = dbInsertId();
            $this->ref_no = $grn_no;
            return true;
        } else {

            return(false);
        }
    }

    function editGRN() {
        $shipment_id = getStringFormatted($this->shipment_id);
        $supplier = getStringFormatted($this->vendor_id);
        $eff_date = getStringFormatted($this->effective_date);
        $note = getStringFormatted($this->note);
        $customer_entity_id= getStringFormatted($this->customer_entity_id);
        $str = "UPDATE grn SET ShipmentID=$shipment_id,vendor_id=$supplier,Date_effective=$eff_date,note=$note,customer_entity_id=$customer_entity_id WHERE id='$this->id';";
//        print $str;
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {

            return(false);
        }
    }

    function deleteGRN() {
        $str = "UPDATE grn set status='0' WHERE id='$this->id';";
        //print$str;
        $res = dbQuery($str);
        if($res){
            $log=new log();
            $log_str="deleted GRN [GRN#".$this->id."|CUS_SYS#".$this->customer_name."]";
            $log->setLog($_SESSION['UID'], "GRN", $this->id, $log_str);
        }
        return $res;
    }

    function confirmGRN() {
         $note = getStringFormatted($this->note);
         $this->getGRN();
         if($this->status_id=='1'){
            if ($this->confirmAllItems()) {
                $str = "UPDATE grn set note=$note,status='2' WHERE id='$this->id';";
                //print$str;
                $res = dbQuery($str);
                return $res;
            } else {
                return false;
            }
        }
        else{
            return false;
        }
    }

    function getGRN() {
        $result = array();
        $str = "SELECT t1.*,t2.name,t3.name as customer_name,t4.ref_no as fault_ticket_ref,t5.name as employee_added_name FROM grn as t1 left join vendor as t2 on t1.vendor_id=t2.id "
                . "left join customer_entity as t3 on t1.customer_entity_id=t3.id left join fault_ticket as t4 "
                . "on t1.fault_ticket_id=t4.id left join employee as t5 on t1.employee_id_added=t5.id WHERE t1.id='$this->id';";
        //print $str;
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        $this->id = $row['id'];
        $this->ref_no = $row['GRN'];
        $this->shipment_id = $row['ShipmentID'];
        $this->date_added = $row['Date'];
        $this->vendor_id = $row['vendor_id'];
        $this->vendor_name = $row['name'];
        $this->status_id = $row['status'];
        $this->effective_date = $row['Date_effective'];
        $this->emp_added = $row['employee_id_added'];
        $this->emp_added_name=$row['employee_added_name'];
        $this->customer_entity_id=$row['customer_entity_id'];
        $this->customer_name=$row['customer_name'];
        $this->fault_ticket_id=$row['fault_ticket_id'];
        $this->fault_ticket_ref=$row['fault_ticket_ref'];
        $this->note = $row['note'];
    }

    function getGRNData($grn_number) {
        $str = "SELECT * FROM grn WHERE GRN='$grn_number';";
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        return $row;
    }

    function getGRNDataFromID($grn_id) {
        $str = "SELECT * FROM grn WHERE id='$grn_id';";
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        return $row;
    }

    function getNextGRNNumber() {
        $str = "SELECT MAX(id) FROM grn;";
        $res = dbQuery($str);
        if (!dbNumRows($res) == 0) {
            $row = dbFetchArray($res);
            $str = "SELECT GRN FROM grn WHERE id='$row[0]';";
            //print $str;
            $res = dbQuery($str);
            if (!dbNumRows($res) == 0) {
                $row = dbFetchArray($res);
                if (substr($row[0], 1, 4) == date('Y')) {
                    $ref = substr($row[0], 6);
                    $ref_id = $ref + 1;
                } else {
                    $ref_id = 1;
                }
            } else {
                $ref_id = 1;
            }
        } else {
            $ref_id = 1;
        }
        $ref_id_str = "000" . $ref_id;
        $ref_no = "G" . date('Y') . "-" . substr($ref_id_str, -4);
        return $ref_no;
    }

    function addGRNItem($grn_id, $sys_id, $serial, $optional_text, $cus_id, $venror_warr, $price, $qty) {
        $grn_id = getStringFormatted($grn_id);
        $serial = getStringFormatted($serial);
        $optional_text = getStringFormatted($optional_text);
        $cus_id = getStringFormatted($cus_id);
        $price = getStringFormatted($price);
        $venror_warr= getStringFormatted($venror_warr);
        $qty = getStringFormatted($qty);

        $str = "INSERT INTO inventory_track(transaction_type,reference_to,reference_id,serial,qty,status,customer_entity_id_to,systems_id,note,cost,warranty_period,date_created) VALUES 
            ('GRN','GRN',$grn_id,$serial,$qty,'1',$cus_id,$sys_id,$optional_text,$price,$venror_warr,NOW());";
//            print $str;
        $res = dbQuery($str);
        $inv_id = dbInsertId();
        if ($res) {
            return $inv_id;
        } else {

            return(false);
        }
    }

    function deleteGRNItem($item_id) {
        $str = "DELETE FROM inventory_track WHERE id='$item_id';";
        //print$str;
        $res = dbQuery($str);
        return $res;
    }

    function deleteGRNItems() {
        $str = "DELETE FROM inventory_track WHERE reference_id='$this->id' AND reference_to='GRN';";
        $res = dbQuery($str);
        if($res){
            $log=new log();
            $log_str="deleted all grn items[GRN#".$this->id."|CUS_SYS#".$this->customer_name."]";
            $log->setLog($_SESSION['UID'], "GRN", $this->id, $log_str);
        }
        return $res;
    }

    function getGRNItemData($inv_id) {
        $item=new inventory_track_item($inv_id);
        $item->getData();
        return $item;
    }

    function getGRNItems() {
        $result = array();
        $str="SELECT t1.*,t2.description as sys_name,t2.type as sys_type,t2.product_code as code FROM inventory_track as t1 left join systems as t2 on t1.systems_id=t2.id  WHERE t1.reference_id='$this->id' AND t1.reference_to='GRN';";
        //print $str;
        $res = dbQuery($str);
        while ($row= dbFetchAssoc($res)){
            $item=new inventory_track_item($row['id']);
            $item->systems_id=$row['systems_id'];
            $item->transaction_type=$row['transaction_type'];
            $item->refrence_to=$row['reference_to'];
            $item->reference_id=$row['reference_id'];
            $item->serial=$row['serial'];
            $item->qty=$row['qty'];
            $item->status=$row['status'];
            $item->unit_id=$row['units_id'];
            $item->customer_entity_id_from=$row['customer_entity_id_from'];
            $item->customer_entity_id_to=$row['customer_entity_id_to'];
            $item->note=$row['note'];
            $item->cost=$row['cost'];
            $item->warranty_period=$row['warranty_period'];
            $item->system_name=$row['sys_name'];
            $item->system_type=$row['sys_type'];
            $item->system_code=$row['code'];
            array_push($result, $item);
        }
        return $result;
    }

    public function confirmAllItems() {
        if($this->customer_entity_id==""){
            $cus_ent_id= '874';
        }
        else{
            $cus_ent_id= $this->customer_entity_id;
        }
        $stock_manager=new stock_manager();
        $inv_item = new \inventory_track_item();
        $log=new log();
        $ary_items = $this->getGRNItems();
        foreach ($ary_items as $inv_item) {
            if($inv_item->status=='1'){
                //var_dump($inv_item);
                //Add item to customer systems if it is inventory item
                if($inv_item->system_type=='I'){
                    //add cus system
                    $cus_sys=new system();
                    $cus_sys->refno=$inv_item->system_code;
                    $cus_sys->serial=$inv_item->serial;
                    $cus_sys->optionalText=$inv_item->note;
                    $cus_sys->status='1';
                    $cus_sys->customerID=$inv_item->customer_entity_id_to;
                    $cus_sys->system_id=$inv_item->systems_id;
                    $cus_sys->grn_id= $this->id;

                    $cus_sys->qty=$inv_item->qty;
                    //Waranty
                    $effctfate = $this->effective_date;
                    if ($inv_item->warranty_period != "") {
                        if ($effctfate == "") {
                            $v_warr_end = date('Y-m-d', strtotime("+" . trim($inv_item->warranty_period) . " months", strtotime(date("Y-m-d"))));
                        } else {
                            $v_warr_end = date('Y-m-d', strtotime("+" . trim($inv_item->warranty_period) . " months", strtotime($effctfate)));
                        }
                    }
                    $cus_sys->v_warr_end=$v_warr_end;
                    $res_id=$cus_sys->save();
                    if($res_id){
                        $log_str="moved item to customer_systems[ST_TRK_ID:".$inv_item->id."|".$inv_item->system_code."|".$inv_item->serial."|CUS_SYS_ID#".$res_id."]";
                    }
                    else{
                        $log_str="NOT moved item to customer_systems[ST_TRK_ID:".$inv_item->id."|".$inv_item->system_code."|".$inv_item->serial."]";
                    }
                    $log->setLog($_SESSION['UID'], "GRN", $this->id, $log_str);
                }
                else{
                    //update stock only
                    $log_str="NOT moved item to customer_systems Type=C [ST_TRK_ID:".$inv_item->id."|".$inv_item->system_code."|".$inv_item->serial."]";
                    $log->setLog($_SESSION['UID'], "GRN", $this->id, $log_str);
                }
                $inv_item->setItemStatus(constants::$SYS_ACTIVE);
                //$item->assignCustomer($cus_ent_id);
                //Update Stock
                $res=$stock_manager->addStock($cus_ent_id, $inv_item->systems_id, $inv_item->qty);
                if($res){
                    $log_str="stock updated + [CUS.ENT#".$cus_ent_id."|".$inv_item->system_code."] [GRN#=".$this->id." | Qty=".$inv_item->qty."]";
                }
                else{
                    $log_str="stock NOT updated + [CUS.ENT#".$cus_ent_id."|".$inv_item->system_code."] [GRN#=".$this->id." | Qty=".$inv_item->qty."]";    
                }
                $log->setLog($_SESSION['UID'], "GRN", $this->id, $log_str);
            }
        }
        return true;
    }
    
    function updateWarrantyandCost($warranty,$cost,$id){
        $warranty= getStringFormatted($warranty);
        $cost= getStringFormatted($cost);
        $str = "UPDATE inventory_track set warranty_period=$warranty,cost=$cost where id ='$id' ";
        $res = dbQuery($str);
        if($res){
            return true;
        }else {
            return false;
        }
    }
    function changeLocation($from_location, $to_location) {

        if ($this->changeGrnLocation($from_location, $to_location)) {
            $ary_items = $this->getGRNItems();
            foreach ($ary_items as $inv_item) {
                if ($inv_item->status == '1') {
                    $inventory_item = new inventory_track_item($inv_item->id);
                    $inventory_item->changeInventoryItemLocation($from_location, $to_location, $id);
                    /*if($this->changeGrnItemLocation($from_location, $to_location, )){
                        
                    }else {
                        //return false;
                    }*/
                    
                    //$log->setLog($_SESSION['UID'], "GRN", $this->id, $log_str);
                }
            }
            return true;
        } else {
            return false;
        }
    }

 

    function changeGrnLocation($from_location, $to_location) {
        $str = "UPDATE grn SET customer_entity_id ='$to_location' WHERE id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            $log=new log();
            $log_str = "Location Updated GRN ID : $this->id  OLD: $from_location NEW : $to_location";
            $log->setLog($_SESSION['UID'], "GRN", $this->id, $log_str);
            return true;
        } else {
            return false;
        }
    }

}

?>