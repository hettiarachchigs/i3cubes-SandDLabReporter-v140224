<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Administrator
 */
include_once 'database.php';
include_once 'status.php';
include_once 'constants.php';

class user {

    public $id, $emp_id,$user_role_id;
    public $userName, $password, $status;
    public $dateCreated, $dateLastLogin;
    public $emp_obj;
    ///////////////////////////
    private $dataLoaded = false;

    public function __construct($id = '') {
        $this->id = $id;
    }

    public function getUser() {
        $quer = "SELECT * FROM usr WHERE id='$this->id'";
        //print $quer;
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            $this->userName = $row['user_name'];
            $this->employeeID = $row['employee_id'];
            $this->emp_id = $row['employee_id'];
            $this->user_role_id=$row['usr_role_id'];
            $this->dateCreated = $row['date_create'];
            $this->dateLastLogin = $row['date_last_login'];
            $this->status = $row['status'];

            return true;
        } else {
            return false;
        }
    }
    
     public function changePassword($ps,$status='C'){
        $str_ps="SHA1('".$ps."')";
        $str="UPDATE usr SET password=$str_ps,status='$status' WHERE id='$this->id';";
        //print $str;
        $result=dbQuery($str);
        if($result){
            return(true);
	}
	else{
            return(false);
	}
    }
    
    public function setLastLoginTime(){
        $str="UPDATE usr SET date_last_login=NOW() WHERE id='$this->id';";
        $result=dbQuery($str);
        return $result;
    }
    function addUser($name, $ps, $role, $empid) {

        $name = getStringFormatted($name);
        $empid = getStringFormatted($empid);
        $role = getStringFormatted($role);
        $str_ps = "SHA1('" . $ps . "')";
        $status = constants::$Active;
        $date_create = date("Y-m-d H:i:s");
        $quer = "insert into usr (user_name,password,date_create,date_last_login,employee_id,status,usr_role_id) values($name,$str_ps,'$date_create',NULL,$empid,$status,$role)";
        //$quer = "insert into usr (user_name,password,date_create,date_last_login,employee_id,status,usr_role_id) values($name,$str_ps,Now(),NULL,$empid,'" . constants::$USER_CHANGE_PS . "',$role)";
        /*$quer = "Insert into usr "
                . "(user_name,password,date_create,date_last_login,employee_id,status,usr_role_id)"
                . " values (" . $name . "," . $str_ps . ",Now(),NULL," . $empid . ",'" . constants::$USER_CHANGE_PS . "',$role);"; */
        //print_r ($quer);
        $result = dbQuery($quer);
        if ($result) {
            return dbInsertId(); //get last insertid 
        } else {
            return(false);
        }
    }

    function deleteUser() {

        //$str = "UPDATE usr set status='" . constants::$USER_DELETED . "' where id='$this->id'";
        $quer = "UPDATE usr set status='0' where id='$this->id'";
        $res = dbQuery($quer);
        if ($res) {
            return true;
        } else {
            return false;
        }
    }

    function editUser($name) {

        $name = getStringFormatted($name);
        $quer = "UPDATE usr set user_name=" . $name . " where id='" . $this->id . "' ";

        $result = dbQuery($quer);
        if ($result) {
            return(true);
        } else {
            return(false);
        }
    }

    function getPreviledges() {
        
        $ary_prev=array();
        $quer = "SELECT * FROM usr_role_prev as t1 left join previledge as t2 on t1.previledge_id=t2.id WHERE t1.usr_role_id='$this->user_role_id'";
        //$quer = "SELECT t1.usr_role_id,t2.module FROM usr_role_prev t1 JOIN previledge t2 WHERE t2.id = t1.previledge_id AND t1.usr_role_id = '$this->user_role_id'";
        $result = dbQuery($quer);
       
        while ($row= dbFetchAssoc($result)){
            if(is_array($row['module'])){
                array_push($ary_prev[$row['module']], $row['previledge_id']);
            }
            else{
                $ary_prev[$row['module']]=array($row['previledge_id']);
            }
        }
            return $ary_prev; 
    }

    function setPreviledges($module,$ary_prev) {
        $str_prev= implode(",", $ary_prev);
        $str="SELECT id FROM usr_prev WHERE module_id='$module' AND user_id='$this->id';";
        $result = dbQuery($str);
        if(dbNumRows($result)==0){
            $str="INSERT INTO usr_prev (user_id,module_id,prev) VALUES('$this->id','$module','$str_prev');";
            $result = dbQuery($str);
            return $result;
        }
        else{
            $str="UPDATE usr_prev SET prev='$str_prev' WHERE user_id='$this->id' AND module_id='$module';";
            //print $str;
            $result = dbQuery($str);
            return $result;
        }
    }
}
