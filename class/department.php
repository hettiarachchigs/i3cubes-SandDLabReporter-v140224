<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of department
 *
 * @author Sudaraka Ranasinghe
 */
include_once 'database.php';

class department {

    public $id, $name,$status;
    private $dataLoded = false;

    public function __construct($id) {
        $this->id = $id;
    }

    function getDefaultDepartment() {
        //return defult department id
        return 1;
    }

    function getADepartment() {

        $str = "SELECT * FROM department id='$this->id'";
        $result = dbQuery($str);
        if ($row = dbFetchAssoc($result)) {
            $this->name = $row['name'];
            $this->status = $row['status_id'];
        }
    }

    function addDepartment($name) {

        $name = getStringFormatted($name);

        $quer = "Insert into department "
                . "(name,status_id)"
                . " values (" . $name . "," . constants::$Active_STE . ")";

        $result = dbQuery($quer);
        if ($result) {
            dbInsertId(); //get last insertid 
        } else {
            return(false);
        }
    }

    function editDepartment($name, $status) {

        $name = getStringFormatted($name);

        $quer = "UPDATE  department set "
                . "name='$name',status_id='$status' where id='$this->id'";

        $result = dbQuery($quer);
        if ($result) {
            return(true);
        } else {
            return(false);
        }
    }

    public function deleteDepartment() {
        $str = "UPDATE department set status_id='" . constants::$Deleted_STE . "' where id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
