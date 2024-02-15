<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customerManager
 *
 * @author Sudaraka Ranasinghe
 * 
 */
include_once 'validation.php';
include_once 'constants.php';
include_once 'database.php';

class customerManager {

    public function getAllCustomers($type="V") {
        $custarry = array();
        $quer = "SELECT t1.*,t2.name as team_name FROM customer_entity as t1 left join team as t2 on t1.team_id=t2.id where t1.category='CUS' AND t1.cus_type='$type' AND t1.status<>'" . constants::$Deleted_STE . "';";
        //print $quer;
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $customer = new customer();
            $customer->id = $row['id'];
            $customer->name = $row['name'];
            $customer->address = $row['address'];
            $customer->code = $row['code'];
            $customer->contactName = $row['contact_name'];
            $customer->contactNumber = $row['contact_number'];
            $customer->contactEmail = $row['contact_email'];
            $customer->note = $row['note'];
            $customer->accOwnerID = $row['acc_owner_id'];
            $customer->teamID = $row['team_id'];
            $customer->teamName = $row['team_name'];
            $customer->status = $row['status_id'];
            $customer->type = $row['cus_type'];
            if (trim($row['cus_type']) == 'D') {
                $customer->type_txt = "Data";
            } else if (trim($row['cus_type']) == 'V') {
                $customer->type_txt = "Voice";
            }

            array_push($custarry, $customer);
        }

        return $custarry;
    }

    public function searchCustomerdetail($customerName, $code, $address, $accownerID, $groupID, $status, $note) {

        $arry_where = array();
        $validation = new validation();
        $where = "";

        if (!$validation->isEmpty($customerName)) {
            array_push($arry_where, "name like %" . $customerName . "%");
        }
        if (!$validation->isEmpty($address)) {
            array_push($arry_where, "address like %" . $address . "%");
        }
        if (!$validation->isEmpty($code)) {
            array_push($arry_where, "code like %" . $code . "%");
        }
        if (!$validation->isEmpty($note)) {
            array_push($arry_where, "note like %" . $note . "%");
        }
        if (!$validation->isEmpty($accownerID)) {
            array_push($arry_where, "acc_owner_id='$accownerID' ");
        }
        if (!$validation->isEmpty($groupID)) {
            array_push($arry_where, "group_id='$groupID' ");
        }
        if (!$validation->isEmpty($status)) {
            array_push($arry_where, "status_id='$status' ");
        }
        if (count($arry_where) > 0) {
            $where = implode(" AND ", $arry_where);
        }

        $quer = "SELECT * FROM customer_entity" . $where . " AND category='CUS' AND status_id<>'" . constants::$Deleted_STE . "';";
        $custarry = array();
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $customer = new customer();
            $customer->id = $row['id'];
            $customer->name = $row['cus_type'] . "-" . $row['name'];
            $customer->address = $row['address'];
            $customer->code = $row['code'];
            $customer->contact = $row['contact'];
            $customer->mobile = $row['mobile'];
            $customer->email = $row['email'];
            $customer->note = $row['note'];
            $customer->contactName = $row['contactname'];
            $customer->accOwnerID = $row['acc_owner_id'];
            $customer->groupID = $row['group_id'];
            $customer->status = $row['status_id'];
            $customer->type = $row['cus_type'];
            if (trim($row['cus_type']) == 'D') {
                $customer->type_txt = "Data";
            } else if (trim($row['cus_type']) == 'V') {
                $customer->type_txt = "Voice";
            }

            array_push($custarry, $customer);
        }

        return $custarry;
    }

    function getCustomerByCode($code) {
        $quer = "SELECT * FROM customer_entity WHERE category='CUS' AND status<>'" . constants::$Deleted_STE . "' AND code='" . $code . "';";
        $custarry = array();
        $result = dbQuery($quer);
        if (dbNumRows($result) != 0) {
            $row = dbFetchAssoc($result);
            $customer = new customer();
            $customer->id = $row['id'];
            $customer->name = $row['cus_type'] . "-" . $row['name'];
            $customer->address = $row['address'];
            $customer->code = $row['code'];
            $customer->contact = $row['contact'];
            $customer->mobile = $row['mobile'];
            $customer->email = $row['email'];
            $customer->note = $row['note'];
            $customer->contactName = $row['contactname'];
            $customer->accOwnerID = $row['acc_owner_id'];
            $customer->groupID = $row['group_id'];
            $customer->status = $row['status_id'];
            $customer->type = $row['cus_type'];
            if (trim($row['cus_type']) == 'D') {
                $customer->type_txt = "Data";
            } else if (trim($row['cus_type']) == 'V') {
                $customer->type_txt = "Voice";
            }
            return $customer;
        } else {
            return null;
        }
    }

    public function searchCustomersystems($id, $typetext, $customer_entity_id, $status) {

        $arry_where = array();
        $validation = new validation();
        //$where = " where ";


        if (!$validation->isEmpty($id)) {
            array_push($arry_where, " id=" . $id . " ");
        }

        if (!$validation->isEmpty($customer_entity_id)) {
            array_push($arry_where, " customer_entity_id=" . $customer_entity_id . " ");
        }
        if (!$validation->isEmpty($status)) {
            array_push($arry_where, " status=" . $status . " ");
        }

        if (!$validation->isEmpty($typetext)) {
            array_push($arry_where, " (serial like '%" . $typetext . "%'  or ref_no like '%" . $typetext . "%') ");
        }
//        if (!$validation->isEmpty($refno)) {
//            array_push($arry_where, " ref_no like %" . $refno . "%");
//        }


        if (count($arry_where) > 0) {
            $where = " WHERE ". implode(" AND ", $arry_where);
            $where .= " LIMIT 100";
        }else {
            $where = " LIMIT 100";
        }

        $quer = "SELECT * FROM customer_systems " . $where . "";
        //echo $quer;

        $custarry = array();
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $customer = new customer();
            $customer->customer_system_id = $row['id'];
            $customer->customer_system_refno = $row['ref_no'];
            $customer->customer_system_serial = $row['serial'];
            $customer->customer_system_status = $row['status'];
            $customer->customer_system_cus_entity_id = $row['customer_entity_id'];
            array_push($custarry, $customer);
        }

        return $custarry;
    }
     function getAllStores ($loc_id){
         $ary_sql = array();
         if($loc_id !=""){
             if (is_array($loc_id)) {
                $location_ids = implode(",", $loc_id);
                array_push($ary_sql, "id IN ($location_ids) ");
            } else {
             array_push($ary_sql, "id='$loc_id'");
            }
         }
         if(count($ary_sql)>0){
             $AND = " AND ".implode(" AND ", $ary_sql);
         }
         $results = array();
         $str = "SELECT * FROM customer_entity WHERE cus_type='S' AND category='CUS' $AND";
         $res = dbQuery($str);
         while ($row = dbFetchAssoc($res)){
             array_push($results, $row);
         }
         return $results;
     }

}
