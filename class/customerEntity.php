<?php

include_once 'database.php';
include_once 'item.php';
include_once 'constants.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customerEntity
 *
 * @author Administrator
 */
class customerEntity {

    //put your code here
    public $id, $teamID, $accOwnerID, $cluster, $clusterName, $district_id;
    public $name, $code, $address, $status, $contactName, $contactNumber, $contactEmail, $note, $accOwnerName, $teamName;
    public $category, $parent_id, $type, $type_txt;
    public $customer_system_id, $customer_system_refno, $customer_system_serial, $customer_system_status, $customer_system_cus_entity_id, $vendor_id,$br_site_id;
    public $lat,$lon;
    function __construct($id = '') {
        $this->id = $id;
    }

    function getCustomerSystem($id) {
        $quer = "SELECT * from customer_systems where id=" . $id . " ";
        //print $quer;
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            $this->customer_system_id = $row['id'];
            $this->customer_system_refno = $row['ref_no'];
            $this->customer_system_serial = $row['serial'];
            $this->customer_system_status = $row['status'];
            $this->customer_system_cus_entity_id = $row['customer_entity_id'];
            return true;
        } else {
            return false;
        }
    }

    function getVendorid($vendorid) {
        $quer = "SELECT * from customer_entity where vendor_id=" . $vendorid . " ";
        //print $quer;
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
        }
    }

    function getData() {
        $quer = "SELECT t1.*,t2.name as team_name,t3.name as acc_owner_name,t4.cluster as cluster_name FROM customer_entity as t1 left join "
                . "team as t2 on t1.team_id=t2.id left join employee as t3 on t1.account_owner=t3.id"
                . " left join customer_cluster as t4 on t1.cluster=t4.id where t1.id='$this->id'";
        //print $quer;
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->address = $row['address'];
            $this->code = $row['code'];
            $this->contactName = $row['contact_name'];
            $this->contactNumber = $row['contact_number'];
            $this->contactEmail = $row['contact_email'];
            $this->note = $row['note'];
            $this->accOwnerID = $row['acc_owner_id'];
            $this->accOwnerName = $row['acc_owner_name'];
            $this->teamID = $row['team_id'];
            $this->teamName = $row['team_name'];
            $this->status = $row['status_id'];
            $this->cluster = $row['cluster'];
            $this->clusterName = $row['cluster_name'];
            $this->category = $row['category'];
            $this->parent_id = $row['parent_id'];
            $this->type = $row['cus_type'];
            $this->district_id = $row['district_id'];
            $this->vendor_id = $row['vendor_id'];
            $this->br_site_id = $row['br_site_id'];
            $this->lat = $row['lat'];
            $this->lon = $row['lon'];
            if (trim($row['cus_type']) == 'D') {
                $this->type_txt = "Data";
            } else if (trim($row['cus_type']) == 'V') {
                $this->type_txt = "Voice";
            }
            //print "XXXX".$this->name;
            return true;
        } else {
            return false;
        }
    }

    function add($name, $address, $code, $contact_name, $mobile, $email, $note, $acc_owner_id, $gourpID, $cat, $parent, $cluster, $type, $district,$vendroid,$br_site_id="") {
        $name = getStringFormatted($name);
        $address = getStringFormatted($address);
        $code = getStringFormatted($code);
        $contact_name = getStringFormatted($contact_name);
        $mobile = getStringFormatted($mobile);
        $email = getStringFormatted($email);
        $note = getStringFormatted($note);
        $acc_owner_id = getStringFormatted($acc_owner_id);
        $gourpID = getStringFormatted($gourpID);
        $parent = getStringFormatted($parent);
        $cluster = getStringFormatted($cluster);
        $district = getStringFormatted($district);
        $vendroid = getStringFormatted($vendroid);
        $br_site_id = getStringFormatted($br_site_id);

        $type == "" ? $type = "V" : $type = $type;

        $type = getStringFormatted($type);

        $quer = "Insert into customer_entity "
                . "(name,address,code,contact_name,contact_number,contact_email,note,account_owner,team_id,status,category,parent_id,cluster,cus_type,district_id,vendor_id,br_site_id)"
                . " values (" . $name . "," . $address . "," . $code . "," . $contact_name . " ," . $mobile . ","
                . "" . $email . "," . $note . "," . $acc_owner_id . ", "
                . "" . $gourpID . "," . constants::$Active_STE . ",'$cat',$parent,$cluster,$type,$district,$vendroid,$br_site_id)";

        $result = dbQuery($quer);
        if ($result) {
            return dbInsertId(); //get last insertid 
        } else {
            return(false);
        }
    }

    function edit($name, $address, $code, $contactname, $mobile, $email, $note, $acc_owner_id, $gourpID, $cluster, $type, $district,$br_site_id="") {

        $name = getStringFormatted($name);
        $address = getStringFormatted($address);
        $code = getStringFormatted($code);
        $mobile = getStringFormatted($mobile);
        $email = getStringFormatted($email);
        $note = getStringFormatted($note);
        $contactname = getStringFormatted($contactname);
        $acc_owner_id = getStringFormatted($acc_owner_id);
        $gourpID = getStringFormatted($gourpID);
        $cluster = getStringFormatted($cluster);
        $district = getStringFormatted($district);
        $br_site_id = getStringFormatted($br_site_id);
        if ($type != '') {
            $type_str = "cus_type='$type',";
        }

        $str = "UPDATE customer_entity set  name=$name,address=$address,code=$code,"
                . "contact_name=$contactname,contact_number=$mobile,contact_email=$email,note=$note,"
                . "account_owner=$acc_owner_id,team_id=$gourpID,cluster=$cluster," . $type_str . "district_id=$district,br_site_id=$br_site_id where id='$this->id'";
        //print $str;
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function editVendorCus($name, $address, $contact, $note) {

        $name = getStringFormatted($name);
        $address = getStringFormatted($address);
        $contact = getStringFormatted($contact);
        $note = getStringFormatted($note);

        $str = "UPDATE customer_entity set  name=$name,address=$address,"
                . "contact_number=$contact,note=$note where id='$this->id'";
        //print $str;
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function delete() {
        $str = "UPDATE customer_entity set status='" . constants::$Deleted_STE . "' where id='$this->id'";
        //print $str;
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllSystems($type ="") {
        $ary_sql = array();
        if($type !=""){
            array_push($ary_sql,"t2.type = '$type'");
        }
        if(count($ary_sql)>0){
            $sql = " AND ".implode(" AND ", $ary_sql);
        }
        $ary_res = array();
        //$str = "SELECT t1.*,t2.description,t2.product_code,t2.type,t4.balance FROM customer_systems as t1 left join systems as t2 on t1.systems_id=t2.id "
            //    . "left join systems_stock as t4 on t1.systems_id=t4.systems_id WHERE t1.status<>'" . constants::$SYS_DELETED . "' AND t1.customer_entity_id='$this->id' and t4.customer_entity_id='$this->id' $sql;";
        //print $str;
        $str = "SELECT t1.*,t2.description,t2.product_code,t2.type FROM customer_systems as t1 left join systems as t2 on t1.systems_id=t2.id "
                . " WHERE t1.status<>'" . constants::$SYS_DELETED . "' AND t1.customer_entity_id='$this->id' $sql;";
        //print $str;
        $result = dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            $eq = new system($row['id']);
            $eq->refno = $row['ref_no'];
            $eq->serial = $row['serial'];
            $eq->capacity = $row['capacity'];
            $eq->customerID = $row['customer_entity_id'];
            $eq->optionalText = $row['optional_text'];
            //$eq->item=new item($row['systems_id']);
            $eq->contract_cover = $row['has_contract'];
            $eq->system_code = $row['product_code'];
            $eq->system_id = $row['systems_id'];
            $eq->system_name = $row['description'];
            $eq->system_type = $row['type'];
            $eq->qty = $row['qty'];
            $eq->status = $row['status'];
            $eq->opr_status = $row['opr_status'];
            $eq->v_warr_end = $row['vendor_warranty_end'];
            $eq->cus_warr_end = $row['customer_warranty_end'];
            $eq->user_name=$row['user_name'];
            $eq->user_contact=$row['user_contact_no'];
            $eq->user_email=$row['user_email'];
            $eq->make_str=$row['make_str'];
            $eq->model_str=$row['model_str'];
            array_push($ary_res, $eq);
            //print '<br>';
            //var_dump($eq);
        }
        //print_r($ary_res);
        return $ary_res;
    }

    public function getAllContractCoveredSystems() {
        $ary_res = array();
        $str = "SELECT t1.*,t2.name as team_name,t3.description as contract_category_txt FROM customer_systems as t1 left join team as t2 on t1.team_id=t2.id left join contract_category as t3 on t1.contract_category=t3.id"
                . " WHERE t1.status<>'" . constants::$Deleted_STE . "' AND t1.customer_entity_id='$this->id' AND has_contract='Y';";
        //print $str;
        $result = dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            $eq = new system($row['id']);
            $eq->refno = $row['ref_no'];
            $eq->serial = $row['serial'];
            $eq->capacity = $row['capacity'];
            $eq->teamID = $row['team_id'];
            $eq->teamName = $row['team_name'];
            $eq->customerID = $row['customer_entity_id'];
            $eq->optionalText = $row['optional_text'];
            $eq->item = new item($row['systems_id']);
            $eq->contract_cover = $row['has_contract'];
            $this->contract_cat = $row['contract_category'];
            $this->contract_cat_txt = $row['contract_category_txt'];
            array_push($ary_res, $eq);
        }
        //print_r($ary_res);
        return $ary_res;
    }

    public function getTeam() {
        $str = "SELECT team_id FROM customer_entity WHERE id='$this->id';";
        //print $str;
        $result = dbQuery($str);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            return $row['team_id'];
        } else {
            return false;
        }
    }

    public function getContractCoverage() {
        $ary_contract = array(array(), array()); //[0]=array of AMC, [1]=array of Warranty
        $str = "SELECT t1.*,t2.description as category_name FROM contract as t1 left join contract_category as t2 on t1.contract_category_id=t2.id WHERE t1.customer_id='$this->id' AND t1.end_date>=NOW() AND t1.status='" . constants::$Active_STE . "';";
        //print $str;
        $result = dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            if ($row['type_id'] == '1') {//AMC
                $amc = new amc($row['id']);
                $amc->endDate = $row['end_date'];
                $amc->startDate = $row['start_date'];
                $amc->categoryName = $row['category_name'];
                array_push($ary_contract[0], $amc);
            }
            if ($row['type_id'] == '2') {
                $war = new warranty($row['id']);
                $war->endDate = $row['end_date'];
                $war->startDate = $row['start_date'];
                array_push($ary_contract[1], $war);
            }
        }
        return $ary_contract;
    }

    public function getLastExpired() {
        $ary_contract = array(array(), array()); //[0]=array of AMC, [1]=array of Warranty
        $str = "SELECT t1.*,t2.description as category_name FROM contract as t1 left join contract_category as t2 on t1.contract_category_id=t2.id WHERE t1.customer_id='$this->id' AND t1.end_date<=NOW() ORDER By t1.end_date DESC LIMIT 1;";
        //print $str;
        $result = dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            if ($row['type_id'] == '1') {//AMC
                $amc = new amc($row['id']);
                $amc->endDate = $row['end_date'];
                $amc->startDate = $row['start_date'];
                $amc->categoryName = $row['category_name'];
                array_push($ary_contract[0], $amc);
            }
            if ($row['type_id'] == '2') {
                $war = new warranty($row['id']);
                $war->endDate = $row['end_date'];
                $war->startDate = $row['start_date'];
                array_push($ary_contract[1], $war);
            }
        }
        return $ary_contract;
    }

}
