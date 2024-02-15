<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of designationManager
 *
 * @author Sudaraka Ranasinghe
 */
class designationManager {

    function getAllDesignation() {
        $designationes = array();
        $str = "SELECT * FROM designation ";
        $result = dbQuery($str);
        if (dbNumRows($result) > 0) {
            while ($row = dbFetchAssoc($result)) {
                $desig = new designation();
                $desig->id = $row['id'];
                $desig->designation = $row['designation'];
                $desig->departmentID = $row['department_id'];
                $desig->status = $row['status_id'];
                array_push($designationes, $desig);
            }
        }

        return $designationes;
    }

    function searchDesignations($AddtionalQuery = '', $designation, $departmentID, $status) {
        $arry_where = array();
        $validation = new validation();
        $where = "";

        if (!$validation->isEmpty($designation)) {
            array_push($arry_where, "designation LIKE '%$designation%'");
        }

        if (!$validation->isEmpty($departmentID)) {
            array_push($arry_where, "department_id='$departmentID' ");
        }
        if (!$validation->isEmpty($status)) {
            array_push($arry_where, "status_id='$status' ");
        }

        $designationes = array();

        if (count($arry_where) > 0) {
            $where = implode(" AND ", $arry_where);
            if (!$validation->isEmpty($AddtionalQuery)) {  // concat if need order by
                $where . " " . $AddtionalQuery;
            }
        }
        $str = "SELECT * FROM designation " . $where;
        $result = dbQuery($str);
        if (dbNumRows($result) > 0) {
            while ($row = dbFetchAssoc($result)) {
                $desig = new designation();
                $desig->id = $row['id'];
                $desig->designation = $row['designation'];
                $desig->departmentID = $row['department_id'];
                $desig->status = $row['status_id'];
                array_push($designationes, $desig);
            }
        }

        return $designationes;
    }

}
