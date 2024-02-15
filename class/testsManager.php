<?php
include_once 'database.php';
include_once 'tests.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of item
 *
 * @author Administrator
 */
class testsManager {

    public function getAlltests() {
        
        $tsts = new tests();
        $testsArray=array();
        $quer = "SELECT * FROM tests";
        $result = dbQuery($quer);
        $i = 0;
        while ($row= dbFetchAssoc($result)){
            /*
            $tsts->id = $row['id'];
            $tsts->name = $row['name'];
            $tsts->type = $row['type'];
            //$tsts->test_categiry_id=$row['category'];
            $tsts->dateCreated = $row['date'];
            $tsts->createdBy = $row['done_by'];
            $tsts->apparatus = $row['apparatus'];
            $tsts->proced = $row['proced'];
            $tsts->chemical = $row['chemical'];
            $tsts->material = $row['material'];
            $tsts->evaluate = $row['evaluate'];

            array_push($testsArray, $tsts);
            */

            $testsArray[$i]['id'] = $row['id'];
            $testsArray[$i]['name'] = $row['name'];
            $testsArray[$i]['type'] = $row['type'];
            //$tsts->test_categiry_id=$row['category'];
            $testsArray[$i]['dateCreated'] = $row['date'];
            $testsArray[$i]['createdBy'] = $row['done_by'];
            $testsArray[$i]['apparatus'] = $row['apparatus'];
            $testsArray[$i]['proced'] = $row['proced'];
            $testsArray[$i]['chemical'] = $row['chemical'];
            $testsArray[$i]['material'] = $row['material'];
            $testsArray[$i]['evaluate'] = $row['evaluate'];
            
            $i++;
        }
        //print_r($testArray);
        return $testsArray;
    }

    public function getTest($testId){ 
      //Array ( [id] => 6 [name] => gsh [type] => 3 [category] => 0 [date] => 2024-02-10 [done_by] => admin [status] => 1 [note] => [apparatus] => <p>asd<br></p> [proced] => <ul><li>hdget</li><li>hjsjs</li><li>klsns<br></li></ul> [chemical] => <p>abc<br></p> [material] => [evaluate] => )    
        $testArray = array();
        $quer = "SELECT * FROM tests WHERE id = $testId ";
        $result = dbQuery($quer);

        if(dbNumRows($result)==1){
            $row = dbFetchAssoc($result);
            $testArray = $row;
        }
        //print_r($testArray);
        return $testArray;
    }

/*
    public function getPartByCode($code){
        $item=null;
        $str = "SELECT t1.*,t2.* FROM product as t1 left join units as t2 on t1.units_id=t2.id WHERE t1.code='$code';";
        $result = dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchAssoc($result);
            $item=new product($row['id']);
            $item->code=$row['code'];
            $item->name = $row['name'];
            $item->remarks = $row['remarks'];
            $item->units_id = $row['units_id'];
            $item->status = $row['status'];
            //$item->status_name=$row['description'];
            $item->units_name=$row['unit'];
        }
        return $item;
    }
    public function getPartByName($name){
        $item=null;
        $str = "SELECT t1.*,t2.* FROM product as t1 left join units as t2 on t1.units_id=t2.id WHERE t1.name='$name';";
        $result = dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchAssoc($result);
            $item=new product($row['id']);
            $item->code=$row['code'];
            $item->name = $row['name'];
            $item->remarks = $row['remarks'];
            $item->units_id = $row['units_id'];
            $item->status = $row['status'];
            //$item->status_name=$row['description'];
            $item->units_name=$row['unit'];
        }
        return $item;
    }
    public function getUnitID($unit){
        $str="SELECT * FROM units WHERE unit='$unit';";
        $result = dbQuery($str);
        if(dbNumRows($result)==1){
            $row= dbFetchAssoc($result);
            return $row['id'];
        }
        else{
            return null;
        }
    }
*/
}
