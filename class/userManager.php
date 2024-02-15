<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of userManager
 *
 * @author Sudaraka Ranasinghe
 */
include_once 'employee.php';
class userManager {

    public function changePassword($id, $ps, $status) {
        $user = new user($id);
        $res = $user->changePassword($ps, $status);
        return $res;
    }

    public function getAllUsers() {
        $usarray = array();
        $quer = "SELECT * FROM usr";
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $user = new user();
            $user->id = $row['id'];
            $user->userName = $row['user_name'];
            $user->employeeID = $row['employee_id'];
            $user->dateCreated = $row['date_create'];
            $user->dateLastLogin = $row['date_last_login'];
            $user->status = $row['status'];
            $emp = new employee($row['employee_id']);
            $emp->getEmployee();
            //print_r($emp);
            $tmp_obj = new stdClass();
            $tmp_obj->emp_name = $emp->name;
            $tmp_obj->lat = $emp->lat;
            $tmp_obj->lon = $emp->lon;
            $user->emp_obj = $tmp_obj;
            array_push($usarray, $user);
        }

        return $usarray;
    }
    
    //-------------------------------------------------------K
    public function searchUserdetail($AddtionalQuery = '', $from, $to, $username, $dateCreate, $dateLastLogin, $empID, $status) {

        $arry_where = array();
        $validation = new validation();
        $where = "";

        if (!$validation->isEmpty($username)) {
            array_push($arry_where, "user_name like %" . $username . "%");
        }
        if (!$validation->isEmpty($dateCreate)) {
            if (!$validation->isEmpty($from)) {
                if ($validation->isEmpty($to)) {
                    $to = date('Y-m-d');
                }
                array_push($arry_where, "date_create BETWEEN '$from 00:00:00' AND '$to 23:59:59'");
            }
        }
        if (!$validation->isEmpty($dateLastLogin)) {
            if (!$validation->isEmpty($from)) {
                if ($validation->isEmpty($to)) {
                    $to = date('Y-m-d');
                }
                array_push($arry_where, "date_last_login BETWEEN '$from 00:00:00' AND '$to 23:59:59'");
            }
        }
        if (!$validation->isEmpty($empID)) {
            array_push($arry_where, "employee_id=" . $empID . "");
        }

        if (!$validation->isEmpty($status)) {
            array_push($arry_where, "status_id='$status' ");
        }

        if (count($arry_where) > 0) {
            $where = implode(" AND ", $arry_where);

            if (!$validation->isEmpty($AddtionalQuery)) {  // concat if need order by
                $where . " " . $AddtionalQuery;
            }
        }

        $usarray = array();
        $quer = "SELECT * FROM user " . $where;
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $user = new user();
            $user->id = $row['id'];
            $user->userName = $row['user_name'];
            $user->employeeID = $row['employee_id'];
            $user->dateCreated = $row['date_create'];
            $user->dateLastLogin = $row['date_last_login'];
            $user->status = $row['status_id'];

            array_push($usarray, $user);
        }

        return $custarry;
    }

}
