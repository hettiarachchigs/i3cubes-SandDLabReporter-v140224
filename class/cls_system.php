<?php

include_once 'item.php';
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
class system {

    public $id,$grn_id;
    public $serial, $optionalText, $refno, $capacity;
    public $customerName, $customerID, $status, $opr_status;
    public $system_id, $contract_cover, $system_name, $system_code, $system_type, $v_warr_end, $cus_warr_end, $price, $qty;
    public $item;
    public $user_name,$user_contact,$user_email,$make_str,$model_str;
    
    function __construct($id = '') {
        $this->id = $id;
    }

    public function getSystem() {
        $str = "SELECT t1.*,t2.name as Customer_entity_name,t3.description as system_name FROM customer_systems as t1 left join customer_entity as t2 on t1.customer_entity_id=t2.id "
                . "left join systems as t3 on t1.systems_id=t3.id WHERE t1.id='$this->id';";
        //print $str;
        $result = dbQuery($str);
        if ($row = dbFetchAssoc($result)) {
            $this->id = $row['id'];
            $this->refno = $row['ref_no'];
            $this->serial = $row['serial'];
            $this->capacity = $row['capacity'];
            $this->optionalText = $row['optional_text'];
            $this->item = new item($row['systems_id']);
            $this->system_id = $row['systems_id'];
            $this->contract_cover = $row['has_contract'];
            $this->customerID = $row['customer_entity_id'];
            $this->v_warr_end = $row['vendor_warranty_end'];
            $this->cus_warr_end = $row['customer_warranty_end'];
            $this->opr_status = $row['opr_status'];
            $this->price = $row['price'];
            $this->system_name=$row['system_name'];
            $this->user_name=$row['user_name'];
            $this->user_contact=$row['user_contact_no'];
            $this->user_email=$row['user_email'];
            $this->qty = $row['qty'];
            $this->make_str=$row['make_str'];
            $this->model_str=$row['model_str'];
        }
    }

    public function assignCustomer($cus_id) {
        $str = "UPDATE  customer_systems set customer_entity_id='$cus_id',status='1' WHERE id='$this->id';";
        //print $str;
        $result = dbQuery($str);
        if ($result) {
            return true; //get last insertid 
        } else {
            return(false);
        }
    }

    public function update() {
        if ($this->id != "") {
            $refno = getStringFormatted($this->refno);
            $serail = getStringFormatted($this->serial);
            $capacity = getStringFormatted($this->capacity);
            $optionalText = getStringFormatted($this->optionalText);
            $cus_ent_id = getStringFormatted($this->customerID);
            $qty = getStringFormattedNumber($this->qty);
            $v_warr_end = getStringFormatted($this->v_warr_end);
            $cus_warr_end = getStringFormatted($this->cus_warr_end);
            $opr_sts = getStringFormatted($this->opr_status);
            //$teamID = getStringFormatted($this->te);
            //$contract_cat = getStringFormatted($this->c);
            //$has_contract=='Y'?$has_contract='Y':$has_contract='N';
//            $quer = "UPDATE  customer_systems set "
//                    . "ref_no=$refno,serial=$serail,capacity=$capacity,optional_text=$optionalText"
//                    . ",vendor_warranty_end=$v_warr_end,customer_warranty_end=$cus_warr_end,qty=$qty,opr_status=$opr_sts"
//                    . " where id='$this->id';";
            $quer = "UPDATE  customer_systems set "
                    . "vendor_warranty_end=$v_warr_end,customer_warranty_end=$cus_warr_end,qty=$qty,opr_status=$opr_sts"
                    . " where id='$this->id';";

//            print $quer;
            $result = dbQuery($quer);
            if ($result) {
                return true; //get last insertid 
            } else {
                return(false);
            }
        }
    }

    public function save() {
        if ($this->system_id != "") {
            $refno = getStringFormatted($this->refno);
            $serail = getStringFormatted($this->serial);
            $capacity = getStringFormatted($this->capacity);
            $optionalText = getStringFormatted($this->optionalText);
            $system_id = getStringFormatted($this->system_id);
            $cus_ent_id = getStringFormatted($this->customerID);
            $ven_warranty_end = getStringFormatted($this->v_warr_end);
            $sts = getStringFormatted($this->status);
            $qty = getStringFormatted($this->qty);
            $grn_id= getStringFormatted($this->grn_id);
            $user_name=getStringFormatted($this->user_name);
            $user_cont=getStringFormatted($this->user_contact);
            $user_email=getStringFormatted($this->user_email);
            $make_str= getStringFormatted($this->make_str);
            $model_str= getStringFormatted($this->model_str);
            //$teamID = getStringFormatted($teamID);
            //$has_contract=='Y'?$has_contract='Y':$has_contract='N';
            //$cont_cat = getStringFormatted($cont_cat);

            $quer = "Insert into customer_systems "
                    . "(ref_no,serial,capacity,optional_text,customer_entity_id,status,systems_id,vendor_warranty_end,qty,grn_id,user_name,user_contact_no,user_email,make_str,model_str)"
                    . " values ($refno,$serail,$capacity ,$optionalText,$cus_ent_id,$sts,$system_id,$ven_warranty_end,$qty,$grn_id,$user_name,$user_cont,$user_email,$make_str,$model_str);";

            $result = dbQuery($quer);
            if ($result) {
                $this->id = dbInsertId;
                return dbInsertId(); //get last insertid
            } else {
                return(false);
            }
        }
    }

    public function addSystem($refno, $serail, $capacity, $optionalText, $system_id, $cus_ent_id, $teamID, $has_contract, $cont_cat) {
        $refno = getStringFormatted($refno);
        $serail = getStringFormatted($serail);
        $capacity = getStringFormatted($capacity);
        $optionalText = getStringFormatted($optionalText);
        $system_id = getStringFormatted($system_id);
        $cus_ent_id = getStringFormatted($cus_ent_id);
        $teamID = getStringFormatted($teamID);
        $has_contract == 'Y' ? $has_contract = 'Y' : $has_contract = 'N';
        $cont_cat = getStringFormatted($cont_cat);

        $quer = "Insert into customer_systems "
                . "(ref_no,serial,capacity,optional_text,customer_entity_id,status,systems_id,has_contract)"
                . " values ($refno,$serail,$capacity ,$optionalText,$cus_ent_id,"
                . constants::$Active_STE . ",$system_id,'$has_contract');";

        $result = dbQuery($quer);
        if ($result) {
            return dbInsertId(); //get last insertid 
        } else {
            return(false);
        }
    }

    public function edit($refno, $serail, $capacity, $optionalText, $system_id, $teamID, $has_contract, $contract_cat) {
        $refno = getStringFormatted($refno);
        $serail = getStringFormatted($serail);
        $capacity = getStringFormatted($capacity);
        $optionalText = getStringFormatted($optionalText);
        $cus_ent_id = getStringFormatted($cus_ent_id);
        $teamID = getStringFormatted($teamID);
        $contract_cat = getStringFormatted($contract_cat);
        $has_contract == 'Y' ? $has_contract = 'Y' : $has_contract = 'N';

        $quer = "UPDATE  customer_systems set "
                . "ref_no=$refno,serial=$serail,capacity=$capacity,optional_text=$optionalText,"
                . "systems_id=$system_id,team_id=$teamID,has_contract='$has_contract',contract_category=$contract_cat where id='$this->id'"
                . " ";
        //print $quer;
        $result = dbQuery($quer);
        if ($result) {
            return true; //get last insertid 
        } else {
            return(false);
        }
    }

    public function deleteSystem() {
        $str = "UPDATE customer_systems set status='" . constants::$SYS_DELETED . "' where id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function setStatus($s) {
        $str = "UPDATE customer_systems set status='" . $s . "' where id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function addSystemLog($from,$to,$note,$ref){
        $note= getStringFormatted($note);
        $ref= getStringFormatted($ref);
        $str="INSERT INTO customer_systems_log (note,reference,customer_systems_id,customer_entity_id_from,customer_entity_id_to,date)"
                . "VALUES($note,$ref,'$this->id','$from','$to',NOW());";
        //print $str;
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }
    public function getSystemLogs(){
        $str="SELECT t1.id,t1.date,t2.name as location_from,t3.name as location_to,t1.note,t1.reference FROM customer_systems_log as t1 left join customer_entity as t2 on t1.customer_entity_id_from=t2.id "
                . "left join customer_entity as t3 on t1.customer_entity_id_to=t3.id WHERE t1.customer_systems_id='$this->id';";
        $result= dbQuery($str);
        $ary_res=array();
        while ($row= dbFetchAssoc($result)){
            array_push($ary_res, $row);
        }
        return $ary_res;
    }
    public Function getNextAssetCode($cus_code,$br_code){
        //print $this->system_code."|".$cus_code."|".$br_code;
        if($this->system_code!=""){
            $str="SELECT ref_no FROM customer_systems as t1 left join systems as t2 on t1.systems_id=t2.id where t2.code='$this->system_code' and t1.ref_no IS NOT NULL ORDER BY t1.id DESC LIMIT 1;";
            print $str;
            $res = dbQuery($str);
            if(dbNumRows($result)==1){
                $row = dbFetchArray($result);
                $ary_ref= preg_split("/\/", $row[0]);
                $id= end($ary_ref)+1;
            }
            else{
                $id=1;
            }
            $ref_id_str = "0000" . $id;
            if($br_code==""){
                $ref_no = $cus_code."/".$this->system_code."/" . substr($ref_id_str, -5);
            }
            else{
                $ref_no = $cus_code."/".$br_code. "/".$this->system_code."/" . substr($ref_id_str, -5);
            }
            
            return $ref_no;
        }
        else{
            return null;
        }
    }
}
