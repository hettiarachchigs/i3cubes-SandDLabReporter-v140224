<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'database.php';
include_once 'ngs_date.php';
class response_time{
    
    
    function getDistanse($district_id){
        $str = "SELECT * FROM district WHERE id = '$district_id'";
        $res = dbQuery($str);
        if(dbNumRows($res)>0){
            $row = dbFetchAssoc($res);
            return $row;
        }
    }
    function get_response_time($district_id,$priority_id){
//        $district_details = $this->getDistanse($district_id);
//        $distance = $district_details['distance'];
        $str = "SELECT * FROM sla WHERE priority_id = '$priority_id' ";
//        $str = "SELECT * FROM slevel WHERE priority_id = '$priority_id' AND  $distance BETWEEN min AND max";
        //echo $str;
        //echo '<br>';
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        return $row;
    }
    function getTargetTime($priotity,$datetime=""){
        $ts_target=time();
        $str = "SELECT * FROM sla WHERE priority_id = '$priotity' ";
        //print $str;
        $res = dbQuery($str);
        $row = dbFetchAssoc($res);
        $t_duration=$row['time'];
        //print "T_D:".$t_duration."<br>";
        $date=new ngs_date();
        
        if($datetime==""){
            date_default_timezone_set('Asia/Colombo');
            $ts_start= time();
        }else {
            $ts_start= strtotime($datetime);
        }
        //print "T_start:".$ts_start."<br>";
        //check for holidays
        $r=true;
        while ($r){
            if(date('w',$ts_start)==0 || date('w',$ts_start)==6){
                //print "HILODAY..";
                $ts_start=$date->dateadd(strtotime(date("Y-m-d",$ts_start)." 09:00:00"), 1, 0, 0, 0);
            }
            else{
                $r=false;
                //print "NOT HILODAY..";
            }
        }
        //print "START TIME:".date('Y-m-d H:i:d',$ts_start)."|";
        $ts_t=$date->dateadd($ts_start, 0, 0, $t_duration, 0);
        $ts_18= strtotime(date('Y-m-d ',$ts_start)."18:00:00");
        $ts_9= strtotime(date('Y-m-d ',$ts_start)."09:00:00");
        
        //print "T_TAR:".date('Y-m-d H:i:d',$ts_t)."|TS_9:".date('Y-m-d H:i:d',$ts_9)."|TS_18:".date('Y-m-d H:i:d',$ts_18)."|TS_START:".date('Y-m-d H:i:d',$ts_start);
        if($ts_t<$ts_9){
            $ts_t=$ts_9+$date->dateadd($ts_9, 0, 0, $t_duration, 0);
            //print "MORNIG";
        }
        //print "START ts:".date('Y-m-d H:i:d',$ts_t)."<br>";
        if($ts_t>$ts_18){
            //next days?
            
            $t_duration=$t_duration-(($ts_18-$ts_start)/60);
            //print "D1:DUR_REM:".$t_duration;
            $ts_target=$date->dateadd($ts_18, 0, 15, 0, 0);//set to next day 9:00AM
            //print "D1:SET TARGET START:".date("Y-m-d H:i:s",$ts_target);
            $run=true;
            //$ts_w=$ts_t;
            $i=2;
            while ($run){
                if($t_duration>(9*60)){// 9:00 AM - 06:00PM
                    //next day
                    //print "Day:".$i."|DUR_REM=".$t_duration;
                    $ts_target=$date->dateadd($ts_target, 0, 24, 0, 0);
                    //if sunday or suturday
                    if(date("w",$ts_target)==0 || date("w",$ts_target)==6){//sunday and suturday
                        //holiday
                        //print "|HOLIDAY:DUR_REM".$t_duration;
                    }
                    else{
                        $t_duration=$t_duration-(9*60);
                    }
                    $run=true;
                }
                else{
                    $ts_target=$date->dateadd($ts_target, 0, 0, $t_duration, 0);   //15<- 06:00PM  to 09:00AM
                    $run=false;
                    //print "D$i:DUR_REM=".$t_duration;
                }
                $i++;
            }
        }
        else{
            $ts_target=$ts_t;
            //print "D0";
        }
        
        return $ts_target;
    }
}