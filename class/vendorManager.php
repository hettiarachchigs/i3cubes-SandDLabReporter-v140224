<?php

include_once 'validation.php';
include_once 'constants.php';
include_once 'database.php';

class vendorManager {

    public function searchVendor($id, $name, $address, $contact, $note, $status) {

        $arry_where = array();
        $validation = new validation();
        $where = " where ";

        if (!$validation->isEmpty($id)) {
            array_push($arry_where, "id=" . $id . "");
        }
        if (!$validation->isEmpty($address)) {
            array_push($arry_where, "address like %" . $address . "%");
        }
        if (!$validation->isEmpty($code)) {
            array_push($arry_where, "name like %" . $name . "%");
        }
        if (!$validation->isEmpty($note)) {
            array_push($arry_where, "note like %" . $note . "%");
        }
        if (!$validation->isEmpty($contact)) {
            array_push($arry_where, "contact='$contact' ");
        }

        if (!$validation->isEmpty($status)) {
            array_push($arry_where, "status='$status' ");
        }
        if (count($arry_where) > 0) {
            $where .= implode(" AND ", $arry_where);
            $where.=" AND ";
        }

        $quer = "SELECT * FROM vendor " . $where . "   status<>'" . constants::$Deleted_STE . "';";
        $vendtarry = array();
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $vendor = new vendor();
            $vendor->id = $row['id'];
            $vendor->name = $row['name'];
            $vendor->address = $row['address'];
            $vendor->contact = $row['contact'];
            $vendor->note = $row['note'];
            $vendor->status = $row['status'];

            array_push($vendtarry, $vendor);
        }

        return $vendtarry;
    }

}

?>
