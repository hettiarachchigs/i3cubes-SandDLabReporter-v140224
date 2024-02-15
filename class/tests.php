<?php
include_once 'database.php';
include_once 'functions.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of test
 *
 * @author Administrator
 */

class tests {
//id, name,type,category, date,emp_id,status,note
    public $id;
    public $name,$type,$date;
    public $apparatus,$proced,$chemical,$material,$evaluate;

    public function __construct($id = '') {
        $this->id = $id;
    }
/*
    public function getTest() {
        $quer = "SELECT * FROM test WHERE id='$this->id'";
        //print $quer;
        $result = dbQuery($quer);
        if (dbNumRows($result) == 1) {
            $row = dbFetchAssoc($result);
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->type = $row['type'];
            $this->test_categiry_id=$row['category'];
            $this->dateCreated = $row['date'];
            $this->createdBy = $row['emp_id'];
            $this->status = $row['status'];

            return true;
        } else {
            return false;
        }
*/        
    
    function addTest() {
        
        //Array ( [0] => tests Object ( [id] => [name] => gggg [type] => 2 [category] => [emp_id] => [date] => [status] => [note] => 
        //[doneBy] => admin [tst_apparatus] => <p>iuhgpiu<br></p> [proced] => <p>yteuyrsi<br></p> [chemical] => [material] => [evaluate] => ) )
      $quer = "INSERT INTO tests(name,type,done_by,apparatus,proced,chemical,material,evaluate) VALUES('$this->name','$this->type','$this->doneBy','$this->apparatus','$this->proced','$this->chemical','$this->material','$this->evaluate')";
    //print_r($quer);
        $result = dbQuery($quer);
        if ($result) {
            return dbInsertId(); //get last insertid 
        } else {
            return(false);
    }

    }
/*
    function deleteTest() {

        
    }

    function editTest($name) {

        
    }
*/

}
