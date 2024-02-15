<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of departmentManager
 *
 * @author Sudaraka Ranasinghe
 */
class departmentManager {

    function getAllDepartment() {
        $departmentes = array();
        $str = "SELECT * FROM department ";
        $result = dbQuery($str);
        if (dbNumRows($result) > 0) {
            while ($row = dbFetchAssoc($result)) {
                $dep = new department();
                $dep->id = $row['id'];
                $dep->name = $row['name'];
                $dep->status = $row['status_id'];
                array_push($departmentes, $dep);
            }
        }

        return $departmentes;
    }

    function searchDepartments($AddtionalQuery = '', $name, $status) {
        $arry_where = array();
        $validation = new validation();
        $where = "";

        if (!$validation->isEmpty($name)) {
            array_push($arry_where, "name LIKE '%$name%'");
        }

        if (!$validation->isEmpty($status)) {
            array_push($arry_where, "status_id='$status' ");
        }

        $departmentes = array();

        if (count($arry_where) > 0) {
            $where = implode(" AND ", $arry_where);
            if (!$validation->isEmpty($AddtionalQuery)) {  // concat if need order by
                $where . " " . $AddtionalQuery;
            }
        }
        $str = "SELECT * FROM department " . $where;
        $result = dbQuery($str);
        if (dbNumRows($result) > 0) {
            while ($row = dbFetchAssoc($result)) {
                $dep = new department();
                $dep->id = $row['id'];
                $dep->name = $row['name'];
                $dep->status = $row['status_id'];
                array_push($departmentes, $dep);
            }
        }

        return $departmentes;
    }

}
