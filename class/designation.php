<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of designation
 *
 * @author Sudaraka Ranasinghe
 */
include_once './database.php';

class designation {

    public $id, $designation, $departmentID, $status;
    private $dataLoded = false;

    public function __construct($id) {
        $this->id = $id;
    }

    function getDefaultDesignation() {
        //return defult designation id
        return 1;
    }

    function getADesignation() {

        $str = "SELECT * FROM designation id='$this->id'";
        $result = dbQuery($str);
        if ($row = dbFetchAssoc($result)) {
            $this->id = $row['id'];
            $this->designation = $row['designation'];
            $this->departmentID = $row['department_id'];
            $this->status = $row['status_id'];
        }
    }

    function addDesignation($designation, $departmentID, $status) {

        $designation = getStringFormatted($designation);
        $departmentID = getStringFormatted($departmentID);


        $quer = "Insert into designation "
                . "(designation,department_id,status_id)"
                . " values (" . $designation . "," . $departmentID . "," . constants::$Active_STE . ")";

        $result = dbQuery($quer);
        if ($result) {
            dbInsertId(); //get last insertid 
        } else {
            return(false);
        }
    }

    function editDesignation($designation, $departmentID, $status) {

        $designation = getStringFormatted($designation);
        $departmentID = getStringFormatted($departmentID);

        $quer = "UPDATE  designation set "
                . "designation='$designation',department_id='$departmentID',status_id='$status' where id='$this->id'";

        $result = dbQuery($quer);
        if ($result) {
            return(true);
        } else {
            return(false);
        }
    }

    public function deleteDesignation() {
        $str = "UPDATE designation set status_id='" . constants::$Deleted_STE . "' where id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

}
