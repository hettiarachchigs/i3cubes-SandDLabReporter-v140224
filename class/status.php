<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of status
 *
 * @author Sudaraka Ranasinghe
 */
include_once 'database.php';

class status {

    public $id;
    public $status;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getStatus() {

        $quer = "SELECT * FROM status WHERE id='$this->id'";
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
//            $this->id = $row['id'];
            $this->status = $row['status'];

            return true;
        } else {
            return false;
        }
    }

    public function updateStatus($id, $status) {
        $str = "UPDATE status SET status='" . trim($status) . "' WHERE id='$id';";
        $res = dbQuery($str);

        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function addStatus() {
        //if needed
    }

}
