<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employeeManager
 *
 * @author Sudaraka Ranasinghe
 */
class employeeManager {

    public function getALLEmployees($type='') { // return employee array
        $emplarray = array();
        if($type==""){
            $quer = "SELECT * FROM employee";
        }
        else{
            $quer = "SELECT * FROM employee WHERE type='$type'";
        }
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $employee = new employee();
            $employee->id = $row['id'];
            $employee->name = $row['name'];
            $employee->address = $row['address'];
            $employee->nic = $row['nic'];
            $employee->note = $row['note'];
            $employee->contact = $row['contact'];
            $employee->mobile = $row['mobile'];
            $employee->email = $row['email'];
            $employee->designationID = $row['designation_id'];
            $employee->departmentID = $row['department_id'];
            $employee->status = $row['status_id'];

            array_push($emplarray, $employee);
        }
        return $emplarray;
    }

    public function getGroupEmployees($team_id) { // return employee array
        $emplarray = array();
        $quer = "SELECT t1.* FROM employee as t1 inner join team_employee as t2 on t1.id=t2.employee_id WHERE t2.group_id='$team_id';";
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $employee = new employee();
            $employee->id = $row['id'];
            $employee->name = $row['name'];
            $employee->address = $row['address'];
            $employee->nic = $row['nic'];
            $employee->contact = $row['contact'];
            $employee->mobile = $row['mobile'];
            $employee->email = $row['email'];
            $employee->note = $row['note'];
            $employee->designationID = $row['designation_id'];
            $employee->departmentID = $row['department_id'];
            $employee->status = $row['status'];

            array_push($emplarray, $employee);
        }

        return $emplarray;
    }

    public function searchEmployeedetail($AddtionalQuery = '', $name, $address, $nic, $contact, $mobile, $email, $designationID, $departmentID, $status) {

        $arry_where = array();
        $validation = new validation();
        $where = "";

        if (!$validation->isEmpty($name)) {
            array_push($arry_where, "name like '%" . $name . "%'");
        }
        if (!$validation->isEmpty($address)) {
            array_push($arry_where, "address like '%" . $address . "%'");
        }
        if (!$validation->isEmpty($nic)) {
            array_push($arry_where, "nic like '%" . $nic . "%'");
        }
        if (!$validation->isEmpty($contact)) {
            array_push($arry_where, "contact like '%" . $contact . "%'");
        }
        if (!$validation->isEmpty($mobile)) {
            array_push($arry_where, "mobile like '%" . $mobile . "%'");
        }
        if (!$validation->isEmpty($email)) {
            array_push($arry_where, "email like '%" . $email . "%'");
        }

        if (!$validation->isEmpty($designationID)) {
            array_push($arry_where, "designation_id='$designationID' ");
        }
        if (!$validation->isEmpty($groupID)) {
            array_push($arry_where, "department_id='$departmentID' ");
        }
        if (!$validation->isEmpty($status)) {
            array_push($arry_where, "status='$status' ");
        }
        if (count($arry_where) > 0) {
            $where = " WHERE " . implode(" AND ", $arry_where);

            if (!$validation->isEmpty($AddtionalQuery)) {  // concat if need order by
                $where = $where . " " . $AddtionalQuery;
            }
        }

        $quer = "SELECT * FROM employee " . $where;
        //print $quer;
        $emplarry = array();
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $employee = new employee();
            $employee->id = $row['id'];
            $employee->name = $row['name'];
            $employee->address = $row['address'];
            $employee->nic = $row['nic'];
            $employee->contact = $row['contact'];
            $employee->mobile = $row['mobile'];
            $employee->email = $row['email'];
            $employee->note = $row['note'];
            $employee->designationID = $row['designation_id'];
            $employee->departmentID = $row['department_id'];
            $employee->status = $row['status'];

            array_push($emplarry, $employee);
        }

        return $emplarry;
    }

    public function searchEmployeedetailwithnote($AddtionalQuery = '', $name, $address, $nic, $contact, $mobile, $email, $designationID, $departmentID, $status, $note) {

        $arry_where = array();
        $validation = new validation();
        $where = "";

        if (!$validation->isEmpty($name)) {
            array_push($arry_where, "name like %" . $name . "%");
        }
        if (!$validation->isEmpty($address)) {
            array_push($arry_where, "address like %" . $address . "%");
        }
        if (!$validation->isEmpty($note)) {
            array_push($arry_where, "note like %" . $note . "%");
        }
        if (!$validation->isEmpty($nic)) {
            array_push($arry_where, "nic like %" . $nic . "%");
        }
        if (!$validation->isEmpty($contact)) {
            array_push($arry_where, "contact like %" . $contact . "%");
        }
        if (!$validation->isEmpty($mobile)) {
            array_push($arry_where, "mobile like %" . $mobile . "%");
        }
        if (!$validation->isEmpty($email)) {
            array_push($arry_where, "email like %" . $email . "%");
        }

        if (!$validation->isEmpty($designationID)) {
            array_push($arry_where, "designation_id='$designationID' ");
        }
        if (!$validation->isEmpty($groupID)) {
            array_push($arry_where, "department_id='$departmentID' ");
        }
        if (!$validation->isEmpty($status)) {
            array_push($arry_where, "status='$status' ");
        }
        if (count($arry_where) > 0) {
            $where = " WHERE " . implode(" AND ", $arry_where);

            if (!$validation->isEmpty($AddtionalQuery)) {  // concat if need order by
                $where = $where . " " . $AddtionalQuery;
            }
        }

        $quer = "SELECT * FROM employee " . $where;
        //print $quer;
        $emplarry = array();
        $result = dbQuery($quer);
        while ($row = dbFetchAssoc($result)) {
            $employee = new employee();
            $employee->id = $row['id'];
            $employee->name = $row['name'];
            $employee->address = $row['address'];
            $employee->nic = $row['nic'];
            $employee->contact = $row['contact'];
            $employee->mobile = $row['mobile'];
            $employee->email = $row['email'];
            $employee->note = $row['note'];
            $employee->designationID = $row['designation_id'];
            $employee->departmentID = $row['department_id'];
            $employee->status = $row['status_id'];

            array_push($emplarry, $employee);
        }

        return $emplarry;
    }

}
