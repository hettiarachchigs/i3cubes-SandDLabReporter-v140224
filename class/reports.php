<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'database.php';
include_once 'constants.php';

class reports {

    public $tot_open = 0;
    public $tot_cancel = 0;
    public $tot_pending = 0;
    public $tot_Inprogress = 0;
    public $tot_closed = 0;
    public $statusarray = array(2, 3, 5, 6, 7);

    function __construct() {
        
    }

    function summery_counts($from, $to, $tablename) {
        $ary_sql = array();

        if ($from != '') {
//            if ($to == '') {
//                $to = date("Y-m-d");
//            }
            array_push($ary_sql, " open_date > '$from' ");
            array_push($ary_sql, " open_date < '$to' ");
        }

        foreach ($this->statusarray as $value) {
            if (count($ary_sql) > 0) {
                $where = "WHERE " . implode(" AND ", $ary_sql);
                $str = "SELECT
                        COUNT(" . $tablename . ".id) as count
                        FROM
                        " . $tablename . "  " . $where . " AND status = " . $value;
            }


            $result = dbQuery($str);
//         
            if ($row = dbFetchAssoc($result)) {

                if ($value == constants::$Open_STE) {
                    if ($row['count'] != 0) {
                        $this->tot_open = "<b><i>" . $row['count'] . "</i></b>";
                    } else {
                        $this->tot_open = 0;
                    }
                }


                if ($value == constants::$Pending_STE) {

                    if ($row['count'] != 0) {
                        $this->tot_pending = "<b><i>" . $row['count'] . "</i></b>";
                    } else {
                        $this->tot_pending = 0;
                    }
                }

                if ($value == constants::$Cancel_STE) {

                    if ($row['count'] != 0) {
                        $this->tot_cancel = "<b><i>" . $row['count'] . "</i></b>";
                    } else {
                        $this->tot_cancel = 0;
                    }
                }

                if ($value == constants::$Inprogress_STE) {

                    if ($row['count'] != 0) {
                        $this->tot_Inprogress = "<b><i>" . $row['count'] . "</i></b>";
                    } else {
                        $this->tot_Inprogress = 0;
                    }
                }

                if ($value == constants::$Close_STE) {

                    if ($row['count'] != 0) {
                        $this->tot_closed = "<b><i>" . $row['count'] . "</i></b>";
                    } else {
                        $this->tot_closed = 0;
                    }
                }
            }
        }
    }

    function ft_report($from, $to, $teamID) {
        $ary_result=array();
        $ary_sql = array();
        if ($from != '') {
            if ($to == '') {
                $to = date("Y-m-d");
            }
            array_push($ary_sql, "open_date > '$from 00:00:00'");
            array_push($ary_sql, "open_date < '$to 23:59:59'");
        }

        if ($teamID != '') {
            array_push($ary_sql, "team_id = '$teamID' ");
        }
        if (count($ary_sql) > 0) {
            $where = implode(" AND ", $ary_sql);
        }
        
        $str="SELECT count(*) as count,status FROM fault_ticket where ".$where." group by status;";
        //print $str;
        $result = dbQuery($str);
        while ($row=  dbFetchAssoc($result)){
            $ary_result[$row['status']]=$row['count'];
        }
        return $ary_result;
    }
    function ft_open($today,$target_date,$team_id){
        $arry_sql = array();
        $results = array();
        if($target_date !=""){
            array_push($arry_sql, "t1.`target_time` < '$target_date'");
        }
        if($team_id !=""){
            array_push($arry_sql, "t2.`team_id` ='$team_id'");
        }
        
        if(count($arry_sql)>0){
            $sql = " AND ". implode(" AND ", $arry_sql);
        }
        $str = "SELECT t1.*,t2.name AS customer_name,t2.area,t2.team_id ,t3.fault,t4.name FROM fault_ticket AS t1 "
                . "LEFT JOIN customer_entity AS t2 ON t1.customer_entity_id = t2.id "
                . "LEFT JOIN fault_type AS t3 ON t1.fault_type_id = t3.id "
                . "LEFT JOIN team AS t4 ON t2.team_id = t4.id"
                . " WHERE t1.status ='".constants::$Open_STE."' $sql  ORDER BY t1.id desc; ";
        //print $str;
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)){
            array_push($results, $row);
        }
        return $results;
        
    }
    function ft_open_pending($from,$to,$target_date,$team_id){
        $arry_sql = array();
        $results = array();
        if($from !=""){
           if($to =="" ){
               $to = date("Y-m-d");
           }
           array_push($arry_sql, "t1.open_date > '$from 00:00:00' AND t1.open_date < '$to 23:59:59'");
        }
        if($team_id !=""){
           array_push($arry_sql, "t2.`team_id` ='$team_id'");
        }
        if($target_date != ""){
           array_push($arry_sql, "t1.`target_time` < '$target_date  23:59:59'");
        }
        
        if(count($arry_sql)>0){
            $sql = " AND ". implode(" AND ", $arry_sql);
        }
        $str = "SELECT t1.*,t2.name AS customer_name,t2.area,t2.team_id ,t3.fault,t4.name FROM fault_ticket AS t1 "
                . "LEFT JOIN customer_entity AS t2 ON t1.customer_entity_id = t2.id "
                . "LEFT JOIN fault_type AS t3 ON t1.fault_type_id = t3.id "
                . "LEFT JOIN team AS t4 ON t2.team_id = t4.id"
                . " WHERE t1.status ='".constants::$Open_STE."' $sql  ORDER BY t1.id desc; ";
        //print $str."<br>";
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)){
            array_push($results, $row);
        }
        return $results;
    }
    function delay_close($from,$to,$close_date,$team_id){
        $arry_sql = array();
        $results = array();
        if($from !=""){
           if($to =="" ){
               $to = date("Y-m-d");
           }
           array_push($arry_sql, "t1.open_date > '$from 00:00:00' AND t1.open_date < '$to 23:59:59'");
        }
        if($team_id !=""){
           array_push($arry_sql, "t2.`team_id` ='$team_id'");
        }
        //if($target_date != ""){
           array_push($arry_sql, "t1.`closed_time` > t1.target_time");
        //}
        
        if(count($arry_sql)>0){
            $sql = " AND ". implode(" AND ", $arry_sql);
        }
        $str = "SELECT t1.*,t2.name AS customer_name,t2.area,t2.team_id ,t3.fault,t4.name FROM fault_ticket AS t1 "
                . "LEFT JOIN customer_entity AS t2 ON t1.customer_entity_id = t2.id "
                . "LEFT JOIN fault_type AS t3 ON t1.fault_type_id = t3.id "
                . "LEFT JOIN team AS t4 ON t2.team_id = t4.id"
                . " WHERE t1.status ='".constants::$Close_STE."' $sql  ORDER BY t1.id desc; ";
        //print $str."<br>";
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)){
            array_push($results, $row);
        }
        return $results;
    }
    function getratings ($lessthan,$graterthan,$between1,$between2,$equel,$lesthan_or_equel,$greaterthan_or_equel,$date_to,$date_from) {
        $result = array();
        $arry_sql = array();
        if($lessthan !=""){
            array_push($arry_sql, "t1.rating < '$lessthan'");
        }else if ($graterthan){
            array_push($arry_sql, "t1.rating > '$graterthan'");
        }else if($between1 !="" && $between2 !=""){
            array_push($arry_sql, "t1.rating BETWEEN  '$between1' AND '$between2'");
        }else if($equel){
            array_push($arry_sql, "t1.rating ='$equel'");

        }else {

        }
         if($date_from !=""){
            if($date_to ==""){
                $date_to = date("Y-m-d");
            }
            array_push($arry_sql, "t1.print_date BETWEEN '$date_from 00:00:00' AND '$date_to 23:59:59'");
        }
        if(count($arry_sql)>0){
            $sql = " AND ".implode(" AND ", $arry_sql);
        }
        $str = "SELECT * FROM feedback AS t1 LEFT JOIN customer_entity AS t2 ON t2.id = t1.customer_entity_id WHERE t1.print_date IS NOT NULL $sql";
        //print $str;
        $res = dbQuery($str);
        while ($row = dbFetchAssoc($res)){
            array_push($result, $row);
        }
        return $result;
    }
}
