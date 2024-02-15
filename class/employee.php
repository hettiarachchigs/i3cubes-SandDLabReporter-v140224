<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author Administrator
 */
include_once 'database.php';
include_once 'validation.php';
include_once 'constants.php';
include_once 'group.php';

class employee {

    public $id, $designationID, $departmentID;
    public $name, $nic, $address, $mobile, $contact, $email, $status, $designation, $department, $type,$note;
    private $dataLoaded = false;

    function __construct($id = '') {
        $this->id = $id;
    }

    public function getEmployee() {
        if($this->id==''){
            return null;
        }
        $quer = "SELECT * FROM employee where id='$this->id'";
        //print $quer;
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->address = $row['address'];
            $this->nic = $row['nic'];
            $this->contact = $row['contact'];
            $this->mobile = $row['mobile'];
            $this->email = $row['email'];
            $this->note = $row['note'];
            $this->designationID = $row['designation_id'];
            //$this->departmentID = $row['department_id'];
            $this->status = $row['status'];

            return true;
        } else {
            return false;
        }
    }

    //function addEmployee($name, $address, $nic, $contact, $mobile, $email, $designationID, $departmentID,$note,$type="",$lat="",$lon="") {
    function addEmployee($name, $address, $nic, $contact, $mobile, $email, $designationID,$note,$type="") {
            
        $name = getStringFormatted($name);
        $address = getStringFormatted($address);
        $nic = getStringFormatted($nic);
        $contact = getStringFormatted($contact);
        $mobile = getStringFormatted($mobile);
        $email = getStringFormatted($email);
        $designationID = getStringFormatted($designationID);
        //$departmentID = getStringFormatted($departmentID);
        $note = getStringFormatted($note);
        //$lat = getStringFormatted($lat);
        //$lon = getStringFormatted($lon);
        
        $type==""?$type='EMP':$type=$type;
        $status = constants::$Active;
        $quer = "insert into employee (name,address,nic,contact,mobile,email,status,designation_id,note) values($name,$address,$nic,$contact,$mobile,$email,$status,$designationID,$note)";
        /*$quer = "Insert into employee "
                . "(name,address,nic,contact,mobile,email,status,designation_id,note)"
                . " values (" . $name . "," . $address . "," . $nic . ","
                . "," . $contact . "," . $mobile . "," . $email . ",'" . constants::$USER_ACTIVE . "'," . $designationID . ",".$note.")"; */
        //print_r($quer);
        $result = dbQuery($quer);
        if ($result) {
            return dbInsertId(); //get last insertid 
        } else {
            return(false);
        }
    }

    function editEmployee($name, $address, $nic, $mobile, $email, $designationID,$note) {

        $name = getStringFormatted($name);
        $address = getStringFormatted($address);
        $nic = getStringFormatted($nic);
        $contact = getStringFormatted($contact);
        $mobile = getStringFormatted($mobile);
        $email = getStringFormatted($email);
        $designationID = getStringFormatted($designationID);
        //$departmentID = getStringFormatted($departmentID);
        $note = getStringFormatted($note);
        //$lat = getStringFormatted($lat);
        //$lon = getStringFormatted($lon);

        $quer = "UPDATE  employee set name=" . $name . ",address=" . $address . ""
                . ",nic=" . $nic . ",contact=" . $contact . ",mobile=" . $mobile . ",email=" . $email . ","
                . "designation_id=" . $designationID . ",note=".$note." where id='" . $this->id
                . "' ";
        //print $quer;
        $result = dbQuery($quer);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }


 function editEmployeeteam($address, $mobile, $email) {

        $address = getStringFormatted($address);
        $mobile = getStringFormatted($mobile);
        $email = getStringFormatted($email);


        $quer = "UPDATE  employee set address=" . $address . ""
                . ",mobile=" . $mobile . ",email=" . $email . ""
                . " where id='" . $this->id . "' ";
        //print $quer;
        $result = dbQuery($quer);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function deleteEmployee() {
        $str = "UPDATE employee set status='" . constants::$Deleted_STE . "' where id='$this->id'";
        $res = dbQuery($str);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    public function getEmployeeID($nic) { //return emp id
        $quer = "SELECT id FROM employee WHERE nic='$nic'";
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            return $row['id'];
        } else {
            return 0;
        }
    }

    public function getEmployeType() {
        $quer = "SELECT * from team_employee WHERE employee_id='$this->id';";
        $result = dbQuery($quer);

        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            return $row['type'];
        } else {
            return 0;
        }
    }

    public function getTeam() {//may be miltiple
        $ary_team = array();
        $str = "SELECT group_id FROM team_employee WHERE employee_id='$this->id';";
        $result = dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            array_push($ary_team, $row['group_id']);
        }
        return $ary_team;
    }

    public function getLeadingTeam() {//may be miltiple
        $ary_team = array();
        $str = "SELECT group_id FROM team_employee WHERE employee_id='$this->id' AND type='L';";
        //print $str;
        $result = dbQuery($str);
        while ($row = dbFetchAssoc($result)) {
            array_push($ary_team, $row['group_id']);
        }
        return $ary_team;
    }

}
